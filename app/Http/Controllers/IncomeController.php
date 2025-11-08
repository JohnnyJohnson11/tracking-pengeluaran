<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Income;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller;

class IncomeController extends Controller
{
    public function create()
    {
        return view('incomes.create');
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

        Income::create($validated);

        return redirect()->route('transactions.index')->with('success', 'Pemasukan berhasil ditambahkan!');
    }

    public function edit(Income $income)
    {
        if ($income->user_id != Auth::id()) {
            abort(403);
        }
        return view('incomes.edit', compact('income'));
    }

    public function update(Request $request, Income $income)
    {
        if ($income->user_id != Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'kategori' => 'required|string|max:100',
            'jumlah' => 'required|numeric|min:0',
            'tanggal' => 'required|date',
            'keterangan' => 'nullable|string|max:255',
        ]);

        $income->update($validated);

        return redirect()->route('transactions.index')->with('success', 'Pemasukan berhasil diperbarui!');
    }

    public function destroy(Income $income)
    {
        if ($income->user_id != Auth::id()) {
            abort(403);
        }

        $income->delete();
        return redirect()->route('transactions.index')->with('success', 'Pemasukan berhasil dihapus!');
    }
}
