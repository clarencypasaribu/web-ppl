<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Penjual | {{ config('app.name') }}</title>
    <style>
        body {
            font-family: 'Inter', Arial, sans-serif;
            background: #0f172a;
            margin: 0;
            color: #e2e8f0;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem 1rem 3rem;
        }

        h1 {
            font-size: 2rem;
            margin-bottom: 1rem;
        }

        .card {
            background: rgba(15, 23, 42, 0.7);
            border-radius: 18px;
            padding: 1.5rem;
            border: 1px solid rgba(226, 232, 240, 0.1);
            box-shadow: 0 25px 50px rgba(15, 15, 15, 0.35);
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            text-align: left;
            padding: 0.85rem;
            border-bottom: 1px solid rgba(226, 232, 240, 0.08);
            vertical-align: top;
        }

        th {
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: #94a3b8;
        }

        .status-pill {
            border-radius: 999px;
            padding: 0.25rem 0.75rem;
            font-size: 0.8rem;
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
        }

        .status-pending {
            background: rgba(234, 179, 8, 0.15);
            color: #facc15;
        }

        .status-approved {
            background: rgba(16, 185, 129, 0.15);
            color: #34d399;
        }

        .status-rejected {
            background: rgba(248, 113, 113, 0.15);
            color: #f87171;
        }

        .actions {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
        }

        button {
            border: none;
            border-radius: 10px;
            padding: 0.5rem 0.9rem;
            font-size: 0.9rem;
            cursor: pointer;
            font-weight: 600;
            color: #0f172a;
        }

        button.approve {
            background: #34d399;
        }

        button.reject {
            background: #f87171;
        }

        textarea {
            width: 100%;
            border-radius: 10px;
            border: none;
            padding: 0.65rem;
            font-family: inherit;
            background: rgba(148, 163, 184, 0.12);
            color: inherit;
        }

        .filters,
        .status {
            margin-bottom: 1rem;
        }

        .filters a {
            color: #94a3b8;
            margin-right: 0.5rem;
            text-decoration: none;
            font-weight: 600;
        }

        .filters a.active {
            color: #38bdf8;
        }

        .status {
            padding: 0.8rem 1rem;
            border-radius: 12px;
            background: rgba(16, 185, 129, 0.15);
            color: #34d399;
        }

        form {
            margin: 0;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Verifikasi Registrasi Penjual</h1>

        <div class="filters">
            @php($current = request('status'))
            <a href="{{ route('admin.seller_applications.index') }}" class="{{ $current ? '' : 'active' }}">Semua</a>
            <a href="{{ route('admin.seller_applications.index', ['status' => \App\Models\SellerApplication::STATUS_PENDING]) }}"
                class="{{ $current === \App\Models\SellerApplication::STATUS_PENDING ? 'active' : '' }}">Pending</a>
            <a href="{{ route('admin.seller_applications.index', ['status' => \App\Models\SellerApplication::STATUS_APPROVED]) }}"
                class="{{ $current === \App\Models\SellerApplication::STATUS_APPROVED ? 'active' : '' }}">Disetujui</a>
            <a href="{{ route('admin.seller_applications.index', ['status' => \App\Models\SellerApplication::STATUS_REJECTED]) }}"
                class="{{ $current === \App\Models\SellerApplication::STATUS_REJECTED ? 'active' : '' }}">Ditolak</a>
        </div>

        @if (session('status'))
            <div class="status">{{ session('status') }}</div>
        @endif

        <div class="card">
            <table>
                <thead>
                    <tr>
                        <th>Penjual</th>
                        <th>Produk</th>
                        <th>Legal</th>
                        <th>Pencairan</th>
                        <th>Tindakan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($applications as $application)
                        <tr>
                            <td>
                                <strong>{{ $application->store_name }}</strong><br>
                                {{ $application->owner_name }}<br>
                                {{ $application->email }}<br>
                                {{ $application->phone }}<br>
                                <small>{{ $application->address }}</small>
                            </td>
                            <td>
                                {{ $application->product_category }}<br>
                                <small>{{ $application->product_description }}</small>
                            </td>
                            <td>
                                NIB: {{ $application->business_license_number ?: '-' }}<br>
                                NPWP/NIK: {{ $application->tax_id_number ?: '-' }}
                            </td>
                            <td>
                                {{ $application->bank_name }}<br>
                                a.n {{ $application->bank_account_name }}<br>
                                {{ $application->bank_account_number }}
                            </td>
                            <td>
                                <span class="status-pill status-{{ $application->status }}">
                                    {{ ucfirst($application->status) }}
                                </span>

                                <details>
                                    <summary>Catatan</summary>
                                    <p>{{ $application->verification_notes ?: 'Belum ada catatan' }}</p>
                                </details>

                                <form action="{{ route('admin.seller_applications.update', $application) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <textarea name="verification_notes" rows="3"
                                        placeholder="Catatan verifikasi">{{ old('verification_notes', $application->verification_notes) }}</textarea>
                                    <div class="actions">
                                        <button class="approve" name="action" value="approve">Setujui</button>
                                        <button class="reject" name="action" value="reject">Tolak</button>
                                    </div>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">Belum ada data.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div style="margin-top: 1rem; color:#94a3b8;">
                {{ $applications->links() }}
            </div>
        </div>
    </div>
</body>

</html>
