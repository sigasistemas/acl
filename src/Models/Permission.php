<?php

/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com, contato@sigasmart.com.br
 * https://www.sigasmart.com.br
 */

namespace Callcocam\Acl\Models;

use App\Models\Callcocam\AbstractModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany as BelongsToManyAlias;
use Callcocam\Acl\Concerns\RefreshesPermissionCache;
use Callcocam\Acl\Contracts\IPermission;
use Database\Factories\Callcocam\Acl\PermissionFactory;
use Illuminate\Database\Eloquent\Factories\Factory;

class Permission extends AbstractModel implements IPermission
{
    use RefreshesPermissionCache, HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        'id'
    ];

    /**
     * Permissions can belong to many roles.
     *
     * @return BelongsToManyAlias
     */
    public function roles(): BelongsToManyAlias
    {
        return $this->belongsToMany(config('acl.models.role'))->withTimestamps();
    }

    public function access_groups()
    {
        return $this->belongsTo(config('acl.models.access_group'), 'access_group_id');
    }

    protected function slugTo()
    {
        return false;
    }
}
