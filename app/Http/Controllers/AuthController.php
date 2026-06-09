<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Cart; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Menampilkan form register
    public function showRegister()
    {
        return view('auth.register');
    }

    // Proses register
    public function register(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|max:15',
            'address' => 'required|string',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'username' => $validated['username'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'address' => $validated['address'],
            'password' => Hash::make($validated['password']),
        ]);

        Auth::login($user);


        $sessionId = session()->getId();
        Cart::where('session_id', $sessionId)
            ->update(['user_id' => Auth::id(), 'session_id' => null]);

        return redirect()->route('home')->with('success', 'Selamat datang, ' . $user->username . '!');
    }

    // Menampilkan form login
    public function showLogin()
    {
        return view('auth.login');
    }

    // Proses login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $sessionId = session()->getId();
            Cart::where('session_id', $sessionId)
                ->update(['user_id' => Auth::id(), 'session_id' => null]);

            return redirect()->intended(route('home'))->with('success', 'Login berhasil!');
        }
            
        // Jika login gagal
        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

        
    // Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login')->with('success', 'Anda telah logout.');
    }

    // Menyimpan tema (dark/light) ke session
    public function storeTheme(Request $request)
    {
        $request->session()->put('theme', $request->theme);
        return response()->json(['success' => true]);
    }
}