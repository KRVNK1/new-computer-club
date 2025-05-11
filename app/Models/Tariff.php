<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tariff extends Model
{

    protected $fillable = [
        'name',
        'price_per_hour',
        'is_room',
        'image',
    ];
    
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
