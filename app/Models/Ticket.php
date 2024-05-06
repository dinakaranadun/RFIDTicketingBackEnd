<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $table = 'ticket';
    protected $primaryKey = 'id';

    protected $fillable = [
        'start_station',
        'destination',
        'class',
        'date',
        'time',
        'cost',
        'passenger_id',
        'train_id',
        'status',

    ];
    
    public $timestamps = true;
    

    public function passenger()
    {
        return $this->belongsTo(Passenger::class, 'passenger_id', 'id');
    }
    public function train()
    {
        return $this->belongsTo(Train::class);
    }
}
