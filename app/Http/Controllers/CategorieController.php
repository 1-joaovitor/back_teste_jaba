<?php

namespace App\Http\Controllers;
use App\Services\categorie\CategoriesService;
use Illuminate\Http\Request;

class CategorieController extends Controller
{
    protected $categoriesService;

    public function __construct(CategoriesService $categoriesService)
    {
        $this->categoriesService = $categoriesService;
    }

    public function registerCategory(Request $request)
    {
        return $this->categoriesService->registerCategory($request);
    }

    public function getCategories()
    {
        return $this->categoriesService->getCategories();
    }

    public function getCategoryById($id)
    {
        return $this->categoriesService->getCategoryById($id);
    }

    public function updateCategory(Request $request, $id)
    {
        return $this->categoriesService->updateCategory($request, $id);
    }

    public function deleteCategory($id)
    {
        return $this->categoriesService->destroyCategory($id);
    }
}
