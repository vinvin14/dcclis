<?php

namespace App\Http\Middleware;

use App\Http\Services\AccountServices;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;

class IARMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
       

        return $next($request);
    }
}
