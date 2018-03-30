<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        $following_users = \App\User::find(1)->followingTracker;
        print_r($following_users);

        $users = DB::table('users')
            //->join('following', 'users.id', '=', 'following.user_id')
            ->get();

        return view('home', ['users' => $users]);
    }
}
