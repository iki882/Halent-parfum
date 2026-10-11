@extends('layout.app')

@section('title', "shop - Halent - Parfum")

@section('content')

<section class="bg-[#172752] px-6 text-white" style="padding-top:160px; padding-bottom:80px;">
    <div class="mx-auto max-w-6x1">
        <div class="text-center">
            <h1 class="text-3x1 font-black md:text-4x1 tracking-wider text-cyan-300">HALENT PARFUM SHOP</h1>
            <p class="mt-2 text-xs text-gray-400 nd:text-sm max-w-xl mx-auto">
                Temukan esensi aroma terbaik yang merepresentasikan karakter unikmu
            </p>
            <div class="mt-10 flex flex-wrap justify-center gap-3">
                <button class="rounded-full bg-cyan-500 px-4 py-1.5 text-xs font-semibold text-slate-900 transition hover:bg-cyan-400">Semua Produk</button>
                <button class="rounded-full bg-white/5 border border-white/10 px-4 py-1.5 text-xs font-semibold text-gray-300 transitio hover:bg-white/10">Men Series</button>
                <button class="rounded-full bg-white/5 border border-white/10 px-4 py-1.5 text-xs font-semibold text-gray-300 transition hover:bg-white/10">Women Series</button>
                <button class="rounded-full bg-white/5 border border-white/10 px-4 py-1.5 text-xs font-semibold text-gray-300 transition hover:bg-white/10">Unise</button>
            </div>
            {{-- =======PRODUKGRID====== --}}
            <div class="mt-10 grid grid-cols-1 sm-grid-cols-2 md:grid-cols-3 gap-6">
                {{-- ==== PRODUK 1 --}}
                <div class="flex flex-col justify-between overflow-hidden rounded-xl border border-white/5 p-5 transition hover:border-cyan-500/50">
                    <div class="h-38 w-full overflow-hidden rounded-lg bg-slate-800/50 flex items-center justify-center">
                    {{-- assets gambar parfum --}}
                    <img src="{{ asset('') }}"
                    alt="Water kiss"
                    class="h-full w-full object transition duration-300 hover:scale-105"
                    >
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>