<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function loginView()
    {
        return view('login');
    }
    public function login(LoginRequest $request){
        if(auth()->attempt(['email' => $request->email, 'password' => $request->password])){
            $role = auth()->user()->role;
            if($role == 'admin'){
                return redirect()->route('admin.dashboard');
            }elseif($role=='doctor'){
                return redirect()->route('doctor.dashboard');
            }
            auth()->logout();
        }
        return redirect()->route('login')->with('error','Invalid Credentials');
    }
    public function logout(){
        auth()->logout();
        return redirect()->route('login')->with('notice','Logged out successfully');
    }
}
