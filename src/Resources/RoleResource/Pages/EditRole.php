<?php

/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com, contato@sigasmart.com.br
 * https://www.sigasmart.com.br
 */

namespace Callcocam\Acl\Resources\RoleResource\Pages;

use Callcocam\Acl\Resources\RoleResource;
use Callcocam\Acl\Traits\HasStatusColumn;
use Filament\Actions;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Pages\EditRecord;

class EditRole extends EditRecord
{
    use HasStatusColumn;

    protected static string $resource = RoleResource::class;

    public  function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Nome do Accesso')
                    ->required()
                    ->maxLength(255),
                TextInput::make('slug')
                    ->label('Slug do Accesso')
                    ->readOnly()
                    ->required()
                    ->maxLength(255),
                Fieldset::make('Informações do Accesso')
                    ->columnSpanFull()
                    ->schema([
                        CheckboxList::make('permissions')
                            ->relationship('permissions', 'name')
                            ->bulkToggleable()
                            ->searchable()->label('Permissões')
                            ->helperText('Selecione as permissões para este Accesso')
                            ->columnSpanFull()
                    ])->label('Informações do Accesso'),
                Radio::make('special')
                    ->label('Tipo de Accesso')
                    ->options([
                        'all-access' => 'Acesso Total',
                        'no-access' => 'Sem Acesso',
                    ])
                    ->inline(),
                static::getStatusFormRadioField(),
                Textarea::make('description')
                    ->label('Descrição')
                    ->maxLength(65535)
                    ->columnSpanFull(),
            ]);
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
}
