<x-mail::message>
# Status Registrasi Penjual

Halo {{ $application->owner_name }},

@if ($application->status === \App\Models\SellerApplication::STATUS_APPROVED)
Pengajuan Anda sebagai penjual di {{ config('app.name') }} telah **disetujui**.  
Gunakan token aktivasi berikut untuk mengaktifkan akun penjual Anda pada saat login pertama:

`{{ $application->activation_token }}`

@else
Mohon maaf, pengajuan Anda **belum dapat kami setujui** pada tahap ini. Silakan lengkapi kembali data sesuai catatan kami berikut.
@endif

@if ($application->verification_notes)
<x-mail::panel>
Catatan verifikasi: {{ $application->verification_notes }}
</x-mail::panel>
@endif

<x-mail::panel>
**Ringkasan Data**  
Nama Toko: {{ $application->store_name }}  
Kategori Produk: {{ $application->product_category }}  
Email Kontak: {{ $application->email }}  
No. Telepon: {{ $application->phone }}
</x-mail::panel>

Terima kasih sudah mempercayai {{ config('app.name') }} sebagai mitra penjualan Anda.

Salam hangat,<br>
Tim {{ config('app.name') }}
</x-mail::message>
