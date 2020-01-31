<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Bill;
use Faker\Generator as Faker;

$factory->define(Bill::class, function (Faker $faker) {
    return [
        'vin'=>$faker->word,
        'engine'=>$faker->word,
        'model'=>$faker->word,
        'notes'=>$faker->sentence,
    ];
});
