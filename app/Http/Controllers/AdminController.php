<?php

namespace App\Http\Controllers;

use App\Services\ProductService;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public ProductService $productService;
    public function __construct($productService){
        $this->productService = $productService;
    }

}
