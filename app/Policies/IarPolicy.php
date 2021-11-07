<?php

namespace App\Policies;

use App\Http\Services\AccountServices;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IarPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    protected $permission, $role;

    public function __construct(Request $request)
    {
        $this->permissions = (new AccountServices())->getPermissions(Auth::id()); 
        $this->role = $request->cookie('role');
    }

    public function show()
    {
        return $this->role === 'Logistics Officer' AND in_array('show', $this->permissions['iar']);
    }

    public function create()
    {
        return $this->role === 'Logistics Officer' AND in_array('create', $this->permissions['iar']);
    }

    public function update()
    {
        return $this->role === 'Logistics Officer' AND in_array('update', $this->permissions['iar']);
    }

    public function destroy()
    {
        return $this->role === 'Logistics Officer' AND in_array('destroy', $this->permissions['iar']);
    }
}
