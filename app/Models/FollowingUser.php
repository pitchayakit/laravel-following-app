<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FollowingUser extends Model
{
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function following()
    {
        return $this->belongsTo('App\Models\User','following_id');
    }
}
