<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class FeedbackController extends Controller
{
    function index()
    {
        return Inertia::render('Feedbacks');
    }
}
