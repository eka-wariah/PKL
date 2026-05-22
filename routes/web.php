<?php

use App\Http\Controllers\comitte\AcademicYearController;
use App\Http\Controllers\comitte\ClassesController;
use App\Http\Controllers\comitte\DashboardController;
use App\Http\Controllers\comitte\MajorController;
use App\Http\Controllers\comitte\StudentController;
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

    Route::prefix('student')->name('student.')->group(function () {
        Route::get('/', [StudentController::class, 'index'])->name('index');
        Route::get('/create', [StudentController::class, 'create'])->name('create');
        Route::post('/create', [StudentController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [StudentController::class, 'edit'])->name('edit');
        Route::post('/{id}/edit', [StudentController::class, 'update'])->name('update');
        Route::delete('/{id}/destroy', [StudentController::class, 'destroy'])->name('destroy');
    });
    Route::prefix('academic-years')->name('academic_years.')->group(function () {
        Route::get('/', [AcademicYearController::class, 'index'])->name('academic_years');
        Route::get('/create', [AcademicYearController::class, 'create'])->name('academic_years.create');
        Route::post('/create', [AcademicYearController::class, 'store'])->name('academic_years.store');
        Route::get('/{id}/edit', [AcademicYearController::class, 'edit'])->name('academic_years.edit');
        Route::post('/{id}/edit', [AcademicYearController::class, 'update'])->name('academic_years.update');
        Route::delete('/{id}/destroy', [AcademicYearController::class, 'destroy'])->name('academic_years.destroy');
    });
    Route::prefix('major')->name('major.')->group(function () {
        Route::get('/', [MajorController::class, 'index'])->name('index');
        Route::get('/create', [MajorController::class, 'create'])->name('create');
        Route::post('/create', [MajorController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [MajorController::class, 'edit'])->name('edit');
        Route::post('/{id}/edit', [MajorController::class, 'update'])->name('update');
        Route::delete('/{id}/destroy', [MajorController::class, 'destroy'])->name('destroy');
    });
    Route::prefix('classes')->name('classes.')->group(function () {
        Route::get('/', [ClassesController::class, 'index'])->name('classes');
        Route::get('/{id}/students', [ClassesController::class, 'students'])->name('students');
        Route::get('/create', [ClassesController::class, 'create'])->name('classes.create');
        Route::post('/create', [ClassesController::class, 'store'])->name('classes.store');
        Route::get('/{id}/edit', [ClassesController::class, 'edit'])->name('classes.edit');
        Route::post('/{id}/edit', [ClassesController::class, 'update'])->name('classes.update');
        Route::delete('/{id}/destroy', [ClassesController::class, 'destroy'])->name('classes.destroy');
    });
});

Route::prefix('mentor')->name('mentor.')->group(function () {
    Route::get('/', [MentorDashboardController::class, 'index'])->name('index');
});

Route::prefix('student')->name('student.')->group(function () {
    Route::get('/', [StudentDashboardController::class, 'index'])->name('index');
});

require __DIR__.'/auth.php';
