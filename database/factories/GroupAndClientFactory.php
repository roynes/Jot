<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Group::class, function (Faker $faker) {
    $object = [
        'email' => $faker->email,
        'street' => $faker->streetName,
        'city' => $faker->city,
        'description' => $faker->sentences,
        'state' => $faker->countryISOAlpha3
    ];

    return [
        'name' => $faker->company,
        'settings' => $object
    ];
});

$factory->define(App\Models\Client::class, function (Faker $faker) {
    $object = [
        'email' => $faker->email,
        'street' => $faker->streetName,
        'city' => $faker->city,
        'description' => $faker->sentences,
        'state' => $faker->countryISOAlpha3
    ];

    return [
        'name' => $faker->company,
        'settings' => $object
    ];
});