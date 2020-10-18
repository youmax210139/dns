<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
 */

$factory->define(App\Models\Domain::class, function (Faker $faker) {
    return [
        'account' => $faker->username,
        'name' => $faker->domainName,
        'usage' => $faker->randomFloat(2, 0, 100),
        'backup' => $faker->boolean,
        'renew' => $faker->boolean,
        'enable' => $faker->boolean,
        'remark' => $faker->word,
        'registered_at' => $faker->dateTime($timezone = 'Asia/Taipei'),
        'expired_at' => $faker->dateTime($timezone = 'Asia/Taipei'),
    ];
});
