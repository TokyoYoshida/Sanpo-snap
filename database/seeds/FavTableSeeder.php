<?php

use Illuminate\Database\Seeder;

class FavTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Fav::class, 1)->create();
    }
}
