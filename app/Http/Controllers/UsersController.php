<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Profile;
use App\Models\FollowingUser;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Show the profile for the given user.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        return view('user', ['user' => User::find($id),'following' => $this->check_user_following($id)]);
    }

    public function update(Request $request, $id)
    {   
        $introduction = $request->input('introduction');

        $user = User::find($id);
        if($user->profile === null) {
            $profile = new Profile;
            $profile->introduction = $introduction;
            $user->profile()->save($profile);
        }
        else {
            $user->profile->introduction = $introduction;
            $user->profile->save();
        }
        
        return view('user', ['user' => User::find($id),'following' => $this->check_user_following($id)]);
    }

    public function store(Request $request)
    {
        $following_id = $request->input('following_user');
        $user = User::find(Auth::id());

        if ($this->check_user_following($following_id) === 0) {
            $followingUser = new FollowingUser;
            $followingUser->following_id = $following_id;
            $user->followingUsers()->save($followingUser);
        }
        
        return view('user', ['user' => User::find($following_id),'following' => $this->check_user_following($following_id)]);
    }

    public function destroy($id)
    {
        $user = User::find(Auth::id());
        $user->followingUsers->where('following_id', $id)->first()->delete();

        return view('user', ['user' => User::find($id),'following' => $this->check_user_following($id)]);
    }

    private function check_user_following($id) {
        $user = User::find(Auth::id());
        $follow_exists = $user->followingUsers->where('user_id', Auth::id())->where('following_id', '=', $id)->first();

        if($follow_exists === null)
            return 0;
        else
            return 1;
    }
    
}