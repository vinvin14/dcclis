<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AccountController extends BaseController
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

    public function AccountVerify(Request $request)
    {
        return view('account.verifyrole')
        ->with('roles', $this->roles());
    }

    public function confirmRole(Request $request)
    {
        return redirect(route('dashboard'))
        ->withCookie(cookie()->forever('role', $request->get('role')));
    }

}
