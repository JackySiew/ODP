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
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'profile' => 'back_1606987865_jpg',
        'email' => $faker->unique()->safeEmail,
        'usertype' => 'admin',
        'mobile' => Str::random(10),
        'password' =>  '$2y$10$W5ZcZKQQoYuThCQu7EpUseEW3splRQFIL6j55lef/8BGy21lkjGZy',//00000000 //$password ?: $password = bcrypt('secret'),
        'remember_token' => Str::random(10),
    ];
});

$factory->define(App\Message::class, function (Faker\Generator $faker) {
    do {
        $from = rand(1,9);
        $to = rand(1,9);
        $is_read = rand(0,1);
    } while ($from === $to);
    return [
        'from' => $from,
        'to' => $to,
        'message' => $faker->sentence,
        'is_read' =>  $is_read
    ];
});

$factory->define(App\Review::class, function (Faker\Generator $faker) {

    return [
        'user_id' => rand(1,7),
        'comment' => $faker->sentence,
        'rating' =>  rand(1,5),
        'product_id' =>  rand(1,9)  
    ];
});
