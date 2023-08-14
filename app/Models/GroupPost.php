<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Status;

class GroupPost extends Model
{
    //public $timestamps = false;
    use HasFactory;

    protected $fillable = ['group_id','status_id'];

    public function post(){
        return $this->belongsTo(Post::class);
    }

    public function group(){
        return $this->belongsTo(Group::class);
    }

    public function status(){
        return $this->belongsTo(Status::class);
    }

    public function records(){
        return $this->hasMany(Record::class);
    }
}
