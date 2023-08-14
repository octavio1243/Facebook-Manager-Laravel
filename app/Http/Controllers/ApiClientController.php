<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Models\Status;
use App\Models\Image;
use App\Models\FacebookAccount;
use App\Models\Group;
//use App\Models\FacebookAccountGroup;
use Illuminate\Support\Facades\Auth;

class ApiClientController extends Controller
{
    //
    public static $url="http://localhost:4000";

    public function login(Request $request){
        $client = new Client(["base_uri" => self::$url ]);
        $options = [
            'json' => [
            'email'=>$request->email,
            'password' => $request->password
        ]];
        $response = $client->post("/login", $options);
        $response_array=json_decode($response->getBody(), true);
        
        if (isset($response_array["access_token"])) {
            $email=$request->email;
            $access_token=$response_array["access_token"];
            $uid=$response_array["uid"];
            
            //Crear facebook account
            $this->createFacebookAccount($email,$access_token,$uid);

            return redirect('/home');
        }
        
        if ($response_array["code"]==406){

            //Crear sesion para guardar:
            $uid=$response_array["uid"];
            $login_first_factor=$response_array["login_first_factor"];

            session(['facebook_email'=>$request->email]);
            session(['uid'=>$uid]);
            session(['login_first_factor'=>$login_first_factor]);
            
            return redirect('/verify');
        }
        
        return redirect()->back();
        
    }

    public function verify(Request $request){
        $client = new Client(["base_uri" => self::$url]);
        $options = [
            'json' => [
            'email'=>session('facebook_email'),
            'uid' => session('uid'),
            'login_first_factor' => session('login_first_factor'),
            'pin' => $request->pin
        ]];
        $response = $client->post("/verify", $options);
        $response_array=json_decode($response->getBody(), true);

        if (isset($response_array["access_token"])) {
            $email=session('facebook_email');
            $access_token=$response_array["access_token"];
            $uid=$response_array["uid"];
            
            //Crear facebook account
            $this->createFacebookAccount($email,$access_token,$uid);

            return redirect('/home');
        }

        return redirect()->back();
    }

    public function createFacebookAccount($email,$access_token,$uid){
        $client = new Client(["base_uri" => self::$url]);
        $options = [
            'json' => [
            'access_token'=>$access_token,
            'uid' =>$uid
        ]];
        $response = $client->post("/getProfile", $options);
        $response_array=json_decode($response->getBody(), true);
        
        //dd($response_array);

        $status=Status::where("type","StatusFacebookAccount")->where("name","Logueado")->first();

        $facebook_account = FacebookAccount::create([
            'email'=>$email,
            'full_name'=>$response_array["full_name"],
            'uid'=>$uid,
            'access_token'=>$access_token,
            'rate'=>2, //2 post por hora
            'user_id'=>Auth::user()->id,
            'status_id'=>$status->id
        ]);

        //dd($facebook_account->id);

        $abs_path="/images/null_profile.png";
        if (!is_null($response_array["image"])){
            // Guardando imagen
            $facebook_path=auth()->user()->id."/".$facebook_account->id."/profile.png";
            $bytes_image = iconv('UTF-8', 'ISO-8859-1', $response_array["image"]);
            $abs_path=ImagesController::store_bytes($facebook_path,$bytes_image);
            
        }
        $facebook_account->image()->create(["path"=>$abs_path]);

    }

    public static function get_groups($facebook_account){
        if ( !isset(session()->all()["groups"][$facebook_account->id]) ){
            $client = new Client(["base_uri" => self::$url]);
            $options = [
                'json' => [
                    'access_token'=>$facebook_account->access_token,
                    'uid' =>$facebook_account->uid
            ]];
            $response = $client->post("/getGroups", $options);
            $response_array=json_decode($response->getBody(), true);
            
            $groups=[];
            foreach ($response_array["groups"] as &$group_json) {            
                $group = Group::where('name',$group_json["name"])->first();
                if( is_null($group) ){
                    $group = Group::create([
                        'name'=>$group_json["name"],
                        'group_id'=>$group_json["id"],
                        'url'=>$group_json["url"]
                    ]);            
                }
                else{
                    $group->url=$group_json["url"];
                    $group->save();
                }    
                array_push($groups, $group);
            }

            $array_temp = session()->all()["groups"];
            $array_temp=$array_temp+[$facebook_account->id=>$groups];
            session([ "groups"=>$array_temp ]);
        }
        return session()->all()["groups"][$facebook_account->id];
    }


}
