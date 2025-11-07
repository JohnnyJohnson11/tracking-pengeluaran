<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Expense; // ✅ tambahkan baris ini
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
<<<<<<< HEAD
            'kategori' => 'required|string|max:100',
            'jumlah' => 'required|numeric|min:0',
            'tanggal' => 'required|date',
            'keterangan' => 'nullable|string|max:255',
=======
            'category' => 'required|string|max:100',
            'amount' => 'required|numeric|min:0',
            'date' => 'required|date',
            'description' => 'nullable|string|max:255',
>>>>>>> 4bffe41d2c61f2f5fd8619611913b60c3a231bf8
        ]);

        $validated['user_id'] = 1; //usernya ganti

        Expense::create($validated);

        return redirect('/')->with('success', 'Pemasukan berhasil ditambahkan!');
    }
}
