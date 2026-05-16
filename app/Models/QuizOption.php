<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuizOption extends Model
{
    protected $fillable = [
        'quiz_id',
        'option_text',
        'is_correct',
        'order'
    ];

    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }
}