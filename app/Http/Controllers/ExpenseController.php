<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use App\Models\Expense;
use Illuminate\Support\Facades\Auth;

class ExpenseController extends Controller
{
    public function create()
    {
        return view('expenses.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kategori' => 'required|string|max:100',
            'jumlah' => 'required|numeric|min:0',
            'tanggal' => 'required|date',
            'keterangan' => 'nullable|string|max:255',
        ]);

        $validated['user_id'] = Auth::id();

        Expense::create($validated);

        return redirect()->route('transactions.index')->with('success', 'Pengeluaran berhasil ditambahkan!');
    }

    public function edit(Expense $expense)
    {
        if ($expense->user_id != Auth::id()) {
            abort(403);
        }
        return view('expenses.edit', compact('expense'));
    }

    public function update(Request $request, Expense $expense)
    {
        if ($expense->user_id != Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'kategori' => 'required|string|max:100',
            'jumlah' => 'required|numeric|min:0',
            'tanggal' => 'required|date',
            'keterangan' => 'nullable|string|max:255',
        ]);

        $expense->update($validated);

        return redirect()->route('transactions.index')->with('success', 'Pengeluaran berhasil diperbarui!');
    }

    public function destroy(Expense $expense)
    {
        if ($expense->user_id != Auth::id()) {
            abort(403);
        }

        $expense->delete();
        return redirect()->route('transactions.index')->with('success', 'Pengeluaran berhasil dihapus!');
    }
}
