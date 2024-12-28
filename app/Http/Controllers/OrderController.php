<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order; // Make sure to import the Order model
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function showCheckedOut()
    {
        // Fetch orders for the logged-in user along with their order items
        $orders = Order::with('orderItems.product') // Assuming you have a relationship defined
                       ->where('user_id', Auth::id())
                       ->get();

        return view('checked_out', compact('orders'));
    }
}