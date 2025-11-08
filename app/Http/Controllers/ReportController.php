<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Income;
use App\Models\Expense;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $userId = Auth::id();

        $month = (int) $request->input('month', Carbon::now()->month);
        $year = (int) $request->input('year', Carbon::now()->year);

        $totalAllIncome = Income::where('user_id', $userId)->sum('jumlah');
        $totalAllExpense = Expense::where('user_id', $userId)->sum('jumlah');
        $balance = $totalAllIncome - $totalAllExpense;

        $totalIncome = Income::where('user_id', $userId)
            ->whereMonth('tanggal', $month)
            ->whereYear('tanggal', $year)
            ->sum('jumlah');

        $totalExpense = Expense::where('user_id', $userId)
            ->whereMonth('tanggal', $month)
            ->whereYear('tanggal', $year)
            ->sum('jumlah');


        return view('reports.reports-index', [
            'totalIncome'  => $totalIncome,
            'totalExpense' => $totalExpense,
            'balance'      => $balance, 
            'month'        => $month,
            'year'         => $year     
        ]);
    }
}