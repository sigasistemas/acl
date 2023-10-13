<?php

/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com, contato@sigasmart.com.br
 * https://www.sigasmart.com.br
 */
 
use App\Models\User;
use Callcocam\Acl\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('acl/{user}/login',  [AuthController::class, 'store'])->name('acl.user.login');
 