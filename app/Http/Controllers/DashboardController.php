<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Vehicle;

class DashboardController extends Controller
{
    function index()
    {
        $vehicles = Vehicle::count();
        $drivers = User::where('role', 'driver')->count();
        $riders = User::where('role', 'rider')->count();
        // bookings Staticts
        $totalBookings = Booking::count();
        $currentBookings = Booking::whereIn('status',[
            'pending',
            'accepted',
            'enRoute',
            'arrived',
            'progress'
        ])->count();
        $completedBookings = Booking::where('status', 'completed')->count();
        $cancelledBookings = Booking::where('status', 'cancelled')->count();
        // earnings
        return Inertia::render('Dashboard', [
            'vehicles' => $vehicles,
            'drivers' => $drivers,
            'riders' => $riders,
            'totalBookings' => $totalBookings,
            'currentBookings' => $currentBookings,
            'completedBookings' => $completedBookings,
            'cancelledBookings' => $cancelledBookings,
        ]);
    }
}
