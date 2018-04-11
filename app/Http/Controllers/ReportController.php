<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\FollowingUser;
use App\Models\Vote;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class reportController extends Controller
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
        $users = User::all();
        $file = fopen("report.csv","w");
        $users_name_row = array(" ");
        foreach ($users as $user) {
            array_push($users_name_row,$user->name);
        }
        fputcsv($file,$users_name_row);

        foreach ($users as $user) {
            unset($user_name_row);
            $user_name_row[0] = $user->name;
            for($j = 1; $j < count($users_name_row); $j++){
                $user_name_row[$j] = 0;
            }
            $user_votes = $user->votes;
            $date = $user_votes[0]->created_at;
            foreach ($user_votes as $vote) {
                if($vote->created_at != $date) {
                    $user_name_row_date = $user_name_row;
                    array_push($user_name_row_date, $date);
                    fputcsv($file,$user_name_row_date);
                    for($j = 1; $j < count($users_name_row); $j++){
                        $user_name_row[$j] = 0;
                    }
                    $date = $vote->created_at;
                } 
                for($j = 1; $j < count($users_name_row); $j++) {
                    if( (User::find($vote->voted_id)->name === $users_name_row[$j]) ){
                        $user_name_row[$j] = $vote->point;
                    }
                }  
            }
            $user_name_row_date = $user_name_row;
            array_push($user_name_row_date,$user_votes[count($user_votes)-1]->created_at);
            fputcsv($file,$user_name_row_date);
            
        }

        fclose($file);
        return view('report');
    }
}
