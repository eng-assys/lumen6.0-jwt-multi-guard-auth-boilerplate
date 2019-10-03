<?php

namespace Tests\Integration;

use App\Business\User;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Tests\TestCase;

class UserTest extends TestCase
{

    use DatabaseMigrations;

    /**
     * Test Register User Endpoint
     *
     * @return void
     *
     */
    public function testRegisterUserEndpoint()
    {
        $bodyData = [
            'name' => 'Test',
            'email' => 'test@test.com',
            'password' => 'test',
            'password_confirmation' => 'test',
        ];
        $headers = [];
        $this->post('api/v1/users/register', $bodyData, $headers);

        $this->seeStatusCode(201);

        $this->seeJsonStructure(
            [
                'user' =>
                [
                    'name',
                    'email',
                    'uuid',
                    'updated_at',
                    'created_at',
                    'id'
                ]
            ]
        );
    }

    /**
     * Test Login User Endpoint
     *
     * @return void
     *
     */
    public function testLoginUserEndpoint()
    {
        User::register('Test', 'test@test.com', 'test');

        $bodyData = [
            'email' => 'test@test.com',
            'password' => 'test'
        ];
        $headers = [];
        $this->post('api/v1/users/login', $bodyData, $headers);

        $this->seeStatusCode(200);

        $this->seeJsonStructure(
            [
                'access_token',
                'token_type',
                'expires_in'
            ]
        );
    }

    /**
     * Test Get all users Endpoint
     *
     * @return void
     *
     */
    public function testGetAllUsersEndpoint()
    {

        $user = User::register('Test', 'test@test.com', 'test');
        $access_token = User::login($user->email, 'test');

        $headers = [
            'Content-Type' => 'application/x-www-form-urlencoded',
            'Authorization' => "Bearer {$access_token}"
        ];
        $this->get('api/v1/users/', $headers);
        $this->seeStatusCode(200);
        $this->seeJsonStructure([
            'users' =>
            [
                [
                    'name',
                    'email',
                    'uuid',
                    'updated_at',
                    'created_at',
                    'id'
                ]
            ]
        ]);
    }


    /**
     * Test Token's User Endpoint
     *
     * @return void
     *
     */
    public function testGetTokensUserEndpoint()
    {
        $user = User::register('Test', 'test@test.com', 'test');
        $access_token = User::login($user->email, 'test');

        $headers = [
            'Content-Type' => 'application/x-www-form-urlencoded',
            'Authorization' => "Bearer {$access_token}"
        ];
        $this->get('api/v1/users/me', $headers);

        $this->seeStatusCode(200);
        $this->seeJsonStructure(
            [
                'user' =>
                [
                    'name',
                    'email',
                    'uuid',
                    'updated_at',
                    'created_at',
                    'id'
                ]
            ]
        );
    }


    /**
     * Test Get User By Id Endpoint
     *
     * @return void
     *
     */
    public function testGetUserByIdEndpoint()
    {
        $user = User::register('Test', 'test@test.com', 'test');
        $access_token = User::login($user->email, 'test');

        $headers = [
            'Content-Type' => 'application/x-www-form-urlencoded',
            'Authorization' => "Bearer {$access_token}"
        ];
        $this->get('api/v1/users/1', $headers);

        $this->seeStatusCode(200);
        $this->seeJsonStructure(
            [
                'user' =>
                [
                    'name',
                    'email',
                    'uuid',
                    'updated_at',
                    'created_at',
                    'id'
                ]
            ]
        );
    }


    /**
     * Test Refresh User Token Endpoint
     *
     * @return void
     *
     */
    public function testRefreshUserTokenEndpoint()
    {
        $user = User::register('Test', 'test@test.com', 'test');
        $access_token = User::login($user->email, 'test');

        $bodyData = [];
        $headers = [
            'Content-Type' => 'application/x-www-form-urlencoded',
            'Authorization' => "Bearer {$access_token}"
        ];
        $this->post('api/v1/users/refresh', $bodyData, $headers);

        $this->seeStatusCode(200);
        $this->seeJsonStructure(
            [
                'access_token',
                'token_type',
                'expires_in'
            ]
        );
    }

    /**
     * Test Logout User Endpoint
     *
     * @return void
     *
     */
    public function testLogoutUserEndpoint()
    {
        $user = User::register('Test', 'test@test.com', 'test');
        $access_token = User::login($user->email, 'test');

        $bodyData = [];
        $headers = [
            'Content-Type' => 'application/x-www-form-urlencoded',
            'Authorization' => "Bearer {$access_token}"
        ];

        $this->post('api/v1/users/logout', $bodyData, $headers);

        $this->seeStatusCode(200);

        $this->get('api/v1/users/1', $headers);

        $this->seeStatusCode(401);
    }
}
