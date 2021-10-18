<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Get products
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        return response()->json(['products' => $this->getProducts($request)]);
    }

    /**
     * Get products by category
     * @param Request $request
     * @param $slug
     * @return \Illuminate\Http\JsonResponse
     */
    public function listByCategory(Request $request, $slug)
    {
        $category = Category::where('slug', $slug)->first();

        if (!$category) return response()->json(['error' => 'Category not found.'], 404);

        return response()->json(['products' => $this->getProducts($request, $category->id)]);
    }

    /**
     * Get product details
     * @param $slug
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($slug)
    {
        $product = Product::where('slug', $slug)->first();

        if (!$product) return response()->json(['error' => 'Product not found.'], 404);

        return response()->json(['product' => $product]);
    }


    private function getProducts(Request $request, $category_id = null)
    {
        $key = $request->has('search') ? $request->get('search') : null;
        $sort_by = $request->has('sort_by') ? $request->get('sort_by') : null;
        $sort_order = $request->has('sort_order') ? $request->get('sort_order') : 'ASC';

        $products = DB::table('products')->select('products.title as title', 'products.slug', 'categories.title as category', 'price', 'image_url')->join('categories', 'products.category_id', '=', 'categories.id');

        $products = $category_id ? $products->where([
            ['products.enabled', '=', 1],
            ['categories.id', '=', $category_id],
        ]) : DB::table('products')->where('products.enabled', 1);

        if ($key) {
            $products = $products->where(function ($query) use ($key) {
                $query->where('title', 'like', "%$key%")
                    ->orWhere('description', 'like', "%$key%");
            });
        }

        if ($sort_by) {
            $products = ($sort_order == 'ASC') ? $products->orderBy($sort_by) : $products->orderByDesc($sort_by);
        }

        return $products->paginate();
    }

}
