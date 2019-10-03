<?php

namespace Tests\Integration;

use App\Business\Application;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Tests\TestCase;

class ApplicationTest extends TestCase
{

    use DatabaseMigrations;

    /**
     * Test Register Application Endpoint
     *
     * @return void
     *
     */
    public function testRegisterApplicationEndpoint()
    {
        $bodyData = [
            'name' => 'Test',
            'client_id' => 'test@test.com',
            'client_secret' => 'test',
            'client_secret_confirmation' => 'test',
        ];
        $headers = [];
        $this->post('api/v1/applications/register', $bodyData, $headers);

        $this->seeStatusCode(201);

        $this->seeJsonStructure(
            [
                'application' =>
                [
                    'name',
                    'client_id',
                    'uuid',
                    'updated_at',
                    'created_at',
                    'id'
                ]
            ]
        );
    }

    /**
     * Test Login Application Endpoint
     *
     * @return void
     *
     */
    public function testLoginApplicationEndpoint()
    {
        Application::register('Test', 'test@test.com', 'test');

        $bodyData = [
            'client_id' => 'test@test.com',
            'client_secret' => 'test'
        ];
        $headers = [];
        $this->post('api/v1/applications/login', $bodyData, $headers);

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
     * Test Get all applications Endpoint
     *
     * @return void
     *
     */
    public function testGetAllApplicationsEndpoint()
    {

        $application = Application::register('Test', 'test@test.com', 'test');
        $access_token = Application::login($application->client_id, 'test');

        $headers = [
            'Content-Type' => 'application/x-www-form-urlencoded',
            'Authorization' => "Bearer {$access_token}"
        ];
        $this->get('api/v1/applications/', $headers);
        $this->seeStatusCode(200);
        $this->seeJsonStructure([
            'applications' =>
            [
                [
                    'name',
                    'client_id',
                    'uuid',
                    'updated_at',
                    'created_at',
                    'id'
                ]
            ]
        ]);
    }


    /**
     * Test Token's Application Endpoint
     *
     * @return void
     *
     */
    public function testGetTokensApplicationEndpoint()
    {
        $application = Application::register('Test', 'test@test.com', 'test');
        $access_token = Application::login($application->client_id, 'test');

        $headers = [
            'Content-Type' => 'application/x-www-form-urlencoded',
            'Authorization' => "Bearer {$access_token}"
        ];
        $this->get('api/v1/applications/current', $headers);

        $this->seeStatusCode(200);
        $this->seeJsonStructure(
            [
                'application' =>
                [
                    'name',
                    'client_id',
                    'uuid',
                    'updated_at',
                    'created_at',
                    'id'
                ]
            ]
        );
    }


    /**
     * Test Get Application By Id Endpoint
     *
     * @return void
     *
     */
    public function testGetApplicationByIdEndpoint()
    {
        $application = Application::register('Test', 'test@test.com', 'test');
        $access_token = Application::login($application->client_id, 'test');

        $headers = [
            'Content-Type' => 'application/x-www-form-urlencoded',
            'Authorization' => "Bearer {$access_token}"
        ];
        $this->get('api/v1/applications/1', $headers);

        $this->seeStatusCode(200);
        $this->seeJsonStructure(
            [
                'application' =>
                [
                    'name',
                    'client_id',
                    'uuid',
                    'updated_at',
                    'created_at',
                    'id'
                ]
            ]
        );
    }


    /**
     * Test Refresh Application Token Endpoint
     *
     * @return void
     *
     */
    public function testRefreshApplicationTokenEndpoint()
    {
        $application = Application::register('Test', 'test@test.com', 'test');
        $access_token = Application::login($application->client_id, 'test');

        $bodyData = [];
        $headers = [
            'Content-Type' => 'application/x-www-form-urlencoded',
            'Authorization' => "Bearer {$access_token}"
        ];
        $this->post('api/v1/applications/refresh', $bodyData, $headers);

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
     * Test Logout Application Endpoint
     *
     * @return void
     *
     */
    public function testLogoutApplicationEndpoint()
    {
        $application = Application::register('Test', 'test@test.com', 'test');
        $access_token = Application::login($application->client_id, 'test');

        $bodyData = [];
        $headers = [
            'Content-Type' => 'application/x-www-form-urlencoded',
            'Authorization' => "Bearer {$access_token}"
        ];

        $this->post('api/v1/applications/logout', $bodyData, $headers);

        $this->seeStatusCode(200);

        $this->get('api/v1/applications/1', $headers);

        $this->seeStatusCode(401);
    }
}
