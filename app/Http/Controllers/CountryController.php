<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Country;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;
class CountryController extends Controller
{
    function index()
    {
        if(request('search')) {
            $country = Country::where(
                'name', 'like', '%' . request('search') . '%'
            )->get();
        } else {
            $country = Country::get();
        }
        return Inertia::render('Countries', [
            'countries' => $country
        ]);
    }
    function store(Request $request) 
    {
        $validated = $request->validate([
            'name' => "required",
        ]);
        if (request()->file('image'))
        {
            $path = request()->file('image')->store('images', 'public');
            $validated['image'] = 'storage/'.$path;
            Country::create($validated);
            return Redirect::route('countries');
        }
    }
    function update(Request $request, $id)
    {
        $country = Country::find($id);
        $validated = $request->validate([
            'name' => "required"
        ]);
        if (request()->file('image'))
        {
            $path = request()->file('image')->store('images', 'public');
            $validated['image'] = 'storage/'.$path;
            $country->update($validated);
            return Redirect::route('countries');
        }
    }
    function distroy($id)
    {
        $country = Country::find($id);
        $country->delete();
        return Redirect::route('countries');
    }
}
