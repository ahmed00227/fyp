<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function cartList(){
        $cart = Cart::where('user_id',auth()->id())->with('product')->paginate();
        return response()->json([
            'success' => true,
            'cart_count' => Cart::where('user_id',auth()->id())->count(),
            'carts' => $cart->items(), // actual product data
            'pagination' => [
                'current_page' => $cart->currentPage(),
                'last_page'    => $cart->lastPage(),
                'per_page'     => $cart->perPage(),
                'total'        => $cart->total(),
                'next_page_url'=> $cart->nextPageUrl(),
                'prev_page_url'=> $cart->previousPageUrl(),
            ]
        ]);
    }
    public function addToCart(Request $request)
    {
        $product = Product::find($request->product_id);
        $cart = auth()->user()->carts()->firstOrNew([
        'product_id' => $product->id,
    ]);
        if ($cart->exists) {
            $cart->quantity += 1;
        } else {
            $cart->quantity = 1;
        }
        $cart->save();
        return $this->cartList();
    }

    public function removeFromCart(Request $request,$id)
    {
        auth()->user()->carts()->where('id', $id)->delete();
        return $this->cartList();
    }

    public function emptyCart()
    {
        auth()->user()->carts()->delete();
        return response()->json([
            'success' => true,
            'message' => 'Your cart is empty.'
        ]);
    }

    public function updateCart(Request $request,$id)
    {
        auth()->user()->carts()->updateOrCreate([
            'id' => $id
        ], [
            'quantity' => $request->quantity ?? 1,
        ]);
        return response()->json([
            'success' => true,
            'message' => 'Cart Updated successfully.'
        ]);
    }

    public function checkout(Request $request)
    {

        $items = auth()->user()->carts()->get();
        $sum = 0;

        foreach ($items as $item) {
            $sum += $item->quantity * $item->product->price;
        }
        $order=Order::create([
            'user_id' => auth()->id(),
            'total' => $sum,
            'receiver_name' => $request->name,
            'receiver_phone' => $request->phone,
            'delivery_address' => $request->address,
        ]);
        foreach ($items as $item) {
            $order->products()->attach($item->id, ['quantity' => $item->quantity]);
        }
        auth()->user()->carts()->delete();
        return response()->json([
            'success' => true,
            'cart_count' => Cart::where('user_id',auth()->id())->count(),
            'message' => 'Order placed successfully.'
        ]);
    }
}
