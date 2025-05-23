<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends Model
{
    use HasFactory;

    protected $table='transactions';
    protected $primaryKey = 'id';


    protected $fillable = [
        'amount',
        'date',
        'passenger_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }


}
