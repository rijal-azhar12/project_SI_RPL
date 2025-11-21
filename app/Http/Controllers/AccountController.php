<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('account', ['users' => $users]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:user',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $lastId = User::max('id_user');
        $newId = $lastId ? $lastId + 1 : 1;

        $user = User::create([
            'id_user' => $newId,
            'nama' => $validatedData['nama'],
            'username' => $validatedData['username'],
            'password' => $validatedData['password'],
            'peran' => $request->input('peran', 'kasir'),
        ]);

        return response()->json(['success' => true, 'message' => 'Account created successfully.']);
    }

    public function show(User $account)
    {
        return response()->json($account);
    }

    public function update(Request $request, User $account)
    {
        $rules = [
            'nama' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:user,username,' . $account->id_user . ',id_user',
        ];

        if ($request->filled('password')) {
            $rules['password'] = 'required|string|min:8|confirmed';
        }

        $validatedData = $request->validate($rules);

        $account->nama = $validatedData['nama'];
        $account->username = $validatedData['username'];
        if ($request->filled('password')) {
            $account->password = $validatedData['password'];
        }
        $account->peran = $request->input('peran', $account->peran);

        $account->save();

        return response()->json(['success' => true, 'message' => 'Account updated successfully.']);
    }

    public function destroy(User $account)
    {
        $account->delete();
        return response()->json(['success' => true, 'message' => 'Account deleted successfully.']);
    }
}