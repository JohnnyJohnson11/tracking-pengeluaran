<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Income;
use App\Models\Expense;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ReportControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_calculates_correct_total_income_expense_and_balance()
    {
        // Arrange: buat user dummy
        $user = User::factory()->create();

        // Buat beberapa data income dan expense untuk user tersebut
        Income::factory()->create([
            'user_id' => $user->id,
            'jumlah'  => 100000,
            'tanggal' => now(),
        ]);

        Income::factory()->create([
            'user_id' => $user->id,
            'jumlah'  => 50000,
            'tanggal' => now(),
        ]);

        Expense::factory()->create([
            'user_id' => $user->id,
            'jumlah'  => 30000,
            'tanggal' => now(),
        ]);

        Expense::factory()->create([
            'user_id' => $user->id,
            'jumlah'  => 20000,
            'tanggal' => now(),
        ]);

        // Act: login user dan akses halaman laporan
        $this->actingAs($user);
        $response = $this->get('/reports'); // pastikan route ini mengarah ke ReportController@index

        // Assert: pastikan view dan datanya benar
        $response->assertStatus(200);
        $response->assertViewHas('totalIncome', 150000);
        $response->assertViewHas('totalExpense', 50000);
        $response->assertViewHas('balance', 100000);
    }
}
