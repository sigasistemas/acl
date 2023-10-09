<?php

/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com, contato@sigasmart.com.br
 * https://www.sigasmart.com.br
 */

namespace Callcocam\Acl\Resources;

use Callcocam\Acl\Models\AccessGroup;
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
use Illuminate\Support\Str;

class PermissionResource extends Resource
{
    use HasStatusColumn, HasDatesFormForTableColums;

    // protected static ?string $model = Permission::class;

    protected static ?string $navigationIcon = 'heroicon-o-key';

    protected static ?string $navigationGroup = "Acl";

    protected static ?string $modelLabel = 'Permissão';

    protected static ?string $pluralModelLabel = 'Permissões';

    protected static ?int $navigationSort = 5;

    public static function getModel(): string
    {
        return config('acl.models.permission', Permission::class);
    }

    public static function getNavigationGroup(): ?string
    {
        return config('acl.navigation.permission.group', static::$navigationGroup);
    }

    public static function getNavigationIcon(): ?string
    {
        return config('acl.navigation.permission.icon', static::$navigationIcon);
    }

    public static function getNavigationLabel(): string
    {
        return static::$navigationLabel ?? config('acl.navigation.permission.label', Str::headline(static::getPluralModelLabel()));
    }


    public static function getNavigationBadge(): ?string
    {
        return config('acl.navigation.permission.badge', null);
    }

    /**
     * @return string | array{50: string, 100: string, 200: string, 300: string, 400: string, 500: string, 600: string, 700: string, 800: string, 900: string, 950: string} | null
     */
    public static function getNavigationBadgeColor(): string | array | null
    {
        return config('acl.navigation.permission.badge_color', null);
    }

    public static function getNavigationSort(): ?int
    {
        return config('acl.navigation.permission.sort', static::$navigationSort);
    }


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('access_group_id')
                    ->label(__('acl::acl.forms.permission.access_group_id.label'))
                    ->required(config('acl.forms.permission.name.required', true))
                    ->placeholder(__('acl::acl.forms.permission.access_group_id.placeholder'))
                    ->columnSpan(config('acl.forms.permission.access_group_id.columnSpan', [
                        'md' => 2,
                    ]))
                    ->options(AccessGroup::query()->pluck('name', 'id')->toArray()),
                Forms\Components\TextInput::make('name')
                    ->label(__('acl::acl.forms.permission.name.label'))
                    ->placeholder(__('acl::acl.forms.permission.name.placeholder'))
                    ->required(config('acl.forms.permission.name.required', true))
                    ->columnSpan(config('acl.forms.permission.name.columnSpan', [
                        'md' => 4,
                    ]))
                    ->maxLength(config('acl.forms.permission.name.maxLength', 255)),
                Forms\Components\TextInput::make('slug')
                    ->columnSpan(config('acl.forms.permission.slug.columnSpan', [
                        'md' => 6
                    ]))
                    ->label(__('acl::acl.forms.permission.slug.label'))
                    ->placeholder(__('acl::acl.forms.permission.slug.placeholder'))
                    ->suffixAction(static::getGlobalRoutes())
                    ->required(config('acl.forms.permission.slug.required', true))
                    ->maxLength(config('acl.forms.permission.slug.maxLength', 255)),

                static::getStatusFormRadioField(),
                Forms\Components\Textarea::make('description')
                    ->label(__('acl::acl.forms.permission.description.label'))
                    ->placeholder(__('acl::acl.forms.permission.description.placeholder'))
                    ->columnSpanFull(),
            ])->columns(12);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->groups([
                Group::make('access_groups.name')
                    ->label(__('acl::acl.permission.groups.access_groups.name')),
            ])
            ->columns([
                Tables\Columns\TextColumn::make('access_groups.name')
                    ->label(__('acl::acl.columns.permission.access_groups'))
                    ->sortable(config('acl.columns.permission.access_groups.name.sortable', true))
                    ->searchable(config('acl.columns.permission.access_groups.name.searchable', true)),
                Tables\Columns\TextColumn::make('name')
                    ->label(__('acl::acl.columns.permission.name'))
                    ->sortable(config('acl.columns.permission.name.sortable', true))
                    ->searchable(config('acl.columns.permission.name.searchable', true)),
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
