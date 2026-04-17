<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseMaterial;
use Illuminate\Http\Request;

class OwnerMaterialController extends Controller
{
    public function index(Course $course)
    {
        $materials = $course->materials;

        return view('owner.materials.index', compact('course', 'materials'));
    }

    public function create(Course $course)
    {
        return view('owner.materials.create', compact('course'));
    }

    public function store(Request $request, Course $course)
    {
        $request->validate([
            'order_number' => 'required|integer',
            'title' => 'required|string|max:255',
            'content' => 'required',
            'exp_reward' => 'required|integer|min:0',
        ]);

        CourseMaterial::create([
            'course_id' => $course->id,
            'order_number' => $request->input('order_number'),
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'exp_reward' => $request->input('exp_reward'),
        ]);

        return redirect()
            ->route('owner.dashboard')
            ->with('success', 'Materi berhasil ditambahkan');
    }

    public function edit(CourseMaterial $material)
    {
        return view('owner.materials.edit', compact('material'));
    }

    public function update(Request $request, CourseMaterial $material)
    {
        $request->validate([
            'order_number' => 'required|integer',
            'title' => 'required',
            'content' => 'required',
            'exp_reward' => 'required|integer',
        ]);

        $material->update([
            'order_number' => $request->order_number,
            'title' => $request->title,
            'content' => $request->content,
            'exp_reward' => $request->exp_reward,
        ]);

        return redirect()
            ->route('owner.dashboard')
            ->with('success', 'Materi berhasil diupdate');
    }

    public function destroy(CourseMaterial $material)
    {
        $material->delete();

        return redirect()
            ->back()
            ->with('success', 'Materi berhasil dihapus');
    }

    public function reorder(Request $request)
    {
        foreach ($request->order as $item) {
            CourseMaterial::where('id', $item['id'])
                ->update(['order_number' => $item['order_number']]);
        }

        return response()->json(['success' => true]);
    }

    public function preview(CourseMaterial $material)
    {
        return view('owner.materials.preview', compact('material'));
    }

}