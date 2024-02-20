<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class LocationController extends Controller
{
    function index()
    {
        $locations = request()->user()->locations()->latest()->get();
        return response()->json($locations);
    }

    function store()
    {
        $validated = request()->validate([
            'lat' => "required",
            'lng' => "required",
            'address' => "required",
            'place_id' => "",
            'region' => "",
        ]);

        $user = request()->user();
        $location = $user->locations()->create($validated);
        return response()->json($location);
    }
}
