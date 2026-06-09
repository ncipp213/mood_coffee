<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function home()
    {
        // Ambil semua menu
        $menus = Menu::where('is_active', true)->get();
        
        // Recommended menu (rating tertinggi)
        $recommended = Menu::where('is_active', true)
                        ->orderBy('rating', 'desc')
                        ->take(4)
                        ->get();
        
        return view('home', compact('menus', 'recommended'));
    }
}