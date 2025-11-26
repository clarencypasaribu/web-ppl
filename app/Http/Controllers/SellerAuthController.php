<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginSellerRequest;
use App\Models\Seller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class SellerAuthController extends Controller
{
    public function create(): View
    {
        return view('auth.seller-login');
    }

    public function store(LoginSellerRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $seller = Seller::where('pic_email', $data['pic_email'])->first();

        if (! $seller || ! $seller->password || ! Hash::check($data['password'], $seller->password)) {
            return back()
                ->withInput($request->only('pic_email'))
                ->withErrors('Email atau password tidak sesuai.');
        }

        if ($seller->status !== Seller::STATUS_APPROVED) {
            return back()
                ->withInput($request->only('pic_email'))
                ->withErrors('Akun penjual belum disetujui admin.');
        }

        $request->session()->put('seller_auth_id', $seller->id);

        return redirect()
            ->route('seller.home')
            ->with('status', 'seller_logged_in');
    }

    public function destroy(Request $request): RedirectResponse
    {
        $request->session()->forget('seller_auth_id');
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()
            ->route('seller.login')
            ->with('status', 'seller_logged_out');
    }
}
