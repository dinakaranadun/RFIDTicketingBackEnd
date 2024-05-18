<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Route extends Model
{
    use HasFactory;

    protected $table = 'route';

    public function stations()
    {
        return $this->hasManyThrough(Station::class, StationRoute::class, 'route_id', 'id', 'id', 'station_id');
    }
}
