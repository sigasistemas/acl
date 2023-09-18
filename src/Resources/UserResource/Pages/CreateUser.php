<?php

/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com, contato@sigasmart.com.br
 * https://www.sigasmart.com.br
 */

namespace Callcocam\Acl\Resources\UserResource\Pages;

use Callcocam\Acl\Resources\UserResource;
use Callcocam\Acl\Traits\HasEditorColumn;
use Callcocam\Acl\Traits\HasPasswordCreateOrUpdate;
use Callcocam\Acl\Traits\HasStatusColumn;
use Filament\Actions;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Pages\CreateRecord;

class CreateUser extends CreateRecord
{
    use HasPasswordCreateOrUpdate, HasStatusColumn, HasEditorColumn;

    protected static string $resource = UserResource::class;

    public function form(Form $form): Form
    {
        return $form->schema([
            Section::make()->schema([
                Select::make('type')
                    ->label('Tipo de Usuário')
                    ->options([
                        'user' => 'User',
                        'rpps' => 'Rpps',
                        'councilors' => 'Consiliors',
                    ])
                    ->columnSpan([
                        'md' => 2,
                    ])
                    ->required(),
                TextInput::make('name')
                    ->label('Nome Completo')
                    ->columnSpan([
                        'md' => 5,
                    ])
                    ->required()
                    ->maxLength(255),

                TextInput::make('email')
                    ->label('Seu Melhor E-mail')
                    ->columnSpan([
                        'md' => 5,
                    ])
                    ->email()
                    ->required()
                    ->maxLength(255),
                TextInput::make('office')
                    ->label('Cargo')
                    ->columnSpan([
                        'md' => 4,
                    ])
                    ->maxLength(255),
                DatePicker::make('date_birth')
                    ->label('Data de Nascimento')
                    ->columnSpan([
                        'md' => 3,
                    ]),
                Fieldset::make('Gênero')
                    ->schema(
                        [
                            Radio::make('genre')
                                ->label('Gênero')
                                ->inline()
                                ->options([
                                    'masculino' => 'Masculino',
                                    'feminino' => 'Feminino',
                                    'outros' => 'Outros',
                                ])
                                ->columnSpan([
                                    'md' => 5,
                                ])
                        ]
                    )->columnSpan([
                        'md' => 5,
                    ]),
                Toggle::make('email_verified')
                    ->label('E-mail Verificado')
                    ->columnSpan([
                        'md' => 3,
                    ]),
                static::getStatusFormRadioField()
                    ->columnSpanFull(),
                Fieldset::make('Dados de acesso')->schema([
                    ...static::getFieldPasswordForCreateForm()
                ])->columns(2),
                static::getEditorFormField()
                    ->columnSpanFull(),
            ])->columns(12)
        ]);
    }
}
