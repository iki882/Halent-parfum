<nav class="bg-[#172752] text-stone-100 sticky top-0 z-50 shadow-md">
    <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
        <!-- Logo -->
        <a href="{{ route('home') }}" class="flex items-center gap-3">
            <img src="{{ asset('assets/logo.png') }}"
                 alt="Halent Parfum"
                 class="h-16 w-auto object-contain">
            <span class="text-xl font-serif font-bold tracking-widest text-amber-100 uppercase">
                Halent <span class="block text-[9px] tracking-[0.3em] font-sans text-stone-400">Parfume & Fragrance</span>
            </span>
        </a>

        <!-- Navigation Links -->
        <div class="hidden md:flex items-center space-x-8 text-xs tracking-widest uppercase font-medium">
            <a href="{{ route('home') }}" class="hover:text-amber-200 transition">Home</a>
            <a href="{{ route('shop') }}" class="hover:text-amber-200 transition">Shop</a>
            <a href="{{ route('bestseller') }}" class="hover:text-amber-200 transition">Best Seller</a>
            <a href="{{ route('contact') }}#contact" class="hover:text-amber-200 transition">Contact</a>
        </div>

        <!-- Right Action Icons -->
        <div class="flex items-center gap-3 text-stone-300">
            <button class="hover:text-amber-200" aria-label="Search">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </button>
            <button class="hover:text-amber-200" aria-label="Profile">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
            </button>
            <button class="hover:text-amber-200" aria-label="Cart">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
            </button>

            @guest
                <a href="{{ route('login') }}" class="rounded-full border border-stone-300/80 px-4 py-2 text-[10px] font-semibold uppercase tracking-[0.2em] text-stone-100 transition hover:border-amber-200 hover:text-amber-200">
                    Login
                </a>
                <a href="{{ route('register') }}" class="rounded-full bg-amber-400 px-4 py-2 text-[10px] font-semibold uppercase tracking-[0.2em] text-stone-900 transition hover:bg-amber-300">
                    Register
                </a>
            @endguest

            @auth
                <a href="{{ route('orders.index') }}" class="rounded-full border border-stone-300/80 px-4 py-2 text-[10px] font-semibold uppercase tracking-[0.2em] text-stone-100 transition hover:border-amber-200 hover:text-amber-200">
                    My Orders
                </a>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="rounded-full bg-amber-400 px-4 py-2 text-[10px] font-semibold uppercase tracking-[0.2em] text-stone-900 transition hover:bg-amber-300">
                        Logout
                    </button>
                </form>
            @endauth
        </div>
    </div>
</nav>