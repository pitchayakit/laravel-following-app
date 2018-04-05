<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\FollowingUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user= User::find(Auth::user());
    
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
        $this->user = User::find($id);

        $inputs = $request->input();
        foreach ($inputs as $key => $value){
            
        }
        $following_users = FollowingUser::all()->where('user_id', Auth::id());

        return view('home', ['following_users' => $following_users]);
    }
}
