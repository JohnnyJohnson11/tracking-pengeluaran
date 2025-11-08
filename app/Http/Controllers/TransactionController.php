<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use App\Models\Income;
use App\Models\Expense;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        $incomes = Income::where('user_id', $userId)->get()->map(function ($item) {
            $item->jenis = 'Pemasukan';
            return $item;
        });

        $expenses = Expense::where('user_id', $userId)->get()->map(function ($item) {
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