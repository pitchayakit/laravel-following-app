<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FollowingUserController extends Controller
{
    public function create(Request $request)
    {
        $current_user_id = Auth::id();
        $following_id = $request->input('following_user');
        DB::table('following_users')->insert(
            ['user_id' => $current_user_id, 'following_id' => $following_id]
        );
        $users = DB::table('users')->get();

        return view('home', ['users' => $users]);
    }
}
