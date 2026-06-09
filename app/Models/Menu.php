<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'slug', 'description', 'price', 
        'rating', 'image_url', 'category', 'is_active'
    ];

    // Relasi many-to-many dengan User melalui favorites
    public function favoritedBy()
    {
        return $this->belongsToMany(User::class, 'favorites', 'menu_id', 'user_id')
                    ->withTimestamps();
    }

    // Relasi dengan cart items
    public function cartItems()
    {
        return $this->hasMany(Cart::class);
    }
}