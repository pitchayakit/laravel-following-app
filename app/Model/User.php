<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    public function followingTracker()
    {
        return $this->hasMany('App\Model\FollowingTracker');
    }
}
