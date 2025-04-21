<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::latest()->paginate();
        return view('product.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('product.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        $image = $request->file('image');
        $image_name = Str::random(3) . time() . '.' . $image->getClientOriginalExtension();
        storage_path('app/public/product/images') . '/' . $image_name;
        Product::create([
           'name' => $request->name,
           'description' => $request->description,
           'price' => $request->price,
           'image' => $image_name,
        ]);
        return redirect()->route('product.index')->with('success', 'Product created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = Product::find($id);
        return view('product.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, string $id)
    {
        $product = Product::find($id);
        if(!$product){
            return redirect()->route('product.index')->with('error', 'Product not found');
        }
        if($request->file('image')){
            $image = $request->file('image');
            $image_name = Str::random(3) . time() . '.' . $image->getClientOriginalExtension();
            storage_path('app/public/product/images') . '/' . $image_name;
            $product->update([
                'image' => $image_name,
            ]);
        }
        $product->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
        ]);
        return redirect()->route('product.index')->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Product::destroy($id);
        return redirect()->route('product.index')->with('success', 'Product deleted successfully.');
    }
}
