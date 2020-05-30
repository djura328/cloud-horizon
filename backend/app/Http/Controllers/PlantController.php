<?php

namespace App\Http\Controllers;

use App\Plant;
use Illuminate\Http\Request;
use App\Helpers\ReturnResponse;

class PlantController extends Controller
{

    public function show()
    {
        return Plant::with(['types:id,name', 'warehouses:id,name'])->get();
    }
    /**
     * $request object:
     * name
     * growth
     * plant_type_id
     * warehouse_id
     */
    public function store(Request $request)
    {
        $plant = Plant::create($request->toArray());

        if($plant) return ReturnResponse::success($plant->load('types'));
        return ReturnResponse::error();
    }

    public function remove(Plant $plant)
    {
        try {
            $plant->delete();

            return ReturnResponse::success();
        }
        catch (Throwable $e) {
            return ReturnResponse::error($e);
        }
    }
}
