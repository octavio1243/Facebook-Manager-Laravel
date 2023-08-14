<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\FacebookAccountController;
use App\Http\Controllers\ApiClientController;
use App\Http\Controllers\ImagesController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserContoller;
use App\Http\Controllers\AdministratorContoller;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


use App\Models\Image;
use App\Models\FacebookAccount;
use App\Models\User;
use App\Models\Rol;
use App\Models\Status;
use App\Models\Record;
use App\Models\GroupPost;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

Route::get('/ejemplo', function () {
    $user_rol = Rol::where('name','Cliente')->first();
    $user_status = Status::where('type','StatusUser')->where('name','Vigente')->first();
    //dd($user_rol,$user_status);
    $users = User::whereRelation('plans', 'expiration_date', '>=', now()->subHour())
        ->where('rol_id',$user_rol->id)
        ->where('status_id',$user_status->id)
        ->get();
    //dd($users);
    $status_posted = Status::where('type','StatusRecordPost')->where('name','Posteado')->first();
    foreach ($users as $user) {
        foreach ($user->facebook_accounts as $facebook_account) {
            $from_time = Carbon::now()->subHours(1)->toDateTimeString(); //Poner en 1 NO OLVIDAR
            $record = Record::whereHas('group_post.post.facebook_account',function (Builder $query) use ($facebook_account,$from_time){   
                $query->where('facebook_accounts.id', '=', $facebook_account->id)->where('records.created_at', '>=', $from_time);
            })->get();
            if ($facebook_account->rate > $record->count()) {        
                for ($i = 0; $i < ($facebook_account->rate-$record->count()); $i++) {
                    $group_posts = GroupPost::whereHas('post.facebook_account',function (Builder $query) use ($facebook_account){
                        $query->where('facebook_accounts.id', '=', $facebook_account->id);
                    })->orderBy('updated_at', 'ASC')->get();
                    if (!$group_posts->isEmpty()){
                        $group_posts[0]->records()->create(['status_id'=>$status_posted->id,'post_url'=>'fakeurl.com/holamundo']);
                        $group_posts[0]->touch();
                    }
                } 
            }
        }
    }
    dd("Posteos hechos");
});


Route::get('/', function () {
    return view('welcome');
});

/* Autenticacion de la pagina */

Route::get('/register', [RegisterController::class, 'show']);

Route::post('/register', [RegisterController::class, 'register']);

Route::get('/login', [LoginController::class, 'show']);

Route::post('/login', [LoginController::class, 'login']);

Route::get('/logout', [LoginController::class, 'logout']);

/* MENU PRINCIPAL */

Route::get('/home', [HomeController::class, 'show'])->name('home');

/* Autenticacion de facebook */

Route::get('/facebook_login', [FacebookAccountController::class, 'show_login'])->name('facebook_login');

Route::post('/facebook_login', [ApiClientController::class, 'login']);

Route::get('/verify', [FacebookAccountController::class, 'show_verify']);

Route::post('/verify', [ApiClientController::class, 'verify']);

/* Ver imagenes */

Route::get('/private/images/{profile_id}/{facebook_account_id}/{image_name}', [ImagesController::class, 'show_profile'])->name('images/private/');

Route::get('/private/images/{profile_id}/{facebook_account_id}/{post_id}/{image_name}', [ImagesController::class, 'show'])->name('images/private/');

/* Administracion de cuenta de facebook */

Route::get('profile/{facebook_account_id}', [FacebookAccountController::class, 'show_profile'])->name('profile.account');

Route::get('profile/{facebook_account_id}/groups', [FacebookAccountController::class, 'show_groups'])->name('profile.groups');

Route::get('profile/{facebook_account_id}/post', [FacebookAccountController::class, 'show_post_form'])->name('profile.post');

Route::post('profile/{facebook_account_id}/post', [FacebookAccountController::class, 'store_post']);

Route::get('profile/{facebook_account_id}/post/{post_id}/record', [PostController::class, 'show_record'])->name('profile.record');

Route::get('profile/{facebook_account_id}/post/{post_id}/details', [PostController::class, 'show_details'])->name('profile.details');

Route::post('profile/{facebook_account_id}/post/{post_id}/details', [PostController::class, 'update_details']);

Route::delete('profile/{facebook_account_id}/post/{post_id}/', [PostController::class, 'delete']);

/* Administracion del usuario */

Route::get('/configuration', [UserContoller::class, 'show_configuration']);

Route::get('/billing', [UserContoller::class, 'show_billing']);

/* Administracion de la pagina */

Route::get('/panel', [AdministratorContoller::class, 'show_panel']);

Route::get('/user/{user_id}/billing_manager', [AdministratorContoller::class, 'show_billing_manager'])->name('user.billing_manager');

Route::get('/user/{user_id}/plan', [AdministratorContoller::class, 'show_plan_form'])->name('user.plan');

Route::post('/user/{user_id}/plan', [AdministratorContoller::class, 'store_plan']);
