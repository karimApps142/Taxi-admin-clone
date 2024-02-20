<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class RidersController extends Controller
{
    function index()
    {
        if(request('search')) {
            //filter
           if(request('filter')){
            $riders = User::where('role', 'rider')->where(
                request('filter'), 'like', '%' . request('search') . '%'
            )->latest()->get();
            $filter = request('filter');
            $search = true;
           } 
           // not filter
           else{
            $riders = User::where('role', 'rider')->where(
                'name', 'like', '%' . request('search') . '%'
            )->latest()->get();
            $filter = null;
            $search = true;
           }
        }
        else {
            $riders = User::where('role', 'rider')->latest()->paginate(10);
            $search = false;
            $filter = null;
        }
        return Inertia::render('Riders', [
            'riders' => $riders,
            'search' => $search,
            'filter' => $filter,
        ]);
    }
    function show()
    {
        $slug = request()->slug;
        $rider = User::where(['slug' => $slug])->first();
        // total booking
        $totalBookings = $rider->bookings()->count();
        // current booking
        $currentBookings = $rider->bookings->whereIn('status',[
            'pending',
            'accepted',
            'enRoute',
            'arrived',
            'progress'
        ])->count();
        // completed bookings
        $completedBookings = $rider->bookings->where('status', 'completed')->count();
        // cancelled bookings
        $cancelledBookings = $rider->bookings->where('status', 'cancelled')->count();
        return Inertia::render('RiderProfile', [
            'rider' => $rider,
            'totalBookings' => $totalBookings,
            'currentBookings' => $currentBookings,
            'completedBookings' => $completedBookings,
            'cancelledBookings' => $cancelledBookings,
        ]);
    }
    function store(Request $request) 
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:6',
            'phone' => 'required|unique:users'
        ]);
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'is_phone_verified' => 1,
            'profile_status' => 'complete',
        ]);
        return Redirect::back();
    }
    function update(Request $request, User $rider) 
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'email' => 'required',
            'phone' => 'required'
        ]);
        $rider->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'is_phone_verified' => 1,
            'profile_status' => 'complete',
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
        $rider = User::find($id);
        $rider->delete();
        return Redirect::back();
    }
}
