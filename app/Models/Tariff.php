<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tariff extends Model
{

    protected $fillable = [
        'name',
        'price_per_hour',
        'image',
        'description',
        'timestamps'
    ];
    
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
