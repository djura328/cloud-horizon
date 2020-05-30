<?php

namespace App\Http\Controllers;

use App\Plant;
use App\Warehouse;
use Illuminate\Http\Request;

class GameController extends Controller
{
    public function start()
    {
        return $this->growing();
    }

    private function growing()
    {
        $plants = Plant::with('types')
            ->where('growth', '<', 100)
            ->where('warehouse_id', '=', 0)
            ->get();

        foreach ($plants as $plant) {

            $plant->growth += $plant->types->speed_growth;


            if($plant->growth >= 100) {
                /**
                 * Plant growth to 100
                 * and store plant to warehouse
                 */

                $plant->growth = 100;
                $plant->state = 2;
                $plant->save();
                $warehouse = $this->findWarehouse($plant->types->volume);

                $warehouse->plants()->save($plant);
            }
            else {
                $plant->save();
            }

        }

    }

    private function findWarehouse($plant_volume)
    {
        /**
         * Find empty warehouse
         * where volume is equal or higher
         * then volume of plant
         */
        $warehouses = Warehouse::withCount('plants as count_stored_plants')
            ->where('volume', '>=', $plant_volume)
            ->having('count_stored_plants', '=', 0)
            ->first();

        if($warehouses) {
            return $warehouses;
        }
        else {

            /**
             * Empty warehouse
             * before store new plants
             */
            $warehouses = Warehouse::first();
            $warehouses->detachPlants();

            return $warehouses;
        }


    }


}
