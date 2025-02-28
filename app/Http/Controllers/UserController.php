<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function login(LoginRequest $request){
        if(Auth::attempt($request->only(['email','password']))){
            if (Auth::user()->role=='admin') {
                return redirect()->route('dashboard');
            } else if(Auth::user()->role=='doctor') {
                return redirect()->route('user.index');
            }else{
                //
            }
        }
        auth()->logout();
        return back()->with('error','Invalid Credentials');
    }
}
