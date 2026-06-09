<?php

namespace App\Http\Controllers;

use App\Models\Coffee;

class CoffeeController extends Controller
{
    public function index()
    {
        $coffees = Coffee::all();
        return view('home', compact('coffees'));
    }
}