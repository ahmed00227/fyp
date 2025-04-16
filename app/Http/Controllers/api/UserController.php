<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\SignupRequest;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function login(LoginRequest $request)
    {
        if (Auth::attempt($request->only(['email', 'password']))) {
            if (Auth::user()->role == 'user') {
                $token = auth()->user()->createToken("access-token")->plainTextToken;
                return response()->json([
                    'success' => true,
                    'user' => Auth::user(),
                    'token' => $token
                ], 200);
            }
        }
        auth()->logout();
        return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
    }

    public function signup(SignupRequest $request)
    {
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
    public function productsList(){
        $products = Product::all();
        return response()->json([
            'success' => true,
            'products' => $products
        ]);
    }
}
