<?php

namespace App\Models;

use App\Models\Train;
use App\Models\Station;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Scheduale extends Model
{
    use HasFactory;

    protected $table = 'schedule';
    protected $primaryKey = 'id';

    protected $fillable = [
        'arrival_time',
        'departure_time',
        'train_id',
        'station_id',
    ];

    public function train()
    {
        return $this->belongsTo(Train::class, 'train_id', 'id');
    }

    public function station()
    {
        return $this->belongsTo(Station::class, 'station_id', 'id');
    }

}
