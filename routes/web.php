<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\EvaluationController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (auth()->check()) {
        $user = auth()->user();
        if ($user->hasRole('admin')) {
            return redirect()->route('admin.dashboard');
        }
        if ($user->hasRole('jawatankuasa')) {
            return redirect()->route('secretariat.dashboard');
        }
        return redirect()->route('dashboard');
    }
    return redirect()->route('login');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/admin/login', [AuthController::class, 'showAdminLogin'])->name('admin.login');
    Route::post('/admin/login', [AuthController::class, 'adminLogin']);
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function (Illuminate\Http\Request $request) {
        $sessionName = $request->query('session');
        if (! in_array($sessionName, ['HARI_1', 'HARI_2'])) {
            $sessionName = \Illuminate\Support\Facades\Cache::get('global_active_session', 'HARI_1');
        }
        return view('dashboard', [
            'user' => auth()->user(),
            'activeSession' => $sessionName
        ]);
    })->name('dashboard');

    Route::post('/attendance/qrcode', [AttendanceController::class, 'generateQR'])->name('attendance.qrcode');

    Route::get('/evaluation', [EvaluationController::class, 'showForm'])->name('evaluation.form');
    Route::post('/evaluation', [EvaluationController::class, 'store'])->name('evaluation.store');

    Route::get('/dashboard/certificate/download', [CertificateController::class, 'download'])->name('certificate.download');

    Route::get('/itinerary', function () {
        return view('participant.itinerary', ['user' => auth()->user()]);
    })->name('participant.itinerary');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

use App\Http\Middleware\CheckJawatankuasa;

// Secure secretariat route group enforcing auth and CheckJawatankuasa middleware
Route::middleware(['auth', CheckJawatankuasa::class])->group(function () {
    Route::get('/secretariat/dashboard', function () {
        return view('secretariat.dashboard');
    })->name('secretariat.dashboard');

    Route::get('/attendance/scan/{user}/{session_name}', [AttendanceController::class, 'scanCheckIn'])
        ->name('attendance.scan')
        ->middleware('signed');

    Route::patch('/secretariat/users/{id}/doorgift', [AttendanceController::class, 'setDoorgift'])
        ->name('secretariat.users.doorgift');
});

use App\Http\Controllers\AdminController;
use App\Http\Middleware\CheckAdmin;

// Secure admin route group enforcing auth and CheckAdmin middleware
Route::middleware(['auth', CheckAdmin::class])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    
    // Attendance Management Dashboard (session-scoped)
    Route::get('/admin/attendance-records', [\App\Http\Controllers\AdminAttendanceController::class, 'index'])->name('admin.attendance.index');
    Route::post('/admin/attendance-records', [\App\Http\Controllers\AdminAttendanceController::class, 'store'])->name('admin.attendance.store');
    Route::put('/admin/attendance-records/{attendance}', [\App\Http\Controllers\AdminAttendanceController::class, 'update'])->name('admin.attendance.update');
    Route::delete('/admin/attendance-records/{attendance}', [\App\Http\Controllers\AdminAttendanceController::class, 'destroy'])->name('admin.attendance.destroy');
    Route::get('/admin/attendance-records/export-pdf', [AdminController::class, 'exportAttendancePdf'])->name('admin.attendance.export-pdf');

    // CRUD route stubs
    Route::get('/admin/users', [AdminController::class, 'indexUsers'])->name('admin.users.index');
    Route::post('/admin/users', [AdminController::class, 'storeUser'])->name('admin.users.store');
    Route::put('/admin/users/{id}', [AdminController::class, 'updateUser'])->name('admin.users.update');
    Route::delete('/admin/users/{id}', [AdminController::class, 'destroyUser'])->name('admin.users.destroy');
    Route::patch('/admin/users/{id}/doorgift', [AdminController::class, 'setDoorgift'])
        ->name('admin.users.doorgift');

    // Evaluation analytics and export
    Route::get('/admin/evaluation/analytics', [AdminController::class, 'evaluationAnalytics'])->name('admin.evaluation.analytics');
    Route::get('/admin/evaluation/export', [AdminController::class, 'exportCsv'])->name('admin.evaluation.export');
    Route::post('/admin/evaluation/toggle', [AdminController::class, 'toggleEvaluation'])->name('admin.evaluation.toggle');

    // Global session toggle
    Route::post('/admin/settings/toggle-session', [AdminController::class, 'toggleGlobalSession'])->name('admin.settings.toggle-session');
});

