<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;

class LoginController extends Controller
{
    //
    public function show(){
        if(Auth::check()){
            return redirect('/home');
        }
        return view('auth.login');
    }

    public function login(LoginRequest $request){
        if (Auth::attempt($request->validated())){
            $request->session()->regenerate();
            session([ "groups"=>[] ]); // Crea la lista donde almacenará los grupos
            session([ "rol"=>auth()->user()->rol->name ]);
            //dd( session()->all() );
            if ( strcmp(session()->get("rol"),'Administrador')==0 ){
                return redirect('/panel');
            }
            else{
                return redirect('/home');
            }
        }
        return back()->withErrors("Credenciales incorrectas");
    }

    public function logout(){
        Session::flush();
        Auth::logout();
        return redirect()->to('/login');
    }
}
