<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    protected $fillable = [
        'name',
        'volume'
    ];

    public function plants()
    {
        return $this->hasMany(Plant::class);
    }

    public function detachPlants()
    {
        $this->plants()->update([
            'warehouse_id' => 0,
            'state' => config('enum.plant.outWarehouse')
        ]);
    }
}
