<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = ['owner_id', 'title', 'description', 'is_published'];

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function materials()
    {
        return $this->hasMany(CourseMaterial::class);
    }

    public function quizzes()
    {
        return $this->hasMany(Quiz::class);
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }
}
