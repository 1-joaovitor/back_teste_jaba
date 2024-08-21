<?php

namespace App\Services\categorie;

use App\Models\Category;
use Illuminate\Http\Request;
use Exception;

class CategoriesService
{
    public function registerCategory(Request $request)
    {
        try {

            $request->validate([
                'name' => 'required|string|max:255|unique:categories,name',
            ]);


            return Category::create([
                'name' => $request->name,
            ]);
        } catch (Exception $e) {

            throw new Exception('Não foi possível registrar a categoria: ' . $e->getMessage());
        }
    }

    public function getCategories()
    {
        try {

            return Category::all();
        } catch (Exception $e) {

            throw new Exception('Não foi possível recuperar as categorias: ' . $e->getMessage());
        }
    }

    public function getCategoryById($id)
    {
        try {

            return Category::findOrFail($id);
        } catch (Exception $e) {

            throw new Exception('Categoria não encontrada: ' . $e->getMessage());
        }
    }

    public function updateCategory(Request $request, $id)
    {
        try {
            $category = Category::findOrFail($id);


            $request->validate([
                'name' => 'required|string|max:255|unique:categories,name,' . $id,
            ]);


            $category->update([
                'name' => $request->name,
            ]);

            return $category;
        } catch (Exception $e) {

            throw new Exception('Não foi possível atualizar a categoria: ' . $e->getMessage());
        }
    }

    public function destroyCategory($id)
    {
        try {
            $category = Category::findOrFail($id);
            $category->delete();

            return response()->json(['message' => 'Categoria removida com sucesso.']);
        } catch (Exception $e) {

            throw new Exception('Não foi possível remover a categoria: ' . $e->getMessage());
        }
    }
}
