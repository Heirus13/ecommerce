<?php

namespace App\Http\Controllers;

use App\Models\Product; 
use App\Models\Category; // Import the Category model
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(Request $request)
    {   
        $query = Product::with('category'); // Eager load the category relationship
    
        // Check if a search query is present
        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->input('search') . '%');
        }
    
        // Check if a category filter is selected
        if ($request->has('category') && $request->input('category') != '') {
            $query->where('category_id', $request->input('category'));
        }
    
        // Use this to retrieve all products instead of paginating
        $products = $query->get(); // Fetch all matching products
        $categories = Category::all(); // Fetch all categories
    
        return view('shop', compact('products', 'categories'));
    }
}