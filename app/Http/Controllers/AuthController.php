<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

use App\Mail\ResetPasswordMail;
use App\Mail\SendOtpMail;

use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // Validasi input
        $request->validate([
            'nik' => 'required|string|size:16',
            'password' => 'required|min:6',
        ], [
            'nik.required' => 'NIK wajib diisi',
            'nik.size' => 'NIK harus 16 digit',
            'password.required' => 'Password wajib diisi',
            'password.min' => 'Password minimal 6 karakter',
        ]);

        $credentials = [
            'nik' => $request->nik,
            'password' => $request->password
        ];

        $remember = $request->has('remember');

        // Attempt login
        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            // Logika role: hanya NIK 3578019876543210 yang bisa menjadi admin
            $user = Auth::user();
            $adminNIK = '3578019876543210';
            
            // Jika NIK bukan admin NIK dan user punya role admin, ubah ke user
            if ($user->nik !== $adminNIK && $user->role === 'admin') {
                $user->update(['role' => 'user']);
                $user->refresh();
            }
            
            // Jika NIK adalah admin NIK dan user tidak punya role admin, ubah ke admin
            if ($user->nik === $adminNIK && $user->role !== 'admin') {
                $user->update(['role' => 'admin']);
                $user->refresh();
            }

            // Redirect semua user ke /dashboard (both admin and regular users)
            return redirect()->intended('/dashboard');
        }

        // Jika gagal
        return back()->withErrors([
            'nik' => 'NIK atau password yang Anda masukkan salah.',
        ])->withInput($request->only('nik'));
    }

    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        // Validasi
        $request->validate([
            // Data Identitas
            'nik' => 'required|string|size:16|unique:users,nik',
            'no_kk' => 'required|string|size:16',
            'name' => 'required|string|max:255',

            // Data Pribadi
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date|before:today',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',

            // Data Alamat
            'alamat' => 'required|string',
            'rt' => 'required|string|max:3',
            'rw' => 'required|string|max:3',
            'desa' => 'required|string|max:255',
            'kecamatan' => 'required|string|max:255',
            'kabupaten' => 'required|string|max:255',
            'provinsi' => 'required|string|max:255',
            'kode_pos' => 'required|string|size:5',

            // Data Lainnya
            'agama' => 'required|in:Islam,Kristen,Katolik,Hindu,Buddha,Konghucu',
            'status_perkawinan' => 'required|in:Belum Kawin,Kawin,Cerai Hidup,Cerai Mati',
            'pekerjaan' => 'required|string|max:255',
            'pendidikan_terakhir' => 'nullable|string|max:255',
            'no_telepon' => 'required|string|max:15',

            // Email & Password
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',

            // Agreement
            'agreement' => 'required|accepted',
        ], [
            // Custom error messages
            'nik.required' => 'NIK wajib diisi',
            'nik.size' => 'NIK harus 16 digit',
            'nik.unique' => 'NIK sudah terdaftar',
            'no_kk.required' => 'Nomor KK wajib diisi',
            'no_kk.size' => 'Nomor KK harus 16 digit',
            'name.required' => 'Nama lengkap wajib diisi',
            'tempat_lahir.required' => 'Tempat lahir wajib diisi',
            'tanggal_lahir.required' => 'Tanggal lahir wajib diisi',
            'tanggal_lahir.before' => 'Tanggal lahir harus sebelum hari ini',
            'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih',
            'alamat.required' => 'Alamat lengkap wajib diisi',
            'rt.required' => 'RT wajib diisi',
            'rw.required' => 'RW wajib diisi',
            'desa.required' => 'Desa wajib diisi',
            'kecamatan.required' => 'Kecamatan wajib diisi',
            'kabupaten.required' => 'Kabupaten wajib diisi',
            'provinsi.required' => 'Provinsi wajib diisi',
            'kode_pos.required' => 'Kode pos wajib diisi',
            'kode_pos.size' => 'Kode pos harus 5 digit',
            'agama.required' => 'Agama wajib dipilih',
            'status_perkawinan.required' => 'Status perkawinan wajib dipilih',
            'pekerjaan.required' => 'Pekerjaan wajib diisi',
            'no_telepon.required' => 'Nomor telepon wajib diisi',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'password.required' => 'Password wajib diisi',
            'password.min' => 'Password minimal 6 karakter',
            'password.confirmed' => 'Konfirmasi password tidak cocok',
            'agreement.required' => 'Anda harus menyetujui pernyataan data',
            'agreement.accepted' => 'Anda harus menyetujui pernyataan data',
        ]);

        // Buat user baru
        $user = User::create([
            // Data Identitas
            'nik' => $request->nik,
            'no_kk' => $request->no_kk,
            'name' => $request->name,

            // Data Pribadi
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,

            // Data Alamat
            'alamat' => $request->alamat,
            'rt' => $request->rt,
            'rw' => $request->rw,
            'desa' => $request->desa,
            'kecamatan' => $request->kecamatan,
            'kabupaten' => $request->kabupaten,
            'provinsi' => $request->provinsi,
            'kode_pos' => $request->kode_pos,

            // Data Lainnya
            'agama' => $request->agama,
            'status_perkawinan' => $request->status_perkawinan,
            'pekerjaan' => $request->pekerjaan,
            'pendidikan_terakhir' => $request->pendidikan_terakhir,
            'no_telepon' => $request->no_telepon,

            // Email & Password
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user',
        ]);

        return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan login dengan NIK Anda.');
    }

    /**
     * Logout user
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'Anda berhasil logout.');
    }

    /**
     * Show forgot password form
     */
    public function showForgotPasswordForm()
    {
        return view('auth.forgot-password.email');
    }

    /**
     * Send reset password link
     */
    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email'
        ], [
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'email.exists' => 'Email tidak terdaftar'
        ]);

        $user = User::where('email', $request->email)->first();

        // Generate token
        $token = Str::random(64);

        // Store token in password_reset_tokens table
        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request->email],
            [
                'token' => Hash::make($token),
                'created_at' => now()
            ]
        );

        // Send email
        $resetLink = route('password.reset', ['token' => $token]) . '?email=' . urlencode($request->email);
        $expireAt = now()->addHours(1);

        try {
            Mail::to($user->email)->send(new ResetPasswordMail($user->name, $resetLink, $expireAt));
            return back()->with('success', 'Link reset password telah dikirim ke email Anda!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mengirim email. Silakan coba lagi.');
        }
    }

    /**
     * Show reset password form
     */
    public function showResetPasswordForm($token)
    {
        $email = request()->query('email');
        $user = User::where('email', $email)->first();
        
        if (!$user) {
            return redirect('/login')->with('error', 'User tidak ditemukan!');
        }
        
        return view('auth.forgot-password.reset', ['token' => $token, 'user' => $user]);
    }

    /**
     * Reset password
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|string|min:6|confirmed',
            'token' => 'required'
        ], [
            'email.required' => 'Email wajib diisi',
            'email.exists' => 'Email tidak terdaftar',
            'password.required' => 'Password wajib diisi',
            'password.min' => 'Password minimal 6 karakter',
            'password.confirmed' => 'Konfirmasi password tidak cocok'
        ]);

        // Verify token
        $passwordReset = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->first();

        if (!$passwordReset) {
            return back()->withErrors(['email' => 'Token reset password tidak valid!']);
        }

        // Verify token matches
        if (!Hash::check($request->token, $passwordReset->token)) {
            return back()->withErrors(['email' => 'Token reset password tidak valid!']);
        }

        // Check if token expired (1 hour)
        if (now()->diffInMinutes($passwordReset->created_at) > 60) {
            return back()->withErrors(['email' => 'Token reset password sudah kadaluarsa!']);
        }

        // Update password
        User::where('email', $request->email)->update([
            'password' => Hash::make($request->password)
        ]);

        // Delete token
        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        return redirect('/login')->with('success', 'Password berhasil direset! Silakan login dengan password baru.');
    }

    /**
     * Show email verification / OTP form
     */
    public function showVerifyForm(Request $request)
    {
        // If there's no email in session, try to set from authenticated user
        if (!session('verify_email')) {
            if (Auth::check()) {
                session(['verify_email' => Auth::user()->email]);
            }
        }

        // Provide resend timer settings to the view
        $timeResendOtp = 60; // seconds before allowing resend
        $cooldown = 0; // client-side will handle countdown; default 0

        return view('auth.verify-email', compact('timeResendOtp', 'cooldown'));
    }

    /**
     * Send OTP to given email (for verification)
     */
    public function sendOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email'
        ]);

        $user = User::where('email', $request->email)->first();

        // Generate 6 digit OTP
        $otp = rand(100000, 999999);

        // Store hashed OTP and expiry (10 minutes)
        $user->otp_code = Hash::make((string) $otp);
        $user->otp_expires_at = now()->addMinutes(10);
        $user->save();

        // Send email with OTP
        try {
            $expireAt = $user->otp_expires_at;
            Mail::to($user->email)->send(new SendOtpMail('Email Verification', $user->name, $otp, $expireAt));
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mengirim OTP ke email. Silakan coba lagi.');
        }

        // Save email to session for verification flow
        session(['verify_email' => $user->email]);

        return back()->with('success', 'Kode verifikasi telah dikirim ke ' . $user->email);
    }

    /**
     * Verify OTP and mark user as verified
     */
    public function verify(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'otp' => 'required|string|size:6'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'Email tidak ditemukan']);
        }

        if (!$user->otp_code || !$user->otp_expires_at) {
            return back()->withErrors(['otp' => 'Tidak ada kode OTP yang dikirim. Silakan minta kirim ulang.']);
        }

        if (now()->greaterThan($user->otp_expires_at)) {
            return back()->withErrors(['otp' => 'Kode OTP sudah kadaluarsa. Silakan minta kode baru.']);
        }

        if (!Hash::check($request->otp, $user->otp_code)) {
            return back()->withErrors(['otp' => 'Kode OTP salah.']);
        }

        // Mark verified
        $user->is_verified = true;
        $user->otp_code = null;
        $user->otp_expires_at = null;
        $user->save();

        // If the user is the currently authenticated user, good; else optionally log them in
        if (Auth::check() && Auth::user()->id === $user->id) {
            // nothing
        }

        return redirect()->route('dashboard')->with('success', 'Email berhasil diverifikasi.');
    }
}
