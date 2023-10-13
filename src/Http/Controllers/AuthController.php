<?php
/**
* Created by Claudio Campos.
* User: callcocam@gmail.com, contato@sigasmart.com.br
* https://www.sigasmart.com.br
*/
namespace Callcocam\Acl\Http\Controllers;

use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Routing\Controller;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{


    /**
     * The guard implementation.
     *
     * @var \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected $guard;

    /**
     * Create a new controller instance.
     *
     * @param  \Illuminate\Contracts\Auth\StatefulGuard  $guard
     * @return void
     */
    public function __construct(StatefulGuard $guard)
    {
        $this->guard = $guard;
    }

    /**
     * Attempt to authenticate a new session.
     *
     * @param  Request  $request
     * @param  int  $user
     * @return mixed
     */
    public function store(Request $request, $model)
    {
        $this->guard->login($this->guard->onceUsingId($model), $request->boolean('remember'));

        return redirect()->intended();
    }
}
