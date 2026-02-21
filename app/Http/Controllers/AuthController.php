<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    //
    public function login()
    {
        return view('auth.login');
    }

    public function authenticate(Request $request)
    {
        // Example authentication logic
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {

            $request->session()->regenerate(); // WAJIB

            $role = Auth::user()->role;

            if ($role === 'admin') {
                return redirect()->route('admin.dashboard')
                    ->with('success', 'Selamat Datang Admin!');
            } elseif ($role === 'officer') {
                return redirect()->route('officer.dashboard')
                    ->with('success', 'Selamat Datang Officer!');
            } else {
                // User biasa - redirect ke login untuk sekarang
                return redirect('/login')
                    ->with('error', 'Akses ditolak untuk user biasa');
            }
        }

        return back()->withErrors(['error' => 'email atau password salah!'])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
