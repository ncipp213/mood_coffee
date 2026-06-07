<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Coffee;

class CoffeeController extends Controller
{
    public function index()
    {
        // Ambil semua data kopi dari database
        $coffees = Coffee::all();
        // Tampilkan view 'home' dan kirim data kopi
        return view('home', compact('coffees'));
    }
}
