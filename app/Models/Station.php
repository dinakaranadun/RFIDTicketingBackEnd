<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Station extends Model
{
    use HasFactory;

    
    protected $table = 'station';
    protected $primaryKey = 'id';

    public $timestamps = true;

    protected $fillable = [
        'station_name',
        'distance_from_central_station',
    ];

    public function schedule()
    {
        return $this->hasMany(Schedule::class);
    }
}
