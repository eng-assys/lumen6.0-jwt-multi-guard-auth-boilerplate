<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

use App\Business\Application;

class ApplicationUnitTest extends TestCase
{

    use DatabaseMigrations;

    /**
     * Test Register Application Function
     *
     * @return void
     *
     */
    public function testApplicationRegistration()
    {
        $application = Application::register('Test Application', 'client_id', 'client_secret');
        $this->assertEquals('Test Application', $application->name);
        $this->assertEquals('client_id', $application->client_id);
    }

    /**
     * Test Login Application Function
     *
     * @return void
     *
     */
    public function testApplicationLogin()
    {
        $application = Application::register('Test Application', '12345678', '987654321');
        $access_token = Application::login($application->client_id, '987654321');

        $this->assertNotNull($access_token);

    }

}
