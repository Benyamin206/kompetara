<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Course;
use App\Models\Enrollment;

class CustomerCourseController extends Controller
{
    public function index()
    {
        $courses = Course::all();

        $enrollments = Enrollment::where('user_id', Auth::id())->get();

        return view('customer.dashboard', compact('courses', 'enrollments'));
    }
}