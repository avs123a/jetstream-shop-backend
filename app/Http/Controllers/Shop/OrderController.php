<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class OrderController extends Controller
{
    public function index()
    {
        return Inertia::render('Frontend/Cart', []);
    }

    public function checkout()
    {
        return Inertia::render('Frontend/Order', []);
    }
}
