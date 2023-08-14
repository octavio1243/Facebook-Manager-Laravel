<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FacebookAccount extends Model
{
    public $timestamps = false;
    use HasFactory;

    protected $fillable = [
        'email',
        'full_name',
        'uid',
        'access_token',
        'rate',
        'user_id',
        'status_id'
    ];

    public function posts(){
        return $this->hasMany(Post::class);
    }

    public function image(){
        return $this->hasOne(Image::class);
        //return $this->belongsTo(Image::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function status(){
        return $this->belongsTo(Status::class);
    }

}
