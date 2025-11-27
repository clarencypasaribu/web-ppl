<?php

namespace App\Http\Controllers;

use App\Models\ProductReview;
use App\Models\Seller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class SellerDashboardController extends Controller
{
    public function show(Seller $seller): View
    {
        return $this->buildDashboardView($seller);
    }

    public function home(Request $request): RedirectResponse|View
    {
        $sellerId = $request->session()->get('seller_auth_id');

        if (! $sellerId) {
            return redirect()
                ->route('seller.login')
                ->withErrors('Silakan login terlebih dahulu untuk mengakses dashboard penjual.');
        }

        $seller = Seller::findOrFail($sellerId);

        return $this->buildDashboardView($seller);
    }

    private function buildDashboardView(Seller $seller): View
    {
        $productStocks = $seller->products()
            ->orderBy('name')
            ->get(['id', 'name', 'stock']);

        $productsWithAvgRating = $seller->products()
            ->withAvg('reviews', 'rating')
            ->withCount('reviews')
            ->orderBy('name')
            ->get();

        $ratingsByProvince = ProductReview::select('province', DB::raw('count(*) as total'))
            ->whereHas('product', function ($query) use ($seller) {
                $query->where('seller_id', $seller->id);
            })
            ->groupBy('province')
            ->orderBy('province')
            ->get();

        $categoriesCount = $seller->products()
            ->distinct('category_id')
            ->count('category_id');

        $recentReviewsByProduct = $seller->products()
            ->with(['reviews' => function ($query) {
                $query->latest()->limit(3);
            }])
            ->orderBy('name')
            ->get(['id', 'name']);

        $allSellers = Seller::orderBy('store_name')->get();

        return view('dashboards.seller', compact(
            'seller',
            'allSellers',
            'productStocks',
            'productsWithAvgRating',
            'ratingsByProvince',
            'categoriesCount',
            'recentReviewsByProduct'
        ));
    }
}
