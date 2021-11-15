<?php

namespace App\Http\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AccountServices
{
    public function getPermissions($user_id, $id)
    {
        $user = User::find($user_id);
        $role = $user->roles()->with('permissions')->where('id', $id)->first();

        $permissions = [];
        
        foreach ($role->permissions as $permission) 
        {
            $permission = explode(':', $permission->name);
            $permissions[$permission[0]][] = $permission[1];
        }

        return $permissions;
    }

    public function getRoles($id)
    {
        $user = User::query()
        ->with('roles.permissions')
        ->find($id);

        return $user->roles;
    }

    public function getRoleById($id)
    {
        $user = User::with('roles.permissions')
        ->find(Auth::id());
      
        return $user->roles->where('id', $id)->first();
    }

    public function organizePermissions($id)
    {
        $user = User::query()
        ->with('roles.permissions')
        ->find($id);
        
        $roles = [];
        $permissions = [];

        foreach ($user->roles as $role)
        {
            array_push($roles, $role->name);
            
            foreach ($role->permissions as $permission) 
            {
                $permission = explode(':', $permission->name);
                $permissions[$permission[0]][] = $permission[1];
            }
        }
      
        return [$roles, $permissions];
    }

}
