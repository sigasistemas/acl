<?php

/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com, contato@sigasmart.com.br
 * https://www.sigasmart.com.br
 */

namespace Callcocam\Acl\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Callcocam\Acl\Contracts\IAccessGroup;
use Database\Factories\Callcocam\Acl\AccessGroupFactory;
use Illuminate\Database\Eloquent\Factories\Factory;

class AccessGroup extends AbstractAclModel implements IAccessGroup
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

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->setTable(config('acl.tables.access_groups', 'access_group'));
    }

    public function permissions()
    {
        return $this->hasMany(config('acl.models.permission'), 'access_group_id');
    }


}
