<?php

namespace App\Http\Controllers;

use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Plan;

class AdministratorContoller extends Controller
{
    //
    public function show_panel()
    {
        $users = User::whereRelation('rol', 'name', 'Cliente')->get();
        //dd($users);
        return view('administrator.panel', ['users' => $users]);
    }

    public function show_billing_manager($user_id)
    {
        $user = User::find($user_id);
        return view('administrator.billing_manager', ['user' => $user]);
    }

    public function show_plan_form($user_id)
    {
        $user = User::find($user_id);
        $payment_methods = PaymentMethod::all();
        return view('administrator.plan', ['user' => $user, 'payment_methods' => $payment_methods]);
    }

    public function store_plan($user_id,Request $request)
    {
        //dd($user_id,$request);
        $plan = Plan::create([
            'initiation_date'=>$request->initiation_date,
            'expiration_date'=>$request->expiration_date,
            'amount'=>$request->amount,
            'payment_method_id'=>$request->payment_method_id,
            'user_id'=>$user_id
        ]);
        return redirect()->route('user.billing_manager',['user_id'=>$user_id]);
    }
}
