<?php

/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com, contato@sigasmart.com.br
 * https://www.sigasmart.com.br
 */

namespace Callcocam\Acl\Models;
 
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Callcocam\Acl\Traits\HasUlids;

class AbstractAclModel extends Model
{
    use SoftDeletes, HasUlids;

    public function __construct(array $attributes = [])
    {
        $this->incrementing = config('acl.incrementing', true);

        $this->keyType = config('acl.keyType', 'int');
        
        $this->connection = config('profile.connection', 'mysql');

        parent::__construct($attributes);
    }

    protected $guarded = [
        'id'
    ];

    
}
