<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order; // Import the Order model
use App\Models\Cart; // Import the Cart model
use App\Models\Product; // Import the Product model
use Illuminate\Support\Facades\Auth; // Import Auth facade
use Illuminate\Support\Facades\Log; // Import Log facade

class CheckoutController extends Controller
{
    // Display the checkout page with cart items
    public function index(Request $request)
    {
        // Retrieve cart items for the authenticated user
        $cartItems = Cart::where('user_id', Auth::id())->get();

        // Log the cart items for debugging
        Log::info('Cart Items:', ['cart_items' => $cartItems]);

        // Calculate total amount
        $totalAmount = $this->calculateTotalAmount($cartItems);

        return view('checkout', compact('cartItems', 'totalAmount'));
    }

    // Process the checkout
    public function checkout(Request $request)
    {
        $cartItems = Cart::where('user_id', Auth::id())->get();

        // Log the User ID
        Log::info('User ID:', ['user_id' => Auth::id()]);

        // Check if cart is empty
        if ($cartItems->isEmpty()) {
            Log::error('Checkout failed: Cart is empty.');
            return redirect()->route('checkout')->with('error', 'Your cart is empty.');
        }

        // Log the Cart Items
        Log::info('Cart Items:', ['cart_items' => $cartItems]);

        // Calculate total amount
        $totalAmount = $this->calculateTotalAmount($cartItems);

        // Prepare products array with necessary details
        $products = [];
        foreach ($cartItems as $item) {
            $product = Product::find($item->product_id);
            if ($product) {
                $products[] = [
                    'name' => $product->name,
                    'price' => $product->price,
                    'quantity' => $item->quantity,
                    'image' => $product->image,
                    'category_name' => $item->product && $item->product->category ? $item->product->category->name : 'Unknown Category',
                ];
            }
        }

        // Try to create the order
        try {
            $order = Order::create([
                'user_id' => Auth::id(),
                'products' => json_encode($products), // Store products with detailed info
                'total_amount' => $totalAmount,
                'payment_method' => $request->payment_method, // Capture payment method from request
            ]);
            Log::info('Order created:', ['order' => $order]);

            // Update the product stock
            foreach ($cartItems as $item) {
                $product = Product::find($item->product_id);
                if ($product) {
                    $product->stock -= $item->quantity;
                    $product->save();
                }
            }

            // Clear the cart
            Cart::where('user_id', Auth::id())->delete();

            // Redirect to checked out page
            return redirect()->route('checkedout.index')->with('success', 'Thank you for your purchase!');
        } catch (\Exception $e) {
            Log::error('Order creation failed: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'There was a problem processing your order.']);
        }
    }

    // Display the checked out page
    public function checkedOut()
    {
        // Fetch orders for the authenticated user
        $orders = Order::where('user_id', Auth::id())->get();

        // Debugging: Check fetched orders
        Log::info('Fetched orders:', ['orders' => $orders]);

        return view('checked_out', compact('orders'));
    }

    // Remove an order
    public function removeOrder($id)
    {
        $order = Order::find($id);
        if ($order) {
            $order->delete(); // Delete the order
            return redirect()->route('checkedout.index')->with('success', 'Order removed successfully.');
        }

        return redirect()->route('checkedout.index')->with('error', 'Order not found.');
    }

    // Calculate total amount from cart items
    private function calculateTotalAmount($cartItems): float
    {
        $totalAmount = 0;

        foreach ($cartItems as $item) {
            $totalAmount += $item->price * $item->quantity;
        }

        return $totalAmount;
    }
}