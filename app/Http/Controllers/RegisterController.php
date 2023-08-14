<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Rol;
use App\Models\Status;

class RegisterController extends Controller
{
    //

    public function show(){
        if(Auth::check()){
            return redirect('/home');
        }
        return view('auth.register');
    }

    public function register(RegisterRequest $request){
        $rol_id=Rol::where('name','Cliente')->first()->id;
        $status_id=Status::where('type','StatusUser')->where('name','Vigente')->first()->id; 
        $user = User::create($request->validated()+['rol_id' =>$rol_id ,'status_id'=>$status_id]);
        return redirect('/login')->with('success','Cuenta creada con éxito');
    }

}
