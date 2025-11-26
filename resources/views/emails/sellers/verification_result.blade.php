<x-mail::message>
# Halo {{ $seller->pic_name }},

@if ($seller->status === \App\Models\Seller::STATUS_APPROVED)
Selamat! Pengajuan toko **{{ $seller->store_name }}** telah *disetujui* oleh tim Sellora. Silakan buat password terlebih dahulu kemudian login ke dashboard penjual.

<x-mail::panel>
Email PIC: {{ $seller->pic_email }}  
No. KTP: {{ $seller->pic_identity_number }}
</x-mail::panel>

@if ($setPasswordUrl)
<x-mail::button :url="$setPasswordUrl">
Buat Password Akun
</x-mail::button>
@else
<x-mail::button :url="route('seller.login')">
Login Penjual
</x-mail::button>
@endif
@else
Mohon maaf, pengajuan toko **{{ $seller->store_name }}** belum dapat kami setujui karena alasan berikut:

@if ($seller->verification_notes)
<x-mail::panel>
{{ $seller->verification_notes }}
</x-mail::panel>
@endif

Silakan lengkapi kekurangan dokumen dan ajukan ulang melalui formulir registrasi.
@endif

Terima kasih,<br>
{{ config('app.name') }}
</x-mail::message>
