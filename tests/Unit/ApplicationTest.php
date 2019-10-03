<?php

namespace Tests\Unit;

use App\Business\Application;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Tests\TestCase;

class ApplicationTest extends TestCase
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
     * Test Successfull Login Application Function
     *
     * @return void
     *
     */
    public function testApplicationSuccessfullLogin()
    {
        $application = Application::register('Test Application', 'client_id', 'client_secret');
        $access_token = Application::login($application->client_id, 'client_secret');

        $this->assertNotNull($access_token);
    }

    /**
     * Test Wrong Login Application Function
     *
     * @return void
     *
     */
    public function testApplicationWrongLogin()
    {
        $application = Application::register('Test Application', 'client_id', 'client_secret');
        $access_token = Application::login($application->client_id, 'wrongclient_secret');

        $this->assertNull($access_token);
    }
}
