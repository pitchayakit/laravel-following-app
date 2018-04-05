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
        $this->middleware(function ($request, $next) {
            $this->user= User::find(Auth::user());
    
            return $next($request);
        });
    }

    public function show($id)
    {
        return view('user', ['user' => User::find($id),'following' => $this->check_user_following($id)]);
    }

    public function update(Request $request, $id)
    {   
        $introduction = $request->input('introduction');

        $this->user = User::find($id);
        if($this->user->profile === null) {
            $profile = new Profile;
            $profile->introduction = $introduction;
            $this->user->profile()->save($profile);
        }
        else {
            $this->user->profile->introduction = $introduction;
            $this->user->profile->save();
        }
        
        return view('user', ['user' => User::find($id),'following' => $this->check_user_following($id)]);
    }

    public function store(Request $request)
    {
        $following_id = $request->input('following_user');
        $this->user = User::find(Auth::id());

        if ($this->check_user_following($following_id) === 0) {
            $followingUser = new FollowingUser;
            $followingUser->following_id = $following_id;
            $this->user->followingUsers()->save($followingUser);
        }
        
        return view('user', ['user' => User::find($following_id),'following' => $this->check_user_following($following_id)]);
    }

    public function destroy($id)
    {
        $this->user = User::find(Auth::id());
        $this->user->followingUsers->where('following_id', $id)->first()->delete();

        return view('user', ['user' => User::find($id),'following' => $this->check_user_following($id)]);
    }

    private function check_user_following($id) {
        $this->user = User::find(Auth::id());
        $follow_exists = $this->user->followingUsers->where('user_id', Auth::id())->where('following_id', '=', $id)->first();

        if($follow_exists === null)
            return 0;
        else
            return 1;
    }
    
}