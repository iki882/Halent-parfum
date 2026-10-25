<!-- SECTION BEST SELLER (3 PRODUK) -->
<section id="best-seller" class="bg-[#edf2ef] px-6 text-stone-800" style="padding-top: 140px; padding-bottom: 80px;">
    <div class="mx-auto max-w-6xl">
        <!-- Header Section -->
        <div class="text-center mb-14">
            <span class="text-xs uppercase tracking-[0.2em] font-semibold text-[#172752] block mb-2">Pilihan Terfavorit</span>
            <h2 class="text-3xl md:text-4xl font-serif font-bold text-stone-900">Koleksi Best Seller</h2>
            <div class="w-16 h-0.5 bg-[#172752] mx-auto mt-4 rounded-full"></div>
            <p class="text-xs text-stone-600 mt-3 max-w-md mx-auto">Varian parfum paling diminati dengan aroma elegan dan ketahanan maksimal sepanjang hari.</p>
        </div>

        <!-- Grid 3 Kolom Responsif -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($bestSellers as $product)
                <div class="bg-white rounded-2xl p-5 border border-stone-200 shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col justify-between group">
                    <div>
                        <!-- Container Gambar Produk -->
                        <div class="relative bg-stone-100 rounded-xl p-4 mb-5 overflow-hidden flex items-center justify-center h-64">
                            <!-- Badge Best Seller -->
                            <span class="absolute top-3 left-3 bg-[#172752] text-white text-[10px] uppercase font-bold tracking-wider px-2.5 py-1 rounded-full shadow-sm">
                                Best Seller
                            </span>

                            <img src="{{ asset($product['image']) }}"
                                 alt="{{ $product['name'] }}"
                                 class="h-full object-contain group-hover:scale-105 transition-transform duration-300"
                                 onerror="this.onerror=null; this.src='https://via.placeholder.com/200x200?text=Halent+Parfum';">
                        </div>

                        <!-- Informasi Produk & Deskripsi -->
                        <div class="space-y-2 mb-4">
                            <div class="flex items-center justify-between text-[11px] text-stone-500">
                                <span class="uppercase font-semibold tracking-wider text-[#172752]">{{ $product['category'] }}</span>
                                <div class="flex items-center space-x-1">
                                    <span class="text-amber-500">★</span>
                                    <span class="font-bold text-stone-700">{{ $product['rating'] }}</span>
                                    <span>({{ $product['sold'] }})</span>
                                </div>
                            </div>

                            <h3 class="text-lg font-serif font-bold text-stone-900 group-hover:text-[#172752] transition-colors">
                                {{ $product['name'] }}
                            </h3>

                            <!-- Deskripsi Parfum -->
                            <p class="text-xs text-stone-600 leading-relaxed line-clamp-2">
                                {{ $product['description'] }}
                            </p>

                            <p class="text-base font-bold text-[#172752] pt-1">
                                Rp {{ number_format($product['price'], 0, ',', '.') }}
                            </p>
                        </div>
                    </div>

                    <!-- Tombol Beli / Checkout -->
                    <a href="{{ url('/checkout/' . $product['slug']) }}"
                       class="block w-full text-center rounded-full bg-[#172752] py-3 text-xs font-semibold text-white hover:bg-[#1f336b] transition shadow-md">
                       Beli Sekarang
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</section>