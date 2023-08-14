<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\FacebookAccount;
use App\Models\Record;
use App\Models\GroupPost;
use App\Models\Status;
use App\Models\Group;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Builder;

class PostController extends Controller
{
    //
    public function show_record($facebook_account_id,$post_id){
        $facebook_account = FacebookAccount::where("id",$facebook_account_id)->first();
        $post = Post::where("id",$post_id)->first();        
        //$records = Record::whereIn('id', $post->group_posts->pluck('id')->toArray() )->get();
        $records = Record::whereHas('group_post',function (Builder $query) use ($post_id){   
            $query->where('group_posts.post_id', '=', $post_id);
        })->orderBy('id', 'DESC')->get();
        //dd($facebook_account,$post,$records);
        return view('facebook.record',["facebook_account"=>$facebook_account,"post"=>$post,"records"=>$records]);
    }

    public function show_details($facebook_account_id,$post_id){
        $facebook_account = FacebookAccount::where("id",$facebook_account_id)->first();
        $post = Post::where("id",$post_id)->first();
        $all_groups= ApiClientController::get_groups($facebook_account);
        return view('facebook.details',["facebook_account"=>$facebook_account,"post"=>$post,"all_groups"=>$all_groups]);
    }

    public function delete($facebook_account_id,$post_id){
        //dd($facebook_account_id,$post_id);
        $post=Post::find($post_id);
        $post->delete();

        //Eliminando carpeta relacionada con el post borrado
        $profile_id=auth()->user()->id;
        ImagesController::delete_folder($profile_id,$facebook_account_id,$post_id);

        return redirect()->route('profile.account',['facebook_account_id'=>$facebook_account_id]);
    }

    // IMPORTANTE: VERIFICAR QUE LOS GRUPOS NO SEAN NULOS
    public function update_details($facebook_account_id,$post_id,Request $request){
        
        //dd($request);

        $post = Post::where("id",$post_id)->first();
        $post->title= $request->title;
        $post->description = $request->description;
        $post->save();

        // Manejo de imagenes
        foreach ($post->images as $image){
            $image->delete();
        }
        $profile_id=auth()->user()->id;
        ImagesController::delete_folder($profile_id,$facebook_account_id,$post_id);
        //dd("imagenes borradas");
        if ($request->hasFile('images')) {
            $facebook_path=auth()->user()->id."/".$facebook_account_id."/".$post_id;
            foreach ($request->images as $image) {
                $abs_path=ImagesController::store($facebook_path,$image);
                $post->images()->create(["path"=>$abs_path]);
            }
        }
        // Fin manejo de imagenes
        
        // Manejo de estados GroupPost
        $status_disable = Status::where('type','StatusPostGroup')->where('name','Deshabilitado')->first();
        $status_enable =  Status::where('type','StatusPostGroup')->where('name','Habilitado')->first();
        foreach ($post->group_posts as $group_post) { //Deshabilitando todos los postgroup
            $status_disable->group_posts()->save($group_post);
        } 
        foreach ($request->groups as $group_id) {
            $group = Group::where('group_id',$group_id)->first();
            $grouppost = $post->group_posts->where('group_id',$group->id)->first();
            if ( !$grouppost ){ //Verificar si no existe la relacion para crearla
                $post->group_posts()->create([
                    "group_id"=>$group->id,
                    "status_id"=>$status_enable->id
                ]);
            }
            else{ // Habilitando los postgroup existentes
                $status_enable->group_posts()->save($grouppost);
            }
        }
        // Fin manejo de estados GroupPost

        return redirect()->route('profile.details',['facebook_account_id'=>$facebook_account_id,'post_id'=>$post_id]);
    }

}
