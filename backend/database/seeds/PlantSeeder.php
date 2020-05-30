<?php

use Illuminate\Database\Seeder;

class PlantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Plant::create([
            'name' => 'Carrot 1',
            'plant_type_id' => 1,
            'warehouse_id' => 0,
            'growth' => 0,
            'state' => 1
        ]);

        \App\Plant::create([
            'name' => 'Onion 1',
            'plant_type_id' => 2,
            'warehouse_id' => 0,
            'growth' => 0,
            'state' => 1
        ]);
    }
}
