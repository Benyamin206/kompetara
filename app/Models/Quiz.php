<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    protected $fillable = ['course_id', 'question', 'correct_answer', 'exp_reward'];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function images()
{
    return $this->hasMany(QuizImage::class);
}
}
