<?php

use App\Http\Controllers\comitte\AcademicYearController;
use App\Http\Controllers\comitte\ClassesController;
use App\Http\Controllers\comitte\CompanyController;
use App\Http\Controllers\comitte\DashboardController;
use App\Http\Controllers\comitte\TeacherController;
use App\Http\Controllers\comitte\MajorController;
use App\Http\Controllers\comitte\StudentController;
use App\Http\Controllers\Mentor\DashboardController as MentorDashboardController;
use App\Http\Controllers\Mentor\GuidanceController;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Student\DashboardController as StudentDashboardController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/dashboard', function () {
    // dd(Auth::user()->hasRole('mentor') );
    if(Auth::user()->hasRole('comitte')){
       return redirect(route('comitte.index'));
    }else if(Auth::user()->hasRole('mentor')){
       return redirect(route('mentor.index'));
    }else{
       return redirect(route('student.index'));

    }

})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::middleware(['auth', 'role:comitte'])->group(function () {
    Route::prefix('comitte')->name('comitte.')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('index');

        Route::prefix('teacher')->name('teacher.')->group(function () {
            Route::get('/template', [TeacherController::class, 'downloadTemplate'])->name('template');
            Route::get('/', [TeacherController::class, 'index'])->name('index');
            Route::get('/create', [TeacherController::class, 'create'])->name('create');
            Route::post('/create', [TeacherController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [TeacherController::class, 'edit'])->name('edit');
            Route::put('/{id}/edit', [TeacherController::class, 'update'])->name('update');
            Route::get('/{id}/edit-password', [TeacherController::class, 'editPassword'])->name('editPassword');
            Route::put('/{id}/edit-password', [TeacherController::class, 'updatePassword'])->name('editPassword');
            Route::delete('/{id}/destroy', [TeacherController::class, 'destroy'])->name('destroy');
            Route::get('/{id}/mentee', [TeacherController::class, 'mentee'])->name('mentee');
            Route::get('/{id}/mentee/create', [TeacherController::class, 'createMentee'])->name('mentee.create');
            Route::post('/{id}/mentee/create', [TeacherController::class, 'storeMentee'])->name('mentee.store');
            Route::get('/import', [TeacherController::class, 'importPage'])->name('importPage');
            Route::post('/import', [TeacherController::class, 'import'])->name('import');
            Route::resource('/', TeacherController::class);
        });
        Route::prefix('student')->name('student.')->group(function () {
            Route::get('/', [StudentController::class, 'index'])->name('index');
            Route::get('/create', [StudentController::class, 'create'])->name('create');
            Route::post('/create', [StudentController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [StudentController::class, 'edit'])->name('edit');
            Route::post('/{id}/edit', [StudentController::class, 'update'])->name('update');
            Route::get('/{id}/detail', [StudentController::class, 'show'])->name('detail');
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
        // Route::prefix('student')->name('student.')->group(function () {
        //     Route::get('/', [StudentController::class, 'index'])->name('index');
        //     Route::get('/create', [StudentController::class, 'create'])->name('create');
        //     Route::post('/create', [StudentController::class, 'store'])->name('store');
        //     Route::get('/{id}/edit', [StudentController::class, 'edit'])->name('edit');
        //     Route::post('/{id}/edit', [StudentController::class, 'update'])->name('update');
        //     Route::delete('/{id}/destroy', [StudentController::class, 'destroy'])->name('destroy');
        // });
        Route::prefix('company')->name('company.')->group(function () {
            Route::get('/', [CompanyController::class, 'index'])->name('index');
            Route::get('/create', [CompanyController::class, 'create'])->name('create');
            Route::post('/create', [CompanyController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [CompanyController::class, 'edit'])->name('edit');
            Route::post('/{id}/edit', [CompanyController::class, 'update'])->name('update');
            Route::get('/{id}/detail', [CompanyController::class, 'detail'])->name('detail');
            Route::delete('/{id}/destroy', [CompanyController::class, 'destroy'])->name('destroy');
        });
    });


    Route::prefix('student')->name('student.')->group(function () {
        Route::get('/', [StudentController::class, 'index'])->name('index');
        Route::get('/create', [StudentController::class, 'create'])->name('create');
        Route::post('/create', [StudentController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [StudentController::class, 'edit'])->name('edit');
        Route::post('/{id}/edit', [StudentController::class, 'update'])->name('update');
        Route::get('/{id}/detail', [StudentController::class, 'show'])->name('detail');
        Route::delete('/{id}/destroy', [StudentController::class, 'destroy'])->name('destroy');
        Route::get('/import', [StudentController::class, 'importPage'])->name('importPage');
        Route::post('/import', [StudentController::class, 'import'])->name('import');
        Route::get('/template', [StudentController::class, 'downloadTemplate'])->name('template');
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
    // Route::prefix('student')->name('student.')->group(function () {
    //     Route::get('/', [StudentController::class, 'index'])->name('index');
    //     Route::get('/create', [StudentController::class, 'create'])->name('create');
    //     Route::post('/create', [StudentController::class, 'store'])->name('store');
    //     Route::get('/{id}/edit', [StudentController::class, 'edit'])->name('edit');
    //     Route::post('/{id}/edit', [StudentController::class, 'update'])->name('update');
    //     Route::delete('/{id}/destroy', [StudentController::class, 'destroy'])->name('destroy');
    // });
    Route::prefix('company')->name('company.')->group(function () {
        Route::get('/', [CompanyController::class, 'index'])->name('index');
        Route::get('/create', [CompanyController::class, 'create'])->name('create');
        Route::post('/create', [CompanyController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [CompanyController::class, 'edit'])->name('edit');
        Route::post('/{id}/edit', [CompanyController::class, 'update'])->name('update');
        Route::get('/{id}/detail', [CompanyController::class, 'detail'])->name('detail');
        Route::delete('/{id}/destroy', [CompanyController::class, 'destroy'])->name('destroy');
    });


});


Route::middleware(['auth', 'role:mentor'])->group(function () {
    Route::prefix('mentor')->name('mentor.')->group(function () {
        Route::get('/', [MentorDashboardController::class, 'index'])->name('index');
        Route::prefix('guidance')->name('guidance.')->group(function () {

            Route::get('/', [GuidanceController::class, 'index'])->name('index');
            Route::get('/create', [GuidanceController::class, 'create'])->name('create');
            Route::post('/create', [GuidanceController::class, 'store'])->name('store');
            Route::get('/{id}/show', [GuidanceController::class, 'show'])->name('show');
            Route::get('/{id}/follow-up', [GuidanceController::class, 'followUp'])->name('followUp');
            Route::post('/{id}/follow-up', [GuidanceController::class, 'followUpStore'])->name('followUpStore');


        });

    });
});
Route::prefix('student')->name('student.')->group(function () {
    Route::get('/', [StudentDashboardController::class, 'index'])->name('index');
});

require __DIR__ . '/auth.php';
