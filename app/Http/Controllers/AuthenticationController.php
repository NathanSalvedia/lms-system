<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthenticationController extends Controller
{
    public function login(Request $request)
    {
        $validatedData = $request->validate([
            'unique_id' => 'required|string',
            'password' => 'required|string',
        ]);

        if (Auth::attempt([
            'unique_id' => $validatedData['unique_id'], 'password' => $validatedData['password'],
        ])) {
            $user = Auth::user();

            return response()->json([
                'message' => 'Login successful',
                'user' => [
                    'id' => $user->id,
                    'unique_id' => $user->unique_id,
                    'usertype' => $user->usertype,
                ],
            ], 200);
        }

        return response()->json(['message' => 'Invalid login credentials.'], 401);
    }


    public function logout(Request $request)
    {
        Auth::logout();

        return response()->json([
            'message' => 'Logout successful',
        ], 200);
    }

}
