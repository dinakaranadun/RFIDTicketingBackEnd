<?php

namespace App\Models;

use App\Models\Train;
use App\Models\TrainClass;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Train extends Model
{
    use HasFactory;

    protected $table = 'train';

    protected $primaryKey = 'id';

    public $timestamps = true;

    protected $fillable = [
        'name',
        'start_station',
        'end_station',
        'train_type',
    ];

    
    public function class()
    {
        return $this->hasMany(TrainClass::class, 'train_id', 'id');
    }

    public function schedule()
    {
        return $this->hasMany(Schedule::class, 'train_id', 'id');
    }


}
