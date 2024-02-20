<?php

namespace App\Http\Controllers\Api;

use Stripe\Charge;
use Stripe\Stripe;
use App\Models\User;
use Stripe\Customer;
use App\Models\Package;
use Stripe\StripeClient;
use Stripe\PaymentIntent;
use App\Models\UserPackage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PackageController extends Controller
{

    function getStripeKey()
    {
        function getStripeKey()
        {
            $public_key = 'pk_test_51IFJTICfYezmg1ybpX4DBy0iTHEIoEVD4BKG2JRa1pGnzhjil08CiRkVsOA8uHAuM39Bb2RMER4NXFDWjpuIenlb00Em85xR7A';
            // $public_key = 'pk_live_51IFJTICfYezmg1ybUJ95JfcZ9ghk0H73vMi3YiFFPRFYS5xU1xG8lbf1DuHcivfUXKvaOjNzuEv2nufwEVOcKTMk00bPf9afHb';
            return response()->json($public_key);
        }
    }

    function getClientSecret()
    {
        request()->validate([
            'amount' => 'required',
        ]);
        $stripe = new StripeClient(env('STRIPE_SECRET'));
        $intent = $stripe->paymentIntents->create([
            'amount' => request()->amount * 100,
            'currency' => 'gbp',
        ]);
        $client_secret = $intent->client_secret;
        return response()->json($client_secret);
    }

    function index()
    {
        $user = auth()->user();

        if ($user->profile_status !== 'complete') {
            return response()->json(['message' => 'Complete your profile!'], 400);
        }

        $packages = Package::where([
            'status' => 'active',
            'city_id' => $user->city_id,
        ])->get();

        return response()->json($packages);
    }


    function store(Package $package)
    {
        $user = User::find(request()->user()->id);
        if ($user->profile_status !== 'complete')
            return response()
                ->json(['message' => "Complete your profile!"], 400);
        $data = [
            'package_id' => $package->id,
            'title' => $package->title,
            'rides' => $package->rides,
            'price' => $package->price,
        ];
        $userPackage = $user->packages()->create($data);
        $user->free_rides = $user->free_rides + $data['rides'];
        $user->save();
        return response()->json($userPackage);
    }

    function myPackages()
    {
        $user = User::find(request()->user()->id);
        $myPackages = UserPackage::where([
            'user_id' => $user->id,
            'status' => 'active'
        ])->get();
        return response()->json($myPackages);
    }
}