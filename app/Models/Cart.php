<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    // app/Models/Cart.php
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
