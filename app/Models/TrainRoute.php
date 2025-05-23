<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainRoute extends Model
{
    use HasFactory;

    protected $table = 'train_route';
    protected $primaryKey = 'id';
    protected $fillable = [
        'train_id',
        'station_id',
    ];

    
}
