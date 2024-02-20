<?php

namespace App\Http\Controllers;

use App\Crons\Cron;
use App\Models\Booking;
use App\Models\City;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, Cron;

    function me($userId)
    {
        $user = User::find($userId);
        // $user->update(['active_status' => 'online']);

        if ($user->role === 'rider') {
            $cities = City::whereNotNull('coords')->select('id', 'coords', 'zipcode')->get();
            $user->setAttribute('cities', $cities);
        }

        if ($user->role === 'driver') {
            $user->load(['city', 'vehicle']);
        }

        $user->setAttribute('pb_key', env('STRIPE_PUBLIC'));
        return $user->makeVisible(['cities', 'pb_key']);
    }

    function baseValidation($validations = [])
    {
        return request()->validate($validations);
    }

    function DeleteIfFileExistInStorage($file)
    {
        if ($file) {
            $current_photo_path = public_path('/storage') . $file;
            if (file_exists($current_photo_path)) {
                @unlink($current_photo_path);
            }
        }
    }

    function makeImage($base64_image, $path = "images")
    {
        @list($type, $file_data) = explode(';', $base64_image);
        @list(, $file_data) = explode(',', $file_data);
        $imageName = Str::random(14) . '.' . explode('/', explode(':', substr($base64_image, 0, strpos($base64_image, ';')))[1])[1];
        $save_path = "${path}/${imageName}";
        Storage::disk('public')->put($save_path, base64_decode($file_data));
        return $save_path;
    }

    function isDriverInPendingList($pendingdIds, $driverId)
    {
        if (collect($pendingdIds)->contains($driverId)) return true;
        else return false;
    }

    function isBookingAvailible($booking)
    {
        return $booking->status === 'pending';
    }

    function getDriverRequestedBooking($booking)
    {
        $booking = Booking::find($booking->id);
        if ($booking) {
            $booking->load(['rider' => function ($q) {
                $q->select('id', 'name', 'avatar', 'lat', 'lng', 'phone');
            }]);
        }
        return $booking;
    }

    function getBookingDetails($user)
    {

        $booking = null;
        if ($user->role === 'rider') {
            $booking = $user->riderActiveBooking;
            if ($booking && $booking->driver_id) {
                $booking->load(['driver' => function ($q) {
                    $q->select('id', 'name', 'avatar', 'lat', 'lng', 'phone', 'car_company', 'car_model', 'car_color', 'vehicle_nr');
                    $q->withAvg('ratings', 'stars');
                }]);
            }
        }
        if ($user->role === 'driver') {
            $booking = $user->driverActiveBooking;
            if ($booking && $booking->rider_id) {
                $booking->load(['rider' => function ($q) {
                    $q->select('id', 'name', 'avatar', 'lat', 'lng', 'phone');
                }]);
            }
        }
        return $booking;
    }
}
