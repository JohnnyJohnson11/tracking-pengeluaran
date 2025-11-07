<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Income; // ✅ tambahkan baris ini
use Illuminate\Support\Facades\Auth;

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

        $validated['user_id'] = 1; //usernya ganti

        Income::create($validated);

        return redirect('/')->with('success', 'Pemasukan berhasil ditambahkan!');
    }
}
