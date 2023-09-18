<?php

/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com, contato@sigasmart.com.br
 * https://www.sigasmart.com.br
 */

 namespace Callcocam\Acl\Models;

use App\Models\Callcocam\AbstractModel;
use Callcocam\Acl\Traits\HasInfoModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class Tenant extends AbstractModel
{
    use HasFactory, Notifiable, HasInfoModel;

   
  
}
