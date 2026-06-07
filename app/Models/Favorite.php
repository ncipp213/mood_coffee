<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    // app/Models/Favorite.php
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function coffee()
    {
        return $this->belongsTo(Coffee::class, 'coffee_id', 'id');
    }
}
