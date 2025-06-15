<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $data=[
            'users' => User::where('role','user')->count(),
            'pendingOrders' => Order::where('status','pending')->count(),
            'products' => Product::count(),
            'monthOrders' => Order::whereMonth('created_at', '=', date('m'))->count(),
            'deliveredOrders' => Order::where('status','completed')->count(),
            'monthSales' => Order::whereMonth('created_at', '=', date('m'))->sum('total'),
        ];
        return view('admin.dashboard',compact('data'));
    }
    public function users()
    {
        $users = User::where('role','user')->paginate();
        return view('admin.users',compact('users'));
    }
}
