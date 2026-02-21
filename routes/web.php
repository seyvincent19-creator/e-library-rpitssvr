<?php

use App\Http\Controllers\AnalyticController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BorrowController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DegreeController;
use App\Http\Controllers\LecturerController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\ReturnController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SupportController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserBookController;
use App\Http\Controllers\UserDashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');






// AuthController
Route::controller(AuthController::class)->group(function () {

    Route::get('/login', 'login')->name('login');
    Route::post('/login', 'loginAction')->name('login.action');
    Route::post('/logout', 'logout')->middleware('auth')->name('logout');


    Route::prefix('registration')->group(function () {
        Route::get('/', function () {
            return view('layout/user/registration/index');
        })->name('registration');

        Route::get('/student', [StudentController::class, 'registration_student']);
        Route::post('/student', [StudentController::class, 'store_registration']);

        Route::get('/lecturer', [LecturerController::class, 'registration_lecturer']);
        Route::post('/lecturer', [LecturerController::class, 'store_registration']);

        // Plain user self-registration — skip student/lecturer form
        Route::get('/user', function () {
            session(['registration_type' => 'user']);
            return redirect()->route('register');
        })->name('registration.user');

        // Middleware Before register
        Route::middleware('registration.complete')->group(function () {

            Route::get('/register', 'register')->name('register');
            Route::post('/register', 'registerSave')->name('register.save');

        });


    });



});



// Ajax Api with Javascript
Route::get('/get-majors/{degree}', [StudentController::class, 'getMajor']);
Route::get('/get-study_time/{degree}/{majors}', [StudentController::class, 'getStudyTime']);
Route::get('/get-degree-id/{degree}/{majors}/{study_time}', [StudentController::class, 'getDegreeId']);






// ─── User-facing Routes ──────────────────────────────────────────────────────
Route::prefix('user')->name('user.')->group(function () {

    // Public: browse books
    Route::get('/books', [UserBookController::class, 'index'])->name('books.index');

    // Auth required
    Route::middleware('auth')->group(function () {
        Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');
        Route::get('/books/{id}/download', [UserBookController::class, 'download'])->name('books.download');
    });

});



// Middleware
Route::middleware('auth', 'role:admin,librarian')->group(function () {

    Route::prefix('admin')->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.admin');


       Route::resource('member', MemberController::class);

       Route::resource('attendance', AttendanceController::class);

       Route::resource('manage_book', BookController::class);
       Route::get('/manage_book/{id}/download', [BookController::class, 'download'])->name('manage_book.download');

       Route::resource('borrow_book', BorrowController::class);

       Route::resource('return_book', ReturnController::class);

       Route::resource('student', StudentController::class);

       Route::resource('lecturer', LecturerController::class);

       // User management (AuthController)
        Route::controller(AuthController::class)->group(function () {
            Route::get('/user', 'index')->name('user.index');
            Route::get('/user/create', 'create')->name('user.create');
            Route::post('/user', 'store')->name('user.store');
            Route::get('/user/{id}', 'show')->name('user.show');
            Route::get('/user/{id}/edit', 'edit')->name('user.edit');
            Route::put('/user/{id}', 'update')->name('user.update');
            Route::delete('/user/{id}', 'destroy')->name('user.destroy');
        });


        Route::controller(AnalyticController::class)->group(function () {
            Route::get('/analytic', 'index')->name('analytic');

        });

        Route::resource('degree', DegreeController::class);

        Route::get('/setting', [SettingController::class, 'index'])->name('setting');
        Route::get('/support', [SupportController::class, 'index'])->name('support');

    });
});
