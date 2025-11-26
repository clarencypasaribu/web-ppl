<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminSessionController extends Controller
{
    public function create(): View
    {
        return view('auth.admin-login');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'passcode' => ['required', 'string'],
        ]);

        $expected = config('services.admin.verification_passcode');

        if (! $expected || ! hash_equals($expected, $validated['passcode'])) {
            return back()
                ->withErrors(['passcode' => 'Passcode admin tidak valid.'])
                ->onlyInput('passcode');
        }

        $request->session()->put('is_admin', true);

        return redirect()
            ->route('sellers.verifications')
            ->with('status', 'admin_logged_in');
    }

    public function destroy(Request $request): RedirectResponse
    {
        $request->session()->forget('is_admin');

        return redirect()
            ->route('admin.login')
            ->with('status', 'admin_logged_out');
    }
}
