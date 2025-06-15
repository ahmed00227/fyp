<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use App\Services\ApiResponseModifier;
use App\Services\CartService;
use Illuminate\Http\Request;

class CartController extends Controller
{
    private ApiResponseModifier $modifier;
    private CartService $cartService;
    public function __construct( ApiResponseModifier $modifier, CartService $cartService)
    {
        $this->modifier = $modifier;
        $this->cartService = $cartService;
    }
    public function cartList(){
        return $this->modifier->setData($this->cartService->cartList())->response();
    }
    public function addToCart(Request $request)
    {
        $cart = $this->cartService->addToCart($request);
        if($cart){
            return $this->cartList();
        }else{
            return $this->modifier->setMessage('Cart not added')->setResponseCode(422)->response();
        }
    }

    public function removeFromCart(Request $request,$id)
    {
        $removal =$this->cartService->removeFromCart($id);
        if($removal){
            return $this->cartList();
        }else{
            return $this->modifier->setMessage('Error On Removing From Cart')->setResponseCode(422)->response();
        }
    }

    public function emptyCart()
    {
        $empty= $this->cartService->emptyCart();
        if($empty){
            return $this->modifier->setMessage('Your cart is empty')->response();
        }else{
            return $this->modifier->setMessage('Unable to Empty the cart')->setResponseCode(422)->response();
        }
    }

    public function updateCart(Request $request,$id)
    {
        $update =$this->cartService->updateCart($request,$id);
        if($update){
            return $this->modifier->setMessage('Cart Updated')->response();
        }else{
            return $this->modifier->setMessage('Error Updating Cart')->setResponseCode(422)->response();
        }
    }

    public function checkout(Request $request)
    {
        $checkout =$this->cartService->checkout($request);
        if($checkout){
            return $this->modifier->setMessage('Order placed successfully')->response();
        }else{
            return $this->modifier->setMessage('Unable To Checkout')->setResponseCode(422)->response();
        }
    }
}
