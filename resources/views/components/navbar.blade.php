<nav class="bg-[#172752] text-stone-100 sticky top-0 z-50 shadow-md">
    <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
        <!-- Logo -->
        <img src="assets/logo.png"
        alt="Halent Parfum"
        class="h-16 w-auto object-contain"
        >
        <a href="{{ route('home') }}" class="text-xl font-serif font-bold tracking-widest text-amber-100 uppercase">
            Halent <span class="block text-[9px] tracking-[0.3em] font-sans text-stone-400">Parfume & Fragrance</span>
        </a>

        <!-- Navigation Links -->
        <div class="hidden md:flex items-center space-x-8 text-xs tracking-widest uppercase font-medium">
            <a href="{{ route('home') }}" class="hover:text-amber-200 transition">Home</a>
            <a href="#shop" class="hover:text-amber-200 transition">Shop</a>
            <a href="#bestseller" class="hover:text-amber-200 transition">Best Seller</a>
            <a href="#moments" class="hover:text-amber-200 transition">Moments</a>
            <a href="{{ route('about') }}" class="hover:text-amber-200 transition">About</a>
            <a href="#contact" class="hover:text-amber-200 transition">Contact</a>
        </div>

        <!-- Right Action Icons -->
        <div class="flex items-center space-x-5 text-stone-300">
            <button class="hover:text-amber-200"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg></button>
            <button class="hover:text-amber-200"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg></button>
            <button class="hover:text-amber-200"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg></button>
        </div>
    </div>
</nav>