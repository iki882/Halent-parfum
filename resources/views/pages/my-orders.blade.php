@extends('layouts.app')

@section('title', 'Pesanan Saya - Halent Parfum')

@section('content')
<main class="mx-auto max-w-5xl px-6 py-12">
    <h1 class="mb-6 text-2xl font-bold text-stone-900">Pesanan Saya</h1>

    @if ($orders->isEmpty())
        <p class="rounded-lg bg-white p-6 text-stone-600">Anda belum memiliki pesanan.</p>
    @else
        <div class="space-y-4">
            @foreach ($orders as $order)
                <a href="{{ route('orders.show', $order) }}" class="block rounded-xl border border-stone-200 bg-white p-5 shadow-sm">
                    <div class="flex flex-wrap justify-between gap-3">
                        <div>
                            <p class="font-semibold text-stone-900">
                                {{ $order->items->first()?->product?->name ?? 'Pesanan' }}
                                @if ($order->items->count() > 1)
                                    dan {{ $order->items->count() - 1 }} produk lainnya
                                @endif
                            </p>
                            <p class="mt-1 text-sm text-stone-500">{{ $order->order_number }}</p>
                        </div>
                        <div class="text-right">
                            <p class="font-bold text-stone-900">Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                            <p class="mt-1 text-sm capitalize text-stone-500">{{ $order->status }}</p>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>

        <div class="mt-6">{{ $orders->links() }}</div>
    @endif
</main>
@endsection
