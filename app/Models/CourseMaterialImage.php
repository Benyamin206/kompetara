<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseMaterialImage extends Model
{
    protected $fillable = [
        'course_material_id',
        'name',
        'image_url',
        'public_id',
        'order'
    ];

    public function material()
    {
        return $this->belongsTo(CourseMaterial::class, 'course_material_id');
    }
}