<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Seller;
use Illuminate\View\View;

class PlatformReportController extends Controller
{
    public function index(): View
    {
        $activeSellers = Seller::where('status', Seller::STATUS_APPROVED)
            ->orderBy('store_name')
            ->get();

        $inactiveSellers = Seller::where('status', '!=', Seller::STATUS_APPROVED)
            ->orderBy('store_name')
            ->get();

        $sellersByProvince = Seller::select('province')
            ->selectRaw('COUNT(*) as total')
            ->groupBy('province')
            ->orderBy('province')
            ->get();

        $productsByRating = Product::with(['seller', 'category'])
            ->withAvg('reviews', 'rating')
            ->orderByDesc('reviews_avg_rating')
            ->orderBy('name')
            ->get();

        return view('reports.platform', [
            'activeSellers' => $activeSellers,
            'inactiveSellers' => $inactiveSellers,
            'sellersByProvince' => $sellersByProvince,
            'productsByRating' => $productsByRating,
        ]);
    }
}
