<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Foundation\Testing\RefreshDatabase;

class Profiletest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_displays_profile_page()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get('/profile')
            ->assertStatus(200)
            ->assertViewIs('profile')
            ->assertViewHas('user', $user);
    }

    /** @test */
    public function it_updates_user_profile()
    {
        $user = User::factory()->create([
            'name' => 'Old Name',
            'email' => 'old@example.com',
        ]);

        $this->actingAs($user)
            ->post('/profile/update', [
                'name' => 'New Name',
                'email' => 'new@example.com',
            ])
            ->assertRedirect()
            ->assertSessionHas('success', 'Profil berhasil diperbarui!');

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'New Name',
            'email' => 'new@example.com',
        ]);
    }

    /** @test */
    public function it_rejects_wrong_current_password_when_updating_password()
    {
        $user = User::factory()->create([
            'password' => Hash::make('correct-password'),
        ]);

        $this->actingAs($user)
            ->post('/profile/update-password', [
                'current_password' => 'wrong-password',
                'new_password' => 'newpassword123',
                'new_password_confirmation' => 'newpassword123',
            ])
            ->assertSessionHasErrors('current_password');
    }

    /** @test */
    public function it_updates_password_with_correct_current_password()
    {
        $user = User::factory()->create([
            'password' => Hash::make('oldpassword'),
        ]);

        $this->actingAs($user)
            ->post('/profile/update-password', [
                'current_password' => 'oldpassword',
                'new_password' => 'newpassword123',
                'new_password_confirmation' => 'newpassword123',
            ])
            ->assertRedirect()
            ->assertSessionHas('success', 'Password berhasil diperbarui!');

        $this->assertTrue(Hash::check('newpassword123', $user->fresh()->password));
    }

    /** @test */
    public function it_exports_csv_successfully()
    {
        $user = User::factory()->create();

        // Mock relasi transactions
        $user->setRelation('transactions', collect([
            (object)[ 'date' => '2025-11-09', 'category' => 'Food', 'amount' => 10000, 'type' => 'expense' ],
            (object)[ 'date' => '2025-11-08', 'category' => 'Salary', 'amount' => 2000000, 'type' => 'income' ],
        ]));

        $this->actingAs($user);
        $response = $this->get('/profile/export-csv');

        $response->assertStatus(200);
        $response->assertHeader('content-disposition', 'attachment; filename=data_' . $user->name . '.csv');
    }

    /** @test */
    public function it_exports_pdf_successfully()
    {
        $user = User::factory()->create();

        Pdf::shouldReceive('loadView')
            ->once()
            ->with('profile.profile_pdf', ['user' => $user])
            ->andReturnSelf();

        Pdf::shouldReceive('download')
            ->once()
            ->with('profil_pengguna.pdf')
            ->andReturn(response('PDF content', 200));

        $this->actingAs($user);
        $response = $this->get('/profile/export-pdf');

        $response->assertStatus(200);
    }
}
