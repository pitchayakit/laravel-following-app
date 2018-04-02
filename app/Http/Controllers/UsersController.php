<?php

namespace App\Http\Controllers;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    /**
     * Show the profile for the given user.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        return view('user', ['user' => User::findOrFail($id),'following' => $this->check_user_following($id)]);
    }

    public function update(Request $request, $id)
    {                   
        if ($this->check_user_following($id) === 0)
            DB::table('profiles')->insert(
                ['user_id' => Auth::id(), 'introduction' => $introduction]
            );
        else
            DB::table('profiles')
            ->where('id', Auth::id())
            ->update(['introduction' => $introduction]);

        return view('user', ['user' => User::findOrFail($id),'following' => $this->check_user_following($id)]);
    }

    public function store(Request $request)
    {
        $following_id = $request->input('following_user');
            
        if ($this->check_user_following($following_id) === 0) {
            DB::table('following_users')->insert(
                ['user_id' => Auth::id(), 'following_id' => $following_id]
            );
        }
        
        return view('user', ['user' => User::findOrFail($following_id),'following' => $this->check_user_following($following_id)]);
    }

    public function destroy($id)
    {
        $current_user_id = Auth::id();
        $user = DB::table('following_users')
            ->where('user_id', '=', $current_user_id)
            ->where('following_id', '=', $id)
            ->delete();
        return view('user', ['user' => User::findOrFail($id),'following' => $this->check_user_following($id)]);
    }

    private function check_user_following($id) {
        $follow_exists = DB::table('following_users')
                        ->where('user_id', '=', Auth::id())
                        ->where('following_id', '=', $id)
                        ->first();
        if($follow_exists === null)
            return 0;
        else
            return 1;
    }

}