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
use Callcocam\Acl\RelationManagers\AddressesRelationManager;
use Callcocam\Acl\RelationManagers\ContactsRelationManager;
use Callcocam\Acl\RelationManagers\DocumentsRelationManager;
use Callcocam\Acl\RelationManagers\SocialsRelationManager;
use Callcocam\Acl\Traits\HasDatesFormForTableColums;
use Callcocam\Acl\Traits\HasGlobalSearchBase;
use Callcocam\Acl\Traits\HasStatusColumn;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserResource extends Resource
{
    use HasGlobalSearchBase, HasStatusColumn, HasDatesFormForTableColums;

    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user'; 

    protected static ?string $navigationGroup = "Acl";

    protected static ?string $modelLabel = 'Usuário';

    protected static ?string $modelLabelPlural = 'Usuários';

    protected static ?int $navigationSort = 2;
    

    public static function table(Table $table): Table
    {
        return $table
            ->columns([ 
                Tables\Columns\TextColumn::make('type')
                    ->searchable(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(), 
                Tables\Columns\TextColumn::make('office')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),   
                Tables\Columns\TextColumn::make('status')
                    ->searchable(), 
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true), 
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

        $relations = [];

        if(class_exists('App\\Models\\Callcocam\\Address')){

            $relations[] = AddressesRelationManager::class;
        }

        if(class_exists('App\\Models\\Callcocam\\Contact')){

            $relations[] = ContactsRelationManager::class;
        }

        if(class_exists('App\\Models\\Callcocam\\Document')){

            $relations[] = DocumentsRelationManager::class;
        }

        if(class_exists('App\\Models\\Callcocam\\Social')){

            $relations[] = SocialsRelationManager::class;
        }

        return $relations;
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }    
    
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
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