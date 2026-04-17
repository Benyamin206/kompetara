<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class OwnerCourseController extends Controller
{
    public function create()
    {
        return view('owner.courses.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|min:5|max:100',
            'description' => 'required|string|min:10|max:500',
        ], [
            'title.required' => 'Judul wajib diisi',
            'title.min' => 'Judul minimal 5 karakter',
            'title.max' => 'Judul maksimal 100 karakter',

            'description.required' => 'Deskripsi wajib diisi',
            'description.min' => 'Deskripsi minimal 10 karakter',
            'description.max' => 'Deskripsi maksimal 500 karakter',
        ]);

        Course::create([
            'owner_id' => auth()->id(),
            'title' => $request->title,
            'description' => $request->description,
            'is_published' => 1
        ]);

        return redirect()->route('owner.dashboard')
            ->with('success', 'Course berhasil ditambahkan');
    }
}