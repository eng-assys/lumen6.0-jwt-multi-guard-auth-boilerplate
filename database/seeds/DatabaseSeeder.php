<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call('UsersTableSeeder');

        // Create 10 Users
        factory(App\Models\User::class, 10)->create();

        // Create 10 Applications
        factory(App\Models\Application::class, 10)->create();
    }
}
