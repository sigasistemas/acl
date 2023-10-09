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
                    ->label(__('acl::acl.forms.user.type.label'))
                    ->options(config('acl.resources.user.type.options', [
                        'user' => 'User',
                        'client' => 'Client',
                    ]))
                    ->columnSpan(config('acl.resources.user.type.columnSpan', [
                        'md' => 2,
                    ]))
                    ->required(config('acl.resources.user.type.required', true)),
                TextInput::make('name')
                    ->label(__('acl::acl.forms.user.name.label'))
                    ->placeholder(__('acl::acl.forms.user.name.placeholder'))
                    ->columnSpan(config('acl.resources.user.name.columnSpan', [
                        'md' => 5,
                    ]))
                    ->required(config('acl.resources.user.name.required', true))
                    ->maxLength(config('acl.resources.user.name.maxLength', 255)),

                TextInput::make('email')
                    ->label(__('acl::acl.forms.user.email.label'))
                    ->placeholder(__('acl::acl.forms.user.email.placeholder'))
                    ->columnSpan(config('acl.resources.user.email.columnSpan', [
                        'md' => 5,
                    ]))
                    ->email()
                    ->required(config('acl.resources.user.email.required', true))
                    ->maxLength(config('acl.resources.user.email.maxLength', 255)),

                static::getStatusFormRadioField()
                    ->columnSpanFull(),
                Fieldset::make(__('acl::acl.forms.user.data.access.label'))->schema([
                    ...static::getFieldPasswordForCreateForm()
                ])->columns(2),
                static::getEditorFormField()
                    ->columnSpanFull(),
            ])->columns(12)
        ]);
    }
}
