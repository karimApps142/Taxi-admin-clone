<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class NotificaionController extends Controller
{
    function index()
    {
        return Inertia::render('Notifications');
    }
}
