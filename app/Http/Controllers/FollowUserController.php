<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FollowUserController extends Controller
{
    public function create(Request $request)
    {
        $current_user_id = Auth::id();
        $following_id = $request->input('following_user');

        $follow_exists = DB::table('following_users')
                        ->where('user_id', '=', $current_user_id)
                        ->where('following_id', '=', $following_id)
                        ->first();
        if ($follow_exists === null) {
            DB::table('following_users')->insert(
                ['user_id' => $current_user_id, 'following_id' => $following_id]
            );
        }
        
        return redirect('home');
    }
}
