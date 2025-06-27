<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
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
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name'                      => ['required', 'string', 'max:255'],
            'email'                     => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password'                  => ['required', Rules\Password::defaults()],
            'nomor_induk_kependudukan'  => ['required', 'numeric', 'digits_between:10,16', 'unique:user_profiles'],
            'nomor_rekening'            => ['required', 'numeric', 'digits_between:5,20', 'unique:user_profiles'],
            'jenis_kelamin'             => ['required', 'in:l,p'],
            'alamat'                    => ['required', 'string'],
            'kecamatan'                 => ['required', 'string'],
            'kabupaten'                 => ['required', 'string'],
            'provinsi'                  => ['required', 'string'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        $user->profile()->create([
            'nomor_induk_kependudukan' => $request->nomor_induk_kependudukan,
            'nomor_rekening'           => $request->nomor_rekening,
            'jenis_kelamin'            => $request->jenis_kelamin,
            'alamat'                   => $request->alamat,
            'kecamatan'                => $request->kecamatan,
            'kabupaten'                => $request->kabupaten,
            'provinsi'                 => $request->provinsi,
        ]);
        $user->addRole('nasabah');

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
