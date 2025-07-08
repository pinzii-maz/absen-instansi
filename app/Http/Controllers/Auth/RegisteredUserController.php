<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Divisi;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        $divisi = Divisi::all();
        return view('auth.register', ['divisi' => $divisi]);
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'divisi_id' => ['required', 'exists:divisi,id'],
            'role' => ['required', 'in:kepala_biro,kepala_bagian_perencanaan_dan_kepegawaian,kepala_bagian_protokol,kepala_bagian_materi_dan_komunikasi_pimpinan,kepala_sub_bagian_tata_usaha,analisi_kebijakan_ahli_muda,pranata_hubungan_masyarakat_ahli_muda,pelaksana'],
            
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'nip' => $request->nip,
            'password' => Hash::make($request->password),
            'divisi_id' => $request->divisi_id,
            'role' => $request->role, 
            'is_admin' => false,
        ]);

        event(new Registered($user));

        Auth::login($user);

         return redirect('/dashboard');
    }
}
