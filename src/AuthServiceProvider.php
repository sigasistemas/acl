<?php

/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com, contato@sigasmart.com.br
 * https://www.sigasmart.com.br
 */

namespace Callcocam\Acl;

// use Illuminate\Support\Facades\Gate;

use App\Models\Callcocam\AccessGroup;
use App\Models\Callcocam\Permission;
use App\Models\Callcocam\Role;
use App\Models\Callcocam\Tenant;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Role::class => Policies\RolePolicy::class,
        Permission::class => Policies\PermissionPolicy::class,
        Tenant::class => Policies\TenantPolicy::class,
        AccessGroup::class => Policies\AccessGroupPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();
    }
}
