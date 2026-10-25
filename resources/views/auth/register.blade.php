@extends('layouts.app')

@section('title', 'Register - Halent Parfum')

@section('content')
<section class="flex min-h-[65vh] items-center justify-center bg-[#f6f0ea] px-5 py-12">
    <div class="w-full max-w-md rounded-2xl border border-stone-200 bg-white p-6 shadow-xl sm:p-9">
        <div class="mb-8 text-center">
            <p class="text-xs font-semibold uppercase tracking-[0.3em] text-[#172752]">Bergabung Bersama Kami</p>
            <h1 class="mt-3 font-serif text-3xl text-stone-900">Buat Akun</h1>
            <p class="mt-2 text-sm text-stone-600">Daftar untuk menjelajahi koleksi Halent Parfume.</p>
        </div>

        @if (session('success'))
            <p class="mb-5 rounded-lg border border-green-200 bg-green-50 p-4 text-sm text-green-800" role="status">
                {{ session('success') }}
            </p>
        @endif

        @if ($errors->any())
            <div class="mb-5 rounded-lg border border-red-200 bg-red-50 p-4 text-sm text-red-800" role="alert">
                <ul class="list-inside list-disc space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('register') }}" method="POST" class="space-y-5">
            @csrf

            <div>
                <label for="name" class="mb-2 block text-sm font-medium text-stone-700">Nama Lengkap</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required autocomplete="name"
                       placeholder="Masukkan nama lengkap"
                       class="w-full rounded-lg border border-stone-300 px-4 py-3 text-sm text-stone-900 outline-none transition placeholder:text-stone-400 focus:border-[#172752] focus:ring-2 focus:ring-[#172752]/20">
            </div>

            <div>
                <label for="email" class="mb-2 block text-sm font-medium text-stone-700">Alamat Email</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required autocomplete="email"
                       placeholder="nama@email.com"
                       class="w-full rounded-lg border border-stone-300 px-4 py-3 text-sm text-stone-900 outline-none transition placeholder:text-stone-400 focus:border-[#172752] focus:ring-2 focus:ring-[#172752]/20">
            </div>

            <div>
                <label for="password" class="mb-2 block text-sm font-medium text-stone-700">Password</label>
                <input type="password" name="password" id="password" required autocomplete="new-password"
                       placeholder="Minimal 8 karakter"
                       class="w-full rounded-lg border border-stone-300 px-4 py-3 text-sm text-stone-900 outline-none transition placeholder:text-stone-400 focus:border-[#172752] focus:ring-2 focus:ring-[#172752]/20">
            </div>

            <div>
                <label for="password_confirmation" class="mb-2 block text-sm font-medium text-stone-700">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation" required autocomplete="new-password"
                       placeholder="Ulangi password"
                       class="w-full rounded-lg border border-stone-300 px-4 py-3 text-sm text-stone-900 outline-none transition placeholder:text-stone-400 focus:border-[#172752] focus:ring-2 focus:ring-[#172752]/20">
            </div>

            <button type="submit" class="w-full rounded-lg bg-[#172752] px-5 py-3 text-sm font-semibold uppercase tracking-wider text-white transition hover:bg-[#22396f] focus:outline-none focus:ring-2 focus:ring-[#172752]/40 focus:ring-offset-2">
                Register
            </button>
        </form>

        <div class="mt-6 border-t border-stone-200 pt-6 text-center">
            <p class="text-sm text-stone-600">Sudah punya akun?</p>
            <a href="{{ route('login') }}" class="mt-3 inline-flex w-full justify-center rounded-lg border border-[#172752] px-5 py-3 text-sm font-semibold text-[#172752] transition hover:bg-[#172752] hover:text-white">
                Login
            </a>
        </div>
    </div>
</section>
@endsection