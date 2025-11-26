<?php

namespace App\Http\Controllers;

use App\Models\ProductReview;
use Illuminate\View\View;

class AlertController extends Controller
{
    public function __invoke(): View
    {
        $reviews = ProductReview::query()
            ->with(['product.seller'])
            ->latest()
            ->take(20)
            ->get();

        return view('alerts.orders', compact('reviews'));
    }
}
