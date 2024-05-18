<?php

namespace App\Models;

use App\Models\Forum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ForumAnswer extends Model
{
    use HasFactory;

    protected $table = 'forum_answer';
    protected $primaryKey = 'id';
    protected $fillable = [
        'content',
        'question_id',
    ];

    public function question()
    {
        return $this->belongsTo(Forum::class, 'question_id', 'id');
    }


}
