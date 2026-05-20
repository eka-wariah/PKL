<?php

use App\Http\Controllers\comitte\DashboardController;
use App\Http\Controllers\comitte\TeacherController;
use App\Http\Controllers\Mentor\DashboardController as MentorDashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Student\DashboardController as StudentDashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::prefix('comitte')->name('comitte.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('index');


    Route::prefix('teacher')->name('teacher.')->group(function () {
        Route::get('/', [TeacherController::class, 'index'])->name('index');
        Route::get('/create', [TeacherController::class, 'create'])->name('create');
        Route::post('/create', [TeacherController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [TeacherController::class, 'edit'])->name('edit');
        Route::put('/{id}/edit', [TeacherController::class, 'update'])->name('update');




       
    });


});

Route::prefix('mentor')->name('mentor.')->group(function () {
    Route::get('/', [MentorDashboardController::class, 'index'])->name('index');

});

Route::prefix('student')->name('student.')->group(function () {
    Route::get('/', [StudentDashboardController::class, 'index'])->name('index');
});

require __DIR__.'/auth.php';
