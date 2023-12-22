<?php

/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com, contato@sigasmart.com.br
 * https://www.sigasmart.com.br
 */

namespace Callcocam\Acl\Http\Controllers;

use App\Models\User;
use Filament\Facades\Filament; 
use Illuminate\Routing\Controller; 
use Illuminate\Http\Request; 
use Illuminate\Support\Facades\Route;

class AuthController extends Controller
{
 

    /**
     * Attempt to authenticate a new session.
     *
     * @param  Request  $request
     * @param  int  $user
     * @return mixed
     */
    public function store($model)
    {
        $user = User::where('id', $model)->first();
        if (!$user) {
            return response([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        } 
        if(Route::has('force.login.email')){
            return redirect()->route('force.login.email', ['email'=>$user->email]);
        }
        Filament::auth()->loginUsingId($user->id);

        return redirect()->intended();
    }
}
