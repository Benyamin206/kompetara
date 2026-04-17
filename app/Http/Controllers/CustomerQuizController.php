<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Quiz;
use App\Models\Enrollment;
use App\Models\QuizProgress;
use Illuminate\Http\Request;

class CustomerQuizController extends Controller
{
    public function index(Course $course)
    {
        $user = auth()->user();

        $enrollment = Enrollment::where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->where('status', 'enrolled')
            ->firstOrFail();

        $quizzes = $course->quizzes;

        return view('customer.quizzes.index', compact('course', 'quizzes', 'enrollment'));
    }

public function answer(Request $request, Quiz $quiz)
{
    $request->validate([
        'answer' => 'required|string'
    ]);

    $user = auth()->user();

    $enrollment = Enrollment::where('user_id', $user->id)
        ->where('course_id', $quiz->course_id)
        ->firstOrFail();

    // 🔥 CEK: apakah sudah pernah jawab BENAR
    $alreadyCorrect = QuizProgress::where('enrollment_id', $enrollment->id)
        ->where('quiz_id', $quiz->id)
        ->where('is_correct', true)
        ->exists();

    if ($alreadyCorrect) {
        return back()->with('error', 'Quiz sudah pernah dijawab dengan benar.');
    }

    $isCorrect = strtolower(trim($request->answer)) === strtolower(trim($quiz->correct_answer));

    // 🔥 simpan progress
    QuizProgress::create([
        'enrollment_id' => $enrollment->id,
        'quiz_id' => $quiz->id,
        'is_correct' => $isCorrect,
        'answered_at' => now(),
    ]);

if ($isCorrect) {

    $profile = $user->customerProfile;

    if (!$profile) {
        $profile = \App\Models\CustomerProfile::create([
            'user_id' => $user->id,
            'total_exp' => 0,
            'level' => 1,
        ]);
    }

    $profile->total_exp += $quiz->exp_reward;
    $profile->save();

    return redirect()
        ->route('customer.quizzes.show', [$quiz->course_id, $quiz->id])
        ->with('success', 'Jawaban benar! +' . $quiz->exp_reward . ' EXP');
}

        return redirect()
        ->route('customer.quizzes.show', [$quiz->course_id, $quiz->id])
        ->with('error', 'Jawaban salah!');
}

public function show(Course $course, Quiz $quiz)
{
    $user = auth()->user();

    $enrollment = Enrollment::where('user_id', $user->id)
        ->where('course_id', $course->id)
        ->where('status', 'enrolled')
        ->firstOrFail();

    $quizzes = $course->quizzes()->get();

    // 🔥 ambil semua progress user
    $progress = QuizProgress::where('enrollment_id', $enrollment->id)
        ->get()
        ->keyBy('quiz_id');

    return view('customer.quizzes.show', compact(
        'course',
        'quiz',
        'quizzes',
        'progress',
        'enrollment'
    ));
}
}