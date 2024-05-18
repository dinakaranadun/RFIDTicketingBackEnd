<?php

namespace App\Models;

use App\Models\User;
use App\Models\Train;
use App\Models\Station;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ticket extends Model
{
    use HasFactory;

    protected $table = 'ticket';
    protected $primaryKey = 'id';

    protected $fillable = [
        'class',
        'date',
        'time',
        'cost',
        'passenger_id',
        'train_id',
        'status',
        'start_station_id',
        'end_station_id',

    ];
    
    public $timestamps = true;
    

    public function passenger()
    {
        return $this->belongsTo(User::class, 'passenger_id', 'id');
    }
    public function train()
    {
        return $this->belongsTo(Train::class);
    }
    public function station(){
        return $this->belongsTo(Station::class);
    }
    public function startStation()
    {
        return $this->belongsTo(Station::class, 'start_station_id');
    }

    public function endStation()
    {
        return $this->belongsTo(Station::class, 'end_station_id');
    }
}
