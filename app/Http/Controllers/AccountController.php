<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        return view('account', ['users' => $users]);
    }

    /**
     * Store a newly created resource in storage.
     */
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
            'peran' => $request->input('peran', 'kasir'), // Default role to 'kasir'
        ]);

        return response()->json(['success' => true, 'message' => 'Account created successfully.']);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $account) // Using $account for route model binding
    {
        return response()->json($account);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $account) // Using $account for route model binding
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
        $account->peran = $request->input('peran', $account->peran); // Allow role update, default to current role

        $account->save();

        return response()->json(['success' => true, 'message' => 'Account updated successfully.']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $account) // Using $account for route model binding
    {
        $account->delete();
        return response()->json(['success' => true, 'message' => 'Account deleted successfully.']);
    }
}