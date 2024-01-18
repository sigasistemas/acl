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
                        ->label(__('acl::acl.forms.user.name.label'))
                        ->placeholder(__('acl::acl.forms.user.name.placeholder'))
                        ->columnSpan(config('acl.forms.user.name.columnSpan', [
                            'md' => 7,
                        ]))
                        ->required(config('acl.forms.user.name.required', true))
                        ->hidden(config('acl.forms.user.name.hidden', false))
                        ->hiddenLabel(config('acl.forms.user.name.hiddenLabel', false))
                        ->maxLength(config('acl.forms.user.name.maxLength', 255)),

                    TextInput::make('email')
                        ->label(__('acl::acl.forms.user.email.label'))
                        ->placeholder(__('acl::acl.forms.user.email.placeholder'))
                        ->columnSpan(config('acl.forms.user.email.columnSpan', [
                            'md' => 5,
                        ]))
                        ->email()
                        ->required(config('acl.forms.user.email.required', true))
                        ->hidden(config('acl.forms.user.email.hidden', false))
                        ->hiddenLabel(config('acl.forms.user.email.hiddenLabel', false))
                        ->maxLength(config('acl.forms.user.email.maxLength', 255)),
                    TextInput::make('office')
                        ->label(__('acl::acl.forms.user.office.label'))
                        ->placeholder(__('acl::acl.forms.user.office.placeholder'))
                        ->columnSpan(config('acl.forms.user.office.columnSpan', [
                            'md' => 3,
                        ]))
                        ->required(config('acl.forms.user.office.required', false))
                        ->hidden(config('acl.forms.user.office.hidden', false))
                        ->hiddenLabel(config('acl.forms.user.office.hiddenLabel', false))
                        ->maxLength(config('acl.forms.user.office.maxLength', 255)),
                    DatePicker::make('date_birth')
                        ->label(__('acl::acl.forms.user.date_birth.label'))
                        ->placeholder(__('acl::acl.forms.user.date_birth.placeholder'))
                        ->required(config('acl.forms.user.date_birth.required', false))
                        ->hidden(config('acl.forms.user.date_birth.hidden', false))
                        ->hiddenLabel(config('acl.forms.user.date_birth.hiddenLabel', false))
                        ->columnSpan(config('acl.forms.user.date_birth.columnSpan', [
                            'md' => 2,
                        ])),
                    Radio::make('genre')
                        ->label(__('acl::acl.forms.user.genre.label'))
                        ->visible(config('acl.forms.user.genre.visible', false))
                        ->inline()
                        ->options(config('acl.forms.user.genre.options', [
                            'masculino' => 'Masculino',
                            'feminino' => 'Feminino',
                            'outros' => 'Outros',
                        ]))
                        ->columnSpan(config('acl.forms.user.genre.columnSpan', [
                            'md' => 5,
                        ])),
                    Toggle::make('email_verified')
                        ->visible(config('acl.forms.user.email_verified.visible', false))
                        ->label(__('acl::acl.forms.user.email_verified.label'))
                        ->helperText(__('acl::acl.forms.user.email_verified.helpText'))
                        ->columnSpan(config('acl.forms.user.email_verified.columnSpan', [
                            'md' => 3,
                        ])),

                    Radio::make('status')
                        ->visible(config('acl.forms.user.status.visible', true))
                        ->options(config('acl.forms.user.status.options', [
                            'published' => 'Ativo',
                            'draft' => 'Inativo',
                        ]))
                        ->columnSpan(config('acl.forms.user.status.columnSpan', [
                            'md' => 12,
                        ]))
                        ->required(config('acl.forms.user.status.required', true)),
                    Fieldset::make(__('acl::acl.forms.user.roles.label'))
                        ->visible(function ($record) {
                            if ($record->isAdmin()) return true;

                            $access = config('acl.forms.user.roles.visible',  'super-admin');
                            if (is_array($access)) {
                                return auth()->user()->hasAnyRoles($access);
                            }
                            return auth()->user()->hasAnyRole($access);
                        })
                        ->schema([
                            CheckboxList::make('roles')
                                ->relationship('roles', 'name')
                                ->bulkToggleable(config('acl.forms.user.roles.bulkToggleable', true))
                                ->searchable(config('acl.forms.user.roles.searchable', true))
                                ->label(config('acl.forms.user.roles.label', 'Roles'))
                                ->helperText(config('acl.forms.user.roles.helperText', 'Select roles for this user.'))
                                ->columnSpanFull(),
                        ])->columnSpanFull(),

                    Fieldset::make(__('acl::acl.forms.user.data.access.label'))->schema([
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

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function mutateFormDataBeforeSave(array $data): array
    {
        return array_filter($data);
    }
}
