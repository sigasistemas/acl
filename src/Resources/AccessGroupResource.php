<?php

/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com, contato@sigasmart.com.br
 * https://www.sigasmart.com.br
 */

namespace Callcocam\Acl\Resources;

use App\Models\Callcocam\AccessGroup;
use App\Models\Callcocam\Tenant;
use Callcocam\Acl\Resources\GroupResource\RelationManagers;
use Callcocam\Acl\Resources\AccessGroupResource\Pages;
use Callcocam\Acl\Traits\HasDatesFormForTableColums;
use Callcocam\Acl\Traits\HasStatusColumn;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class AccessGroupResource extends Resource
{
    use HasStatusColumn, HasDatesFormForTableColums;

    // protected static ?string $model = AccessGroup::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = "Acl";

    protected static ?string $modelLabel = 'Grupo de Acesso';

    protected static ?string $modelLabelPlural = 'Grupos de Acesso';

    protected static ?int $navigationSort = 3;

    public static function getModel(): string
    {
        return config('acl.models.access_group', AccessGroup::class);
    }

    public static function getNavigationGroup(): ?string
    {
        return config('acl.navigation.access_group.group', static::$navigationGroup);
    }

    public static function getNavigationIcon(): ?string
    {
        return config('acl.navigation.access_group.icon', static::$navigationIcon);
    }

    public static function getNavigationLabel(): string
    {
        return static::$navigationLabel ?? config('acl.navigation.access_group.label', Str::headline(static::getPluralModelLabel()));
    }

    
    public static function getNavigationBadge(): ?string
    {
        return config('acl.navigation.access_group.badge', null);
    }

    /**
     * @return string | array{50: string, 100: string, 200: string, 300: string, 400: string, 500: string, 600: string, 700: string, 800: string, 900: string, 950: string} | null
     */
    public static function getNavigationBadgeColor(): string | array | null
    {
        return config('acl.navigation.access_group.badge_color', null);
    }

    public static function getNavigationSort(): ?int
    {
        return config('acl.navigation.access_group.sort', static::$navigationSort);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Forms\Components\TextInput::make('name')
                    ->required()
                    ->columnSpanFull()
                    ->label(__('acl::access_group.form.name.label'))
                    ->placeholder(__('acl::access_group.form.name.placeholder'))
                    ->maxLength(255),
                static::getStatusFormRadioField(),
                Forms\Components\Textarea::make('description')
                    ->label(__('acl::access_group.form.description.label'))
                    ->placeholder(__('acl::access_group.form.description.placeholder'))
                    ->maxLength(65535)
                    ->columnSpanFull(),
            ])->columns(12);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label(__('acl::access_group.table.name'))
                    ->searchable(),
                ...static::getFieldDatesFormForTable(),
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
            'index' => Pages\ManageAccessGroups::route('/'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ])->tenant();
    }
}
