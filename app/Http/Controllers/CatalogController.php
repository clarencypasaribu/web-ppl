<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\View\View;

class CatalogController extends Controller
{
    public function index(): View
    {
        $products = Product::with([
                'category',
                'seller',
                'reviews' => function ($query) {
                    $query->latest()->limit(3);
                },
            ])
            ->withAvg('reviews', 'rating')
            ->withCount('reviews')
            ->where('is_active', true)
            ->orderByDesc('created_at')
            ->get();

        return view('catalog.index', compact('products'));
    }
}
