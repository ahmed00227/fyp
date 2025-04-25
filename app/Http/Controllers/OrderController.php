<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::latest()->paginate();
        return view('admin.orders',compact('orders'));
    }
    public function updateStatus(Request $request,$id){
        $order = Order::find($id);
        $order->status = $request->status;
        $order->save();
        return redirect()->route('order.index');
    }
}
