<?php

/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com, contato@sigasmart.com.br
 * https://www.sigasmart.com.br
 */

namespace Callcocam\Acl\Resources;

use App\Models\Callcocam\Role;
use Callcocam\Acl\Resources\RoleResource\Pages;
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

class RoleResource extends Resource
{
    use HasStatusColumn, HasDatesFormForTableColums;

    // protected static ?string $model = Role::class;

    protected static ?string $navigationIcon = 'heroicon-o-lock-open';

    protected static ?string $navigationGroup = "Acl";

    protected static ?string $modelLabel = 'Controle de Acesso';

    protected static ?string $pluralModelLabel = 'Controle de Acessos';

    protected static ?int $navigationSort = 4;


    public static function getModel(): string
    {
        return  config('acl.models.role', Role::class);
    }
    public static function getNavigationGroup(): ?string
    {
        return config('acl.navigation.role.group', static::$navigationGroup);
    }

    public static function getNavigationIcon(): ?string
    {
        return config('acl.navigation.role.icon', static::$navigationIcon);
    }

    public static function getNavigationLabel(): string
    {
        return static::$navigationLabel ?? config('acl.navigation.role.label', Str::headline(static::getPluralModelLabel()));
    }


    public static function getNavigationBadge(): ?string
    {
        return config('acl.navigation.role.badge', null);
    }

    /**
     * @return string | array{50: string, 100: string, 200: string, 300: string, 400: string, 500: string, 600: string, 700: string, 800: string, 900: string, 950: string} | null
     */
    public static function getNavigationBadgeColor(): string | array | null
    {
        return config('acl.navigation.role.badge_color', null);
    }

    public static function getNavigationSort(): ?int
    {
        return config('acl.navigation.role.sort', static::$navigationSort);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label(__('acl::acl.forms.role.name.label'))
                    ->sortable(config('acl.forms.role.name.sortable', true))
                    ->searchable(config('acl.forms.role.name.searchable', true)),
                Tables\Columns\TextColumn::make('slug')
                    ->label(__('acl::acl.forms.role.slug.label'))
                    ->sortable(config('acl.forms.role.slug.sortable', true))
                    ->searchable(config('acl.forms.role.slug.searchable', true)),
                Tables\Columns\TextColumn::make('special')
                    ->searchable(),
                static::getStatusTableIconColumn(),
                ...static::getFieldDatesFormForTable()
            ])
            ->filters(config('acl.filters.role', [
                Tables\Filters\TrashedFilter::make(),
            ]))
            ->actions(config('acl.actions.role', [
                Tables\Actions\EditAction::make(),
            ]))
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make(static::bulkActionsGroup()),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ]);
    }

    public static function getRelations(): array
    {


        return config('acl.relations.role', [
            //
        ]);
    }

    public static function getPages(): array
    {
        return config('acl.pages.role', [
            'index' => Pages\ListRoles::route('/'),
            'create' => Pages\CreateRole::route('/create'),
            'edit' => Pages\EditRole::route('/{record}/edit'),
        ]);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes(config('acl.scopes.role', [
                SoftDeletingScope::class,
            ]));
    }

    protected static function bulkActionsGroup()
    {

        return config('acl.actions.role.bulk', [
            Tables\Actions\DeleteBulkAction::make(),
            Tables\Actions\ForceDeleteBulkAction::make(),
            Tables\Actions\RestoreBulkAction::make(),
        ]);
    }
}
