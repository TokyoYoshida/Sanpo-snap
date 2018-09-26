<?php

use Faker\Generator as Faker;

$factory->define(App\Photo::class, function (Faker $faker) {
    return [
        'user_id' => 1,
        'title' => $faker->realText($maxNbChars = 20, $indexSize = 1),
        'filename' => "mKtsNSoJigb1pEk7dPbo6AdynFPP6474Wj7K7C7r.jpeg",
        'comment' => $faker->realText($maxNbChars = 20, $indexSize = 1),
    ];
});
