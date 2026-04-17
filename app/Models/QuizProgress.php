<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuizProgress extends Model
{
    protected $table = 'quiz_progress';

    protected $fillable = ['enrollment_id', 'quiz_id', 'is_correct', 'answered_at'];

    public function enrollment()
    {
        return $this->belongsTo(Enrollment::class);
    }

    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }
}
