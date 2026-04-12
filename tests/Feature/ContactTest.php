<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContactTest extends TestCase
{
    use RefreshDatabase;

    public function test_contact_form_stores_request(): void
    {
        $response = $this->post('/contact', [
            'name'    => 'Marie Martin',
            'email'   => 'marie@example.com',
            'subject' => 'Renseignements prêt immobilier',
            'message' => 'Bonjour, je voudrais des informations sur vos prêts immobiliers.',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('contact_requests', [
            'email'   => 'marie@example.com',
            'subject' => 'Renseignements prêt immobilier',
        ]);
    }

    public function test_contact_form_requires_mandatory_fields(): void
    {
        $response = $this->post('/contact', []);

        $response->assertSessionHasErrors(['name', 'email', 'subject', 'message']);
    }

    public function test_contact_form_rejects_invalid_email(): void
    {
        $response = $this->post('/contact', [
            'name'    => 'Marie Martin',
            'email'   => 'not-an-email',
            'subject' => 'Test',
            'message' => 'Message de test.',
        ]);

        $response->assertSessionHasErrors('email');
    }

    public function test_public_appointment_form_stores_request(): void
    {
        $response = $this->post('/contact/rdv', [
            'first_name'   => 'Pierre',
            'last_name'    => 'Leblanc',
            'email'        => 'pierre@example.com',
            'phone'        => '0698765432',
            'project_type' => 'immobilier',
            'date'         => now()->addDays(5)->format('Y-m-d'),
            'time'         => '14:00',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('appointment_requests', [
            'email'        => 'pierre@example.com',
            'project_type' => 'immobilier',
        ]);
    }

    public function test_newsletter_subscription_stores_email(): void
    {
        $response = $this->postJson('/newsletter', [
            'email' => 'abonne@example.com',
        ]);

        $response->assertStatus(200)->assertJson(['status' => 'ok']);
        $this->assertDatabaseHas('newsletter_subscriptions', [
            'email' => 'abonne@example.com',
        ]);
    }

    public function test_newsletter_rejects_duplicate_subscription(): void
    {
        $this->postJson('/newsletter', ['email' => 'abonne@example.com']);
        $response = $this->postJson('/newsletter', ['email' => 'abonne@example.com']);

        $response->assertStatus(200);
        $this->assertEquals(
            1,
            \DB::table('newsletter_subscriptions')->where('email', 'abonne@example.com')->count()
        );
    }

    public function test_locale_switch_stores_in_session(): void
    {
        $response = $this->get('/langue/en');

        $response->assertRedirect();
        $response->assertSessionHas('locale', 'en');
    }

    public function test_locale_switch_rejects_invalid_locale(): void
    {
        $response = $this->get('/langue/xx');

        $response->assertStatus(302);
        $this->assertNotEquals('xx', session('locale'));
    }
}
