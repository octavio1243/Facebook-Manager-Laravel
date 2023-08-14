<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    public $timestamps = false;
    use HasFactory;

    public function users(){
        return $this->hasMany(User::class);
    }
}
