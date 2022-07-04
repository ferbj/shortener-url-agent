<?php

use App\Click;
use Faker\Generator as Faker;

$factory->define(Click::class, function (Faker $faker) {
    return [
        //
        'url_id' => $faker->numberBetween(1,50),
        'browser' => $faker->userAgent(),
        'platform' => $faker->windowsPlatformToken()
    ];
});
