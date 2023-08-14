<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    public $timestamps = false;
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'status_id',
        'facebook_account_id'
    ];

    public function group_posts(){
        return $this->hasMany(GroupPost::class);
    }

    public function images(){
        return $this->hasMany(Image::class);
    }

    public function status(){
        return $this->belongsTo(Status::class);
    }

    public function facebook_account(){
        return $this->belongsTo(FacebookAccount::class);
    }

    public function groups(){
        return $this->belongsToMany(Group::class, 'group_post');
    }
}
