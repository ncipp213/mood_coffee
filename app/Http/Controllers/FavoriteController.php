<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class FavoriteController extends Controller implements HasMiddleware
{
    /**
     * Daftarkan middleware untuk controller ini.
     */
    public static function middleware(): array
    {
        return [
            new Middleware('auth'),
        ];
    }

    public function index()
    {
        $favorites = Auth::user()->favorites()->with('menu')->get();
        return view('favorites.index', compact('favorites'));
    }

    public function toggle(Request $request)
    {
        $request->validate(['menu_id' => 'required|exists:menus,id']);

        $favorite = Favorite::where('user_id', Auth::id())
                            ->where('menu_id', $request->menu_id)
                            ->first();

        if ($favorite) {
            $favorite->delete();
            return response()->json(['status' => 'removed']);
        }

        Favorite::create([
            'user_id' => Auth::id(),
            'menu_id' => $request->menu_id
        ]);

        return response()->json(['status' => 'added']);
    }
}