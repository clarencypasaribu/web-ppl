<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class AdminProfileController extends Controller
{
    public function show(): View
    {
        $profile = [
            'name' => 'Admin Platform',
            'role' => 'Administrator',
            'logged_in_at' => session('admin_logged_in_at'),
            'contact' => config('mail.from.address') ?? 'support@sellora.test',
            'scopes' => [
                'Verifikasi penjual',
                'Monitoring dashboard platform',
                'Kelola alert dan laporan',
            ],
        ];

        return view('admin.profile', compact('profile'));
    }
}
