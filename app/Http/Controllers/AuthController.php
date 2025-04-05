<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Handle user login and return auth token.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required'
        ]);

        if (!Auth::attempt($credentials)) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        /** @var \App\Models\User $user */
        $user = Auth::user();
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'token' => $token
        ]);
    }

    /**
     * Handle user registration and return auth token.
     */
    public function register(Request $request)
    {
        $request->validate([
            'name'                  => 'required|string',
            'email'                 => 'required|email|unique:users',
            'password'              => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'user'  => $user,
            'token' => $token
        ]);
    }

    /**
     * Test authorization via a gate.
     */
    public function testGate()
    {
        /** @var \App\Models\User|null $user */
        $user = Auth::user();

        $allowed = Gate::allows('update-post'); // Replace with your gate name

        return response()->json([
            'user_id'         => $user?->id,
            'can_update_post' => $allowed
        ]);
    }

    public function logout(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        // Revoke the user's current token
        $user->tokens->each(function ($token) {
            $token->delete();
        });

        return response()->json(['message' => 'Successfully logged out']);
    }
}
