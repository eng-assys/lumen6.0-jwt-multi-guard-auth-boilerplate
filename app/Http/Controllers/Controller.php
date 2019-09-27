<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

use Illuminate\Support\Facades\Auth;

class Controller extends BaseController
{
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            // Auth::factory()->getTTL() - return Token's Time to Live in minutes (default=60)
            'expires_in' => Auth::factory()->getTTL() * 60 // Convert time to live to seconds
        ], 200);
    }
}
