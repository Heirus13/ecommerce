<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function create()
    {
        $products = Product::all(); 
        return view('aboutproduct', compact('products')); 
    }

    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $product = new Product();
        $product->name = $request->input('name');
        $product->description = $request->input('description');
        $product->price = $request->input('price');
        $product->stock = $request->input('stock');

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('images/products', 'public');
            $product->image = $path;
        }

        $product->save();

     
        return redirect()->route('about.product')->with('success', 'Product added successfully.');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return response()->json($product); 
    }

    public function update(Request $request, $id): \Illuminate\Http\RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $product = Product::findOrFail($id);
        $product->name = $request->input('name');
        $product->description = $request->input('description');
        $product->price = $request->input('price');
        $product->stock = $request->input('stock');

        if ($request->hasFile('image')) {

            $path = $request->file('image')->store('images/products', 'public');
            $product->image = $path;
        }

        $product->save();

        return redirect()->route('about.product')->with('success', 'Product updated successfully.');
    }

    public function destroy($id): \Illuminate\Http\RedirectResponse
    {
        $product = Product::findOrFail($id);

        $product->delete();

        return redirect()->route('about.product')->with('success', 'Product deleted successfully.');
    }
}