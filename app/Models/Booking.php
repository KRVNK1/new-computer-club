<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'user_id',
        'tariff_id',
        'start_time',
        'end_time',
        'people',
        'comment',
        'total_price',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function workstations()
    {
        return $this->belongsToMany(Workstation::class, 'booking_workstation')->withTimestamps();
    }

    public function tariff()
    {
        return $this->belongsTo(Tariff::class);
    }
}
