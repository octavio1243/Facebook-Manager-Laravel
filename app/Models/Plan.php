<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Plan extends Model
{
    public $timestamps = false;
    use HasFactory;

    protected $fillable = [
        'initiation_date',
        'expiration_date',
        'amount',
        'payment_method_id',
        'user_id'
    ];

    // Mutators para dar formato fecha
    public function getInitiationDateAttribute()
    {
        return (new Carbon($this->attributes['initiation_date']))->format('d/m/y');;
    }

    public function getExpirationDateAttribute()
    {
        return (new Carbon($this->attributes['expiration_date']))->format('d/m/y');;
    }

    public function payment_method(){
        return $this->belongsTo(PaymentMethod::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
