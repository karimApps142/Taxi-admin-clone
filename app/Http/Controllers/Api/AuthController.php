<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    function __construct()
    {
        $this->middleware('auth:sanctum', [
            'except' => [
                'signin',
                'driverSignin',
                'driverSignup',
                'appleLogin',
                'signup',
                'signupValidations',
                'loginWithSocialAccount',
                'resetPassword'
            ]
        ]);
    }

    function signup()
    {
        $validated = request()->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:6',
            'phone' => 'required|unique:users'
        ]);

        $validated['is_phone_verified'] = 1;
        $validated['profile_status'] = 'complete';
        $validated['password'] = Hash::make(request()->password);

        $user = User::create($validated);

        if (request()->token) {
            $user->update(['push_token' => request()->token]);
        }

        return response()->json([
            'access_token' => $user->createToken('token')->plainTextToken,
            'token_type' => 'bearer',
            'user' => $this->me($user->id),
        ]);
    }

    function driverSignup()
    {
        $validated = request()->validate([
            'name' => 'required|string',
            'preferred_name' => '',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:6',
            'phone' => 'required|unique:users'
        ]);

        $validated['is_phone_verified'] = 1;
        $validated['role'] = 'driver';
        $validated['free_rides'] = 25;
        $validated['password'] = Hash::make(request()->password);

        $user = User::create($validated);

        if (request()->token) {
            $user->update(['push_token' => request()->token]);
        }

        return response()->json([
            'access_token' => $user->createToken('token')->plainTextToken,
            'token_type' => 'bearer',
            'user' => $this->me($user->id),
        ]);
    }

    function signupValidations()
    {
        request()->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:6',
            'phone' => 'required|unique:users'
        ]);
        return response()->json(null, 200);
    }

    function appleLogin()
    {
        request()->validate(['identityToken' => "required"]);
        $identityToken = request()->identityToken;
        $user = null;

        $user = User::where('identityToken', $identityToken)->first();

        if (!$user && request()->email)
            $user = User::where('email', request()->email)->first();

        if (!$user) {
            request()->validate([
                'email' => 'required|email|unique:users',
            ]);
            $name = request()->name ? request()->name : "New Rider";
            $email = request()->email;
            $user = User::create([
                'identityToken' => $identityToken,
                'email' => $email,
                'name' => $name,
                'password' => Hash::make(Str::random(10)),
                'provider' => 'apple',
            ]);
        }

        if (request()->token) {
            $user->push_token = request()->token;
            $user->save();
        }

        return response()->json([
            'access_token' => $user->createToken('token')->plainTextToken,
            'token_type' => 'bearer',
            'user' => $this->me($user->id),
        ]);
    }


    function signin()
    {

        $validated = request()->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);



        $user = User::where('email', $validated['email'])->first();

        if (!$user || !Hash::check($validated['password'], $user->password)) {
            return response()->json(['message' => 'These credentials do not match our records'], 400);
        }

        if ($user->role !== 'rider') {
            return response()->json(['message' => 'Account is not valid.'], 400);
        }

        if ($user->status === 'blocked') {
            return response()->json(['message' => 'Account is blocked.'], 400);
        }

        if (!$user->is_phone_verified) {
            return response()->json(['message' => 'Phone number is not verified.'], 400);
        }

        if (request()->token) {
            $user->update(['push_token' => request()->token]);
        }

        $user->tokens()->delete();

        return response()->json([
            'access_token' => $user->createToken('token')->plainTextToken,
            'token_type' => 'bearer',
            'user' => $this->me($user->id),
        ]);
    }

    function driverSignin()
    {
        $validated = request()->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $validated['email'])->first();

        if (!$user || !Hash::check($validated['password'], $user->password)) {
            return response()->json(['message' => 'These credentials do not match our records'], 400);
        }

        if ($user->role !== 'driver') {
            return response()->json(['message' => 'Account is not valid.'], 400);
        }

        if ($user->status === 'blocked') {
            return response()->json(['message' => 'Account is blocked.'], 400);
        }

        if (!$user->is_phone_verified) {
            return response()->json(['message' => 'Phone number is not verified.'], 400);
        }

        if (request()->token) {
            $user->update(['push_token' => request()->token]);
        }

        return response()->json([
            'access_token' => $user->createToken('token')->plainTextToken,
            'token_type' => 'bearer',
            'user' => $this->me($user->id),
        ]);
    }

    function resetPassword()
    {
        $validated = request()->validate([
            'phone' => "required",
            'password' => 'required|confirmed|min:6',
        ]);

        $user = User::where('phone', $validated['phone'])->first();

        if ($user) {
            $user->update(['password' => Hash::make($validated['password'])]);
            return response()->json(['message' => "success"]);
        } else {
            return response()->json(['message' => "this phone number is not found in our system"], 400);
        }
    }


    function switchUser()
    {
        $user = User::find(auth()->user()->id);
        $user->update([
            'role' => $user->role === 'rider' ? 'driver' : 'rider'
        ]);
        return response()->json($this->me($user->id));
    }


    function loginWithSocialAccount($provider)
    {
        $this->baseValidation([
            'name' => 'required',
            'email' => 'required|email',
        ]);

        $email = request()->email;

        $user = User::firstOrCreate([
            'email' => $email,
        ], [
            'name' => request()->name,
            'password' => Hash::make(Str::random(10)),
            'provider' => $provider,
        ]);

        if (request()->token) {
            $user->push_token = request()->token;
        }

        if (request()->photo) {
            $user->avatar = request()->photo;
        }

        $user->role = 'rider';
        $user->save();

        return response()->json([
            'access_token' => $user->createToken('token')->plainTextToken,
            'token_type' => 'bearer',
            'user' => $this->me($user->id),
        ]);
    }


    function user()
    {
        $user = auth()->user();
        return response()->json($this->me($user->id));
    }

    function updatePushToken()
    {
        $user = User::find(auth()->user()->id);
        if (request()->token) {
            $user->push_token = request()->token;
            $user->save();
            return response()->json(['message' => 'success']);
        }
        return response()->json(null, 400);
    }

    function signout()
    {
        $user = User::find(auth()->user()->id);
        if ($user->currentAccessToken())
            $user->currentAccessToken()->delete();
        User::where('id', $user->id)->update(['push_token' => null, 'active_status' => 'offline']);
        return response()->json(['message' => 'Successfully logged out']);
    }
}