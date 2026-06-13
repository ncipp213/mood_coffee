<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Http\Requests\MenuRequest;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Collection;

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

    /**
     * Mengambil data dummy menu (20 item) yang konsisten dengan halaman index.
     */
    private function getDummyMenus(): Collection
    {
        return collect([
            (object) ['id' => 0, 'name' => 'Espresso', 'price' => 18000, 'rating' => 4.5, 'description' => 'Kopi hitam pekat dengan crema kental', 'image_url' => 'https://picsum.photos/id/1/400/300'],
            (object) ['id' => 1, 'name' => 'Americano', 'price' => 22000, 'rating' => 4.3, 'description' => 'Espresso dengan air panas, ringan dan bold', 'image_url' => 'https://picsum.photos/id/2/400/300'],
            (object) ['id' => 2, 'name' => 'Latte', 'price' => 30000, 'rating' => 4.7, 'description' => 'Smooth and creamy latte with rich espresso', 'image_url' => 'https://picsum.photos/id/3/400/300'],
            (object) ['id' => 3, 'name' => 'Cappuccino', 'price' => 28000, 'rating' => 4.8, 'description' => 'Rich espresso with creamy milk foam', 'image_url' => 'https://picsum.photos/id/4/400/300'],
            (object) ['id' => 4, 'name' => 'Mocha', 'price' => 32000, 'rating' => 4.6, 'description' => 'Perpaduan espresso, cokelat, dan susu', 'image_url' => 'https://picsum.photos/id/5/400/300'],
            (object) ['id' => 5, 'name' => 'Caramel Macchiato', 'price' => 35000, 'rating' => 4.9, 'description' => 'Vanilla dan caramel dengan lapisan busa', 'image_url' => 'https://picsum.photos/id/6/400/300'],
            (object) ['id' => 6, 'name' => 'Affogato', 'price' => 38000, 'rating' => 4.4, 'description' => 'Espresso dituang di atas es krim vanila', 'image_url' => 'https://picsum.photos/id/7/400/300'],
            (object) ['id' => 7, 'name' => 'Flat White', 'price' => 29000, 'rating' => 4.5, 'description' => 'Microfoam lembut dengan espresso', 'image_url' => 'https://picsum.photos/id/8/400/300'],
            (object) ['id' => 8, 'name' => 'Irish Coffee', 'price' => 45000, 'rating' => 4.2, 'description' => 'Kopi dengan whiskey Irlandia dan krim', 'image_url' => 'https://picsum.photos/id/9/400/300'],
            (object) ['id' => 9, 'name' => 'Vienna Coffee', 'price' => 33000, 'rating' => 4.3, 'description' => 'Krim kental di atas kopi hitam', 'image_url' => 'https://picsum.photos/id/10/400/300'],
            (object) ['id' => 10, 'name' => 'Kopi Tubruk', 'price' => 15000, 'rating' => 4.0, 'description' => 'Kopi tradisional Indonesia', 'image_url' => 'https://picsum.photos/id/11/400/300'],
            (object) ['id' => 11, 'name' => 'Kopi Luwak', 'price' => 85000, 'rating' => 4.9, 'description' => 'Premium civet coffee', 'image_url' => 'https://picsum.photos/id/12/400/300'],
            (object) ['id' => 12, 'name' => 'Coconut Latte', 'price' => 34000, 'rating' => 4.8, 'description' => 'Latte dengan sentuhan santan', 'image_url' => 'https://picsum.photos/id/13/400/300'],
            (object) ['id' => 13, 'name' => 'Hazelnut Latte', 'price' => 36000, 'rating' => 4.7, 'description' => 'Sirup hazelnut dan latte', 'image_url' => 'https://picsum.photos/id/14/400/300'],
            (object) ['id' => 14, 'name' => 'Pumpkin Spice Latte', 'price' => 40000, 'rating' => 4.6, 'description' => 'Musiman dengan bumbu labu', 'image_url' => 'https://picsum.photos/id/15/400/300'],
            (object) ['id' => 15, 'name' => 'Iced Americano', 'price' => 22000, 'rating' => 4.4, 'description' => 'Refreshing cold brew', 'image_url' => 'https://picsum.photos/id/16/400/300'],
            (object) ['id' => 16, 'name' => 'Iced Caramel Latte', 'price' => 35000, 'rating' => 4.7, 'description' => 'Caramel latte dingin', 'image_url' => 'https://picsum.photos/id/17/400/300'],
            (object) ['id' => 17, 'name' => 'Iced Matcha Latte', 'price' => 38000, 'rating' => 4.5, 'description' => 'Matcha dengan susu dingin', 'image_url' => 'https://picsum.photos/id/18/400/300'],
            (object) ['id' => 18, 'name' => 'Iced Vietnamese Coffee', 'price' => 32000, 'rating' => 4.3, 'description' => 'Kopi robusta dengan susu kental manis', 'image_url' => 'https://picsum.photos/id/19/400/300'],
            (object) ['id' => 19, 'name' => 'Butter Coffee', 'price' => 42000, 'rating' => 4.1, 'description' => 'Kopi dengan mentega dan MCT oil', 'image_url' => 'https://picsum.photos/id/20/400/300'],
        ]);
    }

    public function index()
    {
        $menus = Menu::where('is_available', true)->orderBy('name')->get();
        // Jika database kosong, gunakan dummy (opsional agar halaman index tetap muncul)
        if ($menus->isEmpty()) {
            $menus = $this->getDummyMenus();
        }
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
        // Pastikan ID dibaca sebagai integer
        $id = (int) $id;

        // Coba cari di database terlebih dahulu
        $menu = Menu::find($id);

        // Jika tidak ditemukan, cari di data dummy
        if (!$menu) {
            $dummyMenus = $this->getDummyMenus();
            $menu = $dummyMenus->firstWhere('id', $id);
        }

        // Jika tetap tidak ditemukan, tampilkan 404
        if (!$menu) {
            abort(404, 'Menu tidak ditemukan');
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