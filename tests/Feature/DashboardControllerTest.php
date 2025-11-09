<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Income;
use App\Models\Expense;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Carbon\Carbon;

class DashboardControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_dashboard()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $now = Carbon::now();

        Income::factory()->create([
            'user_id' => $user->id,
            'tanggal' => $now,
            'jumlah' => 100000,
            'kategori' => 'gaji',
        ]);

        Expense::factory()->create([
            'user_id' => $user->id,
            'tanggal' => $now,
            'jumlah' => 50000,
            'kategori' => 'makan',
        ]);

        $response = $this->get(route('dashboard', [
            'month' => $now->month,
            'year' => $now->year,
        ]));

        $response->assertStatus(200);
        $response->assertViewHas('balance', 50000);
        $response->assertViewHas('totalIncome', 100000);
        $response->assertViewHas('totalExpense', 50000);
        $response->assertViewHas('chartData');
    }
}
