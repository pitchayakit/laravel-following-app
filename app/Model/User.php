<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    public function followingUser()
    {
        return $this->hasMany('App\Model\FollowingUser');
    }
    public function profile()
    {
        return $this->hasOne('App\Model\Profile');
    }
}
