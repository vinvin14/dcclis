<?php

namespace App\Http\Services;

use App\Models\User;


class AccountServices
{
    public function getPermissions($id)
    {
        $user = User::query()
        ->with('roles.permissions')
        ->find($id);
        
        $permissions = [];
        
        foreach ($user->roles as $role)
        {            
            foreach ($role->permissions as $permission) 
            {
                $permission = explode(':', $permission->name);
                $permissions[$permission[0]][] = $permission[1];
            }
        }

        return $permissions;
    }

    public function getRoles($id)
    {
        $user = User::query()
        ->with('roles.permissions')
        ->find($id);

        $roles = [];
        
        foreach ($user->roles as $role)
        {            
            array_push($roles, $role->name);
        }

        return $roles;
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
