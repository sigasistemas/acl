<?php

/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com, contato@sigasmart.com.br
 * https://www.sigasmart.com.br
 */

namespace Callcocam\Acl;

use Filament\Contracts\Plugin;
use Filament\Panel; 

class AclPlugin implements Plugin
{

    protected $userUserResources = false;
    protected $userUseAccessGroup = false;

    public function __construct($userUserResources = false, $userUseAccessGroup = true)
    {
        $this->userUserResources = $userUserResources;
        $this->userUseAccessGroup = $userUseAccessGroup;
    } 

    public function getId(): string
    {
        return 'acl';
    }

    public function register(Panel $panel): void
    {
        $resourses = [];

        if ($this->userUserResources) {
            $resourses[] = Resources\UserResource::class;
        }

        if ($this->userUseAccessGroup) {
            $resourses[] = Resources\AccessGroupResource::class;
        }

        $panel->resources(array_merge($resourses, [ 
            Resources\RoleResource::class,
            Resources\PermissionResource::class,
        ]));
    }

    public function boot(Panel $panel): void
    {
        //
    }

    public static function make(): static
    {
        return app(static::class);
    }

    public static function get(): static
    {
        /** @var static $plugin */
        $plugin = filament(app(static::class)->getId());

        return $plugin;
    }
}
