<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

//use App\Models\FacebookAccount;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'surname',
        'rol_id',
        'status_id',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    //mutator
    public function setPasswordAttribute($value){
        $this->attributes['password']=bcrypt($value);
    }


    public function facebook_accounts(){
        return $this->hasMany(FacebookAccount::class);
    }

    public function status(){
        return $this->belongsTo(Status::class);
    }

    public function rol(){
        return $this->belongsTo(Rol::class);
    }

    public function plans(){
        return $this->hasMany(Plan::class);
    }

}
