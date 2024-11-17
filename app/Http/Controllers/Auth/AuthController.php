<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Http\Resources\Auth\RegisterResource;
use App\Http\Resources\Auth\LoginResource;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = $user->createToken('AuthToken')->accessToken;
        return new RegisterResource($token, $user);
    }

    public function login(LoginRequest $request)
    {
        if (!auth()->attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => 'Invalid credentials'
            ], 401);
        }

        $user = $request->user();
        $token = $user->createToken('AuthToken')->accessToken;
        return new LoginResource($token, $user);
    }

    public function logout(Request $request)
    {
        try {
            if (!$request->user()) {
                return response()->json([
                    'message' => 'Already logged out',
                    'status' => 'success'
                ], 200);
            }

            $token = $request->user()->token();
            if ($token) {
                $token->revoke();
            }

            if (session()->has('auth')) {
                session()->forget('auth');
            }

            return response()->json([
                'message' => 'Successfully logged out',
                'status' => 'success'
            ], 200);

        } catch (\Exception $e) {
            \Log::error('Logout error: ' . $e->getMessage());
            
            return response()->json([
                'message' => 'Already logged out',
                'status' => 'success'
            ], 200);
        }
    }

    public function user(Request $request)
    {
        return response()->json($request->user());
    }
} 