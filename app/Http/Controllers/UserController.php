<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function register(Request $request)
    {

            $validatedData = $request->validate([
                'usertype' => 'required|string',
                'unique_id' => 'required|string',
                'fullname' => 'required|string',
                'course' => 'required|string',
                'department' => 'required|string',
                'total_fines' => 'nullable|integer',
                'email' => 'required|string|email|unique:users,email',
                'password' => ['required', 'confirmed'],
            ]);

            try {


            $user = User::create([
                'usertype' => $validatedData['usertype'],
                'unique_id' => $validatedData['unique_id'],
                'fullname' => $validatedData['fullname'],
                'course' => $validatedData['course'],
                'department' => $validatedData['department'],
                'total_fines' => $validatedData['total_fines'],
                'email' => $validatedData['email'],
                'password' => Hash::make($validatedData['password']),
            ]);


            return response()->json(['message' => 'User created successfully', 'user' => $user], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Registration failed', 'message' => $e->getMessage()], status: 500);
        }
    }

    public function index()
    {
        $items = User::all();
        return response()->json($items, 200);
    }


    public function show($id)
    {
        $item = User::find($id);

        if (!$item) {
            return response()->json(['error' => 'Item not found'], 404);
        }

        return response()->json($item, 200);
    }

    /**
     * Create a new item.
     * POST /api/resource
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'usertype' => 'nullable|string',
            'unique_id' => 'required|string',
            'fullname' => 'required|string',
            'course' => 'required|string',
            'department' => 'required|string',
            'total_fines' => 'nullable|integer',
            'email' => 'required|string|email|unique:users,email',
            'password' => 'required|string|min:8',
        ]);

        $item = User::create($validatedData);
        return response()->json(['message' => 'Item created successfully', 'item' => $item], 201);
    }


    public function update(Request $request, $id)
    {
        $item = User::find($id);

        if (!$item) {
            return response()->json(['error' => 'Item not found'], 404);
        }

        $validatedData = $request->validate([
            'usertype' => 'nullable|string',
            'unique_id' => 'required|string',
            'fullname' => 'required|string',
            'course' => 'required|string',
            'department' => 'required|string',
            'total_fines' => 'nullable|integer',
            'email' => 'required|string|email|unique:users,email',
            'password' => 'required|string|min:8',

        ]);

        $item->update($validatedData);

        return response()->json(['message' => 'Item updated successfully', 'item' => $item], 200);
    }


    public function destroy($id)
    {
        $item = User::find($id);

        if (!$item) {
            return response()->json(['error' => 'Item not found'], 404);
        }

        $item->delete();

        return response()->json(['message' => 'Item deleted successfully'], 200);
    }



}
