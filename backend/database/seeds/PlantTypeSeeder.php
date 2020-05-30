<?php

use Illuminate\Database\Seeder;

class PlantTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        \App\PlantType::create([
            'name' => 'Carrot',
            'volume' => 200,
            'speed_growth' => 10
        ]);

        \App\PlantType::create([
            'name' => 'Onion',
            'volume' => 160,
            'speed_growth' => 20
        ]);
    }
}
