<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\ProductReview;
use App\Models\Seller;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class PlatformDashboardController extends Controller
{
    public function index(): View
    {
        $productsByCategory = Category::withCount('products')
            ->orderBy('name')
            ->get();

        $storesByProvince = Seller::select('province', DB::raw('count(*) as total'))
            ->groupBy('province')
            ->orderBy('province')
            ->get();

        $activeSellers = Seller::where('status', Seller::STATUS_APPROVED)->count();
        $inactiveSellers = Seller::where('status', '!=', Seller::STATUS_APPROVED)->count();
        $reviewsCount = ProductReview::count();

        return view('dashboards.platform', compact(
            'productsByCategory',
            'storesByProvince',
            'activeSellers',
            'inactiveSellers',
            'reviewsCount'
        ));
    }
}
