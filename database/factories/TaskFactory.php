<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use App\Task;

$factory->define(Task::class, function (Faker $faker) {
    return [
        'from'=> $faker->sentence,
        'to'=> $faker->sentence,
        'city'=> $faker->sentence,
        'driver'=> $faker->sentence,
        'telephone'=> $faker->sentence,
        'date'=> $faker->sentence,
        'completed' => false,
        'project_id' => factory(App\Project::class),
    ];
});
