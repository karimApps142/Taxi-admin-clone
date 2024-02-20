<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\City;

class Package extends Model
{
    use HasFactory;

    protected $guarded = [];

    function city()
    {
        return $this->belongsTo(City::class, 'city_id', 'id');
    }
}
