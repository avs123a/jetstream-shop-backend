<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class CategoryController extends Controller
{
    public function index() {
        $categories = Cache::rememberForever('enabled_categories', function () {
            return Category::select('slug', 'title')->where('enabled', 1)->get()->toArray();
        });

        return response()->json(['categories' => $categories]);
    }
}
