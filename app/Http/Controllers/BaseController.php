<?php

namespace App\Http\Controllers;

use App\Http\Services\AccountServices;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BaseController extends Controller
{
    protected $credentials, $userid;

    public function __construct()
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

    public function permissions($role_id)
    {
        return (new AccountServices())->getPermissions(Auth::id(), $role_id);
    }

    public function getRoleById($id)
    {
        return (new AccountServices())->getRoleById($id);
    }
}
