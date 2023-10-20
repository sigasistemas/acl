<?php

/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com, contato@sigasmart.com.br
 * https://www.sigasmart.com.br
 */

namespace Callcocam\Acl\Models;
 
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Callcocam\Acl\Concerns\HasPermissions;
use Callcocam\Acl\Contracts\IRole as ContractRole;
use Database\Factories\Callcocam\Acl\RoleFactory;
use Illuminate\Database\Eloquent\Factories\Factory;

class Role extends AbstractAclModel implements ContractRole
{
    use HasPermissions, HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        'id'
    ];

    /**
     * Roles can belong to many users.
     *
     * @return BelongsToMany
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }

    /**
     * Determine if role has permission flags.
     *
     * @return bool
     */
    public function hasPermissionFlags(): bool
    {
        return !is_null($this->special);
    }

    /**
     * Determine if the requested permission is permitted or denied
     * through a special role flag.
     *
     * @return bool
     */
    public function hasPermissionThroughFlag(): bool
    {
        if ($this->hasPermissionFlags()) {
            return !($this->special === 'no-access');
        }

        return true;
    }
 
}
