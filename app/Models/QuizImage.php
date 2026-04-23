<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuizImage extends Model
{
    protected $fillable = [
        'quiz_id',
        'name',
        'image_url',
        'public_id',
        'order'
    ];

    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }
}
