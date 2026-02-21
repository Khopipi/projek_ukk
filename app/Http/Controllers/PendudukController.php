<?php

namespace App\Http\Controllers;

use App\Models\Penduduk;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class PendudukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Penduduk::query();

        // Search functionality
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%")
                  ->orWhere('nik', 'like', "%{$search}%")
                  ->orWhere('kk', 'like', "%{$search}%");
            });
        }

        // Filter by jenis kelamin
        if ($request->has('jenis_kelamin') && $request->jenis_kelamin != '') {
            $query->where('jenis_kelamin', $request->jenis_kelamin);
        }

        // Filter by status perkawinan
        if ($request->has('status_perkawinan') && $request->status_perkawinan != '') {
            $query->where('status_perkawinan', $request->status_perkawinan);
        }

        $penduduks = $query->latest()->paginate(10);

        return view('admin.penduduk.index', compact('penduduks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.penduduk.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nik' => 'required|string|size:16|unique:penduduks,nik',
            'kk' => 'required|string|size:16',
            'nama_lengkap' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required|string',
            'rt' => 'required|string|max:3',
            'rw' => 'required|string|max:3',
            'desa' => 'required|string|max:255',
            'kecamatan' => 'required|string|max:255',
            'kabupaten' => 'required|string|max:255',
            'provinsi' => 'required|string|max:255',
            'kode_pos' => 'nullable|string|max:5',
            'agama' => 'required|in:Islam,Kristen,Katolik,Hindu,Buddha,Konghucu',
            'status_perkawinan' => 'required|in:Belum Kawin,Kawin,Cerai Hidup,Cerai Mati',
            'pekerjaan' => 'required|string|max:255',
            'kewarganegaraan' => 'required|in:WNI,WNA',
            'pendidikan_terakhir' => 'nullable|string|max:255',
            'nama_ayah' => 'nullable|string|max:255',
            'nama_ibu' => 'nullable|string|max:255',
            'status_dalam_keluarga' => 'required|in:Kepala Keluarga,Istri,Anak,Menantu,Cucu,Orang Tua,Mertua,Famili Lain,Pembantu,Lainnya',
            'status_kependudukan' => 'required|in:Tetap,Tidak Tetap,Pendatang',
            'no_telepon' => 'nullable|string|max:15',
            'email' => 'nullable|email|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'keterangan' => 'nullable|string'
        ]);

        // Handle file upload
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/penduduk', $filename);
            $validated['foto'] = $filename;
        }

        Penduduk::create($validated);

        return redirect()->route('penduduk.index')
                         ->with('success', 'Data penduduk berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Penduduk $penduduk)
    {
        return view('admin.penduduk.show', compact('penduduk'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Penduduk $penduduk)
    {
        return view('admin.penduduk.edit', compact('penduduk'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Penduduk $penduduk)
    {
        $validated = $request->validate([
            'nik' => 'required|string|size:16|unique:penduduks,nik,' . $penduduk->id,
            'kk' => 'required|string|size:16',
            'nama_lengkap' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required|string',
            'rt' => 'required|string|max:3',
            'rw' => 'required|string|max:3',
            'desa' => 'required|string|max:255',
            'kecamatan' => 'required|string|max:255',
            'kabupaten' => 'required|string|max:255',
            'provinsi' => 'required|string|max:255',
            'kode_pos' => 'nullable|string|max:5',
            'agama' => 'required|in:Islam,Kristen,Katolik,Hindu,Buddha,Konghucu',
            'status_perkawinan' => 'required|in:Belum Kawin,Kawin,Cerai Hidup,Cerai Mati',
            'pekerjaan' => 'required|string|max:255',
            'kewarganegaraan' => 'required|in:WNI,WNA',
            'pendidikan_terakhir' => 'nullable|string|max:255',
            'nama_ayah' => 'nullable|string|max:255',
            'nama_ibu' => 'nullable|string|max:255',
            'status_dalam_keluarga' => 'required|in:Kepala Keluarga,Istri,Anak,Menantu,Cucu,Orang Tua,Mertua,Famili Lain,Pembantu,Lainnya',
            'status_kependudukan' => 'required|in:Tetap,Tidak Tetap,Pendatang',
            'no_telepon' => 'nullable|string|max:15',
            'email' => 'nullable|email|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'keterangan' => 'nullable|string'
        ]);

        // Handle file upload
        if ($request->hasFile('foto')) {
            // Delete old photo
            if ($penduduk->foto) {
                Storage::delete('public/penduduk/' . $penduduk->foto);
            }

            $file = $request->file('foto');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/penduduk', $filename);
            $validated['foto'] = $filename;
        }

        $penduduk->update($validated);

        return redirect()->route('penduduk.index')
                         ->with('success', 'Data penduduk berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Penduduk $penduduk)
    {
        // Delete photo if exists
        if ($penduduk->foto) {
            Storage::delete('public/penduduk/' . $penduduk->foto);
        }

        $penduduk->delete();

        return redirect()->route('penduduk.index')
                         ->with('success', 'Data penduduk berhasil dihapus!');
    }

    /**
     * Export data penduduk to Excel/PDF
     */
    public function export(Request $request)
    {
        // Implementation for export functionality
        // You can use packages like maatwebsite/excel or barryvdh/laravel-dompdf
    }

    /**
     * Show form to create account from penduduk data
     */
    public function createAccount($id)
    {
        $penduduk = Penduduk::findOrFail($id);
        return view('admin.penduduk.create-account', compact('penduduk'));
    }

    /**
     * Store new user account from penduduk data
     */
    public function storeAccount(Request $request, $id)
    {
        $penduduk = Penduduk::findOrFail($id);

        // Validasi input
        $validator = Validator::make($request->all(), [
            'nik' => 'required|string|size:16',
            'no_kk' => 'required|string|size:16',
            'name' => 'required|string|max:255',
            'tempat_lahir' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'agama' => 'required|string',
            'status_perkawinan' => 'required|string',
            'pekerjaan' => 'required|string|max:100',
            'pendidikan_terakhir' => 'nullable|string|max:50',
            'alamat' => 'required|string|max:255',
            'rt' => 'required|string|max:3',
            'rw' => 'required|string|max:3',
            'desa' => 'required|string|max:100',
            'kecamatan' => 'required|string|max:100',
            'kabupaten' => 'required|string|max:100',
            'provinsi' => 'required|string|max:100',
            'kode_pos' => 'nullable|string|max:5',
            'no_telepon' => 'required|string|max:12|unique:users,no_telepon',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'agreement' => 'required|accepted'
        ], [
            'no_telepon.unique' => 'Nomor telepon ini sudah terdaftar di sistem',
            'email.unique' => 'Email ini sudah terdaftar di sistem',
            'password.confirmed' => 'Password dan konfirmasi password tidak sama',
            'agreement.accepted' => 'Anda harus menyetujui pernyataan data'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                           ->withErrors($validator)
                           ->withInput();
        }

        // Cek apakah email sudah ada di User
        if (User::where('email', $request->email)->exists()) {
            return redirect()->back()
                           ->withErrors(['email' => 'Email sudah terdaftar di sistem'])
                           ->withInput();
        }

        // Create user
        $user = User::create([
            'nik' => $request->nik,
            'name' => $request->name,
            'email' => $request->email,
            'no_telepon' => $request->no_telepon,
            'password' => Hash::make($request->password),
            'role' => 'user',
            'is_verified' => false,
            'email_verified_at' => null, // Email belum terverifikasi
        ]);

        return redirect()->route('penduduk.show', $id)
                       ->with('success', 'Akun user berhasil dibuat! User harus melakukan verifikasi email untuk mengaktifkan akun.');
    }
}
