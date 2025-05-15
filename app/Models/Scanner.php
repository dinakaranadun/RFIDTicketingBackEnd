<?php

namespace App\Models;

use App\Models\ScannerTicket;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Scanner extends Model
{
    use HasFactory;
    protected $table = 'scanner';
    protected $primaryKey = 'id';
    public $timestamps = true;


    protected $fillable = [
        'location',
    ];

    public function scannedticket()
    {
        return $this->hasMany(ScannerTicket::class, 'scanner_id', 'id');
    }
}
