<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSellerPasswordRequest;
use App\Models\Seller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\URL;
use Illuminate\View\View;

class SellerPasswordController extends Controller
{
    public function create(Request $request, Seller $seller): View|RedirectResponse
    {
        abort_if($seller->status !== Seller::STATUS_APPROVED, 403, 'Seller belum disetujui.');

        if ($seller->password) {
            return redirect()
                ->route('seller.login')
                ->with('status', 'password_already_set')
                ->with('prefill_email', $seller->pic_email);
        }

        $expiresTimestamp = (int) $request->query('expires');
        $expiresAt = $expiresTimestamp
            ? Carbon::createFromTimestamp($expiresTimestamp)
            : now()->addMinutes(15);

        $storeUrl = URL::temporarySignedRoute(
            'sellers.password.store',
            $expiresAt,
            ['seller' => $seller->id]
        );

        return view('auth.seller-create-password', [
            'seller' => $seller,
            'storeUrl' => $storeUrl,
        ]);
    }

    public function store(StoreSellerPasswordRequest $request, Seller $seller): RedirectResponse
    {
        abort_if($seller->status !== Seller::STATUS_APPROVED, 403, 'Seller belum disetujui.');

        if ($seller->password) {
            return redirect()
                ->route('seller.login')
                ->with('status', 'password_already_set');
        }

        $seller->update([
            'password' => $request->validated()['password'],
        ]);

        return redirect()
            ->route('seller.login')
            ->with('status', 'password_created')
            ->with('prefill_email', $seller->pic_email);
    }
}
