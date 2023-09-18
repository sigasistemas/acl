<?php
/**
* Created by Claudio Campos.
* User: callcocam@gmail.com, contato@sigasmart.com.br
* https://www.sigasmart.com.br
*/
 namespace Callcocam\Acl\Models;

use App\Models\Callcocam\AbstractModel;
use Illuminate\Database\Eloquent\Factories\HasFactory; 

class Image extends AbstractModel
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
