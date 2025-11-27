<?php

namespace App\Http\Controllers;

use App\Models\Seller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SellerProfileController extends Controller
{
    public function show(Seller $seller): View
    {
        return view('profile.show', compact('seller'));
    }

    public function me(Request $request): View|RedirectResponse
    {
        $sellerId = $request->session()->get('seller_auth_id');

        if (! $sellerId) {
            return redirect()
                ->route('seller.login')
                ->withErrors('Silakan login sebagai penjual untuk melihat profil.');
        }

        $seller = Seller::withCount('products')->findOrFail($sellerId);

        return view('sellers.profile', compact('seller'));
    }
}
