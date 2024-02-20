<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\City;
use App\Models\Country;
use App\Models\Rating;
use App\Models\User;
use App\Models\Vehicle;

class UserController extends Controller
{
    function updateLocation()
    {
        $validated = request()->validate([
            'lat' => "required",
            'lng' => "required",
        ]);

        $user = User::find(auth()->user()->id);

        $user->update([
            'lat' => $validated['lat'],
            'lng' => $validated['lng'],
        ]);

        return response(null, 200);
    }

    function bookingRating(Booking $booking)
    {
        $validated = request()->validate([
            'stars' => 'required',
            'review' => '',
        ]);

        $user = auth()->user();
        $validated['from_id'] = $user->id;
        if ($user->role === 'rider') {
            $validated['user_id'] = $booking->driver_id;
        } else {
            $validated['user_id'] = $booking->rider_id;
        }
        $booking->ratings()->create($validated);

        return response()->json(['message' => "thanks for rating."]);
    }

    function getProfilePickerData()
    {
        $countries = Country::all();
        $cities = City::whereNotNull('coords')->get();
        $vehicles = Vehicle::where('status', 'active')->get();

        return response()->json([
            'countries' => $countries,
            'cities' => $cities,
            'vehicles' => $vehicles,
        ]);
    }

    function completeProfile()
    {
        $user = User::find(auth()->user()->id);
        if ($user->role !== 'driver') {
            return response()->json(['message' => "Invalid account."], 400);
        }
        $validated = request()->validate([
            'preferred_name' =>  '',
            'dob' =>  'required',
            'resident' =>  'required',
            'street_address' =>  'required',
            'vehicle_id' =>  'required',
            'city_id' =>  'required',
            'car_company' =>  'required',
            'car_model' =>  'required',
            'car_color' =>  'required',
            'vehicle_nr' =>  'required',
            'with_chair' =>  '',
            'with_dog' =>  '',
            'with_pets' =>  '',
        ]);
        if ($user->profile_status !== 'complete') {
            $validated['profile_status'] = 'progress';
        }

        $user->update($validated);

        if (request()->image && request()->image !== $user->avatar) {
            $path = $this->makeImage(request()->image);
            $user->avatar = $path;
            $user->save();
        }
        return response()->json($this->me($user->id));
    }

    function getBookings()
    {
        $user = auth()->user();
        $status = null;
        if (request()->status) {
            $status = request()->status;
        }
        $bookings = $this->getAllBookings($user, $status);

        foreach ($bookings as $booking) {
            $rating = null;
            $rating = Rating::where([
                'booking_id' => $booking->id,
                'user_id' => $user->id
            ])->first();

            $booking->setAttribute('rating', $rating);
        }


        return response()->json($bookings);
    }

    function switchUserOnlineStatus()
    {
        $user = request()->user();
        $newStatus = $user->active_status === 'online' ? 'offline' : 'online';
        $user->update(['active_status' => $newStatus]);
        return response()->json($newStatus);
    }



    function getDriverRequests()
    {
        $user = auth()->user();

        if ($user->role !== 'driver') {
            return response()->json(['message' => "Invalid account"], 400);
        }
        $bookings = Booking::where(['status' => 'pending'])->get();

        $filtered = $bookings->filter(function ($booking) use ($user) {
            if ($this->isDriverInPendingList(json_decode($booking->pending_ids), $user->id)) {
                return  $booking->load(['rider' => function ($q) {
                    $q->select('id', 'name', 'avatar', 'lat', 'lng', 'phone');
                }]);
            }
        });
        $filteredBooking = $filtered->values();

        return response()->json($filteredBooking);
    }


    function getAllBookings($user, $query = null)
    {
        $bookings = null;
        if ($user->role === 'rider') {
            $bookings = Booking::where('rider_id', $user->id)
                ->when($query, function ($q) use ($query) {
                    $q->where('status', $query);
                })
                ->with(['driver' => function ($q) {
                    $q->select('id', 'name', 'avatar', 'lat', 'lng', 'phone');
                }])
                ->latest()->paginate(10);
        }
        if ($user->role === 'driver') {
            $bookings = Booking::where('driver_id', $user->id)
                ->when($query, function ($q) use ($query) {
                    $q->where('status', $query);
                })
                ->with(['rider' => function ($q) {
                    $q->select('id', 'name', 'avatar', 'lat', 'lng', 'phone');
                }])
                ->latest()->paginate(10);
        }
        return $bookings;
    }
    function updateProfile()
    {
        $user = User::find(request()->user()->id);
        request()->validate([
            'name' => 'required',
        ]);
        $user->name = request()->name;
        if (request()->image && request()->image !== $user->avatar) {
            $path = $this->makeImage(request()->image);
            $user->avatar = $path;
        }
        $user->save();
        return response()->json($this->me($user->id));
    }
}
