<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'order_number',
        'order_type',
        'payment_method',
        'subtotal',
        'shipping_cost',
        'total',
        'status',
        'expires_at'
    ];

    /**
     * Relasi ke OrderItem (Satu order bisa punya banyak item)
     */
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Relasi ke User (Order ini milik siapa)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}