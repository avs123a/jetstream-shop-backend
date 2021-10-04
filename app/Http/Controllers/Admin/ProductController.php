<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    public function index()
    {
        $enabledCategories = Cache::rememberForever('enabled_categories', function () {
            return Category::select('id', 'title')->where('enabled', 1)->get()->toArray();
        });

        return Inertia::render('Admin/Products', [
            'products' => Product::orderBy('id', 'DESC')->paginate(10),
            'enabledCategories' => $enabledCategories
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'title' => ['required', 'string'],
            'slug' => ['required', 'string'],
            'description' => ['nullable', 'string'],
            'category_id' => ['required', 'integer', 'exists:categories,id'],
            'price' => ['required', 'regex:/^\d+(\.\d{1,2})?$/'],
            'enabled' => ['nullable', 'integer', 'in:0,1'],
        ])->validate();

        $data = $request->all();

        $file = $request->file('image_path');
        if ($file->isValid()) {
            $image_path = $file->store('public/product_images');

            if ($image_path !== false) {
                $data['image_path'] = $image_path;
                $data['image_url'] = asset( str_replace('public/', '', Storage::url($image_path)) );
            }
        }

        Product::create($data);

        return redirect()->back()
            ->with('message', 'Category was created successfully.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        Validator::make($request->all(), [
            'title' => ['required', 'string'],
            'slug' => ['required', 'string'],
            'description' => ['nullable', 'string'],
            'category_id' => ['required', 'integer', 'exists:categories,id'],
            'price' => ['required', 'regex:/^\d+(\.\d{1,2})?$/'],
            'enabled' => ['nullable', 'integer', 'in:0,1'],
        ])->validate();

        $data = $request->all();

        $product = Product::find($id);

        $file = $request->file('image_path');
        if ($file && $file->isValid()) {
            if ($product->image_path && Storage::exists($product->image_path)) {
                Storage::delete($product->image_path);
            }

            $image_path = $file->store('public/product_images');

            if ($image_path !== false) {
                $data['image_path'] = $image_path;
                $data['image_url'] = asset( str_replace('public/', '', Storage::url($image_path)) );
            }
        }

        $product->fill($data);
        $product->save();

        return redirect()->back()
            ->with('message', 'Product was updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        Product::find($id)->delete();
        return redirect()->back();
    }
}
