<?php

namespace App\Services\products;

use App\Models\Product;
use Illuminate\Http\Request;
use Exception;

class ProductsService
{
    public function getProducts()
    {
        try {
            return Product::with('categories')->get();
        } catch (Exception $e) {
            throw new Exception('Não foi possível recuperar os produtos.');
        }
    }

    public function addProduct(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'registration_date' => 'required|date',
                'price' => 'required|numeric|min:0',
                'user_id' => 'required|exists:users,id',
                'category_ids' => 'nullable|array',
                'category_ids.*' => 'exists:categories,id',
            ]);

          
            $product = Product::create($request->only(['name', 'registration_date', 'price', 'user_id']));

           
            if ($request->has('category_ids')) {
                $product->categories()->sync($request->input('category_ids'));
            }

            return $product->load('categories');
        } catch (Exception $e) {
            throw new Exception('Não foi possível adicionar o produto.');
        }
    }

    public function getById($id)
    {
        try {
            return Product::with('categories')->findOrFail($id);
        } catch (Exception $e) {
            throw new Exception('Produto não encontrado.');
        }
    }

    public function updateProduct(Request $request, $id)
    {
        try {
            $product = Product::findOrFail($id);

            $request->validate([
                'name' => 'sometimes|required|string|max:255',
                'registration_date' => 'sometimes|required|date',
                'price' => 'sometimes|required|numeric|min:0',
                'user_id' => 'sometimes|required|exists:users,id',
                'category_ids' => 'nullable|array',
                'category_ids.*' => 'exists:categories,id',
            ]);

           
            $product->update($request->only(['name', 'registration_date', 'price', 'user_id']));

           
            if ($request->has('category_ids')) {
                $product->categories()->sync($request->input('category_ids'));
            } else {
                $product->categories()->detach(); 
            }

            return $product->load('categories');
        } catch (Exception $e) {
            throw new Exception('Não foi possível atualizar o produto.');
        }
    }

    public function destroyProduct($id)
    {
        try {
            $product = Product::findOrFail($id);
            $product->categories()->detach(); 
            $product->delete();

            return response()->json(['message' => 'Produto removido com sucesso.']);
        } catch (Exception $e) {
            throw new Exception('Não foi possível remover o produto.');
        }
    }
}
