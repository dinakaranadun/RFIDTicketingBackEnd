<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainClass extends Model
{
    use HasFactory;

    protected $table = 'train_class';

    protected $fillable = ['train_id', 'class'];
    public $timestamps = false;



    public function train()
    {
        return $this->belongsTo(Train::class, 'train_id', 'id');
    }
    
    
}

