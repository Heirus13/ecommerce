<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{
    // Display the cart items
    public function index()
    {
        // Retrieve cart items for the authenticated user
        $cartItems = Cart::where('user_id', Auth::id())->with('product.category')->get();
        return view('cart', compact('cartItems'));
    }

    // Add or update items in the cart
    public function add(Request $request, $productId)
    {
        // Check if the user is authenticated
        if (!Auth::check()) {
            return response()->json(['error' => 'You must be logged in to add items to your cart.'], 403);
        }
    
        // Find the product
        $product = Product::with('category')->find($productId);
        if (!$product) {
            return response()->json(['error' => 'Product not found.'], 404);
        }
    
        // Check if the product is already in the cart
        $cart = Cart::where('user_id', Auth::id())->where('product_id', $productId)->first();
    
        if ($cart) {
            // If it exists, just increment the quantity
            $cart->increment('quantity');
        } else {
            // If it does not exist, create a new cart item
            Cart::create([
                'user_id' => Auth::id(),
                'product_id' => $productId,
                'category_id' => $product->category_id, // Add category_id
                'price' => $product->price,
                'image' => $product->image, // Assuming the image is part of the product
                'quantity' => 1,
            ]);
        }
    
        return response()->json(['success' => 'Product added to cart successfully!']);
    }
    // Update items in the cart
    public function update(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'quantity' => 'required|array',
            'quantity.*' => 'integer|min:1', // Ensure all quantities are valid
        ]);
    
        foreach ($request->input('quantity') as $id => $quantity) {
            // Check if the cart item exists
            $cart = Cart::where('user_id', Auth::id())->where('product_id', $id)->first();
            if ($cart) {
                $cart->update(['quantity' => $quantity]); // Update the quantity
                Log::info('Updated cart item quantity', ['cart_id' => $cart->id, 'new_quantity' => $quantity]);
            } else {
                return redirect()->route('cart.index')->with('error', 'Item not found in cart.');
            }
        }
    
        return redirect()->route('cart.index')->with('success', 'Cart updated successfully!');
    }
    // Remove an item from the cart
    public function remove($id)
    {
        // Check if the user is authenticated
        if (!Auth::check()) {
            return response()->json(['authenticated' => false], 403);
        }

        $cart = Cart::where('user_id', Auth::id())->where('product_id', $id)->first();
        
        if ($cart) {
            // Remove the item from the cart
            $cart->delete();
            Log::info('Removed item from cart', ['cart_id' => $cart->id]);
            return response()->json(['success' => 'Item removed from cart!']);
        }

        return response()->json(['error' => 'Item not found in cart.'], 404);
    }

    // Clear the cart
    public function clearCart(Request $request)
    {
        if (Auth::check()) {
            Cart::where('user_id', Auth::id())->delete(); // Clear the cart for the authenticated user
            Log::info('Cleared cart for user', ['user_id' => Auth::id()]);
            return response()->json(['success' => 'Cart cleared successfully!']);
        }

        return response()->json(['authenticated' => false], 403);
    }

    // Display the checkout view with cart items
    public function checkout()
    {
        $cartItems = Cart::where('user_id', Auth::id())->with('product')->get();
        
        // Check if cart is empty and handle accordingly
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty. Please add items before checking out.');
        }

        return view('checkout', compact('cartItems'));
    }
}