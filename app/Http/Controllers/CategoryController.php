<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;

class CategoryController extends Controller
{
    public function store(StoreCategoryRequest $request): RedirectResponse
    {
        Category::create($request->validated());

        return redirect()
            ->route('products.index')
            ->with('status', 'category_created');
    }

    public function update(UpdateCategoryRequest $request, Category $category): RedirectResponse
    {
        $category->update($request->validated());

        return redirect()
            ->route('products.index')
            ->with('status', 'category_updated');
    }

    public function destroy(Category $category): RedirectResponse
    {
        if ($category->products()->exists()) {
            return redirect()
                ->route('products.index')
                ->withErrors('Kategori tidak dapat dihapus karena masih memiliki produk aktif.');
        }

        $category->delete();

        return redirect()
            ->route('products.index')
            ->with('status', 'category_deleted');
    }
}
