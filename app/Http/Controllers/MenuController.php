<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Http\Requests\MenuRequest;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class MenuController extends Controller implements HasMiddleware
{
    /**
     * Daftarkan middleware untuk controller ini.
     */
    public static function middleware(): array
    {
        return [
            new Middleware('auth', except: ['index', 'show']),
        ];
    }

    public function index()
    {
        $menus = Menu::where('is_available', true)->orderBy('name')->get();
        return view('menus.index', compact('menus'));
    }

    public function create()
    {
        return view('menus.create');
    }

    public function store(MenuRequest $request)
    {
        Menu::create($request->validated());
        return redirect()->route('menus.index')->with('success', 'Menu berhasil ditambahkan!');
    }

    public function show($id)
    {
        // Coba cari berdasarkan ID, jika tidak ada tampilkan 404
        $menu = \App\Models\Menu::find($id);
        if (!$menu) {
            // Jika menggunakan dummy data (karena database kosong) fallback ke array
            $dummyMenus = [
                0 => (object)['id'=>0,'name'=>'Espresso','price'=>18000,'rating'=>4.5,'description'=>'Kopi hitam pekat dengan crema kental','image_url'=>'https://picsum.photos/id/1/400/300'],
                1 => (object)['id'=>1,'name'=>'Americano','price'=>22000,'rating'=>4.3,'description'=>'Espresso dengan air panas, ringan dan bold','image_url'=>'https://picsum.photos/id/2/400/300'],
                2 => (object)['id'=>2,'name'=>'Latte','price'=>30000,'rating'=>4.7,'description'=>'Smooth and creamy latte with rich espresso','image_url'=>'https://picsum.photos/id/3/400/300'],
                3 => (object)['id'=>3,'name'=>'Cappuccino','price'=>28000,'rating'=>4.8,'description'=>'Rich espresso with creamy milk foam','image_url'=>'https://picsum.photos/id/4/400/300'],
                // ... tambahkan hingga 20 menu sesuai dummy di homepage
            ];
            if (isset($dummyMenus[$id])) {
                $menu = $dummyMenus[$id];
            } else {
                abort(404);
            }
        }
        return view('menus.show', compact('menu'));
    }

    public function edit(Menu $menu)
    {
        return view('menus.edit', compact('menu'));
    }

    public function update(MenuRequest $request, Menu $menu)
    {
        $menu->update($request->validated());
        return redirect()->route('menus.index')->with('success', 'Menu berhasil diperbarui!');
    }

    public function destroy(Menu $menu)
    {
        $menu->delete();
        return redirect()->route('menus.index')->with('success', 'Menu berhasil dihapus!');
    }
}