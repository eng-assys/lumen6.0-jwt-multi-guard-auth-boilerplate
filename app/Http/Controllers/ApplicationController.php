<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Application;

class ApplicationController extends Controller
{
     /**
     * Instantiate a new ApplicationController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:client_applications');
    }

    /**
     * Get the currently authenticated Application.
     *
     * @return Response
     */
    public function current()
    {
        return response()->json(['application' => Auth::guard('client_applications')->user()], 200);
    }

    /**
     * Get all Application.
     *
     * @return Response
     */
    public function applications()
    {
         return response()->json(['applications' =>  Application::all()], 200);
    }

    /**
     * Get one application.
     *
     * @return Response
     */
    public function application($id)
    {
        try {
            $application = Application::findOrFail($id);

            return response()->json(['application' => $application], 200);

        } catch (\Exception $e) {

            return response()->json(['error' => 'application not found!'], 404);
        }

    }

}
