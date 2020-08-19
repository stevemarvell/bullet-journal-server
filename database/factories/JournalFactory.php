<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Journal;
use App\User;
use Faker\Generator as Faker;

$factory->define(Journal::class, function (Faker $faker) {

    $year = $faker->year;

    $started = $faker->boolean(80);
    $completed = $started ? $faker->boolean(50) : null;

    return [
        'index' => $faker->randomLetter,
        'title' => "My Year " . $year,
        'started_at' => $started ? $faker->dateTimeBetween("$year-01-01", "$year-01-31") : null,
        'completed_at' => $completed ? $faker->dateTimeBetween("$year-11-01", "$year-12-31") : null,

        'user_id' => User::all()->random()->id,
    ];
});
