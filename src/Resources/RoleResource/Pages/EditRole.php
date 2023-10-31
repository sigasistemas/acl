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
    use HasStatusColumn, ExtraRoleTrait;

    protected static string $resource = RoleResource::class;

    public  function form(Form $form): Form
    {

        $cantents[] =   TextInput::make('name')
            ->label(__('acl::acl.forms.role.name.label'))
            ->placeholder(__('acl::acl.forms.role.name.placeholder'))
            ->required(config('acl.forms.role.name.required', true))
            ->maxLength(config('acl.forms.role.name.maxlength', 255));

        $cantents[] =    TextInput::make('slug')
            ->label(__('acl::acl.forms.role.slug.label'))
            ->placeholder(__('acl::acl.forms.role.slug.placeholder'))
            ->readOnly(config('acl.forms.role.slug.readonly', true))
            ->required(config('acl.forms.role.slug.required', true))
            ->maxLength(config('acl.forms.role.slug.maxlength', 255));

        $cantents[] =    Fieldset::make(__('acl::acl.forms.role.fieldset.label'))
            ->columnSpanFull()
            ->schema([
                CheckboxList::make('permissions')
                    ->relationship('permissions', 'name')
                    ->bulkToggleable()
                    ->searchable()->label('Permissões')
                    ->helperText('Selecione as permissões para este Accesso')
                    ->columnSpanFull()
            ])->label(__('acl::acl.forms.role.fieldset.label'));

        $cantents[] =    Radio::make('special')
            ->label(__('acl::acl.forms.role.special.label'))
            ->options(config('acl.forms.role.special.options', [
                'all-access' => 'Acesso Total',
                'no-access' => 'Nenhum Acesso',
            ]))
            ->inline();

        $cantents = $this->getExtraFieldsSchemaForm($this->record, $cantents);

        $cantents[] =    static::getStatusFormRadioField();

        $cantents[] =    Textarea::make('description')
            ->label(__('acl::acl.forms.role.description.label'))
            ->placeholder(__('acl::acl.forms.role.description.placeholder'))
            ->columnSpanFull();


        return $form
            ->schema($cantents);
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
