<?php

/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com, contato@sigasmart.com.br
 * https://www.sigasmart.com.br
 */

namespace Callcocam\Acl\Traits;

use Closure;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Get;
use Illuminate\Support\Facades\Hash;

trait HasPasswordCreateOrUpdate
{

    /**
     * @return Fieldset
     * Cria um fieldset para o formulário de cadastro de usuário
     */
    public static function getSectionPasswordForCreateForm($name = "Dados de accesso")
    {
        return Fieldset::make($name)->schema(static::getFieldPasswordForCreateForm())->columns(2);
    }

    /**
     * @return array
     * Cria um array com os campos para o formulário de cadastro de usuário
     * para criar a senha,  o campo senha é obrigatório e o campo senha de confirmação,
     * o campo senha é validado com o campo senha de confirmação.
     */
    public static function getFieldPasswordForCreateForm()
    {

        return  [
            TextInput::make(static::getPasswordName())
                ->label(static::getPasswordLabel())
                ->password()
                ->confirmed(static::getPasswordConfirmationName())
                ->required()
                ->maxLength(static::getMaxLengthPassword()),
            TextInput::make(static::getPasswordConfirmationName())
                ->label(static::getPasswordConfirmationLabel())
                ->password()
                ->required()
                ->maxLength(static::getMaxLengthPassword()),
        ];
    }

    public static function getSectionPasswordForUpdateForm($name = "Dados de accesso")
    {
        return Fieldset::make($name)
            ->schema(static::getFieldPasswordForUpdateForm())
            ->columns(3);
    }

    /**
     * @return array
     * Cria um array com os campos para o formulário de cadastro de usuário
     * para alterar a senha, o campo senha atual é obrigatório se o campo senha
     * for preenchido, o campo senha atual é validado com a senha atual do usuário,
     * se o campo senha atual não for preenchido, o campo senha não é validado,
     * se o campo senha atual for preenchido e o campo senha não for preenchido,
     * o campo senha atual é validado com a senha atual do usuário.
     */
    public static function getFieldPasswordForUpdateForm()
    {
        return  [
            TextInput::make(static::getCurretPasswordName())
                ->label(static::getCurretPasswordLabel())
                ->password()
                ->reactive()
                ->rules(static::getCurretPasswordRules())
                ->maxLength(static::getMaxLengthPassword()),
            TextInput::make(static::getPasswordName())
                ->label(static::getPasswordLabel())
                ->password()
                ->confirmed(static::getPasswordConfirmationName())
                ->maxLength(static::getMaxLengthPassword()),
            TextInput::make(static::getPasswordConfirmationName())
                ->label(static::getPasswordConfirmationLabel())
                ->password()
                ->maxLength(static::getMaxLengthPassword()),
        ];
    }

    public static function getCurretPasswordName()
    {
        return 'current_password';
    }

    public static function getPasswordName()
    {
        return 'password';
    }

    public static function getPasswordConfirmationName()
    {
        return 'password_confirmation';
    }

    public static function getCurretPasswordLabel()
    {
        return 'Senha Atual';
    }

    public static function getPasswordLabel()
    {
        return 'Nova Senha';
    }

    public static function getPasswordConfirmationLabel()
    {
        return 'Confirme a Nova Senha';
    }

    public static function getCurretPasswordPlaceholder()
    {
        return 'Senha Atual';
    }

    public static function getPasswordPlaceholder()
    {
        return 'Nova Senha';
    }

    public static function getPasswordConfirmationPlaceholder()
    {
        return 'Confirme a Nova Senha';
    }

    public static function getCurretPasswordRules()
    {
        return [
            function ($record) {
                return function (string $attribute, $value, Closure $fail) use ($record) {
                    if (!Hash::check($value, $record->password)) {
                        $fail('The :attribute is invalid.');
                    }
                };
            },
        ];
    }

    public static function getRulesRequiredPassword()
    {
        return function (Get $get) {
            return $get(static::getCurretPasswordName()) != null;
        };
    }

    public static function getMaxLengthPassword()
    {
        return 8;
    }

    public function setPasswordAttribute($value)
    {
        if ($value) {
            $this->attributes['password'] = bcrypt($value);
        }
    }
}
