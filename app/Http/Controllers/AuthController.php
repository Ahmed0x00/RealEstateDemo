<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;


class AuthController extends Controller
{
    // Handle registration logic with JSON response
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|confirmed',
            'balance' => 'required|numeric|min:0',
        ]);

        // Check if an owner already exists
        $existingOwner = User::where('role', 'owner')->first();
        if ($existingOwner) {
            return response()->json([
                'message' => 'An owner already exists. Only one owner is allowed.'
            ], 409); // 409 Conflict
        }

        // Create the user with the 'owner' role and balance
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'owner', // Assign the owner role
            'balance' => $request->balance, // Save the balance
        ]);

        return response()->json([
            'message' => 'Registration successful',
            'user' => $user
        ], 201); // 201 Created
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        // Check credentials
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => 'The provided credentials do not match our records.'
            ], 401); // 401 Unauthorized
        }

        $user = Auth::user();

        return response()->json([
            'message' => 'Login successful',
            'user' => $user
        ]); 
    } 

    public function logout(Request $request)
    {
        Auth::logout();
        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|string',
            'new_password' => 'required|string|confirmed',
        ]);

        $user = Auth::user();

        // Check if the current password matches
        if (!Hash::check($request->current_password, $user->password)) {
            throw ValidationException::withMessages([
                'current_password' => ['The provided password does not match your current password.'],
            ]);
        }

        // Update the user's password
        $user->password = Hash::make($request->new_password);
        $user->save();

        return response()->json([
            'message' => 'Password changed successfully'
        ]);
    }

    public function getUserData()
{
    $user = Auth::user();

    return response()->json([
        'user' => $user->makeHidden('password')
    ]);
}

    
}
