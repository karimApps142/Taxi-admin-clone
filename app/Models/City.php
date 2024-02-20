<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Country;
use App\Models\Package;
use App\Models\Vehicle;
class City extends Model
{
    use HasFactory;

    protected $guarded = [];
    
    function country()
    {
        return $this->belongsTo(Country::class, 'country_id', 'id');
    }
    function packages()
    {
        return $this->hasMany(Packages::class);
    }
    function vehicles()
    {
        return $this->hasMany(Vehicle::class);
    }
}
