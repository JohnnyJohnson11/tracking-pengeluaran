<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Income;
use App\Models\Expense;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Carbon\Carbon;

class ReportControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_access_report_page_and_see_correct_balance()
    {
        // 1️⃣ Buat user dan login
        $user = User::factory()->create();
        $this->actingAs($user);

        // 2️⃣ Tambahkan data income dan expense
        $currentMonth = Carbon::now()->month;
        $currentYear  = Carbon::now()->year;

        Income::factory()->create([
            'user_id' => $user->id,
            'jumlah'  => 500000,
            'tanggal' => Carbon::create($currentYear, $currentMonth, 5),
        ]);

        Expense::factory()->create([
            'user_id' => $user->id,
            'jumlah'  => 200000,
            'tanggal' => Carbon::create($currentYear, $currentMonth, 8),
        ]);

        // 3️⃣ Panggil route ke halaman report
        $response = $this->get(route('reports.index', [
            'month' => $currentMonth,
            'year'  => $currentYear,
        ]));

        // 4️⃣ Pastikan halaman tampil sukses
        $response->assertStatus(200);

        // 5️⃣ Pastikan data view sesuai
        $response->assertViewHasAll([
            'totalIncome'  => 500000,
            'totalExpense' => 200000,
            'balance'      => 300000,
            'month'        => $currentMonth,
            'year'         => $currentYear,
        ]);
    }
}
