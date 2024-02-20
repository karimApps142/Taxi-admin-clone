<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\City;

class Vehicle extends Model
{
    use HasFactory;

    protected $guarded = [];


    public function getImageAttribute($value)
    {
        if ($value) {
            return asset('storage/' . $value);
        } else {
            return asset('images/no-image.png');
        }
    }
    function city()
    {
        return $this->belongsTo(City::class, "city_id", "id");
    }
}
