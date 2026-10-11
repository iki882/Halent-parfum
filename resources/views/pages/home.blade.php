@extends('layouts.app')

@section('title', 'Halent Parfum - Find Your Signature Scent')

@section('content')
<div class="space-y-16 pb-12 font-serif text-stone-800">

    <!-- SECTION 1: HERO SECTION -->
    <section class="relative bg-[#f6f0ea] rounded-2xl p-8 md:p-12 overflow-hidden flex flex-col md:flex-row items-center justify-between min-h-[500px]">
        <div class="md:w-1/2 space-y-6 z-10">
            <span class="text-xs uppercase tracking-[0.3em] text-stone-500 font-sans">Premium Fragrance</span>
            <h1 class="text-5xl md:text-6xl font-normal tracking-tight leading-tight text-stone-900">
                HALENT
                <span class="block text-xs font-sans tracking-[0.4em] text-stone-500 mt-1">PARFUME & FRAGRANCE</span>
            </h1>
            <h2 class="text-2xl font-sans italic text-stone-700">Find Your Signature Scent.</h2>
            <p class="text-sm font-sans text-stone-600 max-w-sm">Temukan aroma yang mencerminkan karakter dan momenmu.</p>
            <div class="flex flex-wrap gap-4 pt-4 font-sans text-xs tracking-wider uppercase">
                <a href="#shop" class="bg-stone-900 text-stone-100 px-6 py-3 rounded-full hover:bg-stone-800 transition">Explore Collection &rarr;</a>
                <a href="#quiz" class="border border-stone-800 text-stone-800 px-6 py-3 rounded-full hover:bg-stone-800 hover:text-white transition">Find Your Scent</a>
            </div>
        </div>
        <!-- Hero Product Banner Image -->
        <div class="md:w-1/2 mt-8 md:mt-0 flex justify-center">
            <img src="{{ asset('images/hero-perfumes.png') }}" alt="Halent Perfumes" class="max-h-[420px] object-contain drop-shadow-xl">
        </div>
    </section>

    <!-- SECTION 2: CATEGORY BY SCENT CHARACTER -->
    <section class="text-center space-y-8">
        <div>
            <h2 class="text-2xl font-normal tracking-wide uppercase">A Scent For Every You</h2>
            <p class="text-xs font-sans text-stone-500 mt-1">Karena setiap karakter punya aroma yang berbeda.</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Fresh -->
            <div class="bg-[#e4f0f6] p-6 rounded-2xl flex items-center justify-between text-left">
                <div class="space-y-3 font-sans">
                    <h3 class="font-serif text-xl tracking-wider uppercase">Fresh</h3>
                    <p class="text-[11px] text-stone-500 uppercase tracking-widest">Clean • Fresh • Light</p>
                    <a href="#" class="inline-block bg-stone-900 text-white text-[10px] uppercase tracking-wider px-4 py-2 rounded-full">Explore Fresh &rarr;</a>
                </div>
                <img src="{{ asset('images/scent-fresh.png') }}" alt="Fresh Scent" class="h-32 object-contain">
            </div>
            <!-- Sweet -->
            <div class="bg-[#fcedf0] p-6 rounded-2xl flex items-center justify-between text-left">
                <div class="space-y-3 font-sans">
                    <h3 class="font-serif text-xl tracking-wider uppercase">Sweet</h3>
                    <p class="text-[11px] text-stone-500 uppercase tracking-widest">Sweet • Feminine • Playful</p>
                    <a href="#" class="inline-block bg-stone-100 text-stone-900 text-[10px] uppercase tracking-wider px-4 py-2 rounded-full">Explore Sweet &rarr;</a>
                </div>
                <img src="{{ asset('images/scent-sweet.png') }}" alt="Sweet Scent" class="h-32 object-contain">
            </div>
            <!-- Bold -->
            <div class="bg-[#1c1b18] text-white p-6 rounded-2xl flex items-center justify-between text-left">
                <div class="space-y-3 font-sans">
                    <h3 class="font-serif text-xl tracking-wider uppercase text-amber-100">Bold</h3>
                    <p class="text-[11px] text-stone-400 uppercase tracking-widest">Bold • Elegant • Memorable</p>
                    <a href="#" class="inline-block bg-stone-100 text-stone-900 text-[10px] uppercase tracking-wider px-4 py-2 rounded-full font-semibold">Explore Bold &rarr;</a>
                </div>
                <img src="{{ asset('images/scent-bold.png') }}" alt="Bold Scent" class="h-32 object-contain">
            </div>
        </div>
    </section>

    <!-- SECTION 3: LIMITED COLLECTION / INSPIRED -->
    <section class="bg-[#dbebf6] rounded-2xl p-8 md:p-12 flex flex-col md:flex-row items-center justify-between">
        <div class="md:w-1/3 space-y-4">
            <span class="text-[10px] uppercase tracking-[0.3em] font-sans text-stone-500">Limited Collection</span>
            <h2 class="text-3xl md:text-4xl font-normal leading-tight">PERFUME INSPIRED<br><span class="font-bold tracking-widest">MYKONOS</span></h2>
            <p class="text-xs font-sans text-stone-600">Aroma laut, angin, dan kebebasan.</p>
            <a href="#" class="inline-block bg-stone-900 text-white font-sans text-xs uppercase tracking-wider px-6 py-3 rounded-full mt-2">Explore Mykonos &rarr;</a>
        </div>
        <div class="md:w-2/3 mt-6 md:mt-0 flex justify-end">
            <img src="{{ asset('images/mykonos-collection.png') }}" alt="Mykonos Collection" class="max-h-72 object-contain">
        </div>
    </section>

    <!-- SECTION 4: CHOOSE YOUR MOOD -->
    <section class="text-center space-y-8 bg-gradient-to-b from-stone-50 to-[#f6f0ea] p-8 rounded-2xl">
        <div>
            <h2 class="text-2xl uppercase tracking-wider">Choose Your Mood</h2>
            <p class="text-xs font-sans text-stone-500 mt-1">What do you want to smell like today?</p>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 font-sans">
            <button class="p-4 bg-white rounded-xl shadow-sm border border-stone-100 hover:border-stone-800 transition flex flex-col items-center space-y-2">
                <span class="text-2xl">☀️</span>
                <span class="text-xs uppercase tracking-widest font-semibold">Daily</span>
            </button>
            <button class="p-4 bg-white rounded-xl shadow-sm border border-stone-100 hover:border-stone-800 transition flex flex-col items-center space-y-2">
                <span class="text-2xl">💕</span>
                <span class="text-xs uppercase tracking-widest font-semibold">Date</span>
            </button>
            <button class="p-4 bg-white rounded-xl shadow-sm border border-stone-100 hover:border-stone-800 transition flex flex-col items-center space-y-2">
                <span class="text-2xl">🌙</span>
                <span class="text-xs uppercase tracking-widest font-semibold">Night</span>
            </button>
            <button class="p-4 bg-white rounded-xl shadow-sm border border-stone-100 hover:border-stone-800 transition flex flex-col items-center space-y-2">
                <span class="text-2xl">⭐</span>
                <span class="text-xs uppercase tracking-widest font-semibold">Special</span>
            </button>
        </div>
    </section>

    <!-- SECTION 5: FOR HIM / FOR HER -->
    <section class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- For Him -->
        <div class="bg-[#1c222e] text-white p-8 rounded-2xl flex items-center justify-between">
            <div class="space-y-3 font-sans">
                <h3 class="font-serif text-2xl tracking-wider uppercase text-slate-100">For Him</h3>
                <p class="text-xs text-slate-300">Confident. Fresh. Bold.</p>
                <p class="text-[11px] text-slate-400 max-w-xs">Discover fragrances made for his everyday moments.</p>
                <a href="#" class="inline-block border border-slate-400 text-slate-200 text-[10px] uppercase tracking-wider px-5 py-2.5 rounded-full hover:bg-white hover:text-slate-900 transition">Shop Men's Collection &rarr;</a>
            </div>
            <img src="{{ asset('images/for-him.png') }}" alt="For Him" class="h-40 object-contain">
        </div>
        <!-- For Her -->
        <div class="bg-[#fceef0] p-8 rounded-2xl flex items-center justify-between">
            <div class="space-y-3 font-sans">
                <h3 class="font-serif text-2xl tracking-wider uppercase text-rose-950">For Her</h3>
                <p class="text-xs text-rose-800">Sweet. Feminine. Elegant.</p>
                <p class="text-[11px] text-rose-600 max-w-xs">Find a fragrance that feels like you.</p>
                <a href="#" class="inline-block border border-rose-800 text-rose-900 text-[10px] uppercase tracking-wider px-5 py-2.5 rounded-full hover:bg-rose-900 hover:text-white transition">Shop Women's Collection &rarr;</a>
            </div>
            <img src="{{ asset('images/for-her.png') }}" alt="For Her" class="h-40 object-contain">
        </div>
    </section>

    <!-- SECTION 6: PERFUME FOR EVERY MOMENT -->
    <section class="text-center space-y-8">
        <h2 class="text-2xl uppercase tracking-wider">Perfume For Every Moment</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 font-sans">
            <!-- Daily -->
            <div class="bg-stone-100 rounded-xl overflow-hidden p-3 space-y-2">
                <img src="{{ asset('images/moment-daily.png') }}" alt="Daily" class="w-full h-36 object-cover rounded-lg">
                <h4 class="text-xs font-semibold uppercase">Daily</h4>
                <p class="text-[10px] text-stone-500">Untuk aktivitas sehari-hari</p>
                <a href="#" class="inline-block border border-stone-300 text-[9px] uppercase px-3 py-1 rounded-full">Explore &rarr;</a>
            </div>
            <!-- Date -->
            <div class="bg-stone-100 rounded-xl overflow-hidden p-3 space-y-2">
                <img src="{{ asset('images/moment-date.png') }}" alt="Date" class="w-full h-36 object-cover rounded-lg">
                <h4 class="text-xs font-semibold uppercase">Date</h4>
                <p class="text-[10px] text-stone-500">Untuk momen spesial</p>
                <a href="#" class="inline-block border border-stone-300 text-[9px] uppercase px-3 py-1 rounded-full">Explore &rarr;</a>
            </div>
            <!-- Night -->
            <div class="bg-stone-100 rounded-xl overflow-hidden p-3 space-y-2">
                <img src="{{ asset('images/moment-night.png') }}" alt="Night" class="w-full h-36 object-cover rounded-lg">
                <h4 class="text-xs font-semibold uppercase">Night</h4>
                <p class="text-[10px] text-stone-500">Untuk malam yang memorable</p>
                <a href="#" class="inline-block border border-stone-300 text-[9px] uppercase px-3 py-1 rounded-full">Explore &rarr;</a>
            </div>
            <!-- Special -->
            <div class="bg-stone-100 rounded-xl overflow-hidden p-3 space-y-2">
                <img src="{{ asset('images/moment-special.png') }}" alt="Special" class="w-full h-36 object-cover rounded-lg">
                <h4 class="text-xs font-semibold uppercase">Special</h4>
                <p class="text-[10px] text-stone-500">Saat ingin tampil berbeda</p>
                <a href="#" class="inline-block border border-stone-300 text-[9px] uppercase px-3 py-1 rounded-full">Explore &rarr;</a>
            </div>
        </div>
    </section>

    <!-- SECTION 7: STORY & INSTAGRAM -->
    <section class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-stone-900 text-white p-8 rounded-2xl space-y-4 font-sans">
            <span class="text-[10px] uppercase tracking-[0.3em] text-stone-400">The Story Behind</span>
            <h3 class="font-serif text-3xl text-amber-100">HALENT</h3>
            <p class="text-xs text-stone-300 leading-relaxed max-w-md">Halent hadir untuk membantumu menemukan aroma yang bukan hanya wangi, tetapi juga menjadi bagian dari karakter dan cerita setiap harimu.</p>
            <a href="{{ route('about') }}" class="inline-block border border-stone-500 text-xs uppercase tracking-wider px-5 py-2.5 rounded-full hover:bg-stone-100 hover:text-stone-900 transition">Discover Halent &rarr;</a>
        </div>
        <div class="bg-stone-100 p-8 rounded-2xl space-y-4 font-sans">
            <h3 class="font-serif text-xl">FOLLOW THE HALENT JOURNEY</h3>
            <p class="text-xs text-stone-500">@halent.parfume</p>
            <div class="grid grid-cols-3 gap-2">
                <div class="bg-stone-300 h-20 rounded-lg"></div>
                <div class="bg-stone-300 h-20 rounded-lg"></div>
                <div class="bg-stone-300 h-20 rounded-lg"></div>
            </div>
            <a href="#" class="inline-block border border-stone-800 text-[10px] uppercase tracking-wider px-4 py-2 rounded-full">Follow Us on Instagram &rarr;</a>
        </div>
    </section>

    <!-- SECTION 8: CONSULTATION BANNER -->
    <section class="bg-[#f0f4f8] p-8 rounded-2xl flex flex-col md:flex-row items-center justify-between font-sans">
        <div class="space-y-1">
            <h3 class="font-serif italic text-xl text-stone-800">Still don't know which scent is for you?</h3>
            <p class="text-xs text-stone-500">Let us help you find your signature scent.</p>
        </div>
        <div class="flex items-center space-x-4 mt-4 md:mt-0">
            <a href="#" class="bg-stone-900 text-white text-xs uppercase tracking-wider px-6 py-3 rounded-full">Find My Scent &rarr;</a>
            <div class="text-left border-l border-stone-300 pl-4 text-xs">
                <span class="font-bold block">DM "SCENT"</span>
                <span class="text-stone-500 text-[10px]">untuk konsultasi pilihan aroma</span>
            </div>
        </div>
    </section>

</div>
@endsection