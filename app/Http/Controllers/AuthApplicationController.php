<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Application;

use Illuminate\Support\Facades\Auth;

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

        if (!$token = Auth::guard('client_applications')->attempt($credentials)) {
            return response()->json(['error' => 'Application Unauthorized'], 401);
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
        Auth::guard('client_applications')->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(Auth::guard('client_applications')->refresh());
    }

}
