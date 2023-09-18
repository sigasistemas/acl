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
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Pages\CreateRecord;

class CreateRole extends CreateRecord
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
                Radio::make('special')
                    ->label('Tipo de Accesso')
                    ->options([
                        'all-access' => 'Acesso Total',
                        'no-access' => 'Sem Acesso',
                    ])
                    ->inline(),
                static::getStatusFormRadioField()
                    ->inline(),
                Textarea::make('description')
                    ->label('Descrição')
                    ->maxLength(65535)
                    ->columnSpanFull(),
            ]);
    }
}
