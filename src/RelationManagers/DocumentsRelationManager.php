<?php

/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com, contato@sigasmart.com.br
 * https://www.sigasmart.com.br
 */

namespace Callcocam\Acl\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Support\Enums\IconPosition;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Leandrocfe\FilamentPtbrFormFields\Document;

class DocumentsRelationManager extends RelationManager
{
    protected static string $relationship = 'documents';

    protected static ?string $title = 'Documentos';

    protected static ?string $icon =  'fas-id-badge';


    public static function getIcon(Model $ownerRecord, string $pageClass): ?string
    {
        return config('acl.resources.documents.icon', static::$icon);
    }

    public static function getIconPosition(Model $ownerRecord, string $pageClass): IconPosition
    {
        return config('acl.resources.documents.iconPosition', static::$iconPosition);
    }

    public static function getBadge(Model $ownerRecord, string $pageClass): ?string
    {
        return config('acl.resources.documents.badge', static::$badge);
    }

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return  config('acl.resources.documents.title',   parent::getTitle($ownerRecord, $pageClass));
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('name')
                    ->options(config('acl.resources.documents.options', []))->reactive()
                    ->label(__('acl::acl.forms.document.name.label'))
                    ->placeholder(__('acl::acl.forms.document.name.placeholder'))
                    ->hidden(config('acl.resources.documents.hidden', false))
                    ->required(config('acl.resources.documents.required', true)),
                Document::make('description')
                    ->mask(function (Get $get) {
                        $type = strtolower($get('name'));
                        switch ($type):
                            case 'cpf':
                                return '999.999.999-99';
                                break;
                            case 'cnpj':
                                return '99.999.999/9999-99';
                                break;
                            case 'rg':
                                return '99.999.999-9';
                                break;
                            default:
                                return null;
                                break;
                        endswitch;
                    })
                    ->label(__('acl::acl.forms.document.description.label'))
                    ->placeholder(__('acl::acl.forms.document.description.placeholder'))
                    ->required(config('acl.resources.documents.required', true))
                    ->hidden(config('acl.resources.documents.hidden', false))
                    ->maxLength(config('acl.resources.documents.maxlength', 255)),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->modelLabel(__('acl::acl.forms.document.modelLabel'))
            ->pluralModelLabel(__('acl::acl.forms.document.pluralModelLabel'))
            ->recordTitleAttribute(config('acl.resources.documents.title', 'name'))
            ->columns([
                Tables\Columns\TextColumn::make('name'),
            ])
            ->filters(config('acl.resources.documents.filters', []))
            ->headerActions(config(
                'acl.resources.documents.header_actions',
                [
                    Tables\Actions\CreateAction::make(),
                ]
            ))
            ->actions(config(
                'acl.resources.documents.actions',
                [
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ]
            ))
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make(config(
                    'acl.resources.documents.bulk_actions',
                    [
                        Tables\Actions\DeleteBulkAction::make(),
                    ]
                )),
            ])
            ->emptyStateActions(config(
                'acl.resources.documents.emptyState',
                [
                    Tables\Actions\CreateAction::make(),
                ]
            ));
    }
}
