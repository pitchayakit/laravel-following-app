<?php

namespace App\Http\Controllers;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Show the profile for the given user.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $current_user_id = Auth::id();

        $follow_exists = DB::table('following_users')
                        ->where('user_id', '=', $current_user_id)
                        ->where('following_id', '=', $id)
                        ->first();

        if ($follow_exists === null) 
            return view('user', ['user' => User::findOrFail($id),'following' => 0]);
        else
            return view('user', ['user' => User::findOrFail($id),'following' => 1]);
    }
}