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
use Illuminate\Contracts\Database\Eloquent\Builder;

class AbstractAclModel extends Model
{
    use SoftDeletes, HasUlids;

    public function __construct(array $attributes = [])
    {
        if($connection = config('acl.connection', 'mysql')){

            // $this->connection = $connection;
        } 
        
        $this->incrementing = config('acl.incrementing', true);

        $this->keyType = config('acl.keyType', 'int');
         

        parent::__construct($attributes);
    }

    protected $guarded = [
        'id'
    ];
    public function scopeTenant(Builder $query): void
    {
        // $query->where('tenant_id', auth()->user()->tenant_id);
    }
    
}
