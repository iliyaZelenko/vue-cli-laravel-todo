<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use Faker\Generator as Faker;
use Carbon\Carbon;

$factory->define(App\Todo::class, function (Faker $faker) {

    $completed = !!mt_rand(0, 1);
    $completedDateTime = null;

    if ($completed) {
        $completedDateTime = now()->subDays(mt_rand(1, 80))->subSeconds(mt_rand(5000, 5000 * 10));
    }
    $createdAt = ($completedDateTime ?? now())->subDays(mt_rand(1, 40))->subSeconds(mt_rand(5000, 5000 * 10));

    return [
        'title' => $faker->text(30),
        'comment' => mt_rand(0, 4) === 4 ? $faker->text(30) : null,
        'completed' => $completed,
        'completed_at' => $completedDateTime,
        'created_at' => $createdAt,
        'updated_at' =>  $createdAt
    ];
});

$factory->define(App\Group::class, function (Faker $faker) {
    return [
        'name' => $faker->text(20)
    ];
});
