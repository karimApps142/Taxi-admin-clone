<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class UserController extends Controller
{
    function index()
    {
        return Inertia::render('Users');
    }

    function show($slug)
    {
        return Inertia::render('UserProfile');
    }
}
