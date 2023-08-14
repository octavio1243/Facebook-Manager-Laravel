<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    public $timestamps = false;
    use HasFactory;
    
    protected $fillable = [
        'name',
        'group_id',
        'url'
    ];

    public function group_posts(){
        return $this->hasMany(GroupPost::class);
    }

    public function posts(){
        return $this->belongsToMany(Post::class, 'group_post'); //group_post
    }

}
