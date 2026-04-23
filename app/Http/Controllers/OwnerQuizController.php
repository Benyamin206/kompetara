<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Quiz;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Http;
use App\Models\QuizImage;
use Illuminate\Support\Str;

class OwnerQuizController extends Controller
{
    public function index(Course $course)
    {
        $this->authorizeOwner($course);

        $quizzes = $course->quizzes;

        return view('owner.quizzes.index', compact('course', 'quizzes'));
    }

    public function create(Course $course)
    {
        $this->authorizeOwner($course);

        return view('owner.quizzes.create', compact('course'));
    }

public function store(Request $request, Course $course)
{
    $this->authorizeOwner($course);

    $validated = $request->validate([
        'question' => 'required|string',
        'correct_answer' => 'required|string',
        'exp_reward' => 'required|integer|min:0',

        // multiple images
        'images.*' => 'image|max:2048'
    ]);

    $quiz = $course->quizzes()->create($validated);

    // Upload images ke Cloudinary
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

            $quiz->images()->create([
                'name' => 'image_' . ($index + 1),
                'image_url' => $data['secure_url'] ?? null,
                'public_id' => $data['public_id'] ?? null,
                'order' => $index
            ]);
        }
    }

    return redirect()
        ->route('owner.quizzes.index', $course->id)
        ->with('success', 'Quiz berhasil ditambahkan');
}

    private function authorizeOwner($course)
    {
        if ($course->owner_id !== auth()->id()) {
            abort(403);
        }
    }

public function edit(Quiz $quiz)
{
    $this->authorizeOwner($quiz->course);

    return view('owner.quizzes.edit', compact('quiz'));
}

public function update(Request $request, Quiz $quiz)
{
    $this->authorizeOwner($quiz->course);

    $validated = $request->validate([
        'question' => 'required|string',
        'correct_answer' => 'required|string',
        'exp_reward' => 'required|integer|min:0',

        'images.*' => 'image|max:2048'
    ]);

    $quiz->update($validated);

    // Tambah gambar baru (tidak hapus lama)
    if ($request->hasFile('images')) {
        $currentCount = $quiz->images()->count();

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

            $quiz->images()->create([
                'name' => 'image_' . ($currentCount + $index + 1),
                'image_url' => $data['secure_url'] ?? null,
                'public_id' => $data['public_id'] ?? null,
                'order' => $currentCount + $index
            ]);
        }
    }

    return redirect()
        ->route('owner.quizzes.index', $quiz->course_id)
        ->with('success', 'Quiz berhasil diupdate');
}

public function destroy(Quiz $quiz)
{
    $this->authorizeOwner($quiz->course);

    $courseId = $quiz->course_id;

    $quiz->delete();

    return redirect()
        ->route('owner.quizzes.index', $courseId)
        ->with('success', 'Quiz berhasil dihapus');
}
}