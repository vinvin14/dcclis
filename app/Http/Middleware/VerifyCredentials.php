<?php

namespace App\Http\Middleware;

use App\Http\Services\AccountServices;
use App\Models\Role;
use App\Models\User;
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
    public function handle(Request $request, Closure $next)
    {
        // if (empty($request->cookie('user_id'))) {
        //     return Redirect::to(env('GATEKEEPER_HOST').'/login');
        // }

        $user = User::query()
        ->with('roles.permissions')
        ->find($request->cookie('user_id'));

        dd($user);
            dd((new AccountServices())->organizePermissions($user));
        view()->share('permissions', (new AccountServices())->organizePermissions($role->permissions->toArray()));

        return $next($request)
        ->withCookie(cookie()->forever('role', $role->name))
        ->withCookie(cookie()->forever('permissions', serialize($role->permissions)));
    }
}
