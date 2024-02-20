<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $guarded = [];

    function driver()
    {
        return $this->belongsTo(User::class, 'driver_id', 'id');
    }

    function rider()
    {
        return $this->belongsTo(User::class, 'rider_id', 'id');
    }

    function ratings()
    {
        return $this->hasMany(Rating::class);
    }
}
