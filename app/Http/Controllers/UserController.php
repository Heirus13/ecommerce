<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;  // Ensure that the Order model is imported
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // Show the list of users
    public function totalUsers()
    {
        $users = User::all(); // Get all users
        return view('totalusers', compact('users')); // Pass users data to view
    }

    // Show the form to add a new user
    public function create()
    {
        return view('createuser'); // Show the create user view
    }

    // Store a new user
    public function store(Request $request)
    {
        // Validate the incoming data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email', // Ensure email is unique
            'password' => 'required|string|min:8|confirmed', // Password should be confirmed (password_confirmation field)
        ]);

        // Create the user and hash the password
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Redirect back to the users list with success message
        return redirect()->route('total-users')->with('success', 'User added successfully!');
    }

    // Show the form to edit an existing user
    public function edit(User $user)
    {
        return view('edituser', compact('user')); // Pass the user data to the view
    }

    // Update a user
    public function update(Request $request, User $user)
    {
        // Validate the incoming data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id, // Exclude the current user's email from the unique check
        ]);

        // Update the user data
        $user->update($request->all());

        // Redirect back to the users list with success message
        return redirect()->route('total-users')->with('success', 'User updated successfully!');
    }

    // Delete a user
    public function destroy(User $user)
    {
        // Delete the user
        $user->delete();

        // Redirect back to the users list with success message
        return redirect()->route('total-users')->with('success', 'User deleted successfully!');
    }

    // Fetch all orders and pass them to the 'orders' view
    public function allOrders()
    {
        // Fetch all orders along with the associated user information
        $orders = Order::with('user')->get();

        // Return the 'orders' view, which is not inside any subfolder like 'admin'
        return view('orders', compact('orders'));
    }

    // Show the orders for a specific user
    public function userOrders(User $user)
    {
        // Fetch the orders related to the user
        $orders = $user->orders;

        return view('orders', compact('orders'));  // You can choose to create a separate view for user-specific orders if needed
    }
}
