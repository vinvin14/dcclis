<?php

namespace App\Http\Controllers;

use App\Http\Services\AccountServices;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    // public function login(Request $request, AccountServices $accountServices)
    // {
    //     $init = $accountServices->authorize($request->input('username'), $request->input('password'));

    //     if (@$init['error']) {
    //         return back()
    //         ->with('error', $init['error']);
    //     }

    //     return redirect(route('dashboard'))
    //     ->withCookie(cookie('token', $init['token']))
    //     ->withCookie(cookie('roles', $init['roles']));
    // }

    public function getRole()
    {

    }

}
