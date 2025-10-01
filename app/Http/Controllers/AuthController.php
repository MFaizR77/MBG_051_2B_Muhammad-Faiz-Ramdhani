<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            session([
                'logged_in' => true,
                'user_id' => $user->id,
                'role' => $user->role,
                'name' => $user->name,
            ]);
            return redirect($user->role == 'gudang' ? '/gudang' : '/dapur');
        }

        return back()->withErrors(['login' => 'Email atau password salah']);
    }

    public function logout()
    {
        session()->flush();
        return redirect('/login');
    }
}
