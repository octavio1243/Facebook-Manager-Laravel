<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FacebookAccount;
use App\Models\Status;
use App\Models\Post;
use App\Models\Group;

class FacebookAccountController extends Controller
{
    //
    public function show_login(){
        return view('facebook.login');
    }

    public function show_verify(){
        return view('facebook.verify');
    }

    public function show_profile($facebook_account_id){
        $facebook_account = FacebookAccount::where("id",$facebook_account_id)->first();
        return view('facebook.profile',["facebook_account"=>$facebook_account]);
    }

    public function show_groups($facebook_account_id){
        $facebook_account = FacebookAccount::where("id",$facebook_account_id)->first();
        $all_groups= ApiClientController::get_groups($facebook_account);
        return view('facebook.groups',["all_groups"=>$all_groups,"facebook_account"=>$facebook_account]);
    }

    public function show_post_form($facebook_account_id){
        $facebook_account = FacebookAccount::where("id",$facebook_account_id)->first();
        $all_groups= ApiClientController::get_groups($facebook_account);
        return view('facebook.post',["facebook_account"=>$facebook_account,"all_groups"=>$all_groups]);
    }

    // Requiere autenticacion
    public function store_post(Request $request,$facebook_account_id){

        //dd($request);
        
        //$groups  = Group::whereIn('group_id', $request->groups)->get();
        //dd($groups[0]->name);

        // Busca la cuenta de facebook y el status adecuado para crear el post
        $facebook_account = FacebookAccount::where("id",$facebook_account_id)->first();
        $status = Status::where("type","StatusPost")->where("name","Corriendo")->first();
        $post = Post::create([
            'title'=>$request->title,
            'description'=>$request->description,
            'status_id'=>$status->id,
            'facebook_account_id'=>$facebook_account->id
        ]);

        // Verificar si hay imagenes para crear los Images y asociarlos a la cuenta de facebook
        if ($request->hasFile('images')) {
            $facebook_path=auth()->user()->id."/".$facebook_account_id."/".$post->id;
            foreach ($request->images as $image) {
                $abs_path=ImagesController::store($facebook_path,$image);
                $post->images()->create(["path"=>$abs_path]);
            }
        }

        //Busca los modelos correspondientes a los grupos para asociarlos a la  cuenta de facebook
        $groups = Group::whereIn('group_id', $request->groups)->get(); //Cuidado porque puede no existir tal grupo (me retracto, si existe porque cuando inicia sesion verifica que exista y sino lo agrega)
        $status = Status::where("type","StatusPostGroup")->where("name","Habilitado")->first();
        foreach($groups as $group){
            $post->group_posts()->create([
                "group_id"=>$group->id,
                "status_id"=>$status->id
            ]);
        }

        return redirect()->route('profile.account',['facebook_account_id'=>$facebook_account_id]);
    }

}
