<?php

namespace Callcocam\Acl\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Callcocam\Acl\Acl
 */
class Acl extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Callcocam\Acl\Acl::class;
    }
}
