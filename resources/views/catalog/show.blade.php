@extends('layouts.app')

@section('title', $product->name . ' - Katalog')

@section('content')
    @php
        use Illuminate\Support\Facades\Storage;
        use Illuminate\Support\Str;

        $imageUrl = null;
        if ($product->image_path) {
            $imageUrl = Str::startsWith($product->image_path, ['http://', 'https://'])
                ? $product->image_path
                : Storage::url($product->image_path);
        }
        $avgRating = round($product->reviews_avg_rating ?? 0, 1);
    @endphp

    <div class="max-w-6xl mx-auto px-4 py-10 space-y-10">
        @if (session('status') === 'review_submitted')
            <div class="rounded-lg bg-emerald-50 border border-emerald-200 px-4 py-3 text-sm text-emerald-700">
                Terima kasih! Ulasan Anda telah dikirim.
            </div>
        @endif

        <div class="grid md:grid-cols-2 gap-6 items-stretch">
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="h-80 bg-slate-100">
                    @if ($imageUrl)
                        <img src="{{ $imageUrl }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-sm text-slate-400">
                            Tidak ada foto
                        </div>
                    @endif
                </div>
                <div class="p-4 flex items-center justify-between text-sm text-slate-600">
                    <span>Kategori: <span class="font-semibold text-slate-800">{{ $product->category->name ?? '-' }}</span></span>
                    <span>Stock: <span class="font-semibold text-slate-800">{{ $product->stock }}</span></span>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 space-y-5">
                <div class="flex items-center justify-between gap-3">
                    <div class="space-y-1">
                        <p class="text-xs uppercase tracking-widest text-indigo-500">{{ $product->category->name ?? 'Kategori belum ditentukan' }}</p>
                        <h1 class="text-3xl font-semibold">{{ $product->name }}</h1>
                    </div>
                </div>
                <p class="text-3xl font-semibold text-slate-800">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                <p class="text-sm text-slate-700 leading-relaxed">{{ $product->description ?? 'Belum ada deskripsi produk.' }}</p>

                <div class="flex items-center gap-3 text-sm">
                    <div class="flex items-center gap-2 text-amber-500 font-semibold">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 0 0 .95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 0 0-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 0 0-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 0 0-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81H7.03a1 1 0 0 0 .95-.69l1.07-3.292Z" />
                        </svg>
                        <span>{{ number_format($avgRating, 1) }}</span>
                        <span class="text-xs text-slate-500">({{ $product->reviews_count }} ulasan)</span>
                    </div>
                    <span class="text-xs px-3 py-1 rounded-full bg-emerald-50 text-emerald-700 font-semibold">Tersedia</span>
                </div>

                <div class="grid sm:grid-cols-2 gap-3 text-sm">
                    <div class="border border-slate-200 rounded-xl p-3">
                        <p class="text-xs text-slate-500">Penjual</p>
                        <p class="font-semibold text-slate-800">{{ $product->seller->store_name ?? '-' }}</p>
                        @if ($product->seller?->pic_email)
                            <p class="text-slate-600 text-xs mt-1">{{ $product->seller->pic_email }}</p>
                        @endif
                    </div>
                    <div class="border border-slate-200 rounded-xl p-3 space-y-2">
                        <p class="text-xs text-slate-500">Hubungi</p>
                        <div class="flex flex-wrap gap-2">
                            @if ($product->seller?->pic_email)
                                <a href="mailto:{{ $product->seller->pic_email }}" class="px-3 py-2 rounded-lg bg-indigo-50 text-indigo-700 hover:bg-indigo-100">Email</a>
                            @endif
                            @if ($product->seller?->pic_phone)
                                <a href="https://wa.me/{{ preg_replace('/\\D+/', '', $product->seller->pic_phone) }}" target="_blank" rel="noopener" class="px-3 py-2 rounded-lg bg-emerald-50 text-emerald-700 hover:bg-emerald-100">WhatsApp</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <section class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 space-y-4">
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold">Ulasan</h2>
                <div class="flex items-center gap-2 text-sm text-amber-500 font-semibold">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 0 0 .95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 0 0-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 0 0-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 0 0-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81H7.03a1 1 0 0 0 .95-.69l1.07-3.292Z" />
                    </svg>
                    <span>{{ number_format($avgRating, 1) }}</span>
                    <span class="text-xs text-slate-500">({{ $product->reviews_count }} ulasan)</span>
                </div>
            </div>
            <button id="showReviewFormBtn" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 text-sm">
                Tambahkan Ulasan
            </button>
            <form id="reviewForm" action="{{ route('catalog.reviews.store', $product) }}" method="POST" class="bg-slate-50 border border-slate-200 rounded-xl p-4 space-y-3 hidden">
                @csrf
                <p class="text-xs text-slate-500">Pengunjung dapat langsung menambah ulasan tanpa login. Lengkapi data berikut.</p>
                <div class="grid md:grid-cols-2 gap-3">
                    <div>
                        <label class="text-xs text-slate-500">Nama Anda</label>
                        <input type="text" name="reviewer_name" value="{{ old('reviewer_name') }}" class="w-full border border-slate-200 rounded-lg px-3 py-2 text-sm" required>
                        @error('reviewer_name')
                            <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="text-xs text-slate-500">Nomor HP</label>
                        <input type="text" name="reviewer_phone" value="{{ old('reviewer_phone') }}" class="w-full border border-slate-200 rounded-lg px-3 py-2 text-sm" required>
                        @error('reviewer_phone')
                            <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="grid md:grid-cols-2 gap-3">
                    <div>
                        <label class="text-xs text-slate-500">Email</label>
                        <input type="email" name="reviewer_email" value="{{ old('reviewer_email') }}" class="w-full border border-slate-200 rounded-lg px-3 py-2 text-sm" required>
                        @error('reviewer_email')
                            <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="text-xs text-slate-500">Provinsi</label>
                        <input type="text" name="province" value="{{ old('province') }}" class="w-full border border-slate-200 rounded-lg px-3 py-2 text-sm" required>
                        @error('province')
                            <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="grid md:grid-cols-2 gap-3">
                    <div>
                        <label class="text-xs text-slate-500">Rating</label>
                        <select name="rating" class="w-full border border-slate-200 rounded-lg px-3 py-2 text-sm" required>
                            <option value="">Pilih rating</option>
                            @for ($i = 5; $i >= 1; $i--)
                                <option value="{{ $i }}" @selected(old('rating') == $i)>{{ $i }} / 5</option>
                            @endfor
                        </select>
                        @error('rating')
                            <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div>
                    <label class="text-xs text-slate-500">Komentar</label>
                    <textarea name="comment" rows="3" class="w-full border border-slate-200 rounded-lg px-3 py-2 text-sm" placeholder="Tulis pengalaman Anda">{{ old('comment') }}</textarea>
                    @error('comment')
                        <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="flex justify-end">
                    <button type="submit" class="inline-flex items-center bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 text-sm">
                        Kirim Ulasan
                    </button>
                </div>
            </form>
            @forelse ($product->reviews as $review)
                <div class="bg-slate-50 border border-slate-100 rounded-lg p-4 shadow-inner">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <p class="font-semibold text-slate-800">{{ $review->reviewer_name }}</p>
                            <span class="text-xs text-slate-400">{{ $review->province }}</span>
                        </div>
                        <span class="text-sm text-amber-500 font-semibold">Rating: {{ $review->rating }}/5</span>
                    </div>
                    @if ($review->comment)
                        <p class="text-sm text-slate-700 mt-2">{{ $review->comment }}</p>
                    @endif
                </div>
            @empty
                <p class="text-sm text-slate-500">Belum ada ulasan untuk produk ini.</p>
            @endforelse
        </section>

        @if ($otherProducts->isNotEmpty())
            <section class="space-y-4">
                <h2 class="text-xl font-semibold">Produk lain dari penjual ini</h2>
                <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    @foreach ($otherProducts as $other)
                        @php
                            $otherImage = null;
                            if ($other->image_path) {
                                $otherImage = Str::startsWith($other->image_path, ['http://', 'https://'])
                                    ? $other->image_path
                                    : Storage::url($other->image_path);
                            }
                        @endphp
                        <a href="{{ route('catalog.show', $other) }}" class="bg-white border border-slate-100 rounded-xl overflow-hidden shadow-sm hover:shadow-md transition block">
                            <div class="h-32 bg-slate-100">
                                @if ($otherImage)
                                    <img src="{{ $otherImage }}" alt="{{ $other->name }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-xs text-slate-400">Tidak ada foto</div>
                                @endif
                            </div>
                            <div class="p-3 space-y-1">
                                <p class="text-xs text-slate-500">{{ $other->category->name ?? '-' }}</p>
                                <p class="font-semibold text-slate-800 truncate">{{ $other->name }}</p>
                                <p class="text-sm text-slate-600">Rp {{ number_format($other->price, 0, ',', '.') }}</p>
                            </div>
                        </a>
                    @endforeach
                </div>
            </section>
        @endif
    </div>

    @push('scripts')
        <script>
            const reviewForm = document.getElementById('reviewForm');
            const showReviewFormBtn = document.getElementById('showReviewFormBtn');
            if (reviewForm && showReviewFormBtn) {
                const hasErrors = {{ $errors->any() ? 'true' : 'false' }};
                if (hasErrors) {
                    reviewForm.classList.remove('hidden');
                }
                showReviewFormBtn.addEventListener('click', () => {
                    reviewForm.classList.toggle('hidden');
                });
            }

            const copyBtn = document.getElementById('copyLinkBtn');
            if (copyBtn) {
                copyBtn.addEventListener('click', async () => {
                    try {
                        await navigator.clipboard.writeText(window.location.href);
                        copyBtn.textContent = 'Tautan disalin';
                        setTimeout(() => { copyBtn.textContent = 'Salin tautan'; }, 2000);
                    } catch (e) {
                        copyBtn.textContent = 'Gagal menyalin';
                        setTimeout(() => { copyBtn.textContent = 'Salin tautan'; }, 2000);
                    }
                });
            }
        </script>
    @endpush
@endsection
