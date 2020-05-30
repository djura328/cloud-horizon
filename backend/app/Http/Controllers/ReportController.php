<?php

namespace App\Http\Controllers;

use App\Plant;
use App\PlantType;
use App\Warehouse;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function plantTypes()
    {
        return PlantType::with('plants')
            ->whereHas('plants')
            ->get();
    }

    public function maturePlants()
    {
        return $plants = PlantType::with(['plants' => function($q) {
            $q->isMature();
        }])
            ->whereHas('plants', function($q) {
                $q->isMature();
            })
            ->orderBy('volume', 'DESC')
            ->get();
    }

    public function warehouse()
    {
        $warehouses = Warehouse::with(['plants.types'])->get();

        $warehouses = $warehouses->map(function($warehouse) {

            $sum = $warehouse->plants->reduce(function($carry, $plant) {
                return $carry + $plant->types->volume;
            });

            $warehouse->sum = $sum;
            $warehouse->percentage = $sum / $warehouse->volume * 100;
            $warehouse->free = $warehouse->volume - $sum;

            $warehouse = collect($warehouse)->forget('plants');

            return $warehouse;

        });

        return $warehouses;
    }

    public function maturePlantsWarehouse()
    {
        return Warehouse::with(['plants' => function($q) {
            $q->isMature();
            $q->where('state', config('enum.plant.inWarehouse'));
        }])
            ->whereHas('plants', function($q) {
                $q->isMature();
                $q->where('state', config('enum.plant.inWarehouse'));
            })
            ->get();
    }

    public function maturePlantsOutOfWarehouse()
    {
        return Plant::where('growth', 100)
            ->where('state', config('enum.plant.outWarehouse'))
            ->get();
    }

    public function currentGrow()
    {
        return Plant::where('growth', '<', 100)
            ->where('state',  config('enum.plant.growing'))
            ->where('warehouse_id', 0)
            ->orderBy('growth', 'DESC')
            ->get();
    }
}
