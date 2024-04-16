<?php

namespace App\Http\Controllers\AuthController;

use App\Http\Resources\UserRegistrationResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController
{
    public function register(Request $request): JsonResponse
    {
        try {
            $input = $request->validate([
                'name' => 'required|max:255',
                'email' => 'required|email|unique:users',
                'password' => 'required|confirmed'
            ]);

            $input['password'] = bcrypt($input['password']);
            $user = User::create($input);

            $accessToken = $user->createToken('API Token')->accessToken;

            return response()->json([
                'data' => [
                    'user' => new UserRegistrationResource($user),
                    'token' => $accessToken
                ],
            ]);
        } catch (ValidationException $e) {
            return response()->json(['error' => $e->validator->errors()], 422);
        }
    }

    public function login(Request $request): JsonResponse
    {
        try {
            $data = $request->validate([
                'email' => 'email|required',
                'password' => 'required'
            ]);

            if (Auth::attempt($data)) {
                $user = Auth::user();
                $accessToken = $user->createToken('MyApp')->accessToken;

                return response()->json([
                    'data' => [
                        'user' => $user,
                        'token' => $accessToken
                    ]
                ]);
            } else {
                return response()->json(['error' => 'Invalid credentials.'], 401);
            }
        } catch (ValidationException $e) {
            return response()->json(['error' => $e->validator->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Something went wrong.'], 500);
        }
    }

    public function logout(Request $request): JsonResponse
    {
        try {
            $request->user()->token()->revoke();
            return response()->json(['message' => 'Successfully logged out']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Something went wrong.'], 500);
        }
    }
}

