<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;

class AuthController extends Controller
{
    public function register(Request $request, User $user): JsonResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = auth()->login($user);

        return $this->respondWithToken($token);
    }

    public function login(Request $request): JsonResponse
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $credentials = $request->only(['email', 'password']);
        $key = 'login-attempts:' . $request->ip();

        if (RateLimiter::tooManyAttempts($key, 5)) {
            return response()->json(['error' => 'Too many login attempts. Please try again later.'], 429);
        }

        if (!$token = auth()->attempt($credentials)) {
            RateLimiter::hit($key, 60);
            return response()->json(['error' => 'Invalid credentials'], 401);
        }

        RateLimiter::clear($key);
        return $this->respondWithToken($token);
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
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => $user,
            'links' => [
                'self' => route('me'),
                'logout' => route('logout'),
                'refresh' => route('refresh')
            ]
        ]);
    }
}
