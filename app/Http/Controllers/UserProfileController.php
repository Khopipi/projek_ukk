<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class UserProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        return view('user.profile', compact('user'));
    }

    public function show()
    {
        $user = Auth::user();
        return view('user.profile_show', compact('user'));
    }

    public function update(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        $rules = [
            // NIK dan No. KK TIDAK BISA di-update (readonly)
            'name' => 'required|string|max:255',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date|before:today',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'agama' => 'required|string|max:100',
            'status_perkawinan' => 'required|string|max:100',
            'pekerjaan' => 'required|string|max:150',
            'pendidikan_terakhir' => 'nullable|string|max:150',
            'alamat' => 'required|string',
            'rt' => 'required|max:3',
            'rw' => 'required|max:3',
            'desa' => 'required|string|max:150',
            'kecamatan' => 'required|string|max:150',
            'kabupaten' => 'required|string|max:150',
            'provinsi' => 'required|string|max:150',
            'kode_pos' => 'required|digits:5',
            'no_telepon' => 'required|string|max:15',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:8|confirmed',
        ];

        $data = $request->validate($rules);

        // Jika mengubah password, set secara manual (cast 'password' di User akan hash)
        // If password not provided or empty, remove it so it won't override existing password
        if (empty($data['password'] ?? null)) {
            unset($data['password']);
        }

        // Ensure NIK and No. KK cannot be modified (defense in depth)
        if (isset($data['nik'])) {
            unset($data['nik']);
        }
        if (isset($data['no_kk'])) {
            unset($data['no_kk']);
        }

        // Update user (Eloquent)
        $user->fill($data);
        $user->save();

        return redirect()->route('user.profile.show')->with('success', 'Profil berhasil diperbarui');
    }
}
