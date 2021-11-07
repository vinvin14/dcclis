<?php

namespace App\Http\Middleware;

use App\Http\Services\AccountServices;
use App\Models\Role;
use App\Models\User;
use Closure;
use Facade\FlareClient\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
    public function handle(Request $request, Closure $next)
    {
        if (! Auth::check()) {
            return Response('No valid credentials');
        }
        
        if (empty($request->cookie('role')))
        {
            $role = (new AccountServices())->getRoles(Auth::id());
            if (count($role) > 1)  
            {
               return redirect(route('account.role.verify'));
            }

            $cookieRole = $role;
        }
        $cookieRole = $request->cookie('role');
        return $next($request)
            ->withCookie(cookie()->forever('role', $cookieRole));
    }
}
