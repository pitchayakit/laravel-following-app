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

        if (empty(Profile::where('user_id', $id)->first())){
            $profile = new Profile;
            $profile->introduction = $introduction;
            $profile->user_id = Auth::id();
            $profile->save();
        }
        else {
            $profile = Profile::where('user_id', $id)->first();
            $profile->introduction = $introduction;
            $profile->save();
        }

        return view('user', ['user' => User::find($id),'following' => $this->check_user_following($id)]);
    }

    public function store(Request $request)
    {
        $following_id = $request->input('following_user');
            
        if ($this->check_user_following($following_id) === 0) {
            $following_user = new FollowingUser;
            $following_user->user_id = Auth::id();
            $following_user->following_id = $following_id;
            $following_user->save();
        }
        
        return view('user', ['user' => User::find($following_id),'following' => $this->check_user_following($following_id)]);
    }

    public function destroy($id)
    {
        $following_user = FollowingUser::where('user_id', Auth::id());
        $following_user->following_id = $id;
        $following_user->first();
        $following_user->delete();

            
        return view('user', ['user' => User::find($id),'following' => $this->check_user_following($id)]);
    }

    private function check_user_following($id) {
        $follow_exists = DB::table('following_users')
                        ->where('user_id', '=', Auth::id())
                        ->where('following_id', '=', $id)
                        ->first();

        $following_user = FollowingUser::where('user_id', Auth::id());
        $following_user->following_id = $id;
        $following_user->first();

        if($follow_exists === null)
            return 0;
        else
            return 1;
    }

}