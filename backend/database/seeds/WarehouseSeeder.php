<?php

use Illuminate\Database\Seeder;

class WarehouseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Warehouse::create([
            'name' => 'Warehouse 1',
            'volume' => 400
        ]);

        \App\Warehouse::create([
            'name' => 'Warehouse 2',
            'volume' => 600
        ]);
    }
}
