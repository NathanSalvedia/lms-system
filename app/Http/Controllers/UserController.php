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
            // Validate the incoming request data
            $validatedData = $request->validate([
                'usertype' => 'required|string',
                'unique_id' => 'required|string',
                'fullname' => 'required|string',
                'course' => 'required|string',
                'department' => 'required|string',
                'total_fines' => 'nullable|integer',
                'email' => 'required|string|email|unique:users,email', // Ensure email is unique
                'password' => ['required', 'confirmed'],
            ]);

            try {

            // Create the new user in the database
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

            // Return a success response
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

    /**
     * Get a single item by ID.
     * GET /api/resource/{id}
     */
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
            'email' => 'required|string|email|unique:users,email', // Ensure email is unique
            'password' => 'required|string|min:8', // Ensure password meets the requirements

        ]);

        $item = User::create($validatedData);
        return response()->json(['message' => 'Item created successfully', 'item' => $item], 201);
    }

    /**
     * Update an existing item by ID.
     * PUT /api/resource/{id}
     */
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
            'email' => 'required|string|email|unique:users,email', // Ensure email is unique
            'password' => 'required|string|min:8', // Ensure password meets the requirements
            // Add your validations here
        ]);

        $item->update($validatedData);

        return response()->json(['message' => 'Item updated successfully', 'item' => $item], 200);
    }

    /**
     * Delete an item by ID.
     * DELETE /api/resource/{id}
     */
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
