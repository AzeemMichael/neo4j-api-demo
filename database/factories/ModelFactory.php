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

$factory->define(App\Patient::class, function (Faker\Generator $faker) {

    $gender =  rand(1,0) ? 'male' : 'female';

    return [
        'first_name'     => $faker->firstName($gender),
        'last_name'      => $faker->lastName,
        'gender'         => $gender,
        'email'          => $faker->safeEmail,
        'phone'          => $faker->phoneNumber
    ];
});

$factory->define(\App\Doctor::class, function (Faker\Generator $faker) {

    $gender =  rand(1,0) ? 'male' : 'female';

    return [
        'npi'            => $faker->unique()->randomNumber(),
        'specialty_code' => $faker->unique()->randomNumber(),
        'first_name'     => $faker->firstName($gender),
        'last_name'      => $faker->lastName,
        'gender'         => $gender,
        'email'          => $faker->safeEmail,
        'phone'          => $faker->phoneNumber,
        'password'       => bcrypt('password'),
        'remember_token' => str_random(10)
    ];
});

$factory->define(\App\Appointment::class, function(Faker\Generator $faker) {
    $rand = rand(1,6);
    $sign = rand(0,1)? '-':'+';
    switch(rand(1,4)) {
        case 1:
            return [
                'at' => \Carbon\Carbon::parse("{$sign}{$rand} month"),
                'status' => 'accepted'
            ];
            break;
        case 2:
            return [
                'at' => \Carbon\Carbon::parse("{$sign}{$rand} month"),
                'status' => 'rejected',
                'reason' => $faker->sentence
            ];
            break;
        case 3:
            return [
                'at' => \Carbon\Carbon::parse("+{$rand} week"),
                'status' => 'pending'
            ];
            break;
        case 4: // doctor cancelled already accepted appointment
            return [
                'at' => \Carbon\Carbon::parse("{$sign}{$rand} month"),
                'status' => 'cancelled',
                'cancelled_by' => rand(0,1) ? 'doctor' : 'patient',
                'reason' => $faker->sentence
            ];
            break;
        default:
            break;
    }
});