<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

use App\Business\User;

class UserUnitTest extends TestCase
{

    use DatabaseMigrations;

    /**
     * Test Register User Function
     *
     * @return void
     *
     */
    public function testUserRegistration()
    {
        $user = User::register('Test', 'test@test.com', 'test');
        $this->assertEquals('Test', $user->name);
        $this->assertEquals('test@test.com', $user->email);
    }

    /**
     * Test Login User Function
     *
     * @return void
     *
     */
    public function testUserLogin()
    {
        $user = User::register('Test', 'test@test.com', 'test');
        $access_token = User::login($user->email, 'test');

        $this->assertNotNull($access_token);

    }

}
