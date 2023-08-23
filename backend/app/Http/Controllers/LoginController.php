<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Notifications\LoginVerification;
use GuzzleHttp\Psr7\Message;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'name' => 'string|max:25',
            'phone' => 'required|numeric|min:10'
        ]);

        $user = User::firstOrCreate([
            'name' => $request->name,
            'phone' => $request->phone
        ]);

        if (!$user) {
            return response()->json(['message' => 'User not Found'], 404);
        }

        $user->notify(new LoginVerification());

        return response()->json(['message' => 'Notification Sent']);
    }

    public function verifyLogin(Request $request)
    {
        $request->validate([
            'phone' => 'required|numeric|min:10',
            'login_code' => 'required|numeric|between:11111,99999'
        ]);

        $user = User::where(['phone' => $request->phone, 'login_code' => $request->login_code])->first();

        if (!$user) {
            return response()->json(['message' => 'Bad Request'], 400);
        }

        $user->update([
            'login_code' => null
        ]);

        return $user->createToken($request->login_code)->plainTextToken;
    }
}
