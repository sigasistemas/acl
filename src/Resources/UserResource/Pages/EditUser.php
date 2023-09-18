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
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Pages\EditRecord;

class EditUser extends EditRecord
{
    use HasStatusColumn, HasEditorColumn, HasPasswordCreateOrUpdate;

    protected static string $resource = UserResource::class;

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()->schema([
                    TextInput::make('name')
                        ->label('Nome Completo')
                        ->columnSpan([
                            'md' => 4,
                        ])
                        ->required()
                        ->maxLength(255),

                    TextInput::make('email')
                        ->label('Seu Melhor E-mail')
                        ->columnSpan([
                            'md' => 3,
                        ])
                        ->email()
                        ->required()
                        ->maxLength(255),
                    TextInput::make('office')
                        ->label('Cargo')
                        ->columnSpan([
                            'md' => 3,
                        ])
                        ->maxLength(255),
                    DatePicker::make('date_birth')
                        ->label('Data de Nascimento')
                        ->columnSpan([
                            'md' => 2,
                        ]),
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
                        ]),
                    Toggle::make('email_verified')
                        ->label('E-mail Verificado')
                        ->columnSpan([
                            'md' => 3,
                        ]),

                    Radio::make('status')
                        ->inline()
                        ->options([
                            'draft' => 'Draft',
                            'published' => 'Published',
                        ])
                        ->columnSpan([
                            'md' => 4,
                        ])
                        ->required(),
                    Fieldset::make('Dados de acesso')->schema([
                        CheckboxList::make('roles')
                            ->relationship('roles', 'name')
                            ->bulkToggleable()
                            ->searchable()
                            ->label('Accessos')
                            ->helperText('Selecione os accessos para este usuário')
                            ->columnSpanFull(),
                    ])->columnSpanFull(),

                    Fieldset::make('Dados de acesso')->schema([
                        ...static::getFieldPasswordForUpdateForm()
                    ])->columns(3),
                     static::getEditorFormField(),
                ])->columns(12)
            ])->columns(12);
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
