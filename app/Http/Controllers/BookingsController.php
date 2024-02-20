<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Rating;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BookingsController extends Controller
{
    //
    function index()
    {
        $filter = request('filter');
        // cancelled by rider
        if($filter == 'cancelledByRider') {
            $bookings = Booking::where([
                'status' => 'cancelled',
                'cancelled_by' => 'rider'
                ])->with('rider:id,name', 'driver:id,name')->latest()->get();
            $filter = $filter;
        } else {
              // cancelled by driver
        if($filter == 'cancelledByDriver') {
            $bookings = Booking::where([
                'status' => 'cancelled',
                'cancelled_by' => 'driver'
                ])->with('rider:id,name', 'driver:id,name')->latest()->get();
            $filter = $filter;
        } else {
           if($filter == 'expiredBySystem') {
            $booking_data = Booking::where([
                'status' => 'expired',
                ])->with('rider:id,name', 'driver:id,name')->latest()->get();
             $bookings = $booking_data->where('cronjob_at');
            $filter = $filter;
           } else {
            if($filter == 'expiredByRider') {
                $booking_data = Booking::where([
                    'status' => 'expired',
                    ])->with('rider:id,name', 'driver:id,name')->latest()->get();
                 $bookings = $booking_data->where('cronjob_at', null);
                $filter = $filter;
            } else {
                if($filter) {
                    $bookings = Booking::where(
                        'status', $filter
                    )->with('rider:id,name', 'driver:id,name')->latest()->get();
                    $filter = $filter;
                }
                else{
                    $bookings = Booking::with('rider:id,name', 'driver:id,name')->latest()->paginate(10);
                    $filter = null;
                }
            }
           }
        }
        }
        return Inertia::render('Bookings', [
            'bookings' => $bookings,
            'filter'  => $filter
        ]);
    }
    function show($id)
    {
        $booking = Booking::find($id);
        $booking->load('driver', 'rider', 'ratings');
        $booking->ratings->load('user');
        $pendingIds = json_decode($booking->pending_ids);
        $driverId  = $booking->driver_id;
        // 
        if($booking->pending_ids) {
            $missedByIds = array_filter($pendingIds, function ($id) use ($driverId) { 
                return $id != $driverId;
            });
        }
        else {
            $missedByIds = [];
        }
        $missedBy = User::whereIn('id', $missedByIds)->get();

        return Inertia::render('BookingDetail', [
            'booking' => $booking,
            'missedBy'  => $missedBy,
        ]);
    }
}
