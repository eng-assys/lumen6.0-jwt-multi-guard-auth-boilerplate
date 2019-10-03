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
        $user = User::register('Test User', 'test@test.com', 'password');
        $this->assertEquals('Test User', $user->name);
        $this->assertEquals('test@test.com', $user->email);
    }

    /**
     * Test Successfull Login User Function
     *
     * @return void
     *
     */
    public function testUserSuccessfullLogin()
    {
        $user = User::register('Test User', 'test@test.com', 'password');
        $access_token = User::login($user->email, 'password');

        $this->assertNotNull($access_token);

    }

    /**
     * Test Wrong Login User Function
     *
     * @return void
     *
     */
    public function testUserWrongLogin()
    {
        $user = User::register('Test User', 'test@test.com', 'password');
        $access_token = User::login($user->email, 'wrongpassword');

        $this->assertNull($access_token);

    }

}
