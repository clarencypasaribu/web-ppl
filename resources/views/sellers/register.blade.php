<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Penjual | {{ config('app.name') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            color-scheme: light;
        }

        body {
            font-family: 'Inter', system-ui, -apple-system, BlinkMacSystemFont, sans-serif;
            margin: 0;
            background: #f5f6fb;
            color: #1f2933;
        }

        .hero {
            background: linear-gradient(120deg, #2563eb, #7c3aed);
            color: white;
            padding: 3rem 1.5rem;
            text-align: center;
        }

        .wrapper {
            max-width: 1000px;
            margin: -60px auto 2rem;
            padding: 0 1.5rem;
        }

        .card {
            background: white;
            border-radius: 18px;
            padding: 2rem;
            box-shadow: 0 20px 60px rgba(15, 23, 42, 0.14);
            border: 1px solid #eef0fb;
        }

        h1 {
            font-size: 2.5rem;
            margin-bottom: 0.75rem;
        }

        .subtitle {
            opacity: 0.9;
            font-size: 1.05rem;
        }

        form {
            margin-top: 1rem;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 1.25rem 1.5rem;
        }

        label {
            display: block;
            font-weight: 600;
            margin-bottom: 0.45rem;
            font-size: 0.95rem;
        }

        input,
        textarea,
        select {
            width: 100%;
            border-radius: 12px;
            border: 1px solid #d6daf0;
            padding: 0.85rem 1rem;
            font-size: 0.95rem;
            transition: border 0.2s, box-shadow 0.2s;
            font-family: inherit;
        }

        textarea {
            min-height: 120px;
            resize: vertical;
        }

        input:focus,
        textarea:focus,
        select:focus {
            outline: none;
            border-color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.2);
        }

        .full {
            grid-column: 1 / -1;
        }

        .action {
            margin-top: 1.5rem;
            display: flex;
            justify-content: flex-end;
        }

        button {
            border: none;
            border-radius: 999px;
            padding: 0.95rem 2.5rem;
            font-size: 1rem;
            font-weight: 600;
            color: white;
            cursor: pointer;
            background: linear-gradient(120deg, #2563eb, #7c3aed);
            box-shadow: 0 15px 30px rgba(99, 102, 241, 0.35);
            transition: transform 0.2s ease;
        }

        button:hover {
            transform: translateY(-1px);
        }

        .status {
            grid-column: 1 / -1;
            background: #ecfdf5;
            border: 1px solid #a7f3d0;
            color: #065f46;
            padding: 0.85rem 1rem;
            border-radius: 12px;
        }

        .errors {
            grid-column: 1 / -1;
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #991b1b;
            padding: 0.85rem 1rem;
            border-radius: 12px;
            list-style: none;
        }
    </style>
</head>

<body>
    <section class="hero">
        <h1>Registrasi Penjual</h1>
        <p class="subtitle">Lengkapi data seperti pada SRS-MartPlace-01 untuk mulai berjualan bersama kami.</p>
    </section>

    <div class="wrapper">
        <div class="card">
            @if (session('status'))
                <div class="status">{{ session('status') }}</div>
            @endif

            @if ($errors->any())
                <ul class="errors">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif

            <form action="{{ route('seller.register.store') }}" method="POST">
                @csrf

                <div>
                    <label for="store_name">Nama Toko</label>
                    <input type="text" id="store_name" name="store_name" value="{{ old('store_name') }}"
                        placeholder="contoh: MartPlace Fresh" required>
                </div>

                <div>
                    <label for="owner_name">Nama Pemilik</label>
                    <input type="text" id="owner_name" name="owner_name" value="{{ old('owner_name') }}"
                        placeholder="contoh: Siti Mawarni" required>
                </div>

                <div>
                    <label for="email">Email Penanggung Jawab</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}"
                        placeholder="contoh: owner@martplace.id" required>
                </div>

                <div>
                    <label for="phone">Nomor Telepon/Whatsapp</label>
                    <input type="text" id="phone" name="phone" value="{{ old('phone') }}"
                        placeholder="+62 xxx xxxx" required>
                </div>

                <div class="full">
                    <label for="address">Alamat Lengkap Toko/Gudang</label>
                    <textarea id="address" name="address" placeholder="Jalan, nomor, RT/RW, kelurahan, kecamatan" required>{{ old('address') }}</textarea>
                </div>

                <div>
                    <label for="city">Kota/Kabupaten</label>
                    <input type="text" id="city" name="city" value="{{ old('city') }}" placeholder="contoh: Bandung">
                </div>

                <div>
                    <label for="province">Provinsi</label>
                    <input type="text" id="province" name="province" value="{{ old('province') }}"
                        placeholder="contoh: Jawa Barat">
                </div>

                <div>
                    <label for="postal_code">Kode Pos</label>
                    <input type="text" id="postal_code" name="postal_code" value="{{ old('postal_code') }}"
                        placeholder="40115">
                </div>

                <div>
                    <label for="product_category">Kategori Produk Utama</label>
                    <input type="text" id="product_category" name="product_category"
                        value="{{ old('product_category') }}" placeholder="contoh: Sembako, Fashion, Peralatan Rumah"
                        required>
                </div>

                <div class="full">
                    <label for="product_description">Deskripsi Produk / Kapasitas Produksi</label>
                    <textarea id="product_description" name="product_description" placeholder="Ceritakan keunggulan produk dan kemampuan suplai">{{ old('product_description') }}</textarea>
                </div>

                <div>
                    <label for="business_license_number">Nomor Izin Usaha (NIB/SIUP)</label>
                    <input type="text" id="business_license_number" name="business_license_number"
                        value="{{ old('business_license_number') }}" placeholder="contoh: 91234567890">
                </div>

                <div>
                    <label for="tax_id_number">NPWP / NIK</label>
                    <input type="text" id="tax_id_number" name="tax_id_number" value="{{ old('tax_id_number') }}"
                        placeholder="contoh: 02.123.456.7-432.000">
                </div>

                <div>
                    <label for="bank_account_name">Nama Pemilik Rekening</label>
                    <input type="text" id="bank_account_name" name="bank_account_name"
                        value="{{ old('bank_account_name') }}" placeholder="contoh: Siti Mawarni" required>
                </div>

                <div>
                    <label for="bank_name">Nama Bank</label>
                    <input type="text" id="bank_name" name="bank_name" value="{{ old('bank_name') }}"
                        placeholder="contoh: BCA, BRI" required>
                </div>

                <div>
                    <label for="bank_account_number">Nomor Rekening</label>
                    <input type="text" id="bank_account_number" name="bank_account_number"
                        value="{{ old('bank_account_number') }}" placeholder="contoh: 1234567890" required>
                </div>

                <div class="action full">
                    <button type="submit">Kirim Registrasi</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>
