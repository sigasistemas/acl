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
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Str;

class CreateRole extends CreateRecord
{
    use HasStatusColumn;

    protected static string $resource = RoleResource::class;


    public  function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label(__('acl::acl.forms.role.name.label'))
                    ->placeholder(__('acl::acl.forms.role.name.placeholder'))
                    ->required(config('acl.forms.role.name.required', true))
                    ->maxLength(config('acl.forms.role.name.maxlength', 255))->live(true)
                    ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state))),
                TextInput::make('slug')
                    ->label(__('acl::acl.forms.role.slug.label'))
                    ->placeholder(__('acl::acl.forms.role.slug.placeholder'))
                    ->readOnly(config('acl.forms.role.slug.readonly', false))
                    ->required(config('acl.forms.role.slug.required', true))
                    ->maxLength(config('acl.forms.role.slug.maxlength', 255)),
                Radio::make('special')
                    ->label(__('acl::acl.forms.role.special.label'))
                    ->options(config('acl.forms.role.special.options', [
                        'all-access' => 'Acesso Total',
                        'no-access' => 'Nenhum Acesso',
                    ]))
                    ->inline()
                    ->columnSpanFull(),
                static::getStatusFormRadioField(),
                Textarea::make('description')
                    ->label(__('acl::acl.forms.role.description.label'))
                    ->placeholder(__('acl::acl.forms.role.description.placeholder'))
                    ->columnSpanFull(),
            ]);
    }

   
}
