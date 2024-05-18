<?php

namespace App\Models;

use App\Models\Scanner;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ScannerTicket extends Model
{
    use HasFactory;

    protected $table = 'scanner_ticket';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'scanner_id',
        'ticket_id',
        'date',
        'time',
    ];

    public function scanner(){
        return $this->belongsTo(Scanner::class);
    }
}
