<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;


class User extends Authenticatable
{
    protected $connection = 'gatekeeper';
    protected $table = 'users';

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

}
