<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkStation extends Model
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
