<?php

/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com, contato@sigasmart.com.br
 * https://www.sigasmart.com.br
 */

namespace Callcocam\Acl\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AbstractAclModel extends Model
{
    use SoftDeletes;

    public function __construct(array $attributes = [])
    {
        $this->incrementing = config('acl.incrementing', true);

        $this->keyType = config('acl.keyType', 'int');

        parent::__construct($attributes);
    }

    protected $guarded = [
        'id'
    ];

    
}
