<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Journal;
use App\User;
use Faker\Generator as Faker;

$factory->define(Journal::class, function (Faker $faker) {

    // realistically there should only be one closed journal per person

    $year = $faker->year;

    $started = $faker->boolean(80);
    $completed = $started ? $faker->boolean(50) : null;

    return [
        'code' => $faker->randomLetter(2),
        'title' => "My Year " . $year,
        'started_at' => $started ? $faker->dateTimeBetween("$year-01-01", "$year-01-31") : null,
        'completed_at' => $completed ? $faker->dateTimeBetween("$year-11-01", "$year-12-31") : null,
    ];
});
