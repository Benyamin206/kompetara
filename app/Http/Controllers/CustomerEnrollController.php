<?php

namespace App\Http\Controllers;

use App\Models\Enrollment;
use App\Models\Course;

class CustomerEnrollController extends Controller
{
    public function store(Course $course)
    {
        Enrollment::create([
            'user_id' => auth()->id(),
            'course_id' => $course->id,
            'status' => 'pending'
        ]);

        return back()->with('success', 'Menunggu approval owner');
    }
}