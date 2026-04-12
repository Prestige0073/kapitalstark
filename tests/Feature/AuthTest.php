<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_register(): void
    {
        $response = $this->post('/espace-client/register', [
            'name'                  => 'Jean Dupont',
            'email'                 => 'jean@example.com',
            'password'              => 'motdepasse8',
            'password_confirmation' => 'motdepasse8',
            'terms'                 => '1',
        ]);

        $response->assertRedirect(route('dashboard.index'));
        $this->assertDatabaseHas('users', ['email' => 'jean@example.com']);
    }

    public function test_registration_fails_with_duplicate_email(): void
    {
        User::factory()->create(['email' => 'jean@example.com']);

        $response = $this->post('/espace-client/register', [
            'name'                  => 'Jean Dupont',
            'email'                 => 'jean@example.com',
            'password'              => 'motdepasse8',
            'password_confirmation' => 'motdepasse8',
        ]);

        $response->assertSessionHasErrors('email');
    }

    public function test_registration_requires_password_confirmation(): void
    {
        $response = $this->post('/espace-client/register', [
            'name'                  => 'Jean Dupont',
            'email'                 => 'jean@example.com',
            'password'              => 'motdepasse8',
            'password_confirmation' => 'different',
        ]);

        $response->assertSessionHasErrors('password');
    }

    public function test_user_can_login(): void
    {
        $user = User::factory()->create([
            'email'    => 'client@example.com',
            'password' => Hash::make('motdepasse8'),
        ]);

        $response = $this->post('/espace-client', [
            'email'    => 'client@example.com',
            'password' => 'motdepasse8',
        ]);

        $response->assertRedirect(route('dashboard.index'));
        $this->assertAuthenticatedAs($user);
    }

    public function test_login_fails_with_wrong_password(): void
    {
        User::factory()->create([
            'email'    => 'client@example.com',
            'password' => Hash::make('motdepasse8'),
        ]);

        $response = $this->post('/espace-client', [
            'email'    => 'client@example.com',
            'password' => 'mauvais',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_user_can_logout(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/logout');

        $response->assertRedirect('/');
        $this->assertGuest();
    }

    public function test_forgot_password_sends_reset_link(): void
    {
        User::factory()->create(['email' => 'client@example.com']);

        $response = $this->post('/espace-client/mot-de-passe', [
            'email' => 'client@example.com',
        ]);

        $response->assertSessionHas('status');
    }

    public function test_forgot_password_returns_error_for_unknown_email(): void
    {
        $response = $this->post('/espace-client/mot-de-passe', [
            'email' => 'inconnu@example.com',
        ]);

        $response->assertSessionHasErrors('email');
    }

    public function test_guest_is_redirected_from_dashboard(): void
    {
        $this->get('/dashboard')->assertRedirect('/espace-client');
    }
}
