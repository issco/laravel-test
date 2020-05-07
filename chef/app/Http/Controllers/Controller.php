<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use App\Helper;
use App\Helpers\myCustomHelper;
use Config;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

        public function index()
    {
        return view('welcome');
    }
        public function goToStatisticsPage()
    {
        $Statistics = myCustomHelper::getChannelStatistics();
        return view('statistics',compact('Statistics'));
    }

    public function checkIfAuth(){
       if( myCustomHelper::checkIfAuth())
     return response()->api(null, "USER000");

    }
        public function home(){
        return view('home');
        // if (Auth::user()) {
        // return view('home');}
        // else{abort(403, 'Unauthorized action.');}
    }


}
