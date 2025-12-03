<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    public function index()
    {
        $expenses = Expense::all();
        return view('expense', compact('expenses'));
    }

    public function create()
    {
        return view('expense_create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'keterangan' => 'required|string|max:255',
            'jumlah_pengeluaran' => 'required|numeric|min:0',
            'tanggal_pengeluaran' => 'required|date',
        ]);

        Expense::create($request->all());

        return redirect()->route('expense.index')->with('success', 'Pengeluaran berhasil ditambahkan!');
    }

    public function show(Expense $expense)
    {
        // Not implemented
    }

    public function edit(Expense $expense)
    {
        return view('expense_edit', compact('expense'));
    }

    public function update(Request $request, Expense $expense)
    {
        $request->validate([
            'keterangan' => 'required|string|max:255',
            'jumlah_pengeluaran' => 'required|numeric|min:0',
            'tanggal_pengeluaran' => 'required|date',
        ]);

        $expense->update($request->all());

        return redirect()->route('expense.index')->with('success', 'Pengeluaran berhasil diperbarui!');
    }

    public function destroy(Expense $expense)
    {
        $expense->delete();
        return redirect()->route('expense.index')->with('success', 'Pengeluaran berhasil dihapus!');
    }
}