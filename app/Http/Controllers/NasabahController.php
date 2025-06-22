<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\StoreNasabahRequest;
use App\Http\Requests\UpdateNasabahRequest;
use Illuminate\Support\Facades\Hash;

use Illuminate\Http\Request;

class NasabahController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::with('profile')->whereHasRole('nasabah')->get();
        return view('nasabah.get-all-nasabah', ['users' => $users]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('nasabah.post-nasabah');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreNasabahRequest $request)
    {
        $validated = $request->validated();

        $user = User::create([
            'name'      => $validated['name'],
            'email'     => $validated['email'],
            'password'  => Hash::make($validated['password'])
        ]);
        $user->profile()->create([
            'nomor_induk_kependudukan' => $validated['nomor_induk_kependudukan'],
            'nomor_rekening'           => $validated['nomor_rekening'],
            'jenis_kelamin'            => $validated['jenis_kelamin'],
            'alamat'                   => $validated['alamat'],
            'kecamatan'                => $validated['kecamatan'],
            'kabupaten'                => $validated['kabupaten'],
            'provinsi'                 => $validated['provinsi'],
        ]);
        $user->addRole('nasabah');

        $flashMessage = 'Data nasabah berhasil ditambahkan';

        return to_route('nasabah.index')->with('success', $flashMessage);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $user->load('profile');
        return view('nasabah.put-nasabah', ['user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateNasabahRequest $request, User $user)
    {
        $validated = $request->validated();

        $user->update([
            'name'  => $validated['name'],
            'email' => $validated['email'],
        ]);
        $user->profile()->update([
            'nomor_induk_kependudukan'  => $validated['nomor_induk_kependudukan'],
            'nomor_rekening'            => $validated['nomor_rekening'],
            'jenis_kelamin'             => $validated['jenis_kelamin'],
            'alamat'                    => $validated['alamat'],
            'kecamatan'                 => $validated['kecamatan'],
            'kabupaten'                 => $validated['kabupaten'],
            'provinsi'                  => $validated['provinsi'],
        ]);

        $flashMessage = 'Data nasabah berhasil diperbaharui';

        return to_route('nasabah.index')->with('success', $flashMessage);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();

        $flashMessage = 'Data nasabah berhasil dihapus';

        return to_route('nasabah.index')->with('success', $flashMessage);
    }
}
