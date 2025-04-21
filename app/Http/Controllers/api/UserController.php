<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    public function login(Request $request)
    {
        try {
            $request->validate([
                'email'    => 'required|email|exists:users,email',
                'password' => 'required',
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'errors' => $e->errors(), // Get the error messages
            ], 422); // 422 Unprocessable Entity HTTP status code
        }
        if (Auth::attempt($request->only(['email', 'password']))) {
            if (Auth::user()->role == 'user') {
                $token = auth()->user()->createToken("access-token")->plainTextToken;
                return response()->json([
                    'success' => true,
                    'user' => Auth::user(),
                    'cart_count' => Cart::where('user_id', auth()->id())->count(),
                    'token' => $token
                ], 200);
            }
        }
        auth()->logout();
        return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
    }

    public function signup(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|min:8|confirmed',
                'password_confirmation' => 'required',
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'errors' => $e->errors(), // Get the error messages
            ], 422); // 422 Unprocessable Entity HTTP status code
        }
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);
        return response()->json([
            'success' => true,
            'message' => 'User created successfully'
        ]);
    }

    public function logout()
    {
        Auth::logout();
        return response()->json([
            'success' => true,
            'message' => 'User successfully signed out'
        ]);
    }

    public function orders()
    {
        $orders = auth()->user()->orders;
        return response()->json([
            'success' => true,
            'orders' => $orders
        ]);
    }
    public function productsList(Request $request){
        $products = Product::query();
        if($request->search){
            $products = $products->where('name', 'like', '%'.$request->search.'%');
        }
        $products=$products->paginate(9);
        return response()->json([
            'success' => true,
            'products' => $products->items(), // actual product data
            'pagination' => [
                'current_page' => $products->currentPage(),
                'last_page'    => $products->lastPage(),
                'per_page'     => $products->perPage(),
                'total'        => $products->total(),
                'next_page_url'=> $products->nextPageUrl(),
                'prev_page_url'=> $products->previousPageUrl(),
            ]
        ]);
    }
}
