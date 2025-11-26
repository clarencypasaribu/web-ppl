<?php
namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\Seller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->input('q'));
        $sellerName = trim((string) $request->input('seller'));
        $categoryId = $request->input('category_id');
        $city = trim((string) $request->input('city'));
        $province = trim((string) $request->input('province'));

        $products = Product::with(['seller', 'category'])
            ->when($search, function ($query) use ($search) {
                $query->where(function ($subQuery) use ($search) {
                    $subQuery
                        ->where('name', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%");
                });
            })
            ->when($sellerName, function ($query) use ($sellerName) {
                $query->whereHas('seller', function ($sellerQuery) use ($sellerName) {
                    $sellerQuery->where('store_name', 'like', "%{$sellerName}%");
                });
            })
            ->when($categoryId, function ($query) use ($categoryId) {
                $query->where('category_id', $categoryId);
            })
            ->when($city, function ($query) use ($city) {
                $query->whereHas('seller', function ($sellerQuery) use ($city) {
                    $sellerQuery->where('city', 'like', "%{$city}%");
                });
            })
            ->when($province, function ($query) use ($province) {
                $query->whereHas('seller', function ($sellerQuery) use ($province) {
                    $sellerQuery->where('province', 'like', "%{$province}%");
                });
            })
            ->orderByDesc('created_at')
            ->get();

        $categories = Category::withCount('products')->orderBy('name')->get();
        $editingCategory = null;

        if ($request->filled('edit_category')) {
            $editingCategory = Category::find($request->input('edit_category'));
        }

        return view('products.index', [
            'products' => $products,
            'categories' => $categories,
            'editingCategory' => $editingCategory,
            'filters' => [
                'q' => $search,
                'seller' => $sellerName,
                'category_id' => $categoryId,
                'city' => $city,
                'province' => $province,
            ],
        ]);
    }

    public function create(): View
    {
        $categories = Category::orderBy('name')->get();
        $sellers = Seller::orderBy('store_name')->get();

        return view('products.create', compact('categories', 'sellers'));
    }

    public function store(StoreProductRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['price'] = $this->normalizePrice($data['price']);
        $data['is_active'] = $request->boolean('is_active', true);

        if ($request->hasFile('product_image')) {
            $data['image_path'] = $request->file('product_image')->store('product-images', 'public');
        }

        unset($data['product_image']);

        Product::create($data);

        return redirect()
            ->route('products.index')
            ->with('status', 'product_created');
    }

    public function edit(Product $product): View
    {
        $categories = Category::orderBy('name')->get();
        $sellers = Seller::orderBy('store_name')->get();

        return view('products.edit', compact('product', 'categories', 'sellers'));
    }

    public function update(UpdateProductRequest $request, Product $product): RedirectResponse
    {
        $data = $request->validated();
        $data['price'] = $this->normalizePrice($data['price']);
        $data['is_active'] = $request->boolean('is_active', false);

        if ($request->hasFile('product_image')) {
            if ($product->image_path) {
                Storage::disk('public')->delete($product->image_path);
            }

            $data['image_path'] = $request->file('product_image')->store('product-images', 'public');
        }

        unset($data['product_image']);

        $product->update($data);

        return redirect()
            ->route('products.index')
            ->with('status', 'product_updated');
    }

    public function destroy(Product $product): RedirectResponse
    {
        if ($product->image_path) {
            Storage::disk('public')->delete($product->image_path);
        }

        $product->delete();

        return redirect()
            ->route('products.index')
            ->with('status', 'product_deleted');
    }

    private function normalizePrice($price): float
    {
        if (is_string($price)) {
            $normalized = str_replace([' ', '.'], '', $price);
            $normalized = str_replace(',', '.', $normalized);

            return (float) $normalized;
        }

        return (float) $price;
    }
}
