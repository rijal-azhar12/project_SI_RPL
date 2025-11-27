<?php

namespace App\Http\Controllers;

use App\Models\Pengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{
    public function index()
    {
        $users = Pengguna::all();
        return view('account', ['users' => $users]);
    }

    public function create()
    {
        return view('account_create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:user',
            'password' => 'required|string|min:8',
            'peran' => 'required|string|in:owner,kasir',
        ]);

        Pengguna::create([
            'nama' => $request->nama,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'peran' => $request->peran,
        ]);

        return redirect()->route('account.index')->with('success', 'Akun berhasil ditambahkan!');
    }

    public function show(Pengguna $account) {}

    public function edit(Pengguna $account)
    {
        return view('account_edit', ['user' => $account]);
    }

    public function update(Request $request, Pengguna $account)
    {
        $rules = [
            'nama' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:user,username,' . $account->id_user . ',id_user',
            'peran' => 'required|string|in:owner,kasir',
        ];

        if ($request->filled('password')) {
            $rules['password'] = 'required|string|min:8';
        }

        $request->validate($rules);

        $account->nama = $request->nama;
        $account->username = $request->username;
        if ($request->filled('password')) {
            $account->password = Hash::make($request->password);
        }
        $account->peran = $request->peran;

        $account->save();

        return redirect()->route('account.index')->with('success', 'Akun berhasil diperbarui!');
    }

    public function destroy(Pengguna $account)
    {
        $account->delete();
        return redirect()->route('account.index')->with('success', 'Akun berhasil dihapus!');
    }
}