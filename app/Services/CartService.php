<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class CartService
{
    public function __construct()
    {
    }
    public function cartList(){
        try {
            $cart = Cart::where('user_id', auth()->id())->with('product')->paginate();
        }catch (\Exception $e){
            return false;
        }
        return [
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
        ];
    }
    public function addToCart(Request $request)
    {
        try {
            $product = Product::find($request->product_id);
            $cart = auth()->user()->carts()->firstOrNew([
                'product_id' => $product->id,
            ]);
            $cart->update(['quantity' => $cart->quantity ? ++$cart->quantity : 1]);
        }catch (\Exception $e){
            return false;
        }
        return true;
    }

    public function removeFromCart($id)
    {
        try{
            auth()->user()->carts()->where('id', $id)->delete();
        }catch(\Exception $e){
            return false;
        }
        return true;
    }

    public function emptyCart()
    {
        try {
            auth()->user()->carts()->delete();
        }catch (\Exception $e){
            return false;
        }
        return true;
    }

    public function updateCart(Request $request,$id)
    {
        try {
            auth()->user()->carts()->updateOrCreate([
                'id' => $id
            ], [
                'quantity' => $request->quantity ?? 1,
            ]);
        }catch (\Exception $e){
            return false;
        }
        return true;
    }

    public function checkout(Request $request)
    {
        try {
            $items = auth()->user()->carts()->get();
            $sum = 0;
            foreach ($items as $item) {
                $sum += $item->quantity * $item->product->price;
            }
            $order = Order::create([
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
        }catch (\Exception $e){
            return false;
        }
        return true;
    }
}
