<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Plant extends Model
{
    protected $hidden = [
        'created_at',
        'updated_at',
        'plant_type_id',
        'warehouse_id'
    ];

    protected $fillable = [
        'name',
        'growth',
        'plant_type_id',
        'warehouse_id',
        'state'
    ];

    public function types()
    {
        return $this->hasOne(PlantType::class, 'id', 'plant_type_id');
    }

    public function warehouses()
    {
        return $this->hasOne(Warehouse::class, 'id');
    }

    public function scopeIsMature($query)
    {
        return $query->where('growth', '=', 100);
    }
}
