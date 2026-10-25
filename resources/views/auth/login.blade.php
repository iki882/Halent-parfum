@extends('layouts.app')

@section('title', 'Login - Halent Parfum')

@section('content')
<section class="flex min-h-[65vh] items-center justify-center bg-[#f6f0ea] px-5 py-12">
    <div class="w-full max-w-md rounded-2xl border border-stone-200 bg-white p-6 shadow-xl sm:p-9">
        <div class="mb-8 text-center">
            <p class="text-xs font-semibold uppercase tracking-[0.3em] text-[#172752]">Selamat Datang</p>
            <h1 class="mt-3 font-serif text-3xl text-stone-900">Halent Parfume</h1>
            <p class="mt-2 text-sm text-stone-600">Masuk untuk melanjutkan dan menikmati koleksi kami.</p>
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

        <form action="{{ route('login') }}" method="POST" class="space-y-5">
            @csrf

            <div>
                <label for="email" class="mb-2 block text-sm font-medium text-stone-700">Alamat Email</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required autocomplete="email"
                       placeholder="nama@email.com"
                       class="w-full rounded-lg border border-stone-300 px-4 py-3 text-sm text-stone-900 outline-none transition placeholder:text-stone-400 focus:border-[#172752] focus:ring-2 focus:ring-[#172752]/20">
            </div>

            <div>
                <label for="password" class="mb-2 block text-sm font-medium text-stone-700">Password</label>
                <div class="flex gap-2">
                    <input type="password" name="password" id="password" required autocomplete="current-password"
                           placeholder="Masukkan password"
                           class="min-w-0 flex-1 rounded-lg border border-stone-300 px-4 py-3 text-sm text-stone-900 outline-none transition placeholder:text-stone-400 focus:border-[#172752] focus:ring-2 focus:ring-[#172752]/20">
                    <button class="rounded-lg border border-stone-300 px-3 text-xs font-medium text-stone-700 transition hover:bg-stone-100"
                            type="button" id="togglePassword" aria-label="Tampilkan password">
                        Lihat
                    </button>
                </div>
            </div>

            <button type="submit" class="w-full rounded-lg bg-[#172752] px-5 py-3 text-sm font-semibold uppercase tracking-wider text-white transition hover:bg-[#22396f] focus:outline-none focus:ring-2 focus:ring-[#172752]/40 focus:ring-offset-2">
                Login
            </button>
        </form>

        <div class="mt-6 border-t border-stone-200 pt-6 text-center">
            <p class="text-sm text-stone-600">Belum punya akun?</p>
            <a href="{{ route('register') }}" class="mt-3 inline-flex w-full justify-center rounded-lg border border-[#172752] px-5 py-3 text-sm font-semibold text-[#172752] transition hover:bg-[#172752] hover:text-white">
                Register Akun Baru
            </a>
        </div>
    </div>
</section>

<script>
    const togglePassword = document.querySelector('#togglePassword');
    const password = document.querySelector('#password');

    togglePassword.addEventListener('click', function () {
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);
        this.textContent = type === 'password' ? 'Lihat' : 'Sembunyikan';
        this.setAttribute('aria-label', type === 'password' ? 'Tampilkan password' : 'Sembunyikan password');
    });
</script>
@endsection