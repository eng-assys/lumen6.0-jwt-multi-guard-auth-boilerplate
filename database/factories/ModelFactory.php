<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\Models\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->email,
        'password' => app('hash')->make($faker->email)
        // 'password' => app('hash')->make($faker->password)
    ];
});

$factory->define(App\Models\Application::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'client_id' => $faker->email,
        'client_secret' => app('hash')->make($faker->email)
        // 'client_secret' => app('hash')->make($faker->password)
    ];
});
