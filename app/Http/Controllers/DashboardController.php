<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {

        $products = Product::all();
        return view('index', compact('products'));
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('index')->with([
            'alertColor' => 'danger',
            'success' => '204 No Content'
        ]);
    }
}
