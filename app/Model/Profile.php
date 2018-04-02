<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    public function User()
    {
        return $this->belongsTo('App\Model\User');
    }
}
