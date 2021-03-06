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

$factory->define(\App\Models\Currency::class, function (Faker $faker) {
    return [
        'name'                => $faker->name,
        'code_text'           => $faker->currencyCode,
        'code'                => rand(100, 999),
        'symbol'              => $faker->randomLetter,
        'subunit'             => 2,
        'decimal_mark'        => ',',
        'thousands_separator' => '.',
        'active'              => true,
    ];
});



