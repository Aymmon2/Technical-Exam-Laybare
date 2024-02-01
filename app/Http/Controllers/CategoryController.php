<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('categories', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_name' => 'required|unique:categories',
            'category_description' => 'nullable',
            'product_manager' => 'nullable',
        ]);

        $category = Category::create([
            'category_name' => $request->input('category_name'),
            'category_description' => $request->input('category_description'),
            'product_manager' => $request->input('product_manager'),
        ]);

        return redirect()->route('categories.index')->with('success', '201 created');
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'category_name' => 'required|unique:categories,category_name,' . $category->id,
            'category_description' => 'nullable',
            'product_manager' => 'nullable',
        ]);

        $category->update([
            'category_name' => $request->input('category_name'),
            'category_description' => $request->input('category_description'),
            'product_manager' => $request->input('product_manager'),
        ]);

        return redirect()->route('categories.index')->with('success', '200 OK');
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->route('categories.index')->with([
            'alertColor' => 'danger',
            'success' => '204 No Content'
        ]);
    }

}
