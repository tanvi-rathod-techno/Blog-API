<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

use Illuminate\Http\Request;

class AuthController extends BaseController
{
    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users',
            'password' => 'required|string|min:6',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return $this->sendResponse($user, 'User registered successfully', true, 201);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (!Auth::attempt($credentials)) {
            return $this->sendError([], 'Invalid credentials', false, 401);
        }

        $user  = Auth::user();
        $token = $user->createToken('authToken')->accessToken;

        return $this->sendResponse([
            'user'  => $user,
            'token' => $token,
        ], 'Login successful');
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return $this->sendResponse(null, 'Logged out successfully');
    }

    public function viewProfile(Request $request)
    {
        $user = auth()->user();
        if (!$user) {
            return $this->sendError([], 'User not found', false, 404);
        }
        return $this->sendResponse($user, 'Profile retrieved successfully');
    }

}
