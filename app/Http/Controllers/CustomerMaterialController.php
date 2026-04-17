<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseMaterial;
use App\Models\Enrollment;
use App\Models\MaterialProgress;
use App\Models\CustomerProfile;

class CustomerMaterialController extends Controller
{
    public function index(Course $course)
    {
        $enrollment = Enrollment::where('user_id', auth()->id())
            ->where('course_id', $course->id)
            ->first();

        $materials = $course->materials()->orderBy('order_number')->get();

        $progress = [];

        if ($enrollment) {
            $progress = MaterialProgress::where('enrollment_id', $enrollment->id)
                ->get()
                ->keyBy('material_id');
        }

        return view('customer.materials.index', compact('course', 'materials', 'progress'));
    }

    public function show(Course $course, CourseMaterial $material)
    {
        $enrollment = Enrollment::where('user_id', auth()->id())
            ->where('course_id', $course->id)
            ->first();

        $progress = MaterialProgress::where('enrollment_id', $enrollment->id)
            ->where('material_id', $material->id)
            ->first();

        return view('customer.materials.show', compact('course', 'material', 'progress'));
    }

    public function complete(Course $course, CourseMaterial $material)
    {
        $userId = auth()->id();

        $enrollment = Enrollment::where('user_id', $userId)
            ->where('course_id', $course->id)
            ->first();

        // Cek apakah sudah pernah diselesaikan
        $existing = MaterialProgress::where('enrollment_id', $enrollment->id)
            ->where('material_id', $material->id)
            ->first();

        // Jika belum pernah selesai → kasih EXP
        if (!$existing || !$existing->is_completed) {

            // Simpan progress
            MaterialProgress::updateOrCreate(
                [
                    'enrollment_id' => $enrollment->id,
                    'material_id' => $material->id,
                ],
                [
                    'is_completed' => true,
                    'completed_at' => now(),
                ]
            );

            // 🔥 TAMBAH EXP
            $profile = CustomerProfile::firstOrCreate(
                ['user_id' => $userId],
                ['total_exp' => 0, 'level' => 0]
            );

            $profile->total_exp += $material->exp_reward;

            // 🔥 HITUNG LEVEL (100 EXP = 1 LEVEL)
            $profile->level = floor($profile->total_exp / 100);

            $profile->save();
        }

        return redirect()
            ->route('customer.materials.show', [$course->id, $material->id])
            ->with('success', 'Materi selesai & EXP ditambahkan');
    }
}