<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Menu;

class User extends Authenticatable
{
    // ... kode yang sudah ada

    public function favorites()
    {
        return $this->belongsToMany(Menu::class, 'favorites', 'user_id', 'menu_id')
                    ->withTimestamps();
    }

    public function hasFavorited($menuId)
    {
        return $this->favorites()->where('menu_id', $menuId)->exists();
    }

    public function toggleFavorite($menuId)
    {
        if ($this->hasFavorited($menuId)) {
            $this->favorites()->detach($menuId);
            return false; // Unfavorited
        } else {
            $this->favorites()->attach($menuId);
            return true; // Favorited
        }
    }
}
