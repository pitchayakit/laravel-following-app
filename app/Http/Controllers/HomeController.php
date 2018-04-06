<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\FollowingUser;
use App\Models\Vote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
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

        return view('home', ['following_users' => $following_users]);
    }

    public function store(Request $request)
    {
        $inputs = $request->except('_token');
        foreach ($inputs as $key => $value){
            $vote = new Vote;
            $vote->voted_id = (int)$key;
            $vote->point = (int)$value;
            $this->user->votes()->save($vote);
        }
        $following_users = FollowingUser::all()->where('user_id', Auth::id());

        return view('home', ['following_users' => $following_users]);
    }
}
