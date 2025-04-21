@extends('admin_layout')
@section('body')
    <h1 class="text-3xl font-bold mb-4">
        Welcome to the Admin Dashboard
    </h1>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-bold mb-2">
                Total Users
            </h2>
            <p class="text-2xl">
                {{$data['users']}}
            </p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-bold mb-2">
                This Month Sales
            </h2>
            <p class="text-2xl">
                PKR {{$data['monthSales']}}
            </p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-bold mb-2">
                Total Products
            </h2>
            <p class="text-2xl">
                {{$data['products']}}
            </p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-bold mb-2">
                This Month Orders
            </h2>
            <p class="text-2xl">
                {{$data['monthOrders']}}
            </p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-bold mb-2">
                Orders Delivered
            </h2>
            <p class="text-2xl">
                {{$data['deliveredOrders']}}
            </p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-bold mb-2">Pending Orders
            </h2>
            <p class="text-2xl">
                {{$data['pendingOrders']}}
            </p>
        </div>
    </div>
@endsection
