<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Workstation extends Model
{
    protected $fillable = [
        'number',
        'status',
        'type'
    ];
    
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
