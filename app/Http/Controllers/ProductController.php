<?php

namespace App\Http\Controllers;
use App\Models\Product;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        $categories = Category::all();
        $users = User::all();

        return view('product', compact('products','categories','users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_name' => 'required|unique:products',
            'product_sku' => 'required',
            'product_category' => 'required',
            'product_description' => 'nullable',
            'product_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'created_by' => 'nullable',
        ]);

        $productImage = null;

        if ($request->hasFile('product_image')) {
            $productImage = $request->file('product_image');
            $imagePath = $productImage->store('product_images', 'public');
        }

        $product = Product::create([
            'product_name' => $request->input('product_name'),
            'product_sku' => $request->input('product_sku'),
            'product_category' => $request->input('product_category'),
            'product_description' => $request->input('product_description'),
            'product_image' => $imagePath,
            'created_by' => $request->input('created_by'),
        ]);

        return redirect()->route('products.index')->with('success', '201 created');
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'product_name' => 'required|unique:products,product_name,' . $product->id,
            'product_sku' => 'required|unique:products,product_sku,' . $product->id,
            'product_category' => 'required',
            'product_description' => 'nullable',
            'product_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'created_by' => 'nullable',
        ]);

        if ($request->hasFile('product_image')) {
            $productImage = $request->file('product_image');
            $imagePath = $productImage->store('product_images', 'public');
            $product->update(['product_image' => $imagePath]);
        }

        $product->update([
            'product_name' => $request->input('product_name'),
            'product_sku' => $request->input('product_sku'),
            'product_category' => $request->input('product_category'),
            'product_description' => $request->input('product_description'),
            'created_by' => $request->input('created_by'),

        ]);

        return redirect()->route('products.index')->with('success', '200 OK');
    }


    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('products.index')->with([
            'alertColor' => 'danger',
            'success' => '204 No Content'
        ]);
    }
}
