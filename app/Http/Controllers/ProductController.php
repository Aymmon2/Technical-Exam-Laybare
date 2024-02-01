<?php

namespace App\Http\Controllers;
use App\Models\Product;
use App\Models\Category;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        $categories = Category::all();

        return view('product', compact('products','categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_name' => 'required|unique:products',
            'product_sku' => 'required',
            'product_category_id' => 'required',
            'product_description' => 'nullable',
            'product_image' => 'nullable',
        ]);

        $product = Product::create([
            'product_name' => $request->input('product_name'),
            'product_sku' => $request->input('product_sku'),
            'product_category_id' => $request->input('product_category_id'),
            'product_category' => $request->input('product_category'),
            'product_description' => $request->input('product_description'),
            'product_image' => $request->input('product_image'),
        ]);

        return redirect()->route('products.index')->with('success', 'Product created successfully');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product deleted successfully');
    }
}
