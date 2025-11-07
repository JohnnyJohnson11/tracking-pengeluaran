<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Income;
use App\Models\Expense;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $userId = Auth::id();

        $month = $request->input('month', Carbon::now()->month);
        $year = $request->input('year', Carbon::now()->year);

        $totalIncome = Income::where('user_id', $userId)
            ->whereMonth('tanggal', $month)
            ->whereYear('tanggal', $year)
            ->sum('jumlah');

        $totalExpense = Expense::where('user_id', $userId)
            ->whereMonth('date', $month)
            ->whereYear('date', $year)
            ->sum('amount');

        $totalAllIncome = Income::where('user_id', $userId)->sum('jumlah');
        $totalAllExpense = Expense::where('user_id', $userId)->sum('amount');
        $balance = $totalAllIncome - $totalAllExpense;

        $chartData = [];
        $currentDate = Carbon::create($year, $month, 1);

        for ($i = 5; $i >= 0; $i--) {
            $date = $currentDate->clone()->subMonths($i);
            $chartMonth = $date->month;
            $chartYear = $date->year;

            $income = Income::where('user_id', $userId)
                ->whereMonth('tanggal', $chartMonth)
                ->whereYear('tanggal', $chartYear)
                ->sum('jumlah');

            $expense = Expense::where('user_id', $userId)
                ->whereMonth('date', $chartMonth)
                ->whereYear('date', $chartYear)
                ->sum('amount');

            $chartData[] = [
                'month' => $date->format('M Y'),
                'income' => $income,
                'expense' => $expense,
            ];
        }

        return view('dashboard', compact(
            'balance',
            'totalIncome',
            'totalExpense',
            'chartData',
            'month',
            'year'
        ));
    }
}
