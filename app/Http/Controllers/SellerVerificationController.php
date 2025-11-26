<?php

namespace App\Http\Controllers;

use App\Mail\SellerApplicationStatusMail;
use App\Models\SellerApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class SellerVerificationController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status');

        $applications = SellerApplication::when(
            $status,
            fn ($query) => $query->where('status', $status)
        )
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('sellers.admin_index', compact('applications', 'status'));
    }

    public function update(Request $request, SellerApplication $sellerApplication)
    {
        $data = $request->validate([
            'action' => ['required', 'in:approve,reject'],
            'verification_notes' => ['nullable', 'string'],
        ]);

        $status = $data['action'] === 'approve'
            ? SellerApplication::STATUS_APPROVED
            : SellerApplication::STATUS_REJECTED;

        $sellerApplication->status = $status;
        $sellerApplication->verification_notes = $data['verification_notes'] ?? null;
        $sellerApplication->verified_at = now();

        if ($status === SellerApplication::STATUS_APPROVED && ! $sellerApplication->activation_token) {
            $sellerApplication->activation_token = Str::uuid()->toString();
        }

        if ($status === SellerApplication::STATUS_REJECTED) {
            $sellerApplication->activation_token = null;
        }

        $sellerApplication->save();

        Mail::to($sellerApplication->email)->send(new SellerApplicationStatusMail($sellerApplication));

        return back()->with('status', 'Status aplikasi diperbarui dan email notifikasi dikirim.');
    }
}
