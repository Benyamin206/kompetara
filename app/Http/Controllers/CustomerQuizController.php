<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Quiz;
use App\Models\Enrollment;
use App\Models\QuizProgress;
use Illuminate\Http\Request;
use App\Models\QuizOption;

class CustomerQuizController extends Controller
{
    public function index(Course $course)
    {
        $user = auth()->user();

        $enrollment = Enrollment::where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->where('status', 'enrolled')
            ->firstOrFail();

        // $quizzes = $course->quizzes;
        // $quizzes = $course->quizzes()->with('images')->get();

        $quizzes = $course->quizzes()
    ->with(['images', 'options'])
    ->get();

        $progress = QuizProgress::where('enrollment_id', $enrollment->id)
    ->where('is_correct', true)
    ->pluck('quiz_id')
    ->toArray();

        //return view('customer.quizzes.index', compact('course', 'quizzes', 'enrollment'));
        return view('customer.quizzes.index', compact('course', 'quizzes', 'enrollment', 'progress'));
    }

public function answer(Request $request, Quiz $quiz)
{
    $user = auth()->user();

    $enrollment = Enrollment::where('user_id', $user->id)
        ->where('course_id', $quiz->course_id)
        ->firstOrFail();

    // 🔥 cek sudah benar sebelumnya
    $alreadyCorrect = QuizProgress::where('enrollment_id', $enrollment->id)
        ->where('quiz_id', $quiz->id)
        ->where('is_correct', true)
        ->exists();

    if ($alreadyCorrect) {
        return back()->with('error', 'Quiz sudah pernah dijawab dengan benar.');
    }

    $isCorrect = false;

    /*
    |--------------------------------------------------------------------------
    | ESSAY QUIZ
    |--------------------------------------------------------------------------
    */
    if ($quiz->type === 'essay') {

        $request->validate([
            'answer' => 'required|string'
        ]);

        $isCorrect =
            strtolower(trim($request->answer))
            === strtolower(trim($quiz->correct_answer));
    }

    /*
    |--------------------------------------------------------------------------
    | MULTIPLE CHOICE
    |--------------------------------------------------------------------------
    */
    if ($quiz->type === 'multiple_choice') {

        $request->validate([
            'option_id' => 'required|exists:quiz_options,id'
        ]);

        $selectedOption = QuizOption::where('quiz_id', $quiz->id)
            ->where('id', $request->option_id)
            ->first();

        if (!$selectedOption) {
            return back()->with('error', 'Pilihan tidak valid.');
        }

        $isCorrect = $selectedOption->is_correct;
    }

    // 🔥 simpan progress
    QuizProgress::create([
        'enrollment_id' => $enrollment->id,
        'quiz_id' => $quiz->id,
        'is_correct' => $isCorrect,
        'answered_at' => now(),
    ]);

    /*
    |--------------------------------------------------------------------------
    | GIVE EXP
    |--------------------------------------------------------------------------
    */
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

        // OPTIONAL LEVEL SYSTEM
        $profile->level = floor($profile->total_exp / 100) + 1;

        $profile->save();

        return redirect()
            ->route('customer.quizzes.show', [$quiz->course_id, $quiz->id])
            ->with('success', 'Jawaban benar! +' . $quiz->exp_reward . ' EXP');
    }

    return redirect()
        ->route('customer.quizzes.show', [$quiz->course_id, $quiz->id])
        ->with('error', 'Jawaban salah!');
}


// public function answer(Request $request, Quiz $quiz)
// {
//     $request->validate([
//         'answer' => 'required|string'
//     ]);

//     $user = auth()->user();

//     $enrollment = Enrollment::where('user_id', $user->id)
//         ->where('course_id', $quiz->course_id)
//         ->firstOrFail();

//     // 🔥 CEK: apakah sudah pernah jawab BENAR
//     $alreadyCorrect = QuizProgress::where('enrollment_id', $enrollment->id)
//         ->where('quiz_id', $quiz->id)
//         ->where('is_correct', true)
//         ->exists();

//     if ($alreadyCorrect) {
//         return back()->with('error', 'Quiz sudah pernah dijawab dengan benar.');
//     }

//     $isCorrect = strtolower(trim($request->answer)) === strtolower(trim($quiz->correct_answer));

//     // 🔥 simpan progress
//     QuizProgress::create([
//         'enrollment_id' => $enrollment->id,
//         'quiz_id' => $quiz->id,
//         'is_correct' => $isCorrect,
//         'answered_at' => now(),
//     ]);

// if ($isCorrect) {

//     $profile = $user->customerProfile;

//     if (!$profile) {
//         $profile = \App\Models\CustomerProfile::create([
//             'user_id' => $user->id,
//             'total_exp' => 0,
//             'level' => 1,
//         ]);
//     }

//     $profile->total_exp += $quiz->exp_reward;
//     $profile->save();

//     return redirect()
//         ->route('customer.quizzes.show', [$quiz->course_id, $quiz->id])
//         ->with('success', 'Jawaban benar! +' . $quiz->exp_reward . ' EXP');
// }

//         return redirect()
//         ->route('customer.quizzes.show', [$quiz->course_id, $quiz->id])
//         ->with('error', 'Jawaban salah!');
// }

public function show(Course $course, Quiz $quiz)
{
    $user = auth()->user();

    $enrollment = Enrollment::where('user_id', $user->id)
        ->where('course_id', $course->id)
        ->where('status', 'enrolled')
        ->firstOrFail();

    // $quizzes = $course->quizzes()->get();

    // $quizzes = $course->quizzes()->with('images')->get();
    $quizzes = $course->quizzes()
    ->with(['images', 'options'])
    ->get();

    // 🔥 ambil semua progress user
    $progress = QuizProgress::where('enrollment_id', $enrollment->id)
        ->get()
        ->keyBy('quiz_id');


        // $quiz->load('images');

        $quiz->load(['images', 'options']);
        
    return view('customer.quizzes.show', compact(
        'course',
        'quiz',
        'quizzes',
        'progress',
        'enrollment'
    ));
}
}