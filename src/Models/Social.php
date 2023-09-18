<?php
/**
* Created by Claudio Campos.
* User: callcocam@gmail.com, contato@sigasmart.com.br
* https://www.sigasmart.com.br
*/
 namespace Callcocam\Acl\Models;

use App\Models\Callcocam\AbstractModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Social extends AbstractModel
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

    public function socialable()
    {
        return $this->morphTo();
    }
    protected function slugTo()
    {
        return false;
    }

}