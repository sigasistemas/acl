<?php

/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com, contato@sigasmart.com.br
 * https://www.sigasmart.com.br
 */

namespace Callcocam\Acl\Resources;

use Callcocam\Acl\Resources\UserResource\Pages;
use Callcocam\Acl\Resources\UserResource\RelationManagers;
use App\Models\User;
use Callcocam\Profile\Resources\RelationManagers\AddressesRelationManager;
use Callcocam\Profile\Resources\RelationManagers\ContactsRelationManager;
use Callcocam\Profile\Resources\RelationManagers\DocumentsRelationManager;
use Callcocam\Profile\Resources\RelationManagers\SocialsRelationManager;
use Callcocam\Acl\Traits\HasDatesFormForTableColums;
use Callcocam\Acl\Traits\HasGlobalSearchBase;
use Callcocam\Acl\Traits\HasStatusColumn;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class UserResource extends Resource
{
    use HasGlobalSearchBase, HasStatusColumn, HasDatesFormForTableColums;
 

    protected static ?string $navigationIcon = 'heroicon-o-user';

    protected static ?string $navigationGroup = "Acl";

    protected static ?string $modelLabel = 'Usuário';

    protected static ?string $modelLabelPlural = 'Usuários';

    protected static ?int $navigationSort = 2;

    /**
     * Get the model class name for the user resource.
     *
     * @return string
     */
    public static function getModel(): string
    {
        return config('acl.models.user', User::class);
    }

    public static function getNavigationGroup(): ?string
    {
        return config('acl.navigation.user.group', static::$navigationGroup);
    }

    public static function getNavigationIcon(): ?string
    {
        return config('acl.navigation.user.icon', static::$navigationIcon);
    }

    public static function getNavigationLabel(): string
    {
        return static::$navigationLabel ?? config('acl.navigation.user.label', Str::headline(static::getPluralModelLabel()));
    }


    public static function getNavigationBadge(): ?string
    {
        return config('acl.navigation.user.badge', null);
    }

    /**
     * @return string | array{50: string, 100: string, 200: string, 300: string, 400: string, 500: string, 600: string, 700: string, 800: string, 900: string, 950: string} | null
     */
    public static function getNavigationBadgeColor(): string | array | null
    {
        return config('acl.navigation.user.badge_color', null);
    }

    public static function getNavigationSort(): ?int
    {
        return config('acl.navigation.user.sort', static::$navigationSort);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label(__('acl::acl.forms.user.name.label'))
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->label(__('acl::acl.forms.user.email.label'))
                    ->searchable(),
                static::getStatusTableIconColumn(),
                ...static::getFieldDatesFormForTable(),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Action::make('Logar')
                    ->icon('heroicon-o-user')
                    ->visible(auth()->user()->isAdmin())
                    ->url(fn (User $record): string => route('acl.user.login', ['user' => $record]))
                    ->openUrlInNewTab()
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

        $relations = [];

        if (config('acl.relations.acl.user.address',  true)) {
            $relations[] = AddressesRelationManager::class;
        }
        if (config('acl.relations.acl.user.contact',  true)) {
            $relations[] = ContactsRelationManager::class;
        }
        if (config('acl.relations.acl.user.document',  true)) {
            $relations[] = DocumentsRelationManager::class;
        }
        if (config('acl.relations.acl.user.social',  true)) {
            $relations[] = SocialsRelationManager::class;
        }

        return config('acl.relations.user', [...$relations]);
    }

    public static function getPages(): array
    {
        return config('acl.pages.user', [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ]);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes(config('acl.scopes.user', [
                SoftDeletingScope::class,
            ]))->tenant();
    }


    /**
     * Retorna o subtitulo do resultado da pesquisa global
     * @param Model $record
     * @return string
     */
    public static function getGlobalSearchResultDetails(Model $record): array
    {
        return [
            'E-Mail' => $record->email,
        ];
    }
}
