<?php

/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com, contato@sigasmart.com.br
 * https://www.sigasmart.com.br
 */


use Callcocam\Acl\Models\AccessGroup;
use Callcocam\Acl\Models\Permission;
use Callcocam\Acl\Models\Role;

return [
    /**
     * Você pode ativar ou desativar o sistema de controle de acesso embutido.
     * Isso é útil ao depurar seu aplicativo. Se o seu aplicativo já tiver seu
     * própria camada de controle de acesso, sugerimos desabilitar o Acl
     */
    'enabled' => true,
    /*
      |--------------------------------------------------------------------------
      | Experimental Cache
      |--------------------------------------------------------------------------
      |
      | O Acl-Action control list vem com uma camada de cache experimental na tentativa de diminuir
      | a carga nos recursos ao verificar e validar as permissões. De
      | padrão está desabilitado, habilite para fornecer feedback.
      */

    'cache' => [

        /**
         * Você pode ativar ou desativar o sistema de cache embutido. Isso é útil
         * ao depurar seu aplicativo. Se o seu aplicativo já tiver seu
         * própria camada de cache, sugerimos desabilitar o cache aqui também.
         */

        'enabled' => false,

        /**
         * Defina por quanto tempo as permissões devem ser armazenadas em cache antes de serem
         * atualizado. Os valores aceitos são em segundos ou como DateInterval
         * objeto. Por padrão, armazenamos em cache por 86400 segundos (também conhecido como 24 horas).
         */

        'length' => 60 * 60 * 24,

        /**
         * Ao usar um driver de cache que suporta tags, marcaremos o acl
         * cache com esta tag. Isso é útil para quebrar apenas o cache
         * responsável por armazenar permissões e nada mais.
         */

        'tag' => 'acl',

    ],

    'models' => [

        /*
        |--------------------------------------------------------------------------
        | Model References
        |--------------------------------------------------------------------------
        |
        | Acl precisa saber quais modelos do Eloquent devem ser referenciados durante
        | ações como registro e verificação de permissões, atribuição
        | permissões para funções e usuários e atribuição de funções aos usuários.
        */

        'role' =>  Role::class,
        'permission' =>  Permission::class,
        'access_group' =>  AccessGroup::class,

    ],

    'tables' => [

        /*
        |--------------------------------------------------------------------------
        | Table References
        |--------------------------------------------------------------------------
        |
        | Ao personalizar os modelos usados ​​pelo Acl, você também pode desejar
        | personalize os nomes das tabelas também. Você vai querer publicar o
        | migrações agrupadas e atualize as referências aqui para uso.
        */

        'access_groups' => 'access_groups',
        'roles' => 'roles',
        'permissions' => 'permissions',
        'role_user' => 'role_user',
        'permission_role' => 'permission_role',
        'permission_user' => 'permission_user',

    ],

    /*
    |--------------------------------------------------------------------------
    | Use Migrations
    |--------------------------------------------------------------------------
    |
    | Acl vem embalado com tudo pronto para você, incluindo
    | migrações. Se, em vez disso, você deseja personalizar ou estender o Acl além
    | sua oferta, você pode desativar as migrações fornecidas para você.
    */

    'migrate' => true,

    /*
    |--------------------------------------------------------------------------
    | Use Uuids
    |--------------------------------------------------------------------------
    |
    | Acl vem definida para usar chaves primárias incrementais por padrão. Se você
    | deseja usar UUIDs em vez disso, atualize esta configuração para true.
    | Você também precisará atualizar suas migrações para usar UUIDs.
    */

    'incrementing' => false,

    'keyType' => 'string',

    // 'connection' => 'mysql',

    'route' => [
        'prefix' => 'admin', 
    ],
    // 'navigation' => [
    //     'role' => [
    //         'group' => "Operacional",
    //         'icon' => null,
    //         'label' => 'Controle de Acesso',
    //         'badge' => null,
    //     ],
    //     'user' => [
    //         'group' => "Operacional",
    //         'icon' => null,
    //         'label' => 'Usuários',
    //         'badge' => null,
    //     ],
    //     'access_group' => [
    //         'group' => "Operacional",
    //         'icon' => null,
    //         'label' => 'Grupos de Acesso',
    //         'badge' => null,
    //     ],
    //     'permission' => [
    //         'group' => "Operacional",
    //         'icon' => null,
    //         'label' => 'Permissões',
    //         'badge' => null,
    //     ],
    // ],
];
