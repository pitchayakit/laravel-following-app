<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    public function followingUsers()
    {
        return $this->hasMany('App\Models\FollowingUser');
    }

    public function profile()
    {
        return $this->hasOne('App\Models\Profile');
    }

    public function votes()
    {
        return $this->hasMany('App\Models\Vote');
    }

    public function socialAccount()
    {
        return $this->hasOne('App\SocialAccount');
    }
}
