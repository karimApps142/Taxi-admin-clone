<?php

namespace App\Models;

use Carbon\Carbon;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, Sluggable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }
    function riderActiveBooking()
    {
        return $this->hasOne(Booking::class, 'rider_id', 'id')->whereIn('status', [
            'pending',
            'accepted',
            'enRoute',
            'arrived',
            'progress'
        ]);
    }

    function driverActiveBooking()
    {
        return $this->hasOne(Booking::class, 'driver_id', 'id')->whereIn('status', [
            'accepted',
            'enRoute',
            'arrived',
            'progress'
        ]);
    }

    function city()
    {
        return $this->belongsTo(City::class);
    }

    function hasPushToken()
    {
        if (!$this->push_token) {
            return false;
        }

        $messaging = app('firebase.messaging');
        $validationResult = $messaging->validateRegistrationTokens([$this->push_token]);

        return in_array($this->push_token, $validationResult['valid']);
    }

    function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }
    function bookings()
    {
        return $this->hasMany(Booking::class, 'rider_id', 'id');
    }

    function locations()
    {
        return $this->hasMany(Location::class);
    }

    function packages()
    {
        return $this->hasMany(UserPackage::class);
    }

    function ratings()
    {
        return $this->hasMany(Rating::class);
    }
}
