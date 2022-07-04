<?php
namespace App\Http\Services;
use Faker\Factory as Faker;

class HelpersService{
    /*generator random string [A-Z] pattern size 5*/
    public static function randomstr(){
        $faker = Faker::create();
        return $faker->regexify('[A-Z]{5}');
    }
}
