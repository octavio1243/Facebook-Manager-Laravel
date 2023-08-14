<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    public $timestamps = false;
    use HasFactory;

    public function records(){
        return $this->hasMany(Record::class);
    }

    public function group_posts(){
        return $this->hasMany(GroupPost::class);
    }

    public function posts(){
        return $this->hasMany(Post::class);
    }

    public function users(){
        return $this->hasMany(User::class);
    }

    public function facebook_accounts(){
        return $this->hasMany(FacebookAccount::class);
    }
}
