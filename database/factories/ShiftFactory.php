<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\User;
use App\Shift;
use Faker\Generator as Faker;

$factory->define(Shift::class, function (Faker $faker) {
    return [
        'date' => $faker->date($format = 'Y-m-d', $max = 'now'),
        'start_time' => $faker->time($format = 'H:i:s', $max = 'now'),
        'end_time' => $faker->time($format = 'H:i:s', $max = 'now'),
        'rest_time' => $faker->time($format = 'H:i:s', $max = 'now'),
        'total' => $faker->time($format = 'H:i:s', $max = 'now'),
        'comments' => $faker->text(50),
        'monthly_id' => $faker->numberBetween($min = 1, $max = 10),
        'work_type_id' => $faker->numberBetween($min = 1, $max = 6),
        'user_id' => function() {
            return factory(User::class);
        }
    ];
});
