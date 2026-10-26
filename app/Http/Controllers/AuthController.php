<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use PDOException;

class AuthController extends Controller
{
    // 1. Menampilkan Form Register
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    // 2. Memproses Data Register
    public function register(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8|confirmed',
            ]);

            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
            ]);
        } catch (PDOException $exception) {
            if (! $this->isDatabaseConnectionFailure($exception)) {
                throw $exception;
            }

            report($exception);

            return back()
                ->withErrors(['email' => 'Pendaftaran sementara tidak tersedia karena koneksi database bermasalah. Silakan coba lagi nanti.'])
                ->withInput($request->except(['password', 'password_confirmation']));
        }

        // Otomatis login setelah berhasil register
        Auth::login($user);
        $request->session()->regenerate();

        return redirect()
            ->route('home')
            ->with('success', 'Registrasi berhasil! Selamat datang.');
    }

    // 3. Menampilkan Form Login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // 4. Memproses Data Login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        try {
            $authenticated = Auth::attempt($credentials);
        } catch (PDOException $exception) {
            if (! $this->isDatabaseConnectionFailure($exception)) {
                throw $exception;
            }

            report($exception);

            return back()
                ->withErrors(['email' => 'Login sementara tidak tersedia karena koneksi database bermasalah. Silakan coba lagi nanti.'])
                ->onlyInput('email');
        }

        if ($authenticated) {
            $request->session()->regenerate();

            return redirect()
                ->route('shop')
                ->with('success', 'Berhasil login!');
        }

        // Jika gagal login
        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    // 5. Memproses Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('success', 'Berhasil keluar.');
    }

    private function isDatabaseConnectionFailure(PDOException $exception): bool
    {
        return (int) ($exception->errorInfo[1] ?? $exception->getCode()) === 2002;
    }
}
