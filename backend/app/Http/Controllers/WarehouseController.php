<?php

namespace App\Http\Controllers;

use App\Warehouse;
use Illuminate\Http\Request;
use App\Helpers\ReturnResponse;

class WarehouseController extends Controller
{

    public function show()
    {
        return Warehouse::all();
    }
    /**
     * $request object:
     * name
     * volume
     */
    public function store(Request $request)
    {
        $warehouse = Warehouse::create($request->toArray());

        if($warehouse) return ReturnResponse::success($warehouse);
        return ReturnResponse::error();
    }

    public function remove(Warehouse $warehouse)
    {
        try {
            $warehouse->plants()->update([
                'warehouse_id' => 0,
                'state' => config('enum.plant.outWarehouse')
            ]);

            $warehouse->delete();

            return ReturnResponse::success();
        }
        catch (Throwable $e) {
            return ReturnResponse::error($e);
        }
    }
}
