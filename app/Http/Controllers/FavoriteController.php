<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Favorite;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function index()
    {
        $favorites = Auth::user()->favorites()->with('coffee')->get();
        return view('favorites.index', compact('favorites'));
    }
    
    public function toggle(int $coffeeId)
    {
        $user = Auth::user();
        $favorite = $user->favorites()->where('coffee_id', $coffeeId)->first();
        if ($favorite) {
            $favorite->delete();
            return response()->json(['status' => 'removed']);
        } else {
            $user->favorites()->create(['coffee_id' => $coffeeId]);
            return response()->json(['status' => 'added']);
        }
    }
    
    public function destroy(int $id)
    {
        $favorite = Favorite::findOrFail($id);
        Gate::authorize('delete', $favorite);
        $favorite->delete();
        return redirect()->route('favorites.index')->with('success', 'Dihapus dari favorit');
    }
}