<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\Auth as Authentication;
use App\Http\Requests\User\Create;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'registration']]);
    }

    public function login(Authentication $request)
    {
        $credentials = $request->only('email', 'password');
        try {
            if ($token = $this->guard()->attempt($credentials)) {
                return $this->respondWithToken($token);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Auth failed.'
                ], 401);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function registration(Create $request, User $user)
    {
        try {
            if ($data = $user->registration($request)) {
                return response()->json($data, 200);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Auth failed.'
                ], 401);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function logout()
    {
        $this->guard()->logout();
        return response()->json(['message' => 'Successfully logged out']);
    }

    public function refresh()
    {
        return $this->respondWithToken($this->guard()->refresh());
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expires_in' => $this->guard()->factory()->getTTL() * 60,
            'user' => [
                'name' => $this->guard()->user()
            ]
        ]);
    }

    public function guard()
    {
        return Auth::guard('api');
    }
}
