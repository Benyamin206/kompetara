<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Quiz;
use Illuminate\Http\Request;

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
        ]);

        $course->quizzes()->create($validated);

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
    ]);

    $quiz->update($validated);

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