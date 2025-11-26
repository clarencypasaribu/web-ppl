<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\View\View;

class HomeController extends Controller
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
            ->latest()
            ->take(6)
            ->get();

        return view('home', compact('products'));
    }
}
