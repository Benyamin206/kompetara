<?php

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\CustomerCourseDashboardController;
use App\Http\Controllers\CustomerQuizController;
use App\Http\Controllers\OwnerCourseDashboardController;
use App\Http\Controllers\OwnerQuizController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OwnerCourseController;
use App\Http\Controllers\OwnerMaterialController;
use App\Http\Controllers\OwnerEnrollController;
use App\Http\Controllers\CustomerCourseController;
use App\Http\Controllers\CustomerEnrollController;
use App\Http\Controllers\CustomerMaterialController;

Route::get('/', function () {
    return view('welcome');
});


// 🔥 ROUTE KHUSUS ROLE (SUDAH DIAMANKAN)
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/', function () {
        return view('admin.home');
    });

    Route::get('/users', [UserController::class, 'index']);
    Route::get('/users/create', [UserController::class, 'create']);
    Route::post('/users', [UserController::class, 'store']);
    Route::get('/users/{id}/toggle', [UserController::class, 'toggle']);
});




Route::middleware(['auth', 'role:pemilik_course'])
    ->prefix('owner')
    ->name('owner.')
    ->group(function () {

    Route::get('/dashboard', [OwnerCourseDashboardController::class, 'index'])
        ->name('dashboard');

    Route::get('/courses/create', [OwnerCourseController::class, 'create'])
        ->name('courses.create');

    Route::post('/courses', [OwnerCourseController::class, 'store'])
        ->name('courses.store');

    Route::get('/courses/{course}/materials', [OwnerMaterialController::class, 'index'])
        ->name('materials.index');

    Route::get('/courses/{course}/materials/create', [OwnerMaterialController::class, 'create'])
        ->name('materials.create');

    Route::post('/courses/{course}/materials', [OwnerMaterialController::class, 'store'])
        ->name('materials.store');

    Route::get('/courses/{course}/enrollments', [OwnerEnrollController::class, 'index'])
        ->name('enrollments.index');

    Route::post('/enrollments/{enrollment}/approve', [OwnerEnrollController::class, 'approve'])
        ->name('enrollments.approve');

    Route::get('/materials/{material}/edit', [OwnerMaterialController::class, 'edit'])
        ->name('materials.edit');

    Route::put('/materials/{material}', [OwnerMaterialController::class, 'update'])
        ->name('materials.update');

    Route::delete('/materials/{material}', [OwnerMaterialController::class, 'destroy'])
        ->name('materials.destroy');

    Route::post('/materials/reorder', [OwnerMaterialController::class, 'reorder'])
        ->name('materials.reorder');

    Route::get('/materials/{material}/preview', [OwnerMaterialController::class, 'preview'])
        ->name('materials.preview');

    Route::get('/courses/{course}/quizzes', [OwnerQuizController::class, 'index'])
    ->name('quizzes.index');

    Route::get('/courses/{course}/quizzes/create', [OwnerQuizController::class, 'create'])
        ->name('quizzes.create');

    Route::post('/courses/{course}/quizzes', [OwnerQuizController::class, 'store'])
        ->name('quizzes.store');

    Route::get('/quizzes/{quiz}/edit', [OwnerQuizController::class, 'edit'])
    ->name('quizzes.edit');

    Route::put('/quizzes/{quiz}', [OwnerQuizController::class, 'update'])
        ->name('quizzes.update');

    Route::delete('/quizzes/{quiz}', [OwnerQuizController::class, 'destroy'])
        ->name('quizzes.destroy');

    Route::get('/courses/{course}/edit', [OwnerCourseController::class, 'edit'])
    ->name('courses.edit');

    Route::put('/courses/{course}', [OwnerCourseController::class, 'update'])
        ->name('courses.update');
});




Route::middleware(['auth', 'role:customer'])
    ->prefix('customer')
    ->name('customer.')
    ->group(function () {

    Route::get('/dashboard', [CustomerCourseDashboardController::class, 'index'])
        ->name('dashboard');

    Route::post('/courses/{course}/enroll', [CustomerEnrollController::class, 'store'])
        ->name('enroll.store');

    Route::get('/courses/{course}/materials', [CustomerMaterialController::class, 'index'])
        ->name('materials.index');

    Route::get('/courses/{course}/materials/{material}', [CustomerMaterialController::class, 'show'])
        ->name('materials.show');

    Route::post('/courses/{course}/materials/{material}/complete', [CustomerMaterialController::class, 'complete'])
        ->name('materials.complete');

    Route::get('/courses/{course}/quizzes', [CustomerQuizController::class, 'index'])
        ->name('quizzes.index');

    Route::post('/quizzes/{quiz}/answer', [CustomerQuizController::class, 'answer'])
        ->name('quizzes.answer');

    Route::get('/courses/{course}/quizzes/{quiz}', [CustomerQuizController::class, 'show'])
    ->name('quizzes.show');
});


// route bawaan dashboard
// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

    // ======================
    // DASHBOARD ROLE SWITCH
    // ======================
    // Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/dashboard', function () {
    $user = auth()->user();

    return match ($user->role->nama_role) {
        'pemilik_course' => redirect()->route('owner.dashboard'),
        'customer' => redirect()->route('customer.dashboard'),
        'admin' => redirect()->route('admin.home'),
        default => abort(403),
    };
})->middleware(['auth'])->name('dashboard');

// profile route
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';