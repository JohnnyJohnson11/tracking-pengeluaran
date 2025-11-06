<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class IncomeController extends Controller
{
    public function create()
    {
        return view('incomes.incomes-create');
    }

    public function store(Request $request)
    {
        // nanti isi logika simpan data
    }
}
