<?php

namespace App\Http\Controllers;

use App\PlantType;
use Illuminate\Http\Request;
use App\Helpers\ReturnResponse;

class PlantTypeController extends Controller
{

    public function show()
    {
        return PlantType::all();
    }
    /**
     * $request object:
     * name
     * volume
     * speed_growth
     */
    public function store(Request $request)
    {
        $plant_type = PlantType::create($request->toArray());

        if($plant_type) return ReturnResponse::success($plant_type);
        return ReturnResponse::error();
    }

    public function remove(PlantType $plant_type)
    {
        try {
            $plant_type->delete();

            return ReturnResponse::success();
        }
        catch (Throwable $e) {
            return ReturnResponse::error($e);
        }
    }
}
