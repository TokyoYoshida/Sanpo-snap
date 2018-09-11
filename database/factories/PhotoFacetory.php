<?php

use Faker\Generator as Faker;

$factory->define(App\Photo::class, function (Faker $faker) {
    return [
        'user_id' => 1,
        'title' => $faker->realText($maxNbChars = 20, $indexSize = 1),
        'filename' => "https://frame-illust.com/fi/wp-content/uploads/2018/03/kamome-shirokuro-s-150x150.png",
        'comment' => $faker->realText($maxNbChars = 20, $indexSize = 1),
    ];
});
