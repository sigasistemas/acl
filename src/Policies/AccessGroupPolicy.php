<?php
/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com, contato@sigasmart.com.br
 * https://www.sigasmart.com.br
 */
namespace Callcocam\Acl\Policies;
 
use App\Models\User;
use Callcocam\Acl\Contracts\IAccessGroup; 

class AccessGroupPolicy
{
     protected $permissions = 'admin.access-groups';

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
          return $user->can(sprintf("%s.index", $this->permissions));
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, IAccessGroup $accessGroup): bool
    {
        return $user->can(sprintf("%s.view", $this->permissions));
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can(sprintf("%s.create", $this->permissions));
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, IAccessGroup $accessGroup): bool
    {
         return $user->can(sprintf("%s.update", $this->permissions));
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, IAccessGroup $accessGroup): bool
    {
         return $user->can(sprintf("%s.delete", $this->permissions));
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, IAccessGroup $accessGroup): bool
    {
       return $user->can(sprintf("%s.restore", $this->permissions));
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, IAccessGroup $accessGroup): bool
    {
        return $user->can(sprintf("%s.forceDelete", $this->permissions));
    }
}
