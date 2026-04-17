<?php

namespace App\Http\Controllers;

use App\Models\Enrollment;

class OwnerEnrollController extends Controller
{
    public function index($courseId)
    {
        $enrollments = Enrollment::with('user')
            ->where('course_id', $courseId)
            ->get();

        return view('owner.enrollments.index', compact('enrollments', 'courseId'));
    }

    public function approve(Enrollment $enrollment)
    {
        $enrollment->update([
            'status' => 'enrolled'
        ]);

        return back()->with('success', 'Customer disetujui');
    }
}
