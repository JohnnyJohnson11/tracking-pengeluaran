<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Income;
use App\Models\Expense;
use Carbon\Carbon;

class TransactionTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_cannot_see_other_users_transactions(): void
    {
        $userA = User::factory()->create();
        $userB = User::factory()->create();

        Expense::factory()->create([
            'user_id' => $userB->id,
            'kategori' => 'Belanja Rahasia User B',
            'jumlah' => 10000,
            'tanggal' => Carbon::now(),
        ]);

        $response = $this->actingAs($userA)->get(route('transactions.index'));
        $response->assertStatus(200);
        $response->assertDontSee('Belanja Rahasia User B');
    }

    public function test_user_cannot_update_other_users_transaction(): void
    {
        $userA = User::factory()->create();
        $userB = User::factory()->create();

        $expenseB = Expense::factory()->create([
            'user_id' => $userB->id,
            'kategori' => 'Kategori Lama',
            'jumlah' => 50000,
            'tanggal' => Carbon::now(),
        ]);

        $response = $this->actingAs($userA)->put(route('expenses.update', $expenseB->id), [
            'kategori' => 'Kategori Baru',
            'jumlah' => 12345,
            'tanggal' => now()->format('Y-m-d'),
        ]);

        $response->assertStatus(403); 
    }

    public function test_user_cannot_delete_other_users_transaction(): void
    {
        $userA = User::factory()->create();
        $userB = User::factory()->create();

        $incomeB = Income::factory()->create([
            'user_id' => $userB->id,
            'kategori' => 'Gaji Rahasia',
            'jumlah' => 900000,
            'tanggal' => Carbon::now(),
        ]);

        $response = $this->actingAs($userA)->delete(route('incomes.destroy', $incomeB->id));

        $response->assertStatus(403);
        $this->assertDatabaseHas('incomes', ['id' => $incomeB->id]);
    }
}