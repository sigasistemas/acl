<?php
/**
* Created by Claudio Campos.
* User: callcocam@gmail.com, contato@sigasmart.com.br
* https://www.sigasmart.com.br
*/
namespace Callcocam\Acl\Concerns;


use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Arr;
use Callcocam\Acl\Exceptions\PermissionNotFoundException; 
use Callcocam\Acl\Models\Permission as ModelsPermission;

trait HasPermissions
{

    public function getKeyField()
    {
        return config('acl.key', 'slug');
    }
    /**
     * Users can have many permissions
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function permissions(): BelongsToMany
    {

        return $this->belongsToMany(config('acl.models.permission'));
    }

    /**
     * The mothergoose check. Runs through each scenario provided
     * by Shinobi - checking for special flags, role permissions, and
     * individual user permissions; in that order.
     *
     * @param  ModelsPermission|String  $permission
     * @return boolean
     */
    public function hasPermissionTo($permission): bool
    {

        // Check role flags
        if ((method_exists($this, 'hasPermissionRoleFlags') and $this->hasPermissionRoleFlags())) {
            return $this->hasPermissionThroughRoleFlag();
        }

        if ((method_exists($this, 'hasPermissionFlags') and $this->hasPermissionFlags())) {
            return $this->hasPermissionThroughFlag();
        }

        // Fetch permission if we pass through a string
        if (is_string($permission)) {
            $permission = $this->getPermissionModel()->where($this->getKeyField(), $permission)->first();

            if (! $permission) {
                throw new PermissionNotFoundException;
            }
        }

        // Check role permissions
        if (method_exists($this, 'hasPermissionThroughRole') and $this->hasPermissionThroughRole($permission)) {
            return true;
        }

        // Check user permission
        if ($this->hasPermission($permission)) {
            return true;
        }

        return false;
    }

    /**
     * Give the specified permissions to the model.
     *
     * @param  array  $permissions
     * @return self
     */
    public function givePermissionTo(...$permissions): self
    {
        $permissions = Arr::flatten($permissions);
        $permissions = $this->getPermissions($permissions);

        if (! $permissions) {
            return $this;
        }

        $this->permissions()->syncWithoutDetaching($permissions);

        return $this;
    }

    /**
     * Revoke the specified permissions from the model.
     *
     * @param  array  $permissions
     * @return self
     */
    public function revokePermissionTo(...$permissions): self
    {
        $permissions = Arr::flatten($permissions);
        $permissions = $this->getPermissions($permissions);

        $this->permissions()->detach($permissions);

        return $this;
    }

    /**
     * Sync the specified permissions against the model.
     *
     * @param  array  $permissions
     * @return self
     */
    public function syncPermissions(...$permissions): self
    {
        $permissions = Arr::flatten($permissions);
        $permissions = $this->getPermissions($permissions);

        $this->permissions()->sync($permissions);

        return $this;
    }

    /**
     * Get the specified permissions.
     *
     * @param  array  $permissions
     * @return ModelsPermission
     */
    protected function getPermissions(array $collection)
    {
        return array_map(function($permission) {
            $model = $this->getPermissionModel();

            if ($permission instanceof ModelsPermission) {
                return $permission->id;
            }

            $permission = $model->where($this->getKeyField(), $permission)->first();

            return $permission->id;
        }, $collection);
    }

    /**
     * Checks if the user has the given permission assigned.
     *
     * @param  ModelsPermission  $permission
     * @return boolean
     */
    protected function hasPermission($permission): bool
    {
        $model = $this->getPermissionModel();

        if ($permission instanceof ModelsPermission) {
            $permission = $permission->slug;
        }

        return (bool) $this->permissions()->where($this->getKeyField(), $permission)->count();
    }

    /**
     * Get the model instance responsible for permissions.
     *
     * @return \Callcocam\Acl\Contracts\IPermission|\Illuminate\Database\Eloquent\Collection
     */
    protected function getPermissionModel()
    {
        // if (config('acl.cache.enabled')) {
        //     return cache()->tags(config('acl.cache.tag'))->remember(
        //         'permissions',
        //         config('acl.cache.length'),
        //         function() {
        //             return app()->make(config('acl.models.permission'))->get();
        //         }
        //     );
        // }

        return app()->make(config('acl.models.permission'));
    }
}
