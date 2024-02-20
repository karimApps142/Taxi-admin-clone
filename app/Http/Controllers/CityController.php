<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Country;
use App\Models\City;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;

class CityController extends Controller
{

    function index(Country $country)
    {
        $country->load('cities');
        if(request('search')) {
            $cities =  $country->cities()->where(
                'name', 'like', '%' . request('search') . '%'
            )->get();
            $search = true;
        }
        else {
            $cities =  $country->cities()->paginate(10);
            $search = false;
        }
        return Inertia::render('Cities', [
            'country' => $country,
            'cities' => $cities,
            'search' => $search
        ]);
    }
    function store(Request $request, Country $country, $id)
    {
        $country = Country::find($id);
        $validated = $request->validate([
            'name' => "required",
            'zipcode' => "required|unique:cities",
            'currency' => "required",
            'unit' => "required",
            'coords' => "",
            'radius' => "required"
        ]);

        $coords = json_encode($validated['coords']);
        $validated['coords'] = $coords;
        $country->cities()->create($validated);
        return Redirect::back();
    }
    function update(Request $request, Country $country, $id)
    {
        // dd(request()->all());
        $city = City::find($id);
        $validated = $request->validate([
            'name' => "required",
            'zipcode' => "required",
            'currency' => "required",
            'unit' => "required",
            'coords' => "required",
            'radius' => "required"
        ]);
        $coords = json_encode($validated['coords']);
        $validated['coords'] = $coords;
        $city->update($validated);
        return Redirect::back();
    }
    function destroy(Country $country, $id)
    {
        $city = City::find($id);
        $city->delete();
        return Redirect::back();
    }
}
