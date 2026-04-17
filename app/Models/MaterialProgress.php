<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaterialProgress extends Model
{
    protected $table = 'material_progress';

    protected $fillable = ['enrollment_id', 'material_id', 'is_completed', 'completed_at'];

    public function enrollment()
    {
        return $this->belongsTo(Enrollment::class);
    }

    public function material()
    {
        return $this->belongsTo(CourseMaterial::class, 'material_id');
    }
}