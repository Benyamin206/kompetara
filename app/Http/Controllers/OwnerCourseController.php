<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

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
        'image' => 'nullable|image|max:2048'
    ]);

    $imageUrl = null;
    $publicId = null;

    if ($request->hasFile('image')) {

        $response = Http::asMultipart()->post(
            'https://api.cloudinary.com/v1_1/de9cyaoqo/image/upload',
            [
                [
                    'name' => 'file',
                    'contents' => fopen($request->file('image')->getRealPath(), 'r'),
                ],
                [
                    'name' => 'upload_preset',
                    'contents' => 'my_unsigned_preset',
                ],
            ]
        );

        $data = $response->json();

        $imageUrl = $data['secure_url'] ?? null;
        $publicId = $data['public_id'] ?? null;
    }

    Course::create([
        'owner_id' => auth()->id(),
        'title' => $request->title,
        'description' => $request->description,
        'is_published' => 1,
        'image_url' => $imageUrl,
        'image_public_id' => $publicId
    ]);

    return redirect()->route('owner.dashboard')
        ->with('success', 'Course berhasil ditambahkan');
}

public function edit(Course $course)
{
    if ($course->owner_id !== auth()->id()) {
        abort(403);
    }

    return view('owner.courses.edit', compact('course'));
}

public function update(Request $request, Course $course)
{
    if ($course->owner_id !== auth()->id()) {
        abort(403);
    }

    $request->validate([
        'title' => 'required|string|min:5|max:100',
        'description' => 'required|string|min:10|max:500',
        'image' => 'nullable|image|max:2048'
    ]);

    $imageUrl = $course->image_url;
    $publicId = $course->image_public_id;

    if ($request->hasFile('image')) {

        $response = Http::asMultipart()->post(
            'https://api.cloudinary.com/v1_1/de9cyaoqo/image/upload',
            [
                [
                    'name' => 'file',
                    'contents' => fopen($request->file('image')->getRealPath(), 'r'),
                ],
                [
                    'name' => 'upload_preset',
                    'contents' => 'my_unsigned_preset',
                ],
            ]
        );

        $data = $response->json();

        $imageUrl = $data['secure_url'] ?? $imageUrl;
        $publicId = $data['public_id'] ?? $publicId;
    }

    $course->update([
        'title' => $request->title,
        'description' => $request->description,
        'image_url' => $imageUrl,
        'image_public_id' => $publicId
    ]);

    return redirect()->route('owner.dashboard')
        ->with('success', 'Course berhasil diupdate');
}
}