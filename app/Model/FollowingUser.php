<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class FollowingUser extends Model
{
    public function User()
    {
        return $this->belongsTo('App\Model\User','following_id');
    }
}
