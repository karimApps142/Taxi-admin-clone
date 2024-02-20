<?php

namespace App\Http\Controllers\Api;

use Exception;
use Carbon\Carbon;
use App\Models\City;
use App\Models\User;
use App\Models\Booking;
use App\Models\Vehicle;
use App\Notifications\AppNotify;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Notification;

class BookingController extends Controller
{

    public function getVehicles()
    {
        $zipcode = request()->input('zip');
        $city = City::where('zipcode', $zipcode)->first();
        if (!$zipcode) {
            return response()->json(['message' => 'Zip code is required.'], 400);
        } elseif (!$city) {
            return response()->json(['message' => 'Sorry, we could not find this area.'], 400);
        }
        $vehicles = Vehicle::where(['status' => 'active', 'city_id' => $city->id])->get();
        return $vehicles->isEmpty() ? response()->json(['message' => 'Sorry, we could not find any vehicles in your area. Please try a different area.'], 404) : response()->json($vehicles);
    }

    function createBooking()
    {
        $validationRules = [
            'dropoff_address' => "required",
            'dropoff_lat' => "required",
            'dropoff_lng' => "required",
            'dropoff_placeId' => "",
            'dropoff_region' => "",
            'pickup_address' => "required",
            'pickup_lat' => "required",
            'pickup_lng' => "required",
            'pickup_placeId' => "",
            'pickup_region' => "",
            'vehicle_id' => "required",
            'with_chair' => "",
            'with_dog' => "",
            'with_pets' => "",
            'radius' => "required",
        ];

        $validatedData = request()->validate($validationRules);

        $rider = auth()->user();

        Log::info('Booking creation started', ['rider' => $rider->name]);

        if ($rider->ride_status !== 'available') {

            Log::warning('Rider is busy', ['rider' => $rider->name]);

            return response()->json(['message' => 'Rider is busy!'], 400);
        }


        try {

            DB::beginTransaction();

            if ($rider->riderActiveBooking) {
                $booking = $rider->riderActiveBooking;

                if ($booking) {
                    $driver = User::find($booking->driver_id);
                    $rider = User::find($booking->rider_id);

                    $booking->update([
                        'status' => 'cancelled',
                        'cancelled_at' => Carbon::now(),
                        'cancelled_by' => $rider->role,
                        'cancelled_text' => "unexpected circumstances",
                    ]);

                    if ($driver) {
                        $driver->update(['ride_status' => "available"]);

                        $token = $driver->push_token;
                        Notification::send(
                            $rider,
                            new AppNotify("Request cancelled", "Ride cancelled by the rider.", $token, ['type' => "cancelled", 'data' => null])
                        );
                    }
                    $rider->update(['ride_status' => "available"]);
                }
            }

            $validatedData['rider_id'] = $rider->id;
            $validatedData['booking_nr'] = $this->generateBookingNR();

            $booking = Booking::create($validatedData);

            $data = $this->searchForDrivers($booking);

            Log::info('Booking created', ['booking_id' => $booking->id]);

            DB::commit();

            return response()->json($data);
        } catch (Exception $e) {

            Log::error('Error creating booking', ['error' => $e->getMessage()]);

            DB::rollback();

            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    function searchForDrivers($booking)
    {

        Log::info('Searching for available drivers for booking', ['booking_nr' => $booking->booking_nr]);

        try {

            $Bookingvehicle = Vehicle::find($booking->vehicle_id);

            Log::info('Vehicle found for booking', ['booking_nr' => $booking->booking_nr, 'vehicle_id' => $Bookingvehicle->id]);

            if ($Bookingvehicle->city) {
                $booking->update(['currency' => $Bookingvehicle->city->currency, 'radius' => $Bookingvehicle->city->radius]);
            }

            $baseQuery = User::query();

            $baseQuery = User::select()->where('role', 'driver');
            Log::info('Role driver applied', ['found_drivers' => $baseQuery->count()]);

            $baseQuery->where('status', 'active');
            Log::info('Status active filter applied', ['found_drivers' => $baseQuery->count()]);

            $baseQuery->where('profile_status', 'complete');
            Log::info('Profile status complete filter applied', ['found_drivers' => $baseQuery->count()]);

            $baseQuery->where('ride_status', 'available');
            Log::info('Ride status availible filter applied', ['found_drivers' => $baseQuery->count()]);

            $baseQuery->where('active_status', 'online');
            Log::info('Online status filter applied', ['found_drivers' => $baseQuery->count()]);

            $baseQuery->whereIn('with_chair', [1, $booking->with_chair ? 1 : 0]);
            Log::info('Drivers after with_chair filter', ['found_drivers' => $baseQuery->count()]);

            $baseQuery->whereIn('with_dog', [1, $booking->with_dog ? 1 : 0]);
            Log::info('Drivers after with_dog filter', ['found_drivers' => $baseQuery->count()]);

            $baseQuery->whereIn('with_pets', [1, $booking->with_pets ? 1 : 0]);
            Log::info('Drivers after with_pets filter', ['found_drivers' => $baseQuery->count()]);


            $baseQuery->whereNotNull(['lat', 'lng', 'push_token'])
                ->when($booking->pickup_lng and $booking->pickup_lat, function ($query) use ($booking) {
                    $query->addSelect(DB::Raw("ST_Distance_Sphere(
                    POINT('$booking->pickup_lng', '$booking->pickup_lat'), POINT(lng, lat)
                ) as distance"))
                        ->having("distance", "<", $booking->radius * 1609.34)
                        ->orderBy('distance');
                });

            Log::info('Additional filters applied (checking coordinates, push token, and distance comparison)', ['found_drivers' => $baseQuery->count()]);

            $selectedDrivers = $baseQuery->get();

            $filtered = $selectedDrivers->filter(function ($driver) use ($Bookingvehicle) {
                $driverVehicle = Vehicle::find($driver->vehicle_id);
                if ($driverVehicle && $driverVehicle->seats >= $Bookingvehicle->seats && $driver->free_rides > 0 && $driver->hasPushToken()) {
                    Log::info('Driver meets criteria: Has a vehicle with enough seats and available free rides and a valid push token', ['driver' => $driver->name]);
                    return $driver;
                } else {
                    Log::warning(
                        'Driver does not meet criteria: Does not have a vehicle with enough seats or has no available free rides or uninstall the app (invalid push toke)',
                        [
                            'driver' => $driver->name,
                            'driver Vehicle seats' => $driverVehicle ? $driverVehicle->seats : null,
                            'booking seats' => $Bookingvehicle->seats,
                            'driver free rides' => $driver->free_rides,
                            'push_token' => $driver->push_token,
                            'push_token_state' => $driver->hasPushToken() ? 'Valid' : 'Invalid'
                        ],
                    );
                }
            });


            $drivers = $filtered->values();

            $foundDrivers = $drivers->count();

            $rider = User::find($booking->rider_id);

            if ($foundDrivers) {

                Log::info('Found drivers for booking', ['booking_nr' => $booking->booking_nr, 'found_drivers' => $foundDrivers]);

                $rider->update(['ride_status' => 'onRide']);
                $driverIds = $drivers->pluck('id');
                $booking->update(['pending_ids' => json_encode($driverIds)]);
                $bookingRequest = $this->getDriverRequestedBooking($booking);
                foreach ($drivers as $driver) {

                    Log::info('Booking request sent to driver', ['booking_nr' => $booking->booking_nr, 'driver' => $driver->name]);

                    $token = $driver->push_token;
                    Notification::send(
                        $driver,
                        new AppNotify("New Booking", "New booking request received.", $token, ['type' => "newRequest", 'data' => $bookingRequest])
                    );
                }

                $riderBooking = $this->getBookingDetails($rider);
                return $riderBooking;
            } else {
                $rider->ride_status = 'available';
                $booking->update(['status' => "expired"]);
                $rider->save();

                throw new Exception("No TACSI available at the moment. Please try again later.");
            }
        } catch (Exception $e) {

            Log::error('Error during driver search', ['booking_nr' => $booking->booking_nr, 'error' => $e->getMessage()]);

            throw new Exception($e->getMessage());
        }
    }


    function getUserBookingDetails()
    {
        $user = User::find(auth()->user()->id);

        if ($user->ride_status !== 'available') {
            $booking = $this->getBookingDetails($user);
            if ($booking) {
                return response()->json($booking);
            } else {
                $user->ride_status = 'available';
                $user->save();
                return response()->json(['message' => 'ride not found in database.'], 400);
            }
        } else {
            return response()->json(['message' => 'user have no ride'], 400);
        }
    }

    public function onAccept(Booking $booking)
    {
        try {
            $driver = User::find(auth()->user()->id);

            if ($driver->role !== 'driver') {
                throw new Exception('Invalid account.');
            }

            if ($driver->ride_status === 'onRide') {
                throw new Exception('You are on a ride.');
            }

            if (!$driver->free_rides) {
                throw new Exception("Sorry, it looks like you've used up all your rides. Upgrade to one of our subscription packages to continue riding with TACSI!");
            }

            $result = DB::transaction(function () use ($booking, $driver) {
                // Lock the booking for update
                $booking = Booking::lockForUpdate()->find($booking->id);

                if ($booking->status !== 'pending') {
                    throw new Exception('Your booking request has expired or has already been accepted by another driver.');
                }

                if (!$this->isDriverInPendingList(json_decode($booking->pending_ids), $driver->id)) {
                    throw new Exception('You are not in the booking pending list.');
                }

                $rider = User::find($booking->rider_id);
                $rider->update(['ride_status' => 'onRide']);

                $driver->update([
                    'ride_status' => 'onRide',
                    'free_rides' => $driver->free_rides - 1,
                ]);

                $vehicle = null;

                if ($driver->car_company && $driver->car_model) {
                    $vehicle = $driver->car_company . ' ' . $driver->car_model;
                }

                $booking->update([
                    'status' => 'accepted',
                    'driver_id' => $driver->id,
                    'vehicle' => $vehicle,
                    'accepted_at' => now(),
                ]);

                $token = $rider->push_token;
                $riderBookingDetails = $this->getBookingDetails($rider);
                $driverBookingDetails = $this->getBookingDetails($driver);

                Notification::send(
                    $rider,
                    new AppNotify('Booking Accepted', 'Ride confirmed!', $token, ['type' => 'progress', 'data' => $riderBookingDetails])
                );

                return ['data' => $driverBookingDetails, 'status' => 200];
            });

            return response()->json($result['data'], $result['status']);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }

    public function changeBookingStatus(Booking $booking)
    {
        $user = auth()->user();
        if ($user->role !== 'driver') {
            return response()->json(['message' => 'Invalid account'], 400);
        }

        $bookingStatus = $booking->status;
        $notificationTitle = '';
        $notificationMessage = '';
        $notificationData = [];

        switch ($bookingStatus) {
            case 'accepted':
                $booking->status = 'enRoute';
                $notificationTitle = 'Ride Accepted';
                $notificationMessage = 'Driver en route to you.';
                break;
            case 'enRoute':
                $booking->status = 'arrived';
                $notificationTitle = 'Driver Arrived';
                $notificationMessage = 'Driver is ready to go.';
                break;
            case 'arrived':
                $booking->status = 'progress';
                $notificationTitle = 'Trip Started';
                $notificationMessage = 'Enjoy the ride with TACSI!';
                break;
            case 'progress':
                $booking->status = 'completed';
                $booking->completed_at = Carbon::now();
                $notificationTitle = 'Trip Ended';
                $notificationMessage = 'Thank you for choosing TACSI!';
                $notificationData = ['type' => 'completed', 'data' => $booking];
                break;
            default:
                return response()->json(['message' => 'Booking is not available'], 400);
        }


        if ($booking->save()) {
            $rider = User::find($booking->rider_id);
            $driver = User::find($booking->driver_id);
            $riderBookingDetails = $this->getBookingDetails($rider);
            $token = $rider->push_token;


            $driverBookingDetails = $this->getBookingDetails($driver);

            if ($booking->status === 'completed') {
                $driver->update(['ride_status' => 'available']);
                $rider->update(['ride_status' => 'available']);
                Notification::send($rider, new AppNotify($notificationTitle, $notificationMessage, $token, $notificationData));
                return response()->json($booking);
            }
            if ($booking->status === 'arrived') {
                Notification::send($rider, new AppNotify($notificationTitle, $notificationMessage, $token, ['type' => 'arrived', 'data' => $riderBookingDetails]));
                return response()->json($driverBookingDetails);
            } else {
                Notification::send($rider, new AppNotify($notificationTitle, $notificationMessage, $token, ['type' => 'progress', 'data' => $riderBookingDetails]));
                return response()->json($driverBookingDetails);
            }
        } else {
            return response()->json(['message' => 'Failed to update booking status'], 500);
        }
    }


    function cancelSearch()
    {
        $rider = User::find(auth()->user()->id);

        if ($rider->role !== 'rider') {
            return response()->json(['message' => 'Invalid account'], 400);
        }

        $booking = $rider->riderActiveBooking;

        if (!$booking) {
            return response()->json(['message' => 'There is no active booking associated with this rider account.'], 400);
        }

        if ($booking->status === 'accepted') {
            return response()->json(['message' => 'Unfortunately, your ride cannot be cancelled as it has already been accepted by a driver.'], 400);
        }

        if ($booking->status === 'pending') {
            $driverIds = json_decode($booking->pending_ids);
            $drivers = User::whereIn('id', $driverIds)->get();
            $notificationData = ['type' => 'expire', 'data' => $booking];

            foreach ($drivers as $driver) {
                $token = $driver->push_token;
                Notification::send(
                    $driver,
                    new AppNotify("Request Canceled", "Request canceled by the rider.", $token, $notificationData)
                );
            }

            $booking->update(['status' => 'expired', 'cancelled_at' => Carbon::now()]);
            $rider->update(['ride_status' => 'available']);

            return response()->json(['message' => 'Your booking has been cancelled. We hope to see you again soon!']);
        }
    }


    function orderRejection()
    {
        $validated = request()->validate(['text' => 'required']);
        $user = auth()->user();

        $booking = null;

        if ($user->role === 'rider') {
            $booking = $user->riderActiveBooking;
        }
        if ($user->role === 'driver') {
            $booking = $user->driverActiveBooking;
        }

        if ($booking) {
            $driver = User::find($booking->driver_id);
            $rider = User::find($booking->rider_id);

            $booking->update([
                'status' => 'cancelled',
                'cancelled_at' => Carbon::now(),
                'cancelled_by' => $user->role,
                'cancelled_text' => $validated['text'],
            ]);

            $driver->update(['ride_status' => "available"]);
            $rider->update(['ride_status' => "available"]);

            if ($user->role === 'rider') {
                $token = $driver->push_token;
                Notification::send($rider, new AppNotify("Request cancelled", "Ride canceled by the rider.", $token, ['type' => "cancelled", 'data' => null]));
            }
            if ($user->role === 'driver') {
                $token = $rider->push_token;
                Notification::send($driver, new AppNotify("Ride cancelled", "Ride canceled by the driver.", $token, ['type' => "cancelled", 'data' => null]));
            }

            return response()->json(['message' => 'success']);
        }

        $user->update(['ride_status' => "available"]);
        return response()->json(['message' => 'there is no ride in our recoords.'], 400);
    }


    function generateBookingNR()
    {
        $orderObj = Booking::select('booking_nr')->latest('id')->first();
        if ($orderObj) {
            $orderNr = $orderObj->booking_nr;
            $removed1char = substr($orderNr, 1);
            $generateBooking_nr = $stpad = '#' . str_pad($removed1char + 1, 6, "0", STR_PAD_LEFT);
        } else {
            $generateBooking_nr = '#' . str_pad(1, 6, "0", STR_PAD_LEFT);
        }
        return $generateBooking_nr;
    }
}
