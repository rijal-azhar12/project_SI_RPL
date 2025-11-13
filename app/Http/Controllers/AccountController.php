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
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $validatedData['name'],
            'username' => $validatedData['username'],
            'password' => Hash::make($validatedData['password']),
            'role' => $request->input('role', 'cashier'), // Default role to 'cashier'
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
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $account->id,
        ];

        if ($request->filled('password')) {
            $rules['password'] = 'required|string|min:8|confirmed';
        }

        $validatedData = $request->validate($rules);

        $account->name = $validatedData['name'];
        $account->username = $validatedData['username'];
        if ($request->filled('password')) {
            $account->password = Hash::make($validatedData['password']);
        }
        $account->role = $request->input('role', $account->role); // Allow role update, default to current role

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