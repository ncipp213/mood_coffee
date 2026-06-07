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
            auth::login($user);
            
            // Arahkan ke halaman utama
            return redirect()->route('home');
        }
}
