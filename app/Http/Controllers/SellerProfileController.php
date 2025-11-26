<?php

namespace App\Http\Controllers;

use App\Models\Seller;
use Illuminate\View\View;

class SellerProfileController extends Controller
{
    public function show(Seller $seller): View
    {
        return view('profile.show', compact('seller'));
    }
}
