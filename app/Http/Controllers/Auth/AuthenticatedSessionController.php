<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
       
    $request->authenticate();
    $request->session()->regenerate();

    // Dapatkan data lengkap user yang baru saja login
    $user = Auth::user();

    // UBAH LOGIKA DI SINI:
    // Periksa apakah kolom 'is_admin' bernilai true.
    if ($user->is_admin) {
        // Jika ya, arahkan ke halaman admin Filament
        return redirect()->intended(config('filament.path', '/admin'));
    }

    // Untuk semua role lainnya, arahkan ke dashboard user
    return redirect()->intended('/dashboard');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();       

        return redirect('/');
    }
}
