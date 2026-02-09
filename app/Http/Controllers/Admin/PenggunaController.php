<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\PetugasRegisteredMail;

class PenggunaController extends Controller
{
   public function index()
    {
        $users = User::whereIn('role', ['petugas', 'peminjam'])->get();
        return view('admin.pengguna.index', compact('users'));
    }

    public function create()
    {
        return view('admin.pengguna.create');
    }

    public function store(Request $request)
    {
        $request->validate([
        'name' => 'required',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:6'
    ]);

    $plainPassword = $request->password;

    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($plainPassword),
        'role' => 'petugas'
    ]);

    // KIRIM EMAIL
    Mail::to($user->email)
        ->send(new PetugasRegisteredMail($user, $plainPassword));

    return redirect()->route('admin.pengguna.index')
        ->with('success', 'Petugas berhasil ditambahkan & email terkirim');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
