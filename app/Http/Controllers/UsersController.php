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
        $follow_exists = DB::table('following_users')
                        ->where('user_id', '=', Auth::id())
                        ->where('following_id', '=', $id)
                        ->first();

        if ($follow_exists === null) 
            return view('user', ['user' => User::findOrFail($id),'following' => 0]);
        else
            return view('user', ['user' => User::findOrFail($id),'following' => 1]);
    }

    public function update(Request $request, $id)
    {       
        $introduction = $request->input('introduction');

        $follow_exists = DB::table('profiles')
                        ->where('user_id', '=', Auth::id())
                        ->first();
                        
        if ($follow_exists === null)
            DB::table('profiles')->insert(
                ['user_id' => Auth::id(), 'introduction' => $introduction]
            );
        else
            DB::table('profiles')
            ->where('id', Auth::id())
            ->update(['introduction' => $introduction]);

        return view('user', ['user' => User::findOrFail($id),'following' => 0]);
    }

    public function store(Request $request)
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

    public function destroy($id)
    {
        $current_user_id = Auth::id();

        $user = DB::table('following_users')
            ->where('user_id', '=', $current_user_id)
            ->where('following_id', '=', $id)
            ->delete();
        return redirect('home');
    }

}