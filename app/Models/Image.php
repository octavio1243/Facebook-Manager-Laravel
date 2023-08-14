<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    public $timestamps = false;
    use HasFactory;

    protected $fillable = [
        'path'
    ];

    public function post(){
        return $this->belongsTo(Post::class);
    }

    public function facebook_account(){
        return $this->belongsTo(FacebookAccount::class);
    }

    public function group(){
        return $this->belongsTo(Group::class);
    }

}
