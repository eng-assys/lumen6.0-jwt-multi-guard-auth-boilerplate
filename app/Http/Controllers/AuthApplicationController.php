<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Application;

use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;

class AuthApplicationController extends Controller
{
    /**
     * Store a new application.
     *
     * @param  Request  $request
     * @return Response
     */
    public function register(Request $request)
    {
        //validate incoming request
        $this->validate($request, [
            'name' => 'required|string',
            'client_id' => 'required|unique:applications',
            'client_secret' => 'required|confirmed',
        ]);

        try {

            $application = new Application;
            $application->name = $request->input('name');
            $application->client_id = $request->input('client_id');
            $application->client_secret = app('hash')->make($request->input('client_secret'));
            $application->save();

            //return successful response
            return response()->json(['application' => $application, 'message' => 'CREATED'], 201);
        } catch (\Exception $e) {
            //return error message
            return response()->json(['message' => 'Application Registration Failed!'], 409);
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
            'client_id' => 'required|string',
            'client_secret' => 'required|string',
        ]);

        $credentials = [
            'client_id' => $request->input('client_id'),
            'password' => $request->input('client_secret')
        ];

        if (!$token = Auth::guard('client_application')->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * Log the application out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        try {
            Auth::guard('client_application')->logout();
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
            return $this->respondWithToken(Auth::guard('client_application')->refresh());
        } catch (TokenExpiredException $e) {
            return response()->json(['error' => 'Token has expired and can no longer be refreshed'], 401);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Token refresh failed!'], 400);
        }
    }
}
