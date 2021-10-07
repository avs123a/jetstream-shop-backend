<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

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

        return response()->json(['products' => $this->getProducts($request, $category)]);
    }

    /**
     * Get product details
     * @param $slug
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($slug)
    {
        $product = Product::find($slug);

        if (!$product) return response()->json(['error' => 'Product not found.'], 404);

        return response()->json(['product' => $product]);
    }


    private function getProducts(Request $request, $category_id = null)
    {
        $key = $request->has('search') ? $request->get('search') : null;
        $sort_by = $request->has('sort_by') ? $request->get('sort_by') : null;
        $sort_order = $request->has('sort_order') ? $request->get('sort_order') : 'ASC';

        $products = $category_id ? Product::where([
            ['enabled', '=', 1],
            ['category_id', '=', $category_id],
        ]) : Product::where('enabled', 1);
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
