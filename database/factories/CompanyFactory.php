<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Company;
use Faker\Generator as Faker;

$factory->define(Company::class, function (Faker $faker) {
    return [
        'name' => $faker->company,
        'industry_class' => 'IT',
        'number_of_employees' => $faker->randomDigit,
        'fiscal_start_date' => $faker->dateTime,
        'fiscal_end_date' => $faker->dateTime,
        'founded_date' => $faker->dateTime,
    ];
});
