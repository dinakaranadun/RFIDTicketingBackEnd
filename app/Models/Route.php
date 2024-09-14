<?php

namespace App\Models;

use App\Models\Train;
use App\Models\TrainRoute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Route extends Model
{
    use HasFactory;

    protected $table = 'route';

    public function stations()
    {
        return $this->hasManyThrough(Station::class, StationRoute::class, 'route_id', 'id', 'id', 'station_id')->orderBy('order');;
    }

    public function trains()
    {
        return $this->hasManyThrough(Train::class,TrainRoute::class,'route_id','id','id','train_id');
    }


}
