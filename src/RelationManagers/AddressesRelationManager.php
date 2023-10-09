<?php

/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com, contato@sigasmart.com.br
 * https://www.sigasmart.com.br
 */

namespace Callcocam\Acl\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Support\Enums\IconPosition;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class AddressesRelationManager extends RelationManager
{
    protected static string $relationship = 'addresses';

    protected static ?string $title = 'Endereços';

    protected static ?string $icon =  'fas-map-location-dot';


    public static function getIcon(Model $ownerRecord, string $pageClass): ?string
    {
        return config('acl.resources.address.icon', static::$icon);
    }

    public static function getIconPosition(Model $ownerRecord, string $pageClass): IconPosition
    {
        return config('acl.resources.address.iconPosition', static::$iconPosition);
    }

    public static function getBadge(Model $ownerRecord, string $pageClass): ?string
    {
        return config('acl.resources.address.badge', static::$badge);
    }

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return  config('acl.resources.address.title',   parent::getTitle($ownerRecord, $pageClass));
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label(__('acl::acl.forms.address.name.label'))
                    ->placeholder(__('acl::acl.forms.address.name.placeholder'))
                    ->columnSpan([
                        'md' => config('acl.resources.address.name.columnSpan', 5),
                    ])
                    ->hidden(config('acl.resources.address.name.hidden', false))
                    ->required(config('acl.resources.address.name.required', true))
                    ->maxLength(config('acl.resources.address.name.maxLength', 255)),
                \Leandrocfe\FilamentPtbrFormFields\Cep::make('zip')
                    ->label(__('acl::acl.forms.address.zip.label'))
                    ->placeholder(__('acl::acl.forms.address.zip.placeholder'))
                    ->hidden(config('acl.resources.address.zip.hidden', false))
                    ->viaCep(
                        mode: 'suffix', // Determines whether the action should be appended to (suffix) or prepended to (prefix) the cep field, or not included at all (none).
                        errorMessage: 'CEP inválido.', // Error message to display if the CEP is invalid.

                        /**
                         * Other form fields that can be filled by ViaCep.
                         * The key is the name of the Filament input, and the value is the ViaCep attribute that corresponds to it.
                         * More information: https://viacep.com.br/
                         */
                        setFields: [
                            'street' => 'logradouro',
                            'number' => 'numero',
                            'complement' => 'complemento',
                            'district' => 'bairro',
                            'city' => 'localidade',
                            'state' => 'uf'
                        ]
                    )
                    ->columnSpan([
                        'md' => config('acl.resources.address.zip.columnSpan', 3),
                    ])
                    ->required(config('acl.resources.address.zip.required', true))
                    ->maxLength(config('acl.resources.address.zip.maxLength', 255)),
                Forms\Components\TextInput::make('street')
                    ->label(__('acl::acl.forms.address.street.label'))
                    ->placeholder(__('acl::acl.forms.address.street.placeholder'))
                    ->hidden(config('acl.resources.address.street.hidden', false))
                    ->columnSpan([
                        'md' => config('acl.resources.address.street.columnSpan', 4),
                    ])
                    ->required(config('acl.resources.address.street.required', true))
                    ->maxLength(config('acl.resources.address.street.maxLength', 255)),
                Forms\Components\TextInput::make('number')
                    ->label(__('acl::acl.forms.address.number.label'))
                    ->placeholder(__('acl::acl.forms.address.number.placeholder'))
                    ->columnSpan([
                        'md' => config('acl.resources.address.number.columnSpan', 4),
                    ])
                    ->required(config('acl.resources.address.number.required', true))
                    ->maxLength(config('acl.resources.address.number.maxLength', 255)),
                Forms\Components\TextInput::make('complement')
                    ->label(__('acl::acl.forms.address.complement.label'))
                    ->placeholder(__('acl::acl.forms.address.complement.placeholder'))
                    ->columnSpan([
                        'md' => config('acl.resources.address.complement.columnSpan', 8),
                    ])
                    ->required(config('acl.resources.address.complement.required', true))
                    ->maxLength(config('acl.resources.address.complement.maxLength', 255)),
                Forms\Components\TextInput::make('district')
                    ->label(__('acl::acl.forms.address.district.label'))
                    ->placeholder(__('acl::acl.forms.address.district.placeholder'))
                    ->columnSpan([
                        'md' => config('acl.resources.address.district.columnSpan', 4),
                    ])
                    ->required(config('acl.resources.address.district.required', true))
                    ->maxLength(config('acl.resources.address.district.maxLength', 255)),
                Forms\Components\TextInput::make('city')
                    ->label(__('acl::acl.forms.address.city.label'))
                    ->placeholder(__('acl::acl.forms.address.city.placeholder'))
                    ->columnSpan([
                        'md' => config('acl.resources.address.city.columnSpan', 5),
                    ])
                    ->required(config('acl.resources.address.city.required', true))
                    ->maxLength(config('acl.resources.address.city.maxLength', 255)),
                Forms\Components\Select::make('state')
                    ->options(config('acl.resources.address.options.state', []))
                    ->label(__('acl::acl.forms.address.state.label'))
                    ->placeholder(__('acl::acl.forms.address.state.placeholder'))
                    ->columnSpan([
                        'md' => config('acl.resources.address.state.columnSpan', 3)
                    ])
                    ->required(),
                Forms\Components\TextInput::make('country')
                    ->label(__('acl::acl.forms.address.country.label'))
                    ->placeholder(__('acl::acl.forms.address.country.placeholder'))
                    ->default('Brasil')
                    ->columnSpan([
                        'md' => config('acl.resources.address.country.columnSpan', 4),
                    ])
                    ->required(config('acl.resources.address.country.required', true))
                    ->maxLength(config('acl.resources.address.country.maxLength', 255)),
                Forms\Components\TextInput::make('latitude')
                    ->label(__('acl::acl.forms.address.latitude.label'))
                    ->placeholder(__('acl::acl.forms.address.latitude.placeholder'))
                    ->columnSpan([
                        'md' => config('acl.resources.address.latitude.columnSpan', 4)
                    ])
                    ->required()
                    ->maxLength(config('acl.resources.address.latitude.maxLength', 255)),
                Forms\Components\TextInput::make('longitude')
                    ->label(__('acl::acl.forms.address.longitude.label'))
                    ->placeholder(__('acl::acl.forms.address.longitude.placeholder'))
                    ->columnSpan([
                        'md' => config('acl.resources.address.longitude.columnSpan', 4)
                    ])
                    ->required(config('acl.resources.address.longitude.required', true))
                    ->maxLength(config('acl.resources.address.longitude.maxLength', 255)),
                Forms\Components\Radio::make('status')
                    ->label(__('acl::acl.forms.address.status.label'))
                    ->inline()
                    ->options([
                        'draft' => 'Rascunho',
                        'published' => 'Publicado',
                    ])
                    ->columnSpanFull()
                    ->required(config('acl.resources.address.status.required', true)),
            ])->columns(12);
    }

    public function table(Table $table): Table
    {
        return $table
            ->modelLabel(__('acl::acl.forms.address.modelLabel'))
            ->pluralModelLabel(__('acl::acl.forms.address.pluralModelLabel'))
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label(__('acl::acl.forms.address.name.label'))
                    ->placeholder(__('acl::acl.forms.address.name.placeholder'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('zip')
                    ->label(__('acl::acl.forms.address.zip.label'))
                    ->placeholder(__('acl::acl.forms.address.zip.placeholder'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('street')
                    ->label(__('acl::acl.forms.address.street.label'))
                    ->placeholder(__('acl::acl.forms.address.street.placeholder'))
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions(
                config('acl.resources.address.header_actions', [
                    Tables\Actions\CreateAction::make(),
                ])
            )
            ->actions(
                config('acl.resources.address.actions', [
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ])
            )
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make(config(
                    'acl.resources.address.bulk_actions',
                    [
                        Tables\Actions\DeleteBulkAction::make(),
                    ]
                )),
            ])
            ->emptyStateActions(config(
                'acl.resources.address.emptyState',
                [
                    Tables\Actions\CreateAction::make(),
                ]
            ));
    }
}
