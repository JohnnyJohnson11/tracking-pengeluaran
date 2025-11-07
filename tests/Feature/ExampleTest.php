<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class ExampleTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    /** @test */
    public function it_rejects_invalid_income_data()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->post('/incomes', [
            'kategori' => '', // ❌ empty
            'jumlah' => -500, // ❌ invalid
            'tanggal' => 'not-a-date', // ❌ invalid
        ]);

        $response->assertSessionHasErrors(['kategori', 'jumlah', 'tanggal']);
    }

    /** @test */
    public function guest_cannot_create_income()
    {
        $response = $this->post('/incomes', [
            'kategori' => 'Bonus',
            'jumlah' => 1000,
            'tanggal' => '2025-11-06',
        ]);

        $response->assertRedirect('/login');
    }

    /** @test */
    public function it_stores_income_correctly_for_authenticated_user()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $data = [
            'kategori' => 'Gaji',
            'jumlah' => 2500000,
            'tanggal' => '2025-11-06',
            'keterangan' => 'November salary',
        ];

        $this->post('/incomes', $data);

        $this->assertDatabaseHas('incomes', [
            'user_id' => $user->id,
            'kategori' => 'Gaji',
            'jumlah' => 2500000,
        ]);
    }

}
