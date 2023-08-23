<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TripController extends Controller
{
    public function create(Request $request)
    {
        $request->validate([
            'origin' => 'required',
            'destination' => 'required',
            'destination_name' => 'required'
        ]);
        $trip = Auth::user()->trips()->create($request->only([
            'origin',
            'destination',
            'destination_name'
        ]));
        return $trip;
    }

    public function show(Request $request, Trip $trip)
    {
        if ($trip->user->id == Auth::user()->id) {
            return $trip;
        }
        if ($trip->driver && $request->user()->driver) {
            if ($trip->driver->id == $request->user()->driver->id) {
                return $trip;
            }
        }
        return response()->json(['message' => 'Trip not found'], 404);
    }

    public function accept(Request $request, Trip $trip)
    {
        $request->validate([
            'driver_location' => 'required'
        ]);
        $trip->update([
            'driver_id' => $request->user()->id,
            'driver_location' => $request->driver_location
        ]);
        return $trip;
    }

    public function start(Request $request, Trip $trip)
    {
        $trip->update([
            'is_started' => 'true'
        ]);
        return $trip->load('driver.user');
    }

    public function end(Request $request, Trip $trip)
    {
        $trip->update([
            'is_complete' => 'true'
        ]);
        return $trip->load('driver.user');
    }

    public function location(Request $request, Trip $trip)
    {
        $request->validate([
            'driver_location' => 'required'
        ]);
        $trip->update([
            'driver_location' => $request->driver_location
        ]);
        $trip->load('driver.user');
        return $trip;
    }
}
