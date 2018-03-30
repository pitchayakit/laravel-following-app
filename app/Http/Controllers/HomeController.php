<?php

namespace App\Http\Controllers;

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
        $current_user_id = Auth::id();
        
        $users = DB::table('following_users')
            ->join('users', 'users.id', '=', 'following_users.following_id')
            //->where('user_id', $current_user_id)
            ->get();

        return view('home', ['users' => $users]);
    }
}
