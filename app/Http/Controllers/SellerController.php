<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSellerRequest;
use App\Http\Requests\VerifySellerRequest;
use App\Mail\SellerVerificationResultMail;
use App\Models\Seller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\View\View;

class SellerController extends Controller
{
    public function create(): View
    {
        return view('sellers.create');
    }

    public function store(StoreSellerRequest $request): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('pic_identity_photo')) {
            $data['pic_identity_photo_path'] = $request->file('pic_identity_photo')->store('seller-documents', 'public');
        }

        if ($request->hasFile('pic_profile_photo')) {
            $data['pic_profile_photo_path'] = $request->file('pic_profile_photo')->store('seller-documents', 'public');
        }

        unset($data['pic_identity_photo'], $data['pic_profile_photo']);

        Seller::create($data);

        return redirect()
            ->route('sellers.register')
            ->with('status', 'registration_submitted');
    }

    public function verificationIndex(): View
    {
        $sellers = Seller::orderByDesc('created_at')->get();

        return view('sellers.verifications', compact('sellers'));
    }

    public function verify(Seller $seller, VerifySellerRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $seller->fill([
            'status' => $data['status'],
            'verification_notes' => $data['verification_notes'] ?? null,
            'verified_at' => now(),
        ])->save();

        $freshSeller = $seller->fresh();

        $setPasswordUrl = null;
        if ($freshSeller->status === Seller::STATUS_APPROVED && ! $freshSeller->password) {
            $setPasswordUrl = URL::temporarySignedRoute(
                'sellers.password.create',
                now()->addDays(7),
                ['seller' => $freshSeller->id]
            );
        }

        Mail::to($freshSeller->pic_email)->send(new SellerVerificationResultMail($freshSeller, $setPasswordUrl));

        return redirect()
            ->route('sellers.verifications')
            ->with('status', 'seller_verified');
    }
}
