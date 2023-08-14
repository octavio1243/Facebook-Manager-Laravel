<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FacebookAccount;
use App\Models\User;

class HomeController extends Controller
{
    //
    public function show(){
        $facebook_accounts=auth()->user()->facebook_accounts;
        return view('/home',['facebook_accounts' => $facebook_accounts]);
    }
    
    
    
}
