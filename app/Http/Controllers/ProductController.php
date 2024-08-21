<?php

namespace App\Http\Controllers;
use App\Services\products\ProductsService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $productService;
  
    public function __construct(ProductsService $productService)
    {
        $this->productService = $productService;
    }

    public function index()
    {

        $result = $this->productService->getProducts();
        return  $result;
    }

    public function store(Request $request)
    {
        $result = $this->productService->addProduct($request);
        return  $result;
    }

    public function show($id)
    {
        $result = $this->productService->getByid($id);
        return  $result;
    }

    public function update(Request $request, $id)
    {
        $result = $this->productService->updateProduct($request, $id);
        return  $result;
    }

    public function destroy($id)
    {
        $result = $this->productService->destroyProduct($id);
        return  $result;
    }
}
