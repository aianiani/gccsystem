<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CounselorAvailabilityController extends Controller
{
    // Show the availability schedule page
    public function index()
    {
        return view('counselor.availability.index');
    }
} 