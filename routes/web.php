<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BiodataController;
use App\Http\Controllers\PendudukController;
use App\Http\Controllers\PengajuanSuratController;
use App\Http\Controllers\VerifikasiPengajuanController;
use App\Http\Controllers\VerifikasiPengaduanController;
use App\Http\Controllers\PengaduanController;
use App\Http\Controllers\UserProfileController;

// ============================================
// LANDING PAGE - Public Access
// ============================================
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/welcome', function () {
    return view('welcome');
})->name('welcome.index');

// ============================================
// GUEST ROUTES - Hanya untuk yang belum login
// ============================================
Route::middleware(['guest'])->group(function () {
    // Login
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');

    // Register
    Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');

    // Social Login (Google, Discord, dll)
    Route::get('/auth/{provider}', [AuthController::class, 'redirect'])->name('sso.redirect');
    Route::get('/auth/{provider}/callback', [AuthController::class, 'callback'])->name('sso.callback');

    // Forgot Password
    Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('forgot_password.email_form');
    Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('forgot_password.send_link');

    // Reset Password
    Route::get('/password-reset/{token}', [AuthController::class, 'showResetPasswordForm'])->name('password.reset');
    Route::post('/password-reset', [AuthController::class, 'resetPassword'])->name('password.update');
});

// ============================================
// EMAIL VERIFICATION - Bisa diakses guest atau auth
// ============================================
Route::get('/verify-email', [AuthController::class, 'showVerifyForm'])->name('verify.form');
Route::post('/send-otp', [AuthController::class, 'sendOtp'])->name('send.otp');
Route::post('/verify-email', [AuthController::class, 'verify'])->name('verify.otp');

// ============================================
// FILE SERVING ROUTES - Require authentication
// ============================================
Route::middleware(['auth'])->group(function () {
    Route::get('/pengajuan/file/{filename}', [PengajuanSuratController::class, 'file'])->name('pengajuan.file');
    Route::get('/pengaduan/file/{filename}', [PengaduanController::class, 'file'])->name('pengaduan.file');
    Route::get('/pengaduan/download/{filename}', [PengaduanController::class, 'download'])->name('pengaduan.download');
});

// ============================================
// AUTHENTICATED ROUTES - Harus login
// ============================================
Route::middleware(['auth'])->group(function () {

    // Dashboard - Semua user yang login
    Route::get('/dashboard', function () {
        // Set common variables
        $name = Auth::user()->name;
        $role = ucfirst(Auth::user()->role);
        $avatar = Auth::user()->avatar ?? asset('assets/images/user/avatar-1.jpg');

        return view('dashboard', compact('name', 'role', 'avatar'));
    })->name('dashboard');

    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // ============================================
    // ADMIN ROUTES
    // ============================================
    Route::middleware(['cekRole:admin'])->group(function () {

        // Admin Dashboard
        Route::get('/admin/dashboard', function () {
            return view('admin.dashboard');
        })->name('admin.dashboard');

        // Data Penduduk CRUD (tanpa prefix - route utama untuk admin)
        Route::resource('penduduk', PendudukController::class);

        // Export Penduduk
        Route::get('/penduduk-export', [PendudukController::class, 'export'])->name('penduduk.export');

        // Verifikasi Pengajuan Surat
        Route::prefix('admin/pengajuan')->name('admin.pengajuan.')->group(function () {
            Route::get('/', [VerifikasiPengajuanController::class, 'index'])->name('index');
            Route::get('/{pengajuan}', [VerifikasiPengajuanController::class, 'show'])->name('show');
            Route::post('/{pengajuan}/proses', [VerifikasiPengajuanController::class, 'proses'])->name('proses');
            Route::post('/{pengajuan}/approve', [VerifikasiPengajuanController::class, 'approve'])->name('approve');
            Route::post('/{pengajuan}/reject', [VerifikasiPengajuanController::class, 'reject'])->name('reject');
            Route::post('/{pengajuan}/upload-surat', [VerifikasiPengajuanController::class, 'uploadSurat'])->name('upload-surat');
            Route::delete('/{pengajuan}/delete-surat', [VerifikasiPengajuanController::class, 'deleteSurat'])->name('delete-surat');
            Route::post('/bulk-action', [VerifikasiPengajuanController::class, 'bulkAction'])->name('bulk-action');
            // Pengajuan file serving route
            Route::get('/file/{filename}', [PengajuanSuratController::class, 'file'])->name('file');
        });

        // Verifikasi Pengaduan
        Route::prefix('admin/pengaduan')->name('admin.pengaduan.')->group(function () {
            Route::get('/', [VerifikasiPengaduanController::class, 'index'])->name('index');
            Route::get('/{pengaduan}', [VerifikasiPengaduanController::class, 'show'])->name('show');
            Route::post('/{pengaduan}/proses', [VerifikasiPengaduanController::class, 'proses'])->name('proses');
            Route::post('/{pengaduan}/tanggapi', [VerifikasiPengaduanController::class, 'tanggapi'])->name('tanggapi');
            Route::post('/{pengaduan}/selesai', [VerifikasiPengaduanController::class, 'selesai'])->name('selesai');
            Route::post('/{pengaduan}/tolak', [VerifikasiPengaduanController::class, 'tolak'])->name('tolak');
            Route::post('/{pengaduan}/update-prioritas', [VerifikasiPengaduanController::class, 'updatePrioritas'])->name('update-prioritas');
            Route::post('/bulk-action', [VerifikasiPengaduanController::class, 'bulkAction'])->name('bulk-action');
        });

        // Admin Menu Lainnya
        Route::prefix('admin')->name('admin.')->group(function () {
            Route::get('/verifikasi', function () {
                return view('admin.verifikasi');
            })->name('verifikasi');

            Route::get('/seleksi', function () {
                return view('admin.seleksi');
            })->name('seleksi');

            Route::get('/pengumuman', function () {
                return view('admin.pengumuman');
            })->name('pengumuman');

            Route::get('/laporan', function () {
                return view('admin.laporan');
            })->name('laporan');
        });
    });

    // ============================================
    // USER ROUTES
    // ============================================
    Route::middleware(['cekRole:user'])->group(function () {

        // Pengajuan Surat CRUD
        Route::resource('pengajuan', PengajuanSuratController::class);

        // Pengaduan CRUD (tanpa edit & update)

        // Debug route: list pengaduan file names (only for the authenticated user) and storage files
        Route::get('/pengaduan/debug-files', [PengaduanController::class, 'debugFiles'])->name('pengaduan.debug-files');

        Route::resource('pengaduan', PengaduanController::class)->except(['edit', 'update']);

        // Biodata
        Route::get('/biodata', [BiodataController::class, 'index'])->name('user.biodata');

        // My Profile (user)
        // Show profile (read-only)
        Route::get('/profile', [UserProfileController::class, 'show'])->name('user.profile.show');
        // Edit profile form
        Route::get('/profile/edit', [UserProfileController::class, 'edit'])->name('user.profile.edit');
        // Update profile
        Route::post('/profile', [UserProfileController::class, 'update'])->name('user.profile.update');
    });

});
