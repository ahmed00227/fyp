@extends('admin_layout')
@section('body')
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="mb-4" style="font-size: 2rem;font-weight: bold">Product Management</h2>
            <a href="{{route('product.create')}}" class="btn btn-primary">New Product</a>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered align-middle text-center">
                <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>description</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @forelse ($products as $product)
                    <tr>
                        <td>{{ $product->id }}</td>
                        <td>{{ ucwords($product->name) }}</td>
                        <td>PKR {{ $product->price }}</td>
                        <td class="col-6 text-truncate">{{ $product->description}}</td>
                        <td>
                            <a href="{{ route('product.edit', $product->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('product.destroy', $product->id) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Are you sure to delete this user?');">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5">No products found.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>

        {{ $products->links() }} <!-- Laravel pagination -->
    </div>
@endsection

