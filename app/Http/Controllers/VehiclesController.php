<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vehicle;
use App\Models\City;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;

class VehiclesController extends Controller
{
    //
    function index(City $city)
    {
        $city->load("vehicles");
        if(request('search')) {
            $vehicles = $city->vehicles()->where(
                'title', 'like', '%' . request('search') . '%'
            )->get();
            $search = true;
        }
        else {
            $vehicles = $city->vehicles()->paginate(10);
            $search = false;
        }
        return Inertia::render('VehicleTypes', [
            'city' => $city,
            'vehicles' => $vehicles,
            'search' => $search
        ]);
    }
    function store(Request $request, $id)
    {
        $city = City::find($id);
        $validated = $request->validate([
            'title' => "required",
            'seats' => 'required'
        ]);
        if (request()->file('image')) {
            $path = request()->file('image')->store('images', 'public');
            $validated['image'] = $path;
            $city->vehicles()->create($validated);
            return redirect::back();
        }
    }
    function update(Request $request, $id)
    {
        $vehicles = Vehicle::find($id);
        $validated = $request->validate([
            'title' => "required",
            'seats' => "required"
        ]);
        if (request()->file('image')) {
            $path = request()->file('image')->store('images', 'public');
            $validated['image'] = $path;
            $vehicles->update($validated);
            return Redirect::back();
        }
    }
    function changeStatus(Vehicle $vehicle)
    {
        $vehicle->update([
            'status' => $vehicle->status === 'active' ? 'inactive' : "active"
        ]);
        return redirect::back();
    }
    function distroy($id)
    {
        $vehicles = Vehicle::find($id);
        $vehicles->delete();
        return redirect::back();
    }
}
