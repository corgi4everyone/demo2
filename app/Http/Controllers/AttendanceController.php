<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    //
    public function checkIn(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'check_in_at' => 'required',
            'date' => 'required',

        ]);
    }
}
