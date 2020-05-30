<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/warehouse', 'WarehouseController@show');
Route::post('/warehouse', 'WarehouseController@store');
Route::delete('/warehouse/{warehouse}', 'WarehouseController@remove');

Route::get('/plant', 'PlantController@show');
Route::post('/plant', 'PlantController@store');
Route::delete('/plant/{plant}', 'PlantController@remove');

Route::get('/plant-type', 'PlantTypeController@show');
Route::post('/plant-type', 'PlantTypeController@store');
Route::get('/plant-type/{plant_type}', 'PlantTypeController@remove');

Route::get('/game/start', 'GameController@start');

Route::group(
    [
        'prefix' => '/report'
    ],
    function () {
        Route::get('/plant-type/plant', 'ReportController@plantTypes');
        Route::get('/mature-plant', 'ReportController@maturePlants');
        Route::get('/mature-plant/warehouse', 'ReportController@maturePlantsWarehouse');
        Route::get('/mature-plant/out-of-warehouse', 'ReportController@maturePlantsOutOfWarehouse');
        Route::get('/warehouse', 'ReportController@warehouse');
        Route::get('/plant/current-grow', 'ReportController@currentGrow');
    }
);