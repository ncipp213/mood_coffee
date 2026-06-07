<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
        public function register(Request $request)
        {
            // Validasi data dari form
            $validated = $request->validate([
                'username' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'phone' => 'required|string|max:15',
                'address' => 'required|string',
                'password' => 'required|string|min:6|confirmed',
            ]);
            
            // Simpan ke database, password di-hash untuk keamanan
            $user = User::create([
                'username' => $validated['username'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'address' => $validated['address'],
                'password' => bcrypt($validated['password']),
            ]);
            
            // Login otomatis setelah registrasi
            Auth::login($user);
            
            // Arahkan ke halaman utama
            return redirect()->route('home');
        }

        public function storeTheme(Request $request)
        {
            $request->session()->put('theme', $request->theme);
            return response()->json(['success' => true]);
        }

        // 1. Fungsi untuk menampilkan halaman login
    public function showLogin()
    {
        return view('auth.login'); // Pastikan nama file kamu di resources/views/auth/login.blade.php
    }

    // 2. Fungsi untuk memproses login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string', // sesuaikan dengan field input form-mu (username/email)
            'password' => 'required|string',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/'); // Diarahkan ke halaman utama setelah login sukses
        }

        return back()->withErrors([
            'username' => 'Username atau password salah.',
        ])->onlyInput('username');
    }

    // 3. Fungsi untuk menampilkan halaman register
    public function showRegister()
    {
        return view('auth.register'); // Pastikan nama file kamu di resources/views/auth/register.blade.php
    }

    // 4. Fungsi untuk logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
