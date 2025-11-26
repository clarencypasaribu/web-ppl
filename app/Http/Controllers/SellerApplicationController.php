<?php

namespace App\Http\Controllers;

use App\Models\SellerApplication;
use Illuminate\Http\Request;

class SellerApplicationController extends Controller
{
    public function create()
    {
        return view('sellers.register');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'store_name' => ['required', 'string', 'max:255'],
            'owner_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email'],
            'phone' => ['required', 'string', 'max:30'],
            'address' => ['required', 'string'],
            'city' => ['nullable', 'string', 'max:120'],
            'province' => ['nullable', 'string', 'max:120'],
            'postal_code' => ['nullable', 'string', 'max:10'],
            'product_category' => ['required', 'string', 'max:255'],
            'product_description' => ['nullable', 'string'],
            'business_license_number' => ['nullable', 'string', 'max:255'],
            'tax_id_number' => ['nullable', 'string', 'max:255'],
            'bank_account_name' => ['required', 'string', 'max:255'],
            'bank_account_number' => ['required', 'string', 'max:50'],
            'bank_name' => ['required', 'string', 'max:255'],
        ]);

        SellerApplication::create($data);

        return redirect()
            ->route('seller.register')
            ->with('status', 'Registrasi berhasil dikirim. Tim kami akan melakukan verifikasi dan mengirimkan hasil via email.');
    }
}
