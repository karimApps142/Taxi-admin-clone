<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\City;
use App\Models\Package;
use Illuminate\Support\Facades\Redirect;

class PackageController extends Controller
{
    //
    function index()
    {
        if(request('search')){
            $packages = Package::where(
                'title', 'like', '%' . request('search') . '%'
            )->with('city')->get();
            $search = true;
        }
        else {
            $packages = Package::with('city')->paginate(10);
            $search = false;
        }
        $cities = City::get();
        return Inertia::render("Packages", [
            'cities' => $cities, 
            'packages' => $packages,
            'search' => $search
            ]);
    }
    function store(Request $request)
    {
        $validated = $request->validate(['title' => "required", 'rides' => "required", 'price' => "required", 'city_id' => "required",]);
        Package::create($validated);
        return Redirect::back();
    }
    function update(Request $request, $id)
    {
        $package = Package::find($id);
        $validated = $request->validate(['title' => "required", 'rides' => "required", 'price' => "required", 'city_id' => "required",]);
        $package->update($validated);
        return Redirect::back();
    }
    function changeStatus(Package $package)
    {
        $package->update([
            'status' => $package->status === 'active' ? 'inactive' : 'active'
        ]);
        return Redirect::back();
    }
    function destroy($id)
    {
        $package = Package::find($id);
        $package->delete();
        return Redirect::back();
    }
}
