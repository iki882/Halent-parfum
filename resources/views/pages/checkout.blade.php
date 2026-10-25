@extends('layouts.app')

@section('title', 'Checkout - Halent Parfum')

@section('content')

@php
    $shippingFee = config('checkout.shipping_fee');
    $totalPayment = $product->price + $shippingFee;
@endphp

<section class="bg-[#edf2ef] px-6 text-stone-800" style="padding-top: 140px; padding-bottom: 80px;">
    <div class="mx-auto max-w-5xl">
        <!-- Judul Halaman -->
        <div class="mb-8 border-b border-stone-300 pb-4">
            <h1 class="text-2xl font-serif font-bold text-stone-900 md:text-3xl">Checkout Pembelian</h1>
            <p class="text-xs text-stone-600 mt-1">Lengkapi data pengiriman dan pilih metode pembayaran</p>
        </div>

        <form action="{{ route('checkout.store') }}" method="POST" class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            @csrf
            <input type="hidden" name="product" value="{{ $product->slug }}">

            <!-- FORMULIR PENGIRIMAN (Kiri - Col 7) -->
            <div class="lg:col-span-7 bg-white p-6 rounded-2xl border border-stone-200 shadow-sm h-fit">
                <h2 class="text-base font-serif font-bold text-stone-900 mb-4 border-b pb-2">Informasi Pembeli & Pengiriman</h2>

                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-semibold text-stone-700 mb-1">Nama Lengkap</label>
                        <input type="text" name="customer_name" value="{{ old('customer_name', auth()->user()->name) }}" placeholder="Masukkan nama lengkap" required maxlength="255"
                            class="w-full rounded-lg border border-stone-300 px-3 py-2 text-xs focus:border-[#172752] focus:outline-none">
                        @error('customer_name')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-stone-700 mb-1">Nomor WhatsApp</label>
                            <input type="tel" name="customer_whatsapp" value="{{ old('customer_whatsapp') }}" placeholder="08123456789" required maxlength="20"
                                class="w-full rounded-lg border border-stone-300 px-3 py-2 text-xs focus:border-[#172752] focus:outline-none">
                            @error('customer_whatsapp')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-stone-700 mb-1">Email</label>
                            <input type="email" name="customer_email" value="{{ old('customer_email', auth()->user()->email) }}" placeholder="nama@email.com" required maxlength="255"
                                class="w-full rounded-lg border border-stone-300 px-3 py-2 text-xs focus:border-[#172752] focus:outline-none">
                            @error('customer_email')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-stone-700 mb-1">Alamat Lengkap Pengiriman</label>
                        <textarea name="shipping_address" rows="3" placeholder="Nama jalan, RT/RW, Kecamatan, Kota/Kabupaten, Kode Pos" required
                            class="w-full rounded-lg border border-stone-300 px-3 py-2 text-xs focus:border-[#172752] focus:outline-none">{{ old('shipping_address') }}</textarea>
                        @error('shipping_address')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-stone-700 mb-1">Catatan Pesanan (Opsional)</label>
                        <input type="text" name="notes" value="{{ old('notes') }}" maxlength="2000" placeholder="Catatan khusus untuk kurir/penjual"
                            class="w-full rounded-lg border border-stone-300 px-3 py-2 text-xs focus:border-[#172752] focus:outline-none">
                        @error('notes')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                    </div>
                </div>
            </div>

            <!-- RINGKASAN PESANAN & PEMBAYARAN (Kanan - Col 5) -->
            <div class="lg:col-span-5 space-y-6">
                <!-- Card Detail Produk -->
                <div class="bg-white p-6 rounded-2xl border border-stone-200 shadow-sm">
                    <h2 class="text-base font-serif font-bold text-stone-900 mb-4 border-b pb-2">Ringkasan Pesanan</h2>

                    <div class="flex items-center space-x-4 mb-4">
                        <div class="h-16 w-16 bg-stone-100 rounded-lg flex items-center justify-center p-1">
                            <img src="{{ asset($product->image ?: 'assets/hero-parfume.jpeg') }}" alt="{{ $product->name }}" class="h-full object-contain">
                        </div>
                        <div>
                            <span class="text-[10px] uppercase font-semibold text-[#172752]">{{ $product->category->name }}</span>
                            <h3 class="text-sm font-bold text-stone-900">{{ $product->name }}</h3>
                            <p class="text-xs text-stone-500">1x Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                        </div>
                    </div>

                    <div class="space-y-2 border-t border-stone-100 pt-3 text-xs">
                        <div class="flex justify-between text-stone-600">
                            <span>Subtotal Produk</span>
                            <span>Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-stone-600">
                            <span>Biaya Pengiriman</span>
                            <span>Rp {{ number_format($shippingFee, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between font-bold text-stone-900 border-t pt-2 text-sm">
                            <span>Total Pembayaran</span>
                            <span class="text-[#172752]">Rp {{ number_format($totalPayment, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

                <fieldset class="space-y-4 rounded-2xl border border-stone-200 bg-white p-6 shadow-sm">
                    <legend class="text-base font-serif font-bold text-stone-900">Pilih Metode Pembayaran</legend>
                    <p class="text-[11px] text-stone-500">Pilih platform pembayaran yang ingin Anda gunakan:</p>

                    <div>
                        <input id="payment-seabank" class="peer sr-only" type="radio" name="payment_method" value="seabank" @checked(old('payment_method', 'seabank') === 'seabank') required>
                        <label for="payment-seabank" class="flex cursor-pointer items-center gap-3 rounded-xl border border-stone-200 p-4 transition hover:bg-stone-50 peer-checked:border-[#172752] peer-checked:bg-blue-50/40">
                            <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-blue-600 text-xs font-bold text-white">Sea</span>
                            <span>
                                <span class="block text-xs font-bold text-stone-900">SeaBank (Transfer Rekening)</span>
                                <span class="block text-[10px] text-stone-500">Transfer manual ke rekening toko</span>
                            </span>
                        </label>
                        <div class="hidden space-y-4 px-2 pt-4 peer-checked:block">
                            <div class="space-y-2 rounded-xl border border-blue-200 bg-blue-50 p-4">
                                <p class="border-b border-blue-100 pb-2 text-xs font-bold text-[#172752]">Instruksi Transfer SeaBank — Kode Bank 535</p>
                                <p class="text-xs text-stone-700">Nama pemilik rekening: <strong>Rika Henia</strong></p>
                                <p class="text-xs text-stone-700">Nomor rekening: <strong class="font-mono">901793085179</strong></p>
                            </div>
                            <p class="text-[11px] text-stone-600">Total transfer: <strong>Rp {{ number_format($totalPayment, 0, ',', '.') }}</strong></p>
                            <button type="submit" class="block w-full rounded-full bg-emerald-600 py-3 text-center text-xs font-semibold text-white transition hover:bg-emerald-700">
                                Buat pesanan &amp; lanjut ke WhatsApp
                            </button>
                        </div>
                    </div>

                    <div>
                        <input id="payment-gopay" class="peer sr-only" type="radio" name="payment_method" value="gopay" @checked(old('payment_method') === 'gopay') required>
                        <label for="payment-gopay" class="flex cursor-pointer items-center gap-3 rounded-xl border border-stone-200 p-4 transition hover:bg-stone-50 peer-checked:border-[#172752] peer-checked:bg-sky-50/40">
                            <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-sky-500 text-xs font-bold text-white">G</span>
                            <span>
                                <span class="block text-xs font-bold text-stone-900">GoPay / QRIS</span>
                                <span class="block text-[10px] text-stone-500">Bayar menggunakan GoPay atau e-wallet</span>
                            </span>
                        </label>
                        <div class="hidden space-y-4 px-2 pt-4 peer-checked:block">
                            <div class="space-y-3 rounded-xl border border-sky-200 bg-sky-50 p-4 text-center">
                                <p class="text-xs font-bold text-stone-800">Scan QR Code menggunakan GoPay / e-wallet:</p>
                                <img src="{{ asset('assets/qr-code.png') }}" alt="QR Code GoPay QRIS" class="mx-auto w-44 object-contain">
                                <p class="text-[11px] text-stone-600">Total pembayaran: <strong>Rp {{ number_format($totalPayment, 0, ',', '.') }}</strong></p>
                            </div>
                            <button type="submit" class="block w-full rounded-full bg-emerald-600 py-3 text-center text-xs font-semibold text-white transition hover:bg-emerald-700">
                                Buat pesanan &amp; lanjut ke WhatsApp
                            </button>
                        </div>
                    </div>
                </fieldset>

                    <p class="text-xs leading-5 text-stone-500">
                        Pesanan akan disimpan dan WhatsApp terbuka dengan detailnya. Tekan tombol kirim di WhatsApp untuk mengirim konfirmasi.
                    </p>
                    <button type="submit" class="w-full rounded-full bg-[#172752] py-3 text-sm font-semibold text-white transition hover:bg-[#243a70]">
                        Buat Pesanan &amp; Lanjut ke WhatsApp
                    </button>
                    @if ($errors->any())
                        <p class="text-xs text-red-600">Periksa kembali data checkout Anda.</p>
                    @endif
                    @error('product')
                        <p class="text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

            </form>

        </div>
    </div>
</section>

@endsection