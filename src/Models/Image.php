<?php
/**
* Created by Claudio Campos.
* User: callcocam@gmail.com, contato@sigasmart.com.br
* https://www.sigasmart.com.br
*/
 namespace Callcocam\Acl\Models; 

use Illuminate\Database\Eloquent\Factories\HasFactory; 

class Image extends AbstractAclModel
{
    use HasFactory;

    public function imageable()
    {
        return $this->morphTo();
    }

    protected function slugTo()
    {
        return false;
    }

}
