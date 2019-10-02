<?php

namespace App\Business;

use App\Models\User as UserModel;

class User extends UserModel
{

    /**
     * Register a new user
     *
     * @param string $name
     * @param string $email
     * @param string $password
     *
     * @return mixed $user
     *
     */
    public static function register($name, $email, $password)
    {
        $user = new UserModel;
        $user->name = $name;
        $user->email = $email;
        $user->password = app('hash')->make($password);
        $user->save();

        return $user;
    }

    /**
     * Log into user with corresponding e-mail and password
     *
     * @param string $email
     * @param string $password
     *
     * @return string|null $access_token
     *
     */
    public static function login($email, $password)
    {
        $credentials = ['email' => $email, 'password' => $password];
        $access_token = \Auth::guard('api')->attempt($credentials);
        return $access_token ? $access_token : null;
    }

}
