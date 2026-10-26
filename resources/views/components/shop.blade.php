@extends('layouts.app')

@section('title', 'Shop - Halent Parfum')

@section('content')
<section class="bg-[#edf2ef] px-6 text-stone-800" style="padding-top: 160px; padding-bottom: 80px;">
    <div class="mx-auto max-w-6xl">
        @if (session('success'))
            <p class="mb-6 rounded-xl border border-green-200 bg-green-50 p-4 text-center text-sm text-green-800" role="status">
                {{ session('success') }}
            </p>
        @endif

        <header class="text-center">
            <h1 class="text-3xl font-black tracking-wider text-stone-900 md:text-4xl">HALENT PARFUM SHOP</h1>
            @auth
                <p class="mx-auto mt-2 max-w-xl text-xs text-stone-600 md:text-sm">
                    Halo, {{ auth()->user()->name }}. Temukan aroma favoritmu hari ini.
                </p>
            @else
                <p class="mx-auto mt-2 max-w-xl text-xs text-stone-600 md:text-sm">
                    Temukan esensi aroma terbaik yang merepresentasikan karakter unikmu
                </p>
            @endauth

            <nav aria-label="Filter kategori produk" class="mt-10 flex flex-wrap justify-center gap-3">
                <a href="{{ route('shop') }}"
                   @class([
                       'rounded-full border px-4 py-1.5 text-xs font-semibold transition',
                       'border-[#172752] bg-[#172752] text-white' => ! $selectedCategory,
                       'border-stone-300 bg-white text-stone-700 hover:bg-stone-100' => $selectedCategory,
                   ])>
                    Semua Produk
                </a>
                @foreach ($categories as $category)
                    <a href="{{ route('shop', ['category' => $category->slug]) }}"
                       @class([
                           'rounded-full border px-4 py-1.5 text-xs font-semibold transition',
                           'border-[#172752] bg-[#172752] text-white' => $selectedCategory === $category->slug,
                           'border-stone-300 bg-white text-stone-700 hover:bg-stone-100' => $selectedCategory !== $category->slug,
                       ])>
                        {{ $category->name }}
                    </a>
                @endforeach
            </nav>
        </header>

        @if ($catalogUnavailable ?? false)
            <p class="mt-10 rounded-xl border border-amber-200 bg-amber-50 p-8 text-center text-sm text-amber-900" role="status">
                Menampilkan katalog cadangan. Pemesanan sementara tidak tersedia.
            </p>
        @endif

        @if ($products->isEmpty())
            <p class="mt-10 rounded-xl bg-white p-8 text-center text-sm text-stone-600">
                Belum ada produk tersedia pada kategori ini.
            </p>
        @else
            <div class="mt-10 grid grid-cols-1 gap-6 text-left sm:grid-cols-2 md:grid-cols-3">
                @foreach ($products as $product)
                    <article class="flex flex-col justify-between overflow-hidden rounded-xl border border-stone-200 bg-white p-5 shadow-sm transition hover:border-[#172752]/50 hover:shadow-md">
                        <div>
                            <div class="mb-4 flex h-48 w-full items-center justify-center overflow-hidden rounded-lg bg-stone-100">
                                <img src="{{ asset($product->image ?: 'assets/hero-parfume.jpeg') }}"
                                     alt="{{ $product->name }}"
                                     class="h-full w-full object-contain transition duration-300 hover:scale-105">
                            </div>
                            <span class="text-[10px] font-semibold uppercase tracking-widest text-[#172752]">
                                {{ $product->category->name }}
                            </span>
                            <h2 class="mt-1 font-serif text-base font-bold text-stone-900">{{ $product->name }}</h2>
                            <p class="mt-1 text-xs text-stone-600">{{ $product->description }}</p>
                            <p class="mt-2 text-xs text-stone-500">
                                {{ $product->stock > 0 ? 'Stok tersedia: '.$product->stock : 'Stok habis' }}
                            </p>
                        </div>

                        <div class="mt-6 flex items-center justify-between gap-3">
                            <span class="text-sm font-bold text-stone-900">
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                            </span>
                            @if ($product->stock > 0)
                                <a href="{{ route('checkout', $product->slug) }}"
                                   class="rounded-full bg-[#172752] px-4 py-1.5 text-[11px] font-semibold text-white transition hover:bg-opacity-90">
                                    Beli Sekarang
                                </a>
                            @else
                                <span class="rounded-full bg-stone-300 px-4 py-1.5 text-[11px] font-semibold text-stone-600">
                                    Stok Habis
                                </span>
                            @endif
                        </div>
                    </article>
                @endforeach
            </div>
        @endif
    </div>
</section>
@endsection
