<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DriverController extends Controller
{
    public function show()
    {
        return Auth::user()->load('driver');
    }

    public function create(Request $request)
    {
        $request->validate([
            'model' => 'required|string|max:25',
            'license_plate' => 'required|numeric|max:9999'
        ]);
        $user = $request->user();
        $user->driver()->updateOrCreate($request->only([
            'model',
            'license_plate'
        ]));
        $user->load('driver');
        return $user;
    }
}
