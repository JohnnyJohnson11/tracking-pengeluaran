<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Income;
use App\Models\Expense;

class TransactionController extends Controller
{
    public function index()
    {
        $incomes = Income::all()->map(function($item) {
            $item->jenis = 'Pemasukan';
            return $item;
        });

        $expenses = Expense::all()->map(function($item) {
            $item->jenis = 'Pengeluaran';
            return $item;
        });

        $transactions = $incomes->concat($expenses) 
            ->sortByDesc('date')                    
            ->values();                              

        return view('transaction.transaction-index', [
            'transactions' => $transactions
        ]);
    }
}