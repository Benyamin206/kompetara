<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseMaterial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\CourseMaterialImage;

class OwnerMaterialController extends Controller
{
    public function index(Course $course)
    {
        // $materials = $course->materials;
        $materials = $course->materials()
    ->with('images')
    ->orderBy('order_number')
    ->get();

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

        'images.*' => 'image|max:2048',
        'image_names.*' => 'nullable|string|max:255',
    ]);

    $material = CourseMaterial::create([
        'course_id' => $course->id,
        'order_number' => $request->input('order_number'),
        'title' => $request->input('title'),
        'content' => $request->input('content'),
        'exp_reward' => $request->input('exp_reward'),
    ]);

    // upload images
    if ($request->hasFile('images')) {

        foreach ($request->file('images') as $index => $image) {

            $response = Http::asMultipart()->post(
                'https://api.cloudinary.com/v1_1/de9cyaoqo/image/upload',
                [
                    [
                        'name' => 'file',
                        'contents' => fopen($image->getRealPath(), 'r'),
                    ],
                    [
                        'name' => 'upload_preset',
                        'contents' => 'my_unsigned_preset',
                    ],
                ]
            );

            $data = $response->json();

            $material->images()->create([
                'name' => $request->image_names[$index]
                    ?? ('image_' . ($index + 1)),

                'image_url' => $data['secure_url'] ?? null,
                'public_id' => $data['public_id'] ?? null,
                'order' => $index,
            ]);
        }
    }

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

        'images.*' => 'image|max:2048',
        'image_names.*' => 'nullable|string|max:255',
    ]);

    $material->update([
        'order_number' => $request->order_number,
        'title' => $request->title,
        'content' => $request->content,
        'exp_reward' => $request->exp_reward,
    ]);

    // upload new images
    if ($request->hasFile('images')) {

        $currentCount = $material->images()->count();

        foreach ($request->file('images') as $index => $image) {

            $response = Http::asMultipart()->post(
                'https://api.cloudinary.com/v1_1/de9cyaoqo/image/upload',
                [
                    [
                        'name' => 'file',
                        'contents' => fopen($image->getRealPath(), 'r'),
                    ],
                    [
                        'name' => 'upload_preset',
                        'contents' => 'my_unsigned_preset',
                    ],
                ]
            );

            $data = $response->json();

            $material->images()->create([
                'name' => $request->image_names[$index]
                    ?? ('image_' . ($currentCount + $index + 1)),

                'image_url' => $data['secure_url'] ?? null,
                'public_id' => $data['public_id'] ?? null,
                'order' => $currentCount + $index,
            ]);
        }
    }

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
    $material->load('images');

    return view('owner.materials.preview', compact('material'));
    }

    public function deleteImage(CourseMaterialImage $image)
{
    // optional: validasi owner
    if ($image->material->course->owner_id !== auth()->id()) {
        abort(403);
    }

    $image->delete();

    return back()->with('success', 'Gambar berhasil dihapus');
}

}