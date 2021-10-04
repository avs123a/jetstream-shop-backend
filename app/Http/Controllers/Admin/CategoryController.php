<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class CategoryController extends Controller
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

        return Inertia::render('Admin/Categories', [
            'categories' => Category::orderBy('id', 'DESC')->paginate(10),
            'enabledCategories' => $enabledCategories,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'title' => ['required', 'string'],
            'slug' => ['required', 'string'],
            'parent_id' => ['nullable', 'integer', 'exists:categories,id'],
            'enabled' => ['nullable', 'integer', 'in:0,1'],
        ])->validate();

        Category::create($request->all());

        return redirect()->back()
            ->with('message', 'Category was created successfully.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return mixed
     */
    public function update(Request $request, $id)
    {
        Validator::make($request->all(), [
            'title' => ['required', 'string'],
            'slug' => ['required', 'string'],
            'parent_id' => ['nullable', 'integer', 'exists:categories,id'],
            'enabled' => ['nullable', 'integer', 'in:0,1'],
        ])->validate();

        Category::find($id)->update($request->all());

        return redirect()->back()
            ->with('message', 'Category was updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return mixed
     */
    public function destroy($id)
    {
        Category::find($id)->delete();

        return redirect()->back();
    }
}
