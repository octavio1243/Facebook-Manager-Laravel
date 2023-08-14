<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class ImagesController extends Controller
{
    public static $real_path="/private/images/";

    public function show_profile($profile_id,$facebook_account_id,$image_name){
        $abs_path=ImagesController::$real_path.$profile_id."/".$facebook_account_id."/".$image_name;
        if (Storage::exists($abs_path)){
            return Storage::response($abs_path);
        }
        abort(404);
    }

    public function show($profile_id,$facebook_account_id,$post_id,$image_name){
        $abs_path=ImagesController::$real_path.$profile_id."/".$facebook_account_id."/".$post_id."/".$image_name;
        if (Storage::exists($abs_path)){
            return Storage::response($abs_path);
        }
        abort(404);
    }

    public static function store($facebook_path,$image){
        $path = ImagesController::$real_path.$facebook_path;
        $abs_path = Storage::putFile($path, $image);
        //dd($abs_path);
        return $abs_path;
    }

    public static function store_bytes($facebook_path,$bytes_image){
        $abs_path=ImagesController::$real_path.$facebook_path;
        Storage::put($abs_path , $bytes_image);
        return $abs_path;
    }

    public static function delete_folder($profile_id,$facebook_account_id,$post_id){
        $abs_path=ImagesController::$real_path.$profile_id."/".$facebook_account_id."/".$post_id;
        Storage::deleteDirectory($abs_path);
    }

}
