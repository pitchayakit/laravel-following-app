<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    public function followingUser()
    {
        return $this->hasMany('App\Models\FollowingUser');
    }
    public function profile()
    {
        return $this->hasOne('App\Models\Profile');
    }
}
