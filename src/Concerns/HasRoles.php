<?php
/**
* Created by Claudio Campos.
* User: callcocam@gmail.com, contato@sigasmart.com.br
* https://www.sigasmart.com.br
*/
namespace Callcocam\Acl\Concerns;

use Callcocam\Acl\Contracts\IRole;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Arr;
use Illuminate\Support\Str; 

trait HasRoles
{
  /**
     * Users can have many roles.
     *
     * @return BelongsToMany
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(config('acl.models.role'),'role_user','user_id')->withTimestamps();
    }

    /**
     * Checks if the model has the given role assigned.
     *
     * @return boolean
     */
    public function isAdmin(): bool
    {
              return (bool)$this->hasPermissionRoleFlags();
    }

    /**
     * Checks if the model has the given role assigned.
     *
     * @param string $role
     * @return boolean
     */
    public function hasRole($role): bool
    {
        $slug = Str::slug($role);

        return (bool)$this->roles->where('slug', $slug)->count();
    }

    /**
     * Checks if the model has any of the given roles assigned.
     *
     * @param array $roles
     * @return bool
     */
    public function hasAnyRole(...$roles): bool
    {
        
        foreach ($roles as $role) {
            if ($this->hasRole($role)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Checks if the model has all of the given roles assigned.
     *
     * @param array $roles
     * @return bool
     */
    public function hasAllRoles(...$roles): bool
    {
        foreach ($roles as $role) {
            if (!$this->hasRole(trim($role))) {
                return false;
            }
        }

        return true;
    }

    public function hasAnyRoles(array $roles): bool
    {
        foreach ($roles as $role) {
            if ($this->hasRole($role)) {
                return true;
            }
        }

        return false;
    }
    
    public function hasRoles(): bool
    {
        return (bool)$this->roles->count();
    }

    /**
     * Assign the specified roles to the model.
     *
     * @param mixed $roles,...
     * @return self
     */
    public function assignRoles(...$roles): self
    {
        $roles = Arr::flatten($roles);
        $roles = $this->getRoles($roles);

        if (!$roles) {
            return $this;
        }

        $this->roles()->syncWithoutDetaching($roles);

        return $this;
    }

    /**
     * Remove the specified roles from the model.
     *
     * @param mixed $roles,...
     * @return self
     */
    public function removeRoles(...$roles): self
    {
        $roles = Arr::flatten($roles);
        $roles = $this->getRoles($roles);

        $this->roles()->detach($roles);

        return $this;
    }

    /**
     * Sync the specified roles to the model.
     *
     * @param mixed $roles,...
     * @return self
     */
    public function syncRoles(...$roles): self
    {
        $roles = Arr::flatten($roles);
        $roles = $this->getRoles($roles);

        $this->roles()->sync($roles);

        return $this;
    }

    /**
     * Get the specified roles.
     *
     * @param array $roles
     * @return Role
     */
    protected function getRoles(array $roles)
    {
        return array_map(function ($role) {
            $model = $this->getRoleModel();

            if ($role instanceof $model) {
                return $role->id;
            }

            $role = $model->where('slug', $role)->first();

            return $role->id;
        }, $roles);
    }

    public function hasPermissionRoleFlags()
    {
        if ($this->hasRoles()) {
            return ($this->roles
                    ->filter(function ($role) {
                        return $role->special == "all-access";
                    })->count()) >= 1;
        }

        return false;
    }

    /**
     * Get the model instance responsible for permissions.
     *
     * @return  IRole
     */
    protected function getRoleModel(): IRole
    {
        return app()->make(config('acl.models.role'));
    }
}
