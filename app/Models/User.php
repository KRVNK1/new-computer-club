<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    protected $fillable = [
        'first_name',
        'last_name',
        'login',
        'email',
        'phone',
        'password',
    ];

    // Для хеширования пароля при использовании сидера
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
    
}
