<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Group::class, function (Faker $faker) {
    return [
        'name' => $faker->domainName,
        'url' => $faker->url,
        'detail' => $faker->sentence
    ];
});

$factory->define(App\Models\Client::class, function (Faker $faker) {
    return [
        'name' => $faker->domainName,
        'url' => $faker->url,
        'detail' => $faker->sentence
    ];
});