@extends('layouts.app')

@section('title', 'Status Pesanan - Halent Parfum')

@section('content')
<main class="mx-auto max-w-3xl px-6 py-12">
    @if (session('success'))
        <p class="mb-6 rounded-lg bg-green-100 p-4 text-green-800">{{ session('success') }}</p>
    @endif

    <section class="rounded-2xl border border-stone-200 bg-white p-6 shadow-sm">
        <h1 class="mb-4 text-2xl font-bold text-stone-900">Detail Pesanan</h1>
        <p class="mb-6 text-stone-600">Nomor pesanan: <strong>{{ $order->order_number }}</strong></p>

        <dl class="space-y-3 text-sm">
            @foreach ($order->items as $item)
                <div class="flex justify-between gap-4">
                    <dt class="text-stone-600">{{ $item->product->name }} × {{ $item->quantity }}</dt>
                    <dd class="font-medium text-stone-900">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</dd>
                </div>
            @endforeach
            <div class="flex justify-between gap-4">
                <dt class="text-stone-600">Nama penerima</dt>
                <dd class="font-medium text-stone-900">{{ $order->customer_name }}</dd>
            </div>
            <div class="flex justify-between gap-4">
                <dt class="text-stone-600">Nomor WhatsApp</dt>
                <dd class="font-medium text-stone-900">{{ $order->customer_whatsapp }}</dd>
            </div>
            <div class="flex justify-between gap-4">
                <dt class="text-stone-600">Metode pembayaran</dt>
                <dd class="font-medium uppercase text-stone-900">{{ $order->payment_method }}</dd>
            </div>
            <div class="flex justify-between gap-4">
                <dt class="text-stone-600">Status</dt>
                <dd class="font-medium capitalize text-stone-900">{{ $order->status }}</dd>
            </div>
            <div class="flex justify-between gap-4">
                <dt class="text-stone-600">Ongkir</dt>
                <dd class="font-medium text-stone-900">Rp {{ number_format($order->shipping_fee, 0, ',', '.') }}</dd>
            </div>
            <div class="flex justify-between gap-4 border-t border-stone-200 pt-3">
                <dt class="text-stone-600">Total pembayaran</dt>
                <dd class="font-bold text-stone-900">Rp {{ number_format($order->total_price, 0, ',', '.') }}</dd>
            </div>
            <div>
                <dt class="text-stone-600">Alamat pengiriman</dt>
                <dd class="mt-1 whitespace-pre-line font-medium text-stone-900">{{ $order->shipping_address }}</dd>
            </div>
        </dl>

        <a href="{{ route('orders.index') }}" class="mt-6 inline-block text-sm font-semibold text-[#172752] underline">
            Lihat semua pesanan
        </a>

        <a href="{{ route('orders.whatsapp', $order) }}" target="_blank" rel="noopener noreferrer"
           class="mt-6 inline-flex w-full items-center justify-center rounded-full bg-emerald-600 px-5 py-3 text-sm font-semibold text-white transition hover:bg-emerald-700">
            Kirim Bukti Pesanan via WhatsApp
        </a>
    </section>
</main>
@endsection
