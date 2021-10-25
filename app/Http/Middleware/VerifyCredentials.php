<?php

namespace App\Http\Middleware;

use App\Http\Services\AccountServices;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class VerifyCredentials
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, AccountServices $accountServices)
    {
        if (empty($request->cookie('token') && $request->cookie('account_id'))) {
            return Redirect::to('https://192.168.224.68:8000/login');
        }

        return $next($request)
        ->withCookie(cookie('roles', $accountServices->getRoles($request->cookie('account_id'))));
    }
}
