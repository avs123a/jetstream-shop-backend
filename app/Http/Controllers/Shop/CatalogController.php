<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CatalogController extends Controller
{
    /**
     * Catalog
     * @return \Inertia\Response
     */
    public function index()
    {
        return Inertia::render('Frontend/Catalog', []);
    }

    /**
     * Get product details
     * @param $slug
     * @return \Inertia\Response
     */
    public function details($slug)
    {
        return Inertia::render('Frontend/Details', [
            'product' => Product::where('slug', $slug)->first()
        ]);
    }

}
