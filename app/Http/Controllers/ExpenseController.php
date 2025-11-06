<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    public function create()
    {
        return view('expenses.expenses-create');
    }

    public function store(Request $request)
    {
        // nanti isi logika simpan data
    }
}
