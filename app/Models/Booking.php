<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'user_id',
        'workstation_id',
        'tariff_id',
        'hours',
        'people',
        'comment',
        'total_price',
        'status'
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function workstation()
    {
        return $this->belongsTo(Workstation::class);
    }
    
    public function tariff()
    {
        return $this->belongsTo(Tariff::class);
    }
}
