<?php

namespace App\Business;

use App\Models\Application as ApplicationModel;

class Application extends ApplicationModel
{

    /**
     * Register a new application
     *
     * @param string $name
     * @param string $client_id
     * @param string $client_secret
     *
     * @return mixed $application
     *
     */
    public static function register($name, $client_id, $client_secret)
    {
        $application = new ApplicationModel;
        $application->name = $name;
        $application->client_id = $client_id;
        $application->client_secret = app('hash')->make($client_secret);
        $application->save();

        return $application;
    }

    /**
     * Log into application with corresponding e-mail and client_secret
     *
     * @param string $client_id
     * @param string $client_secret
     *
     * @return string|null $access_token
     *
     */
    public static function login($client_id, $client_secret)
    {
        $credentials = ['client_id' => $client_id, 'password' => $client_secret];
        $access_token = \Auth::guard('client_application')->attempt($credentials);
        return $access_token ? $access_token : null;
    }

}
