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
            
            $this->user= User::find(Auth::id());
    
            return $next($request);
        });
    }

    public function index()
    {
        $following_users = FollowingUser::all()->where('user_id', Auth::id());
        return view('users',['users' => User::all(),'following_users' => $following_users]);
    }

    public function show($id)
    {
        return view('user', ['user' => User::find($id),'following' => $this->check_user_following($id)]);
    }

    public function update(Request $request, $id)
    {   
        $introduction = $request->input('introduction');

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

        if ($this->check_user_following($following_id) === 0) {
            $followingUser = new FollowingUser;
            $followingUser->following_id = $following_id;
            $this->user->followingUsers()->save($followingUser);
        }

        $following_users = FollowingUser::all()->where('user_id', Auth::id());
        return redirect('users');
    }

    public function destroy($id)
    {
        $this->user->followingUsers->where('following_id', $id)->first()->delete();

        return redirect('users');
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