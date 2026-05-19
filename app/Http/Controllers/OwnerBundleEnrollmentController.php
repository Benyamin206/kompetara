<?php

namespace App\Http\Controllers;

use App\Models\Enrollment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OwnerBundleEnrollmentController extends Controller
{
    public function index()
    {
        $bundleEnrollments = Enrollment::with(['user', 'course'])
            ->where('status', 'pending')
            ->get()
            ->groupBy('user_id')
            ->filter(function ($items) {
                return $items->count() > 1;
            });

        return view(
            'owner.bundle-enrollments.index',
            compact('bundleEnrollments')
        );
    }

    public function approve($userId)
    {
        Enrollment::where('user_id', $userId)
            ->where('status', 'pending')
            ->update([
                'status' => 'enrolled'
            ]);

        return back()->with(
            'success',
            'Bundle enrollment berhasil di-approve'
        );
    }
}