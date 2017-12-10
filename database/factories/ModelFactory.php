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

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Models\Provider::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'business_name' => $faker->name,
        'cif' => 'B' . $faker->randomNumber(8),
        'address' => $faker->address,
        'zipcode' => $faker->randomNumber(5),
        'city' => $faker->city,
        'province' => $faker->state,
        'telephone' => $faker->e164PhoneNumber,
        'telephone2' => $faker->e164PhoneNumber,
        'fax' => $faker->e164PhoneNumber,
        'email' => $faker->unique()->safeEmail,
        'iban' => $faker->randomNumber(8),
        'contact' => $faker->name,
    ];
});

$factory->define(App\Models\Product::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->word,
        'ean' => $faker->randomNumber(8),
        'price' => $faker->randomFloat(2, 1, 60),
        'active' => 1,
    ];
});
