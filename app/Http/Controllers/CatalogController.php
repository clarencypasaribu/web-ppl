<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class CatalogController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->input('q', ''));
        $searchTerms = collect(preg_split('/[\s,]+/', $search, -1, PREG_SPLIT_NO_EMPTY))
            ->filter()
            ->values();

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
            ->when($searchTerms->isNotEmpty(), function ($query) use ($searchTerms) {
                $query->where(function ($sub) use ($searchTerms) {
                    foreach ($searchTerms as $term) {
                        $sub->where(function ($inner) use ($term) {
                            $inner->where('name', 'like', "%{$term}%")
                                ->orWhere('description', 'like', "%{$term}%")
                                ->orWhereHas('category', function ($categoryQuery) use ($term) {
                                    $categoryQuery->where('name', 'like', "%{$term}%");
                                })
                                ->orWhereHas('seller', function ($sellerQuery) use ($term) {
                                    $sellerQuery->where('store_name', 'like', "%{$term}%")
                                        ->orWhere('city', 'like', "%{$term}%")
                                        ->orWhere('province', 'like', "%{$term}%");
                                });
                        });
                    }
                });
            })
            ->orderByDesc('created_at')
            ->get();

        return view('catalog.index', [
            'products' => $products,
            'search' => $search,
        ]);
    }

    public function show(Product $product): View
    {
        $product->load([
            'category',
            'seller',
            'reviews' => function ($query) {
                $query->latest();
            },
        ])->loadAvg('reviews', 'rating')
          ->loadCount('reviews');

        $otherProducts = Product::with(['category'])
            ->withAvg('reviews', 'rating')
            ->where('seller_id', $product->seller_id)
            ->where('id', '!=', $product->id)
            ->where('is_active', true)
            ->latest()
            ->limit(4)
            ->get();

        return view('catalog.show', compact('product', 'otherProducts'));
    }

    public function storeReview(Request $request, Product $product)
    {
        $validated = $request->validate([
            'reviewer_name' => ['required', 'string', 'max:255'],
            'reviewer_phone' => ['required', 'string', 'max:32'],
            'reviewer_email' => ['required', 'email', 'max:255'],
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'province' => ['required', 'string', 'max:255'],
            'comment' => ['nullable', 'string', 'max:2000'],
        ]);

        $product->reviews()->create($validated);

        Mail::raw(
            "Terima kasih telah memberikan ulasan untuk {$product->name}. Kami menghargai waktu dan masukan Anda!",
            function ($message) use ($validated, $product) {
                $message->to($validated['reviewer_email'])
                    ->subject("Terima kasih atas ulasan Anda untuk {$product->name}");
            }
        );

        return redirect()
            ->route('catalog.show', $product)
            ->with('status', 'review_submitted');
    }
}
