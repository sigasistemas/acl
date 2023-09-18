<?php

/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com, contato@sigasmart.com.br
 * https://www.sigasmart.com.br
 */

namespace Callcocam\Acl\Resources;

use App\Models\Callcocam\AccessGroup;
use App\Models\Callcocam\Permission;
use Callcocam\Acl\Resources\PermissionResource\Pages;
use Callcocam\Acl\Resources\PermissionResource\RelationManagers;
use Callcocam\Acl\Traits\HasDatesFormForTableColums;
use Callcocam\Acl\Traits\HasStatusColumn;
use Filament\Forms;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Grouping\Group;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PermissionResource extends Resource
{
    use HasStatusColumn, HasDatesFormForTableColums;

    protected static ?string $model = Permission::class;

    protected static ?string $navigationIcon = 'heroicon-o-key';

    protected static ?string $navigationGroup = "Acl";

    protected static ?string $modelLabel = 'Permissão';

    protected static ?string $pluralModelLabel = 'Permissões';

    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('access_group_id')
                    ->label('Group')
                    ->required()
                    ->placeholder('Select Group')
                    ->columnSpan(
                        [
                            'md' => 2
                        ]
                    )
                    ->options(AccessGroup::query()->pluck('name', 'id')->toArray()),
                Forms\Components\TextInput::make('name')
                    ->columnSpan(
                        [
                            'md' => 4
                        ]
                    )
                    ->label('Name da Permissão')
                    ->required()

                    ->maxLength(255),
                Forms\Components\TextInput::make('slug')
                    ->columnSpan(
                        [
                            'md' => 6
                        ]
                    )
                    ->label('Permissão')
                    ->suffixAction(static::getGlobalRoutes())
                    ->required()
                    ->maxLength(255),

                static::getStatusFormRadioField(),
                Forms\Components\Textarea::make('description')
                    ->maxLength(65535)
                    ->columnSpanFull(),

            ])->columns(12);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->groups([
                Group::make('access_groups.name')
                    ->label('Group')
            ])
            ->columns([
                Tables\Columns\TextColumn::make('access_groups.name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('slug')
                    ->searchable(),
                static::getStatusTableIconColumn(),
                ...static::getFieldDatesFormForTable()
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPermissions::route('/'),
            'create' => Pages\CreatePermission::route('/create'),
            'edit' => Pages\EditPermission::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    protected static function getGlobalRoutes()
    {
        $options = collect(app('router')->getRoutes()->getRoutesByName())->filter(function ($route) {
            return str_contains($route->getName(), 'filament.') && str_contains($route->getName(), '.index');
        })->map(function ($route) {
            return $route->getName();
        })->toArray();

        return  Action::make('generate-slug')
            ->icon('fas-search')
            ->iconButton()
            ->label('Generate')
            ->mutateFormDataUsing(function (array $data, Set $set) {
                $set('slug', $data['new_slug']);
                return $data;
            })
            ->form(
                [
                    Forms\Components\Select::make('new_slug')
                        ->options($options)
                        ->searchable()
                        ->label('Permissão em slug')
                        ->required(),
                ]
            );
    }
}
