<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // Display categories on the admin dashboard
    public function index()
    {
        // Retrieve all categories from the database
        $categories = Category::all();

        // Return the view with categories
        return view('admindashboard', compact('categories'));
    }

    // Add a new category
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
        ]);

        $category = new Category();
        $category->name = $request->name;
        $category->save();

        return redirect('/admindashboard')->with('success', 'Category added successfully!');
    }

    // Update an existing category
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $request->id,
        ]);

        $category = Category::findOrFail($request->id);
        $category->name = $request->name;
        $category->save();

        return redirect('/admindashboard')->with('success', 'Category updated successfully!');
    }

    // Delete a category
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return redirect('/admindashboard')->with('success', 'Category deleted successfully!');
    }
}
