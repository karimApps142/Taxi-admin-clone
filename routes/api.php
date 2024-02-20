<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BookingController;
use App\Http\Controllers\Api\LocationController;
use App\Http\Controllers\Api\PackageController;
use App\Http\Controllers\Api\UserController;
use App\Notifications\AppNotify;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/



Route::group([
    'prefix' => 'auth'
], function () {
    Route::post('signin', [AuthController::class, 'signin']);
    Route::post('driver_signin', [AuthController::class, 'driverSignin']);
    Route::post('signup', [AuthController::class, 'signup']);
    Route::post('apple_login', [AuthController::class, 'appleLogin']);
    Route::post('driver_signup', [AuthController::class, 'driverSignup']);
    Route::post('signup_validations', [AuthController::class, 'signupValidations']);
    Route::post('reset_password', [AuthController::class, 'resetPassword']);
    Route::post('signout', [AuthController::class, 'signout']);
    Route::post('me', [AuthController::class, 'user']);
    Route::post('update/push_token', [AuthController::class, 'updatePushToken']);
    Route::post('switch_user', [AuthController::class, 'switchUser']);
    Route::post('login_with_social_account/{provider}', [AuthController::class, 'loginWithSocialAccount']);
});

Route::group([
    'prefix' => 'v1',
    'middleware' => 'auth:sanctum',
], function () {
    Route::get('get_vehicles', [BookingController::class, 'getVehicles']);
    Route::post('create_booking', [BookingController::class, 'createBooking']);
    Route::get('get_user_booking_details', [BookingController::class, 'getUserBookingDetails']);
    Route::post('change_booking_status/{booking}', [BookingController::class, 'changeBookingStatus']);
    Route::post('update_location', [UserController::class, 'updateLocation']);
    Route::post('on_accept/{booking}', [BookingController::class, 'onAccept']);
    Route::post('booking_rating/{booking}', [UserController::class, 'bookingRating']);
    Route::post('complete_profile', [UserController::class, 'completeProfile']);
    Route::get('get_profile_picker_data', [UserController::class, 'getProfilePickerData']);
    Route::get('get_bookings', [UserController::class, 'getBookings']);
    Route::post('switch_user_online_status', [UserController::class, 'switchUserOnlineStatus']);
    Route::get('get_driver_requests', [UserController::class, 'getDriverRequests']);
    Route::post('cancel_search', [BookingController::class, 'cancelSearch']);
    Route::post('order_rejection/{booking}', [BookingController::class, 'orderRejection']);
    Route::post('update_profile', [UserController::class, 'updateProfile']);
    Route::post('store_location', [LocationController::class, 'store']);
    Route::get('get_locations', [LocationController::class, 'index']);
    Route::get('get_packages', [PackageController::class, 'index']);
    Route::get('my_packages', [PackageController::class, 'myPackages']);
    Route::post('get_client_secret', [PackageController::class, 'getClientSecret']);
    Route::post('purchase_package/{package}', [PackageController::class, 'store']);

    Route::post('test', function () {
        $user = request()->user();

        dd($user->hasPushToken());
        // Notification::send($user, new AppNotify("Testr", "Test description", $token));
        return Notification::send($user, new AppNotify("New Request", "You just received new booking request.", $user->push_token));
    });
});

// public apis 
Route::get('get_stripe_key', [PackageController::class, 'getStripeKey']);
