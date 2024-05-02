<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        return $this->belongsTo(Train::class);
    }

    public function station()
    {
        return $this->belongsTo(Station::class);
    }

}
