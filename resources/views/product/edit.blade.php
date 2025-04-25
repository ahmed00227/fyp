@extends('admin_layout')
@section('body')
    <style>
        .form-container {
            max-width: 600px;
            margin: 2rem auto;
            padding: 2rem;
            background-color: #ffffff;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            font-family: Arial, sans-serif;
        }

        .form-container h2 {
            font-size: 2rem;
            font-weight: bold;
            margin-bottom: 1.5rem;
            text-align: center;
        }

        .form-group {
            margin-bottom: 1.25rem;
        }

        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: bold;
        }

        .form-control {
            width: 100%;
            padding: 0.5rem;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 1rem;
        }

        .form-control:focus {
            border-color: #007bff;
            outline: none;
        }

        .btn {
            display: inline-block;
            padding: 0.6rem 1.2rem;
            font-size: 1rem;
            font-weight: bold;
            color: #fff;
            background-color: #28a745;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: #218838;
        }
    </style>

    <div class="form-container">
        <h2>Update Product</h2>

        <form action="{{ route('product.update',$product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name" class="form-label">Product Name</label>
                <input type="text" name="name" id="name" class="form-control" value="{{$product->name}}" required>
            </div>

            <div class="form-group">
                <label for="price" class="form-label">Unit Price (PKR)</label>
                <input type="number" name="price" id="price" value="{{$product->price}}" class="form-control" step="0.01" min="0" required>
            </div>

            <div class="form-group">
                <label for="description" class="form-label">Product Description</label>
                <textarea name="description" id="description" class="form-control" rows="4" required>{{$product->description}}</textarea>
            </div>

            <div class="form-group">
                <label for="image" class="form-label">Product Image</label>
                <input type="file" name="image" id="image" class="form-control" accept="image/*">
            </div>

            <button type="submit" class="btn">Update Product</button>
        </form>
    </div>
@endsection
