<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Record extends Model
{
    public $timestamps = false;
    use HasFactory;

    protected $fillable = ['status_id','post_url'];

    public function group_post(){
        return $this->belongsTo(GroupPost::class); //,'group_post_id'
    }

    public function status(){
        return $this->belongsTo(Status::class);
    }
}
