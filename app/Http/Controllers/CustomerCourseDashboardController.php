<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

use App\Models\Course;
use App\Models\Enrollment;

class CustomerCourseDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $courses = Course::all();

        $enrollments = Enrollment::where('user_id', $user->id)->get();

        $profile = $user->customerProfile; // 🔥 ambil EXP & level

        return view('customer.dashboard', compact('courses', 'enrollments', 'profile'));
    }
}