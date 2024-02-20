<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\User;
use App\Models\Vehicle;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use SebastianBergmann\CodeCoverage\Driver\Driver;

class DriversController extends Controller
{
    function index()
    {
        $vehicles = Vehicle::latest()->get(['id', 'title', 'city_id']);
        $cities = City::latest()->get(['id', 'name', 'country_id']);
        if (request('search')) {
            if (request('filter')) {
                $drivers = User::where('role', 'driver')->where(
                    request('filter'),
                    'like',
                    '%' . request('search') . '%'
                )->latest()->get();
                $filter = request('filter');
                $search = true;
            } else {
                $drivers = User::where('role', 'driver')->where(
                    'name',
                    'like',
                    '%' . request('search') . '%'
                )->latest()->get();
                $filter = null;
                $search = true;
            }
        } else {
            $drivers = User::where('role', 'driver')->latest()->paginate(10);
            $filter = null;
            $search = false;
        }

        return Inertia::render('Drivers', [
            'drivers' => $drivers,
            'filter' => $filter,
            'search' => $search,
            'vehicles' => $vehicles,
            'cities' => $cities,
        ]);
    }
    function show()
    {
        $test = 'git test';
        $slug = request()->slug;
        $driver = User::where(['slug' => $slug])->first();
        $driver = $driver->load("vehicle");
        // booking staticts
        $totalBookings = $driver->bookings()->count();
        // current booking
        $currentBookings = $driver->bookings->whereIn('status', [
            'pending',
            'accepted',
            'enRoute',
            'arrived',
            'progress'
        ])->count();
        // completed bookings
        $completedBookings = $driver->bookings->where('status', 'completed')->count();
        // cancelled bookings
        $cancelledBookings = $driver->bookings->where('status', 'cancelled')->count();
        return Inertia::render('DriverProfile', [
            'driver' => $driver,
            'totalBookings' => $totalBookings,
            'currentBookings' => $currentBookings,
            'completedBookings' => $completedBookings,
            'cancelledBookings' => $cancelledBookings,
            'test' => $test
        ]);
    }

    function verifyProfile($id)
    {
        $user = User::find($id);
        $user->profile_status = 'complete';
        $user->save();
        return Redirect::back();
    }
    function store(Request $request)
    {
        // dd(request()->all());
        $validated = $request->validate([
            'name' => 'required',
            'preferred_name' => 'required',
            'email' => 'required|email|unique:users',
            'phone' => 'required',
            'password' => 'required|confirmed|min:6',
            'dob' => '',
            'resident' => '',
            'street_address' => '',
            'vehicle_id' => '',
            'city_id' => '',
            'car_company' => '',
            'car_model' => '',
            'car_color' => '',
            'vehicle_nr' => '',
            'with_chair' => '',
            'with_dog' => '',
            'with_pets' => '',
        ]);
        User::create([
            'name' => $request->name,
            'preferred_name' => $request->preferred_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'dob' => $request->dob,
            'resident' => $request->resident,
            'street_address' => $request->street_address,
            'vehicle_id' => $request->vehicle_id,
            'city_id' => $request->city_id,
            'car_company' => $request->car_company,
            'car_model' => $request->car_model,
            'car_color' => $request->car_color,
            'vehicle_nr' => $request->vehicle_nr,
            'with_chair' => $request->with_chair,
            'with_dog' => $request->with_dog,
            'with_pets' => $request->with_pets,
            // static
            'is_phone_verified' => 1,
            'role' => 'driver',
            'free_rides' => 25,
            'profile_status' => 'complete'
        ]);
        return Redirect::back();
    }
    function update(Request $request, User $driver)
    {
        // dd(request()->all());
        $validated = $request->validate([
            'name' => 'required',
            'preferred_name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'dob' => '',
            'resident' => '',
            'street_address' => '',
            'vehicle_id' => '',
            'city_id' => '',
            'car_company' => '',
            'car_model' => '',
            'car_color' => '',
            'vehicle_nr' => '',
            'with_chair' => '',
            'with_dog' => '',
            'with_pets' => '',
        ]);
        $driver->update([
            'name' => $request->name,
            'preferred_name' => $request->preferred_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'dob' => $request->dob,
            'resident' => $request->resident,
            'street_address' => $request->street_address,
            'vehicle_id' => $request->vehicle_id,
            'city_id' => $request->city_id,
            'car_company' => $request->car_company,
            'car_model' => $request->car_model,
            'car_color' => $request->car_color,
            'vehicle_nr' => $request->vehicle_nr,
            'with_chair' => $request->with_chair,
            'with_dog' => $request->with_dog,
            'with_pets' => $request->with_pets,
            'profile_status' => 'complete'
        ]);
        return Redirect::back();
    }
    function onStatusChange(User $user)
    {
        $user->update([
            'status' => $user->status === 'active' ? 'blocked' : 'active'
        ]);
        return Redirect::back();
    }
    function destroy($id)
    {
        $driver = User::find($id);
        $driver->delete();
        return Redirect::back();
    }
}