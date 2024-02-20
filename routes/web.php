<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DriversController;
use App\Http\Controllers\RidersController;
use App\Http\Controllers\VehiclesController;
use App\Http\Controllers\BookingsController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\PackageController;

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;




Route::middleware('guest')->group(function () {
    Route::get('/', function () {
        return Inertia::render('Auth/Login', [
            'canResetPassword' => Route::has('password.request'),
            'status' => session('status'),
        ]);
    });
});

Route::middleware(['auth', 'verified'])->group(function () {

    //dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    //drivers
    Route::get('/drivers', [DriversController::class, 'index'])->name('drivers');
    Route::get('/driver', [DriversController::class, 'show'])->name('drivers.profile');
    Route::post('/driver/store', [DriversController::class, 'store'])->name('drivers.store');
    Route::put('/driver/update/{driver}', [DriversController::class, 'update'])->name('drivers.update');
    Route::put('/driver/{id}', [DriversController::class, 'verifyProfile'])->name('user.profileStatus');
    Route::put('/driver-status/{user}', [DriversController::class, 'onStatusChange'])->name('drivers.status.change');
    Route::delete('/driver-delete/{id}', [DriversController::class, 'destroy'])->name('drivers.delete');


    //riders
    Route::get('/riders', [RidersController::class, 'index'])->name('riders');
    Route::get('/rider', [RidersController::class, 'show'])->name('rider.profile');
    Route::post('/rider/store', [RidersController::class, 'store'])->name('riders.store');
    Route::put('/rider/update/{rider}', [RidersController::class, 'update'])->name('riders.update');
    Route::put('/rider-status/{user}', [RidersController::class, 'onStatusChange'])->name('rider.status.change');
    Route::delete('/rider-delete/{id}', [RidersController::class, 'destroy'])->name('rider.delete');
    // countries
    Route::get('/countries', [CountryController::class, 'index'])->name('countries');
    Route::post('/add-country', [CountryController::class, 'store'])->name('countries.store');
    Route::post('/update-country/{id}', [CountryController::class, 'update'])->name('countries.update');
    Route::delete('/delete-country/{id}', [CountryController::class, 'distroy'])->name('countries.delete');
    //cities
    Route::get('/{country}/cities', [CityController::class, 'index'])->name('cities');
    Route::post('/add/city/{id}', [CityController::class, 'store'])->name('cities.store');
    Route::post('/edit/city/{id}', [CityController::class, 'update'])->name('cities.update');
    Route::delete('/edit/city/{id}', [CityController::class, 'destroy'])->name('cities.delete');
    // packages
    Route::get('/packages', [PackageController::class, 'index'])->name('packages');
    Route::post('/add/packages', [PackageController::class, 'store'])->name('packages.store');
    Route::post('/update/packages/{id}', [PackageController::class, 'update'])->name('packages.update');
    Route::put('/status/packages/{package}', [PackageController::class, 'changeStatus'])->name('packages.status');
    Route::delete('/delete/packages/{id}', [PackageController::class, 'destroy'])->name('packages.delete');

    //vehicles
    Route::get('/{city}/vehicles', [VehiclesController::class, 'index'])->name('vehicles');
    Route::post('/addvehicle/{id}', [VehiclesController::class, 'store'])->name('vehicles.store');
    Route::post('/updatevehicle/{id}', [VehiclesController::class, 'update'])->name('vehicles.update');
    Route::put('/vehicle_status/{vehicle}', [VehiclesController::class, 'changeStatus'])->name('vehicles.status');
    Route::delete('/deletevehicle/{id}', [VehiclesController::class, 'distroy'])->name('vehicles.delete');

    //bookings
    Route::get('/bookings', [BookingsController::class, 'index'])->name('bookings');
    Route::get('/{id}/bookingdetail', [BookingsController::class, 'show'])->name('booking.detail');

    // Route::get('/feedbacks', [FeedbackController::class, 'index'])->name('feedbacks');
    // Route::get('/notifications', [NotificaionController::class, 'index'])->name('notifications');
    // Route::get('/reports', [ReportController::class, 'index'])->name('reports');
});


require __DIR__ . '/auth.php';
