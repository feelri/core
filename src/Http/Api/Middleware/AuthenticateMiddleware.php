<?php

namespace Feelri\Core\Http\Api\Middleware;

use Feelri\Core\Exceptions\AuthException;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class AuthenticateMiddleware extends Middleware
{
    /**
     * 重写未授权方法
     *
     * @param $request
     * @param array $guards
     * @return void
     * @throws AuthException
     */
    protected function unauthenticated($request, array $guards): void
    {
        throw new AuthException();
    }
}
