<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;

class AuthController extends Controller
{
    public function register(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $newUser = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = $newUser->createToken($request->email, ['server:update'])->plainTextToken;

        return $this->respondWithToken($token, $newUser);
    }

    public function login(Request $request): JsonResponse
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (RateLimiter::tooManyAttempts($request->ip(), 5)) {
            return response()->json([
                'message' => __('auth.throttle', ['seconds' => 60])
            ], 429);
        }

        if (!auth()->attempt($request->only('email', 'password'))) {
            RateLimiter::hit($request->ip());
            return response()->json([
                'message' => __('auth.failed')
            ], 401);
        }

        RateLimiter::clear($request->ip());

        $token = auth()->user()->createToken($request->email, ['server:update'])->plainTextToken;
        return $this->respondWithToken($token, auth()->user());
    }

    public function me(): JsonResponse
    {
        $user = auth()->user();
        return response()->json([
            'user' => $user,
            'links' => [
                'self' => route('me'),
                'logout' => route('logout'),
                'refresh' => route('refresh')
            ]
        ]);
    }

    public function logout(): JsonResponse
    {
        auth()->logout();

        return response()->json([
            'message' => 'Successfully logged out',
            'links' => [
                'login' => route('login')
            ]
        ]);
    }

    public function refresh(): JsonResponse
    {
        $token = auth()->refresh();
        return $this->respondWithToken($token, auth()->user());
    }

    protected function respondWithToken($token, $user): JsonResponse
    {
        return response()->json([
            'access_token' => $token,
            'user' => $user,
            'token_type' => 'bearer',
            'expires_in' => config('sanctum.expiration') * 60, // ajuste conforme necessário
        ]);
    }

}
