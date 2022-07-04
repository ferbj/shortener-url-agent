<?php

use App\Url;
use Faker\Generator as Faker;

$factory->define(Url::class, function (Faker $faker) {
    return [
        //
        'short_url' => $faker->regexify('[A-Z]{5}'),
        'original_url' => $faker->url(),
        'clicks_count' => $faker->numberBetween(1,50)
    ];
});
