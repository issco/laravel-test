<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\myCustomHelper;
use App\Helper;
use Illuminate\Support\Facades\Auth;
use Validator;
use Config;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable; 
class User extends Controller
{
        public $successStatus = 200;

    public function login(Request $request) 
    {
        // return $request;
        if (Auth::attempt(['email' => request('identifier'), 'password' => request('password')])) { 
            $user = Auth::user();
            $dataToReturn = [
                "token" => $user->createToken('MyApp')->accessToken,
                "name" => $user->name,
                "email" => $user->email,
                "isAdmin" => myCustomHelper::checkIfAdmin($user),
            ];
            return response()->api($dataToReturn, "USER001");
        } 
        else {
            return response()->api(null, "USER002"); 
        } 
    }


}
