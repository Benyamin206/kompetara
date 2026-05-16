<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseMaterial extends Model
{
    protected $fillable = ['course_id', 'order_number', 'title', 'content', 'exp_reward'];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function images()
    {
        return $this->hasMany(CourseMaterialImage::class)
            ->orderBy('order');
    }
}
