<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\FollowingUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $following_users = FollowingUser::all()->where('user_id', '1');

        return view('home', ['following_users' => $following_users]);
    }
}
