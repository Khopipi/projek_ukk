<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BiodataController;
use App\Http\Controllers\PendudukController;
use App\Http\Controllers\PengajuanSuratController;
use App\Http\Controllers\VerifikasiPengajuanController;
use App\Http\Controllers\PengaduanController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/contact-us', function () {
    return view('contact');
});

Route::get('/verify-email', [AuthController::class, 'showVerifyForm'])->name('verify.form');

Route::post('/send-otp', [AuthController::class, 'sendOtp'])->name('send.otp');

Route::post('/verify-email', [AuthController::class, 'verify'])->name('verify.otp');

// Route yang hanya bisa diakses oleh user yang belum login
Route::middleware(['guest'])->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');

    Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');

    Route::get('/auth/{provider}', [AuthController::class, 'redirect'])->name('sso.redirect');
    Route::get('/auth/{provider}/callback', [AuthController::class, 'callback'])->name('sso.callback');

    // Request reset link
    Route::get('/forgot-password', [AuthController::class, 'showRequestForm'])->name('forgot_password.email_form');
    Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('forgot_password.send_link');

    // Reset password form
    Route::get('/password-reset/{token}', [AuthController::class, 'showResetForm'])->name('password.reset');
    Route::post('/password-reset', [AuthController::class, 'resetPassword'])->name('password.update');
});

// Route yang hanya bisa diakses oleh user yang sudah login
Route::middleware(['auth', 'web'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/myprofile', function () {
        return view('myprofile');
    });

    // Admin routes
    Route::middleware(['cekRole:admin'])->group(function () {
        // Data Penduduk CRUD
        Route::resource('penduduk', PendudukController::class);
        
        // Export Penduduk (optional)
        Route::get('/penduduk-export', [PendudukController::class, 'export'])->name('penduduk.export');

        // Verifikasi Pengajuan Surat dari User
        Route::prefix('admin/pengajuan')->name('admin.pengajuan.')->group(function () {
            Route::get('/', [VerifikasiPengajuanController::class, 'index'])->name('index');
            Route::get('/{pengajuan}', [VerifikasiPengajuanController::class, 'show'])->name('show');
            Route::post('/{pengajuan}/proses', [VerifikasiPengajuanController::class, 'proses'])->name('proses');
            Route::post('/{pengajuan}/approve', [VerifikasiPengajuanController::class, 'approve'])->name('approve');
            Route::post('/{pengajuan}/reject', [VerifikasiPengajuanController::class, 'reject'])->name('reject');
            Route::post('/{pengajuan}/upload-surat', [VerifikasiPengajuanController::class, 'uploadSurat'])->name('upload-surat');
            Route::delete('/{pengajuan}/delete-surat', [VerifikasiPengajuanController::class, 'deleteSurat'])->name('delete-surat');
            Route::post('/bulk-action', [VerifikasiPengajuanController::class, 'bulkAction'])->name('bulk');
        });

        Route::get('/verifikasi', function () {
            return view('admin.verifikasi');
        })->name('admin.verifikasi');
        
        Route::get('/seleksi', function () {
            return view('admin.seleksi');
        })->name('admin.seleksi');
        
        Route::get('/pengumuman', function () {
            return view('admin.pengumuman');
        })->name('admin.pengumuman');
        
        Route::get('/laporan', function () {
            return view('admin.laporan');
        })->name('admin.laporan');
    });

    // User routes
    Route::middleware(['cekRole:user'])->group(function () {
        // Pengajuan Surat CRUD (Resource Routes)
        Route::resource('pengajuan', PengajuanSuratController::class);
        
        Route::get('/biodata', [BiodataController::class, 'index'])->name('user.biodata');
        
    });

    // Dalam Route::middleware(['auth', 'web'])->group(function () {
    // User routes
    Route::middleware(['cekRole:user'])->group(function () {
        // Pengajuan Surat CRUD (Resource Routes)
        Route::resource('pengajuan', PengajuanSuratController::class);
        
        // Pengaduan CRUD (Resource Routes)
        Route::resource('pengaduan', PengaduanController::class)->except(['edit', 'update']);
        
        Route::get('/biodata', [BiodataController::class, 'index'])->name('user.biodata');
    });

});