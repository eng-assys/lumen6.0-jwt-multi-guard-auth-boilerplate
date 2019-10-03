<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

use App\Business\Application;

class ApplicationIntegrationTest extends TestCase
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
            'name' => 'Test Application',
            'client_id' => 'client_id',
            'client_secret' => 'client_secret',
            'client_secret_confirmation' => 'client_secret',
        ];
        $headers = [];
        $this->post('api/v1/applications/register', $bodyData, $headers);

        $this->seeStatusCode(201);

        $this->seeJsonStructure(
            ['application' =>
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
        Application::register('Test Application', 'client_id', 'client_secret');

        $bodyData = [
            'client_id' => 'client_id',
            'client_secret' => 'client_secret'
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

        $application = Application::register('Test Application', 'client_id', 'client_secret');
        $access_token = Application::login($application->client_id, 'client_secret');

        $headers = [
            'Content-Type' => 'application/x-www-form-urlencoded',
            'Authorization' => "Bearer {$access_token}"
        ];
        $this->get('api/v1/applications/', $headers);

        $this->seeStatusCode(200);
        $this->seeJsonStructure(
            ['applications' =>
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
     * Test Token's Application Endpoint
     *
     * @return void
     *
     */
    public function testGetTokensApplicationEndpoint()
    {
        $application = Application::register('Test Application', 'client_id', 'client_secret');
        $access_token = Application::login($application->client_id, 'client_secret');

        $headers = [
            'Content-Type' => 'application/x-www-form-urlencoded',
            'Authorization' => "Bearer {$access_token}"
        ];
        $this->get('api/v1/applications/me', $headers);

        $this->seeStatusCode(200);
        $this->seeJsonStructure(
            ['application' =>
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
        $application = Application::register('Test Application', 'client_id', 'client_secret');
        $access_token = Application::login($application->client_id, 'client_secret');

        $headers = [
            'Content-Type' => 'application/x-www-form-urlencoded',
            'Authorization' => "Bearer {$access_token}"
        ];
        $this->get('api/v1/applications/1', $headers);

        $this->seeStatusCode(200);
        $this->seeJsonStructure(
            ['application' =>
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
        $application = Application::register('Test Application', 'client_id', 'client_secret');
        $access_token = Application::login($application->client_id, 'client_secret');

        $bodyData = [];
        $headers = [
            'Content-Type' => 'application/x-www-form-urlencoded',
            'Authorization' => "Bearer {$access_token}"
        ];
        $this->post('api/v1/applications/refresh', $bodyData, $headers);

        $this->seeStatusCode(200);
        $this->seeJsonStructure(
            ['data' =>
                [
                    'product_name',
                    'product_description',
                    'created_at',
                    'updated_at',
                    'links'
                ]
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
        $bodyData = [];
        $headers = [];
        $this->post('api/v1/applications/logout', $bodyData, $headers);

        $this->seeStatusCode(200);
        $this->seeJsonStructure(
            ['data' =>
                [
                    'product_name',
                    'product_description',
                    'created_at',
                    'updated_at',
                    'links'
                ]
            ]
        );
    }


}
