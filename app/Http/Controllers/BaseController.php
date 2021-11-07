<?php

namespace App\Http\Controllers;

use App\Http\Services\AccountServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BaseController extends Controller
{
    protected $credentials, $userid;

    public function __construct(Request $request)
    {
        $this->middleware('auth');
    }

    public function credentials()
    {
        return $this->credentials = (new AccountServices())->organizePermissions(Auth::id());
    }
    
    public function roles()
    {
        return (new AccountServices())->getRoles(Auth::id());
    }

    public function permissions()
    {
        return (new AccountServices())->getPermissions(Auth::id());
    }
}
