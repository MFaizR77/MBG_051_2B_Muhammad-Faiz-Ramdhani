<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Menampilkan halaman login.
     */
    public function showLoginForm()
    {
        // Mengembalikan tampilan view 'auth.login'
        return view('auth.login');
    }

    /**
     * Proses login pengguna.
     */
    public function login(Request $request)
    {
        // Validasi input agar email dan password wajib diisi
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Cari user berdasarkan email
        $user = User::where('email', $request->email)->first();

        // Cek apakah user ada dan password cocok
        if ($user && Hash::check($request->password, $user->password)) {
            // Simpan data penting user ke session
            session([
                'logged_in' => true,
                'user_id' => $user->id,
                'role' => $user->role,
                'name' => $user->name,
            ]);

            // Arahkan ke halaman sesuai peran (gudang atau dapur)
            return redirect($user->role == 'gudang' ? '/gudang' : '/dapur');
        }

        // Jika gagal login, kembalikan ke form dengan pesan error
        return back()->withErrors(['login' => 'Email atau password salah']);
    }

    /**
     * Logout pengguna.
     */
    public function logout()
    {
        // Hapus semua data session pengguna
        session()->flush();

        // Arahkan kembali ke halaman login
        return redirect('/login');
    }
}
