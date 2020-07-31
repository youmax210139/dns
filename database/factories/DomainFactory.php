<?php

use Faker\Generator as Faker;
use Illuminate\Support\Str;

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

$factory->define(App\Domain::class, function (Faker $faker) {
    return [
        'account' => $faker->username,
        'domainName' => $faker->domainName,
        'usage_status' => 'using',
        'backup_status' => 'using',
        'renew' => $faker->boolean,
        'registered_at' => $faker->dateTime($timezone='Asia/Taipei'),
        'expired_at' => $faker->dateTime($timezone='Asia/Taipei'),
    ];
});
