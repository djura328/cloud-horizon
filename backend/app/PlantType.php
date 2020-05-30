<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlantType extends Model
{
    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    protected $fillable = [
        'name',
        'volume',
        'speed_growth'
    ];

    public function plants()
    {
        return $this->hasMany(Plant::class);
    }
}
