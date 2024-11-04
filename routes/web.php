<?php

use App\Helpers\PeriodHelper;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CourseClassController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DashboardProdiController;
use App\Http\Controllers\DepartmentAdminController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\FacultyController;
use App\Http\Controllers\PelaporanAdminController;
use App\Http\Controllers\PelaporanProdiController;
use App\Http\Controllers\PeriodController;
use App\Http\Controllers\ProfileController;
use Illuminate\Http\Request;
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
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/dashboard/submissions-by-department', [DashboardController::class, 'getSubmissionsByDepartment'])->name('dashboard.getSubmissionsByDepartment');
    Route::get('/dashboard/iku-data', [DashboardController::class, 'getIKUDataByFaculty'])->name('dashboard.getIKUDataByFaculty');
    Route::post('/dashboard/iku-data-by-department', [DashboardController::class, 'getIKUDataByDepartment'])->name('dashboard.getIKUDataByDepartment');

    Route::get('/dashboard/program-studi', [DashboardProdiController::class, 'index'])->name('dashboard-program-studi.index');

    Route::get('/administrator', [AdminController::class, 'index'])->middleware('password.confirm')->name('dashboard.administrator.index');
    Route::resource('/administrator', AdminController::class)->names('dashboard.administrator')->except('index');
    
    Route::resource('/mata-kuliah', CourseController::class)->names('dashboard.mata-kuliah')->except('create', 'edit');
    Route::resource('/pelaporan', PelaporanProdiController::class)->names('dashboard.pelaporan-prodi')->except('create', 'destroy');
    Route::get('/pelaporan/{pelaporan}/edit-bobot', [PelaporanProdiController::class, 'editBobot'])->name('dashboard.pelaporan-prodi.edit-bobot');
    Route::put('/pelaporan/{pelaporan}/update-bobot', [PelaporanProdiController::class, 'updateBobot'])->name('dashboard.pelaporan-prodi.update-bobot');
    Route::get('/pelaporan/{pelaporan}/edit-deskripsi', [PelaporanProdiController::class, 'editDeskripsi'])->name('dashboard.pelaporan-prodi.edit-deskripsi');
    Route::put('/pelaporan/{pelaporan}/update-deskripsi', [PelaporanProdiController::class, 'updateDeskripsi'])->name('dashboard.pelaporan-prodi.update-deskripsi');
    Route::put('/pelaporan/{pelaporan}/update-rps', [PelaporanProdiController::class, 'updateRPS'])->name('dashboard.pelaporan-prodi.update-rps');
    Route::post('/pelaporan/{mata_kuliah}/input-bobot', [PelaporanProdiController::class, 'inputBobot'])->name('dashboard.pelaporan-prodi.input-bobot');
    Route::post('/pelaporan/{mata_kuliah}/input-deskripsi', [PelaporanProdiController::class, 'inputDeskripsi'])->name('dashboard.pelaporan-prodi.input-deskripsi');
    Route::get('/pelaporan/view/{daftar_pelaporan}', [PelaporanProdiController::class, 'view'])->name('dashboard.pelaporan-prodi.view');

    Route::resource('/daftar-pelaporan', PelaporanAdminController::class)->names('dashboard.pelaporan-admin')->except('create', 'edit');
    Route::put('/daftar-pelaporan/{daftar_pelaporan}/update-verifikasi', [PelaporanAdminController::class, 'updateVerifikasi'])->name('dashboard.pelaporan-admin.update-verifikasi');
    Route::get('/daftar-pelaporan/view/{daftar_pelaporan}', [PelaporanAdminController::class, 'view'])->name('dashboard.pelaporan-admin.view');
    Route::resource('/periode', PeriodController::class)->names('dashboard.periode');
    Route::resource('/fakultas', FacultyController::class)->names('dashboard.fakultas')->except('create', 'edit');
    Route::resource('/program-studi', DepartmentController::class)->names('dashboard.prodi')->except('create', 'edit', 'show');
    Route::resource('/admin-program-studi', DepartmentAdminController::class)->names('dashboard.admin-prodi');
    Route::put('/admin-program-studi/{program_studi}/status', [DepartmentAdminController::class, 'updateStatus'])->name('dashboard.admin-prodi.update-status');
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile/admin', [ProfileController::class, 'update_admin'])->name('profile.update.admin');
    Route::patch('/profile/student', [ProfileController::class, 'update_student'])->name('profile.update.student');
    Route::patch('/profile/lecturer', [ProfileController::class, 'update_lecturer'])->name('profile.update.lecturer');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/update-period/{id}', function (Request $request, $id) {
        PeriodHelper::setCurrentPeriod($id);
        return response()->json(['message' => 'Period updated successfully']);
    })->name('update-period');

    // Comming Soon
    Route::get('/kelas-mata-kuliah', [CourseClassController::class, 'index'])->name('dashboard.kelas-mata-kuliah.index');
    Route::get('/kelas-mata-kuliah/daftar-nilai', [CourseClassController::class, 'index'])->name('dashboard.kelas-mata-kuliah.daftar-nilai.index');
});

require __DIR__ . '/auth.php';
