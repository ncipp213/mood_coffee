<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function index()
    {
        $favorites = Auth::user()->favorites;
        return view('favorites', compact('favorites'));
    }

    public function toggle(Menu $menu)
    {
        $isFavorited = Auth::user()->toggleFavorite($menu->id);
        
        if ($isFavorited) {
            return back()->with('success', 'Menu ditambahkan ke favorit!');
        } else {
            return back()->with('info', 'Menu dihapus dari favorit.');
        }
    }
}