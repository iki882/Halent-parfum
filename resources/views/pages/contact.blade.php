@extends('layouts.app')

@section('title', 'Contact - Halent Parfum')

@section('content')
    <section id="contact" class="scroll-mt-24 bg-stone-50 px-6 py-16 sm:py-20">
        <div class="mx-auto max-w-6xl">
            <div class="mx-auto mb-12 max-w-2xl text-center">
                <p class="text-xs font-semibold uppercase tracking-[0.25em] text-[#172752]">Kami siap membantu</p>
                <h1 class="mt-3 font-serif text-3xl font-bold text-stone-900 sm:text-4xl">Hubungi Halent Parfum</h1>
                <p class="mt-4 text-sm leading-6 text-stone-600">
                    Ada pertanyaan tentang produk atau pesanan? Hubungi kami melalui WhatsApp Business.
                </p>
            </div>

            <div class="mx-auto grid max-w-5xl gap-8 rounded-3xl border border-stone-200 bg-white p-6 shadow-sm sm:p-8 md:grid-cols-[0.8fr_1.2fr] md:gap-12">
                <div class="rounded-2xl bg-[#172752] p-6 text-stone-100 sm:p-8">
                    <p class="text-xs font-semibold uppercase tracking-[0.2em] text-amber-200">Halent Parfum</p>
                    <h2 class="mt-4 font-serif text-2xl font-bold">Kami senang mendengar dari Anda.</h2>
                    <p class="mt-4 text-sm leading-6 text-stone-300">
                        Hubungi kami secara langsung melalui WhatsApp Business untuk pertanyaan seputar produk atau pesanan.
                    </p>
                </div>

                <form action="{{ route('contact.whatsapp') }}" method="POST" target="_blank" class="space-y-5">
                    @csrf

                    <div>
                        <label for="name" class="block text-sm font-medium text-stone-700">Nama lengkap</label>
                        <input
                            type="text"
                            name="name"
                            id="name"
                            value="{{ old('name') }}"
                            required
                            maxlength="255"
                            autocomplete="name"
                            class="mt-1.5 block w-full rounded-xl border border-stone-300 px-4 py-3 text-sm text-stone-900 shadow-sm outline-none transition placeholder:text-stone-400 focus:border-[#172752] focus:ring-2 focus:ring-[#172752]/20"
                            placeholder="Masukkan nama Anda"
                        >
                        @error('name')
                            <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="order_id" class="block text-sm font-medium text-stone-700">ID pesanan <span class="font-normal text-stone-500">(opsional)</span></label>
                        <input
                            type="text"
                            name="order_id"
                            id="order_id"
                            value="{{ old('order_id') }}"
                            maxlength="100"
                            class="mt-1.5 block w-full rounded-xl border border-stone-300 px-4 py-3 text-sm text-stone-900 shadow-sm outline-none transition placeholder:text-stone-400 focus:border-[#172752] focus:ring-2 focus:ring-[#172752]/20"
                            placeholder="Contoh: ORD-12345"
                        >
                        @error('order_id')
                            <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="message" class="block text-sm font-medium text-stone-700">Pesan atau kendala</label>
                        <textarea
                            name="message"
                            id="message"
                            rows="5"
                            required
                            maxlength="2000"
                            class="mt-1.5 block w-full resize-y rounded-xl border border-stone-300 px-4 py-3 text-sm text-stone-900 shadow-sm outline-none transition placeholder:text-stone-400 focus:border-[#172752] focus:ring-2 focus:ring-[#172752]/20"
                            placeholder="Jelaskan pertanyaan atau kendala Anda..."
                        >{{ old('message') }}</textarea>
                        @error('message')
                            <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <p class="text-xs leading-5 text-stone-500">
                        WhatsApp akan terbuka dengan pesan yang sudah diisi. Tekan tombol kirim di WhatsApp untuk mengirimkannya.
                    </p>

                    <button
                        type="submit"
                        class="inline-flex w-full items-center justify-center gap-2 rounded-full bg-emerald-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:ring-offset-2"
                    >
                        <span>Kirim pesan via WhatsApp</span>
                    </button>
                </form>
            </div>
        </div>
    </section>
@endsection
