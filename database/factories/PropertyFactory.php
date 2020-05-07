<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Models\Property;
use Faker\Generator as Faker;
use Ramsey\Uuid\Uuid;

$factory->define(Property::class, function (Faker $faker) {
    return [
        'guid'    => $faker->uuid,
        'suburb'  => $faker->randomElement(['Parramatta', 'Richmond', 'Ryde', 'Castle Hill']),
        'state'   => $faker->randomElement(['NSW', 'Vic', 'Ryde', 'Castle Hill']),
        'country' => 'Australia',
    ];
});
