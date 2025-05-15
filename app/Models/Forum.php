<?php

namespace App\Models;

use App\Models\User;
use App\Models\ForumAnswer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Forum extends Model
{
    use HasFactory;
    protected $table = 'forum_question';
    protected $primaryKey = 'id';
    public $timestamps = true;


    protected $fillable = [
        'title',
        'category',
        'content',
        'passenger_id',
    ];

    public function passenger()
    {
        return $this->belongsTo(User::class, 'passenger_id', 'id');
    }

    public function answers()
    {
        return $this->hasMany(ForumAnswer::class, 'question_id', 'id');
    }


}
