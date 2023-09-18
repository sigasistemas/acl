<?php

/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com, contato@sigasmart.com.br
 * https://www.sigasmart.com.br
 */

namespace Callcocam\Acl\Models;

use App\Models\Callcocam\AbstractModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Callcocam\Acl\Contracts\IAccessGroup;
use Callcocam\Acl\Contracts\IPermission;
use Database\Factories\Callcocam\Acl\AccessGroupFactory;
use Illuminate\Database\Eloquent\Factories\Factory;

class AccessGroup extends AbstractModel implements IAccessGroup
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        'id'
    ];


    public function permissions()
    {
        return $this->hasMany(config('acl.models.permission'), 'access_group_id');
    }

    
}
