<?php

namespace App\Http\Controllers;

use App\Models\User;

class AuthController extends Controller
{
    public function register()
    {
        $attr = $this->validate(request(), [
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed',
        ]);
        try {
            $password_confirmation = request('password_confirmation');
            $attr['password'] = app('hash')->make($password_confirmation);
            $user = User::create($attr);
            return response()->json([
                'success' => true,
                'message' => 'User Created Successfully!',
                'data'    => $user
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'User Registration Failed!'
            ], 409);
        }
    }

    public function login()
    {
        $credentials = request(['email', 'password']);
        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        return $this->respondWithToken($token);
    }

    public function me()
    {
        try{
            return response()->json([auth()->user()], 200);
        } catch (\Exception $e)
        {
            return response()->json([
                'success' => false,
                'message' => 'You must login first!'
            ], 401);
        }
    }

    public function logout()
    {
        auth()->logout();
        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}
