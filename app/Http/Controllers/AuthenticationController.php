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
        $request->validate([
            'unique_id' => 'required|string',
            'password' => 'required',
        ]);
        $user = User::where("unique_id", $request->unique_id)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Invalid login credentials.'], 401);
        }
        $token = $user->createToken($user->fullname);
            return response()->json([
                'message' => 'Login successful',
                'user' => [
                    'id' => $user->id,
                    'unique_id' => $user->unique_id,
                    'usertype' => $user->usertype,
                ],
                'token' => $token->plainTextToken,
            ], 200);
    }


    public function logout(Request $request)
    {
        Auth::logout();

        return response()->json([
            'message' => 'Logout successful',
        ], 200);
    }

}
