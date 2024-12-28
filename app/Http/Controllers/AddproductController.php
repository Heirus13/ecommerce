<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class AddProductController extends Controller
{
    // This method displays the product page
    public function create()
    {
        $categories = Category::all();
        $products = Product::all();
        return view('aboutproduct', compact('categories', 'products'));
    }

    // This method stores a new product
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|max:2048',
        ]);

        $productData = $request->only(['description', 'price', 'stock', 'category_id']);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
            $productData['image'] = $imagePath;
        }

        Product::create($productData);

        return redirect()->route('aboutproduct')->with('success', 'Product added successfully.');
    }

    // This method shows the edit form for a specific product
    public function edit(Product $product)
    {
        $categories = Category::all(); // Fetch all categories
        return view('editproduct', compact('product', 'categories')); // Return edit view with product info
    }

    // This method updates an existing product
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|max:2048',
        ]);

        $productData = $request->only(['description', 'price', 'stock', 'category_id']);

        if ($request->hasFile('image')) {
            // Optionally delete the old image if you want
            if ($product->image) {
                \Storage::disk('public')->delete($product->image);
            }
            $imagePath = $request->file('image')->store('images', 'public');
            $productData['image'] = $imagePath;
        }

        $product->update($productData); // Update the product with new data

        return redirect()->route('aboutproduct')->with('success', 'Product updated successfully.');
    }

    // This method deletes a product
    public function destroy(Product $product)
    {
        // Optionally delete the image when the product is deleted
        if ($product->image) {
            \Storage::disk('public')->delete($product->image);
        }

        $product->delete();
        return redirect()->route('aboutproduct')->with('success', 'Product deleted successfully');
    }
}