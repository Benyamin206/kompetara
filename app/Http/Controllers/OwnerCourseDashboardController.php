<?php

namespace App\Http\Controllers;

use App\Models\Course;

class OwnerCourseDashboardController extends Controller
{
    public function index()
    {
        $courses = Course::where('owner_id', auth()->id())->get();

        return view('owner.dashboard', compact('courses'));
    }
}
