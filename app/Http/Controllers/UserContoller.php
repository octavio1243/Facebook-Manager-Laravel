<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserContoller extends Controller
{
    //
    public function show_configuration(){
        $user = auth()->user();
        return view('user.configuration',['user'=>$user]);
    }
    
    public function show_billing(){
        $plans = auth()->user()->plans;
        return view('user.billing',['plans'=>$plans]);
    }

}
