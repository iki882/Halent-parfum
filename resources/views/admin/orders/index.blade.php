@extends('layouts.app')

@section('title', 'Admin Dashboard - Halent Parfum')

@section('content')
<section class="bg-[#edf3ef] px-4 py-10 text-stone-800 sm:px-6">
    <div class="mx-auto max-w-6xl">
        <header class="mb-8 flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
            <div>
                <h1 class="font-serif text-2xl font-bold text-stone-900">Dashboard Kelola Pesanan</h1>
                <p class="mt-1 text-xs text-stone-600">Atur status pesanan dan lihat informasi pembeli.</p>
            </div>
            <p class="rounded-full bg-[#172752] px-4 py-2 text-xs font-bold text-white">
                Total: {{ $orders->count() }} pesanan
            </p>
        </header>

        @if (session('success'))
            <p class="mb-4 rounded-xl border border-emerald-300 bg-emerald-100 px-4 py-3 text-xs font-semibold text-emerald-800" role="status">
                {{ session('success') }}
            </p>
        @endif

        <div class="overflow-hidden rounded-2xl border border-stone-300 bg-white shadow-sm">
            <div class="overflow-x-auto">
                <table class="w-full min-w-[900px] text-left text-xs">
                    <thead class="bg-stone-100 text-[10px] uppercase tracking-wider text-stone-700">
                        <tr>
                            <th class="p-4">No. Pesanan</th>
                            <th class="p-4">Pembeli</th>
                            <th class="p-4">Produk</th>
                            <th class="p-4">Total</th>
                            <th class="p-4">Metode</th>
                            <th class="p-4">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-stone-100">
                        @forelse ($orders as $order)
                            <tr class="hover:bg-stone-50">
                                <td class="p-4 font-mono font-bold text-[#172752]">
                                    {{ $order->order_number }}
                                    <span class="mt-1 block font-sans text-[10px] font-normal text-stone-400">
                                        {{ $order->created_at->format('d M Y, H:i') }}
                                    </span>
                                </td>
                                <td class="p-4">
                                    <span class="block font-bold text-stone-900">{{ $order->customer_name }}</span>
                                    <span class="mt-1 block text-stone-500">{{ $order->customer_whatsapp }}</span>
                                </td>
                                <td class="p-4 font-medium text-stone-800">{{ $order->product_name }}</td>
                                <td class="p-4 font-bold text-[#172752]">
                                    Rp {{ number_format($order->total_payment, 0, ',', '.') }}
                                </td>
                                <td class="p-4 uppercase font-semibold text-stone-600">{{ $order->payment_method }}</td>
                                <td class="p-4">
                                    <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST" class="flex items-center gap-2">
                                        @csrf
                                        @method('PATCH')
                                        <select name="status" aria-label="Status pesanan {{ $order->order_number }}"
                                            class="rounded-lg border border-stone-300 px-2.5 py-1.5 text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-[#172752]">
                                            <option value="pending" @selected($order->status === 'pending')>Pending</option>
                                            <option value="processing" @selected($order->status === 'processing')>Diproses</option>
                                            <option value="completed" @selected($order->status === 'completed')>Selesai</option>
                                            <option value="cancelled" @selected($order->status === 'cancelled')>Dibatalkan</option>
                                        </select>
                                        <button type="submit" class="rounded-lg bg-[#172752] px-3 py-1.5 font-semibold text-white hover:bg-[#1f336b]">
                                            Simpan
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="p-8 text-center text-stone-500">Belum ada pesanan yang masuk.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
@endsection
