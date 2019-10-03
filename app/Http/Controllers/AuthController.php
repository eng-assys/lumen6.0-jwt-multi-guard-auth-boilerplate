<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Business\User;

use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class AuthController extends Controller
{
    /**
     * Store a new user.
     *
     * @param  Request  $request
     * @return Response
     */
    public function register(Request $request)
    {
        //validate incoming request
        $this->validate($request, [
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed',
        ]);

        try {
            $user = User::register($request->input('name'), $request->input('email'), $request->input('password'));
            return response()->json(['user' => $user], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'User Registration Failed!'], 400);
        }
    }

    /**
     * Get a JWT via given credentials.
     *
     * @param  Request  $request
     * @return Response
     */
    public function login(Request $request)
    {
        //validate incoming request
        $this->validate($request, [
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        if (!$token = User::login($request->input('email'), $request->input('password'))) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        try {
            Auth::guard('api')->logout();
            return response()->json(['message' => 'Successfully logged out']);
        } catch (TokenExpiredException $e) {
            return response()->json(['message' => 'Token has already been invalidated']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'User Logout Failed!'], 400);
        }
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        try {
            return $this->respondWithToken(Auth::guard('api')->refresh());
        } catch (TokenExpiredException $e) {
            return response()->json(['error' => 'Token has expired and can no longer be refreshed'], 401);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Token refresh failed!'], 400);
        }
    }
}
