<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Group::class, function (Faker $faker) {
    $object = [ 'email' => $faker->email, 'address' => $faker->address ];

    return [
        'name' => $faker->company,
        'settings' => json_encode($object)
    ];
});

$factory->define(App\Models\Client::class, function (Faker $faker) {
    $object = [ 'email' => $faker->email, 'address' => $faker->address ];

    return [
        'name' => $faker->company,
        'settings' => json_encode($object)
    ];
});