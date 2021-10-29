<?php

namespace App\Http\Services;

use App\Models\AccountRole;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class AccountServices
{
    public function getRole($id)
    {
        DB::connection('gatekeeper')
        ->table('roles')
        ->leftJoin('permissions', 'roles.id', '=', 'permissions.role_id')
        ->select(
            'roles.*',
            'permissions.name as permission'
        )
        ->where('roles.user_id', $id)
        ->get();
    }

    public function getPermissions($id)
    {
        DB::connection('getekeeper')
        ->table('permissions')
        ->where('')
        ->get();
    }

    public function organizePermissions($user)
    {
        $role = [];
        $permissions = [];


        foreach ($user->roles as $role)
        {
            $permission = explode(':', $permission);
            $new_permissions[$permission[0]][] = $permission[1];
        }

        return $new_permissions;
    }

}
