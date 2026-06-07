<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        return view('profile.index');
    }
    
    public function update(Request $request)
    {
        $user = Auth::user();
        $validated = $request->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'phone' => 'required|string',
            'address' => 'required|string',
            'photo' => 'nullable|image|max:2048'
        ]);
        if ($request->hasFile('photo')) {
            if ($user->photo_path) Storage::delete($user->photo_path);
            $path = $request->file('photo')->store('photos', 'public');
            $validated['photo_path'] = $path;
        }
        $user->update($validated);
        return redirect()->route('profile.index')->with('success', 'Profil berhasil diperbarui');
    }
}