<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Models\AnalyticType;
use Faker\Generator as Faker;


$factory->define(AnalyticType::class, function (Faker $faker) {
    return [
        'name'               => $faker->randomElement(['max_Bld_Height_m', 'min_lot_size_m2', 'fsr']),
        'units'              => $faker->tld,
        'is_numeric'         => true,
        'num_decimal_places' => $faker->randomDigit,
    ];
});
