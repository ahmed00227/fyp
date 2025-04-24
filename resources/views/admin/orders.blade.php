@extends('admin_layout')
@section('body')
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="mb-4" style="font-size: 2rem;font-weight: bold">Order Management</h2>
            </div>

        <div class="table-responsive">
            <table class="table table-bordered align-middle text-center">
                <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Bill</th>
                    <th>Placed at</th>
                    <th>Order Status</th>
                </tr>
                </thead>
                <tbody>
                @forelse ($orders as $order)
                    <tr>
                        <td>{{ $order->id }}</td>
                        <td>{{ ucwords($order->user->name) }}</td>
                        <td>PKR {{ $order->total }}</td>
                        <td class="col-6 text-truncate">{{ $order->created_at->format('H:i d/m/y')}}</td>
                        <td>
                            <form action="{{route('order.update-status',$order->id)}}" method="post">
                                @csrf
                                <select name="status" class="form-select px-2 mx-2 w-auto d-inline py-2 rounded" onchange="this.form.submit()">
                                    <option value="pending" {{$order->status=='pending' ? 'selected' :''}}>Pending</option>
                                    <option value="processing" {{$order->status=='processing' ? 'selected' :''}}>Processing</option>
                                    <option value="completed" {{$order->status=='completed' ? 'selected' :''}}>Delivered</option>
                                    <option value="cancel" {{$order->status=='cancel' ? 'selected' :''}}>Cancelled</option>
                                </select>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5">No orders found.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>

        {{ $orders->links() }} <!-- Laravel pagination -->
    </div>
@endsection

