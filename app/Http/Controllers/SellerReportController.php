<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Seller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SellerReportController extends Controller
{
    public function index(Request $request): View
    {
        $sessionSellerId = $request->session()->get('seller_auth_id');
        $selectedSellerId = (int) $request->input('seller_id', $sessionSellerId);

        $sellerOptions = Seller::orderBy('store_name')->get();
        $selectedSeller = $selectedSellerId ? Seller::find($selectedSellerId) : null;

        $baseQuery = Product::query()
            ->with(['category', 'seller'])
            ->withAvg('reviews', 'rating');

        if ($selectedSellerId) {
            $baseQuery->where('seller_id', $selectedSellerId);
        }

        $stockReport = (clone $baseQuery)
            ->orderByDesc('stock')
            ->get();

        $ratingReport = (clone $baseQuery)
            ->orderByDesc('reviews_avg_rating')
            ->orderBy('name')
            ->get();

        $criticalStockReport = (clone $baseQuery)
            ->where('stock', '<', 2)
            ->orderBy('stock')
            ->get();

        return view('reports.seller', [
            'stockReport' => $stockReport,
            'ratingReport' => $ratingReport,
            'criticalStockReport' => $criticalStockReport,
            'sellerOptions' => $sellerOptions,
            'selectedSellerId' => $selectedSellerId,
            'selectedSeller' => $selectedSeller,
        ]);
    }
}
