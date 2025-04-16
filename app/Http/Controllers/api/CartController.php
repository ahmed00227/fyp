<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        $product = Product::find($request->product_id);
        auth()->user()->carts()->createOrFirst([
            'product_id' => $product->id
        ], [
            'quantity' => $request->quantity ?? 1,
        ]);
        return response()->json([
            'success' => true,
            'message' => 'Product added to cart successfully.'
        ]);
    }

    public function removeFromCart(Request $request)
    {
        $product = Product::find($request->product_id);
        auth()->user()->carts()->where('product_id', $product->id)->delete();
        return response()->json([
            'success' => true,
            'message' => 'Product removed from the cart successfully.'
        ]);
    }

    public function emptyCart()
    {
        auth()->user()->carts()->delete();
        return response()->json([
            'success' => true,
            'message' => 'Your cart is empty.'
        ]);
    }

    public function updateCart(Request $request)
    {
        $product = Product::find($request->product_id);
        auth()->user()->carts()->updateOrCreate([
            'product_id' => $product->id
        ], [
            'quantity' => $request->quantity ?? 1,
        ]);
        return response()->json([
            'success' => true,
            'message' => 'Cart Updated successfully.'
        ]);
    }

    public function checkout()
    {
        $items = auth()->user()->carts()->get();
        $sum = 0;

        foreach ($items as $item) {
            $sum += $item->quantity * $item->product->price;
        }
        $order=Order::create([
            'user_id' => auth()->id(),
            'total_price' => $sum,
        ]);
        foreach ($items as $item) {
            $order->products()->attach($item->id, ['quantity' => $item->quantity]);
        }
        auth()->user()->carts()->delete();
        return response()->json([
            'success' => true,
            'message' => 'Order placed successfully.'
        ]);
    }
}
