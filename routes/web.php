<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\FacultyController;
use App\Http\Controllers\HeadOfDepartmentController;
use App\Http\Controllers\LecturerController;
use App\Http\Controllers\PelaporanAdminController;
use App\Http\Controllers\PelaporanProdiController;
use App\Http\Controllers\PeriodController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentChartController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubmissionChartController;
use App\Http\Controllers\SubmissionController;
use App\Http\Controllers\SubmissionStudentController;
use App\Models\Faculty;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if(!auth()->check()) {
        return view('auth.login');
    } elseif (auth()->user()->role == 'admin' || auth()->user()->role == 'super-admin'){
        return redirect()->route('dashboard');
    } elseif (auth()->user()->role == 'admin-prodi'){
        return redirect()->route('dashboard.pelaporan-prodi.index');
    } else {
        abort(403);
    }
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/administrator', [AdminController::class, 'index'])->middleware('password.confirm')->name('dashboard.administrator.index');
    Route::resource('/administrator', AdminController::class)->names('dashboard.administrator')->except('index');
    
    Route::resource('/pelaporan', PelaporanProdiController::class)->names('dashboard.pelaporan-prodi');
    Route::resource('/daftar-pelaporan', PelaporanAdminController::class)->names('dashboard.pelaporan-admin');
    Route::resource('/periode', PeriodController::class)->names('dashboard.periode');
    Route::resource('/fakultas', FacultyController::class)->names('dashboard.fakultas')->except('create', 'edit');
    Route::resource('/program-studi', DepartmentController::class)->names('dashboard.prodi');
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile/admin', [ProfileController::class, 'update_admin'])->name('profile.update.admin');
    Route::patch('/profile/student', [ProfileController::class, 'update_student'])->name('profile.update.student');
    Route::patch('/profile/lecturer', [ProfileController::class, 'update_lecturer'])->name('profile.update.lecturer');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';