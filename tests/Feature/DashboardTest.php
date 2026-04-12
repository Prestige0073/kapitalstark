<?php

namespace Tests\Feature;

use App\Models\Message;
use App\Models\PushSubscription;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_dashboard_loads_for_authenticated_user(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->get('/dashboard')->assertStatus(200);
    }

    public function test_dashboard_loans_page_loads(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->get('/dashboard/prets')->assertStatus(200);
    }

    public function test_dashboard_requests_page_loads(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->get('/dashboard/demandes')->assertStatus(200);
    }

    public function test_dashboard_new_request_page_loads(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->get('/dashboard/demandes/nouvelle')->assertStatus(200);
    }

    public function test_dashboard_messages_page_loads(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->get('/dashboard/messagerie')->assertStatus(200);
    }

    public function test_dashboard_appointments_page_loads(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->get('/dashboard/calendrier')->assertStatus(200);
    }

    public function test_dashboard_documents_page_loads(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->get('/dashboard/documents')->assertStatus(200);
    }

    public function test_dashboard_profile_page_loads(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->get('/dashboard/profil')->assertStatus(200);
    }

    public function test_profile_update_saves_name_and_phone(): void
    {
        $user = User::factory()->create(['name' => 'Ancien Nom']);

        $this->actingAs($user)->put('/dashboard/profil', [
            'name'  => 'Nouveau Nom',
            'email' => $user->email,
            'phone' => '+33 6 12 34 56 78',
        ]);

        $this->assertDatabaseHas('users', [
            'id'    => $user->id,
            'name'  => 'Nouveau Nom',
            'phone' => '+33 6 12 34 56 78',
        ]);
    }

    public function test_loan_request_submission_stores_record(): void
    {
        Mail::fake();

        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/dashboard/demandes/nouvelle', [
            'loan_type'  => 'immobilier',
            'amount'     => 150000,
            'duration'   => 240,
            'purpose'    => 'Achat résidence principale',
            'income'     => 3500,
            'charges'    => 500,
            'employment' => 'cdi',
            'consent'    => '1',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('loan_requests', [
            'user_id'   => $user->id,
            'loan_type' => 'immobilier',
            'amount'    => 150000,
        ]);
    }

    public function test_loan_request_requires_mandatory_fields(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/dashboard/demandes/nouvelle', []);

        $response->assertSessionHasErrors(['loan_type', 'amount', 'duration']);
    }

    public function test_message_submission_stores_record(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->post('/dashboard/messagerie', [
            'subject' => 'Question sur mon prêt',
            'message' => 'Bonjour, je voudrais savoir...',
        ]);

        $this->assertDatabaseHas('messages', [
            'user_id'   => $user->id,
            'direction' => 'inbound',
            'body'      => 'Bonjour, je voudrais savoir...',
        ]);
    }

    public function test_appointment_submission_stores_record(): void
    {
        Mail::fake();

        $user = User::factory()->create();

        $this->actingAs($user)->post('/dashboard/calendrier', [
            'date'    => now()->addDays(7)->format('Y-m-d'),
            'time'    => '10:00',
            'channel' => 'visio',
            'subject' => 'Suivi de dossier',
        ]);

        $this->assertDatabaseHas('appointments', [
            'user_id' => $user->id,
            'channel' => 'visio',
            'subject' => 'Suivi de dossier',
        ]);
    }

    public function test_guest_cannot_access_any_dashboard_route(): void
    {
        $routes = [
            '/dashboard',
            '/dashboard/prets',
            '/dashboard/demandes',
            '/dashboard/messagerie',
            '/dashboard/calendrier',
            '/dashboard/documents',
            '/dashboard/profil',
        ];

        foreach ($routes as $route) {
            $this->get($route)->assertRedirect('/espace-client');
        }
    }

    // ── Push subscriptions (#9) ───────────────────────────────────

    public function test_user_can_save_push_subscription(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->postJson('/dashboard/push/subscribe', [
            'endpoint' => 'https://fcm.googleapis.com/fcm/send/test123',
            'p256dh'   => base64_encode(random_bytes(65)),
            'auth'     => base64_encode(random_bytes(16)),
        ]);

        $response->assertStatus(200)->assertJson(['ok' => true]);

        $this->assertDatabaseHas('push_subscriptions', [
            'user_id'  => $user->id,
            'endpoint' => 'https://fcm.googleapis.com/fcm/send/test123',
        ]);
    }

    public function test_save_push_subscription_is_idempotent(): void
    {
        $user     = User::factory()->create();
        $endpoint = 'https://fcm.googleapis.com/fcm/send/dup';
        $p256dh   = base64_encode(random_bytes(65));
        $auth     = base64_encode(random_bytes(16));

        // Envoyer deux fois le même endpoint
        $this->actingAs($user)->postJson('/dashboard/push/subscribe', [
            'endpoint' => $endpoint, 'p256dh' => $p256dh, 'auth' => $auth,
        ])->assertStatus(200);

        $this->actingAs($user)->postJson('/dashboard/push/subscribe', [
            'endpoint' => $endpoint, 'p256dh' => $p256dh, 'auth' => $auth,
        ])->assertStatus(200);

        // Un seul enregistrement doit exister
        $this->assertSame(1, PushSubscription::where('user_id', $user->id)->count());
    }

    public function test_user_can_remove_push_subscription(): void
    {
        $user = User::factory()->create();

        PushSubscription::create([
            'user_id'  => $user->id,
            'endpoint' => 'https://fcm.googleapis.com/fcm/send/todelete',
            'p256dh'   => str_repeat('a', 87),
            'auth'     => str_repeat('b', 24),
        ]);

        $response = $this->actingAs($user)->postJson('/dashboard/push/unsubscribe', [
            'endpoint' => 'https://fcm.googleapis.com/fcm/send/todelete',
        ]);

        $response->assertStatus(200)->assertJson(['ok' => true]);

        $this->assertDatabaseMissing('push_subscriptions', [
            'user_id'  => $user->id,
            'endpoint' => 'https://fcm.googleapis.com/fcm/send/todelete',
        ]);
    }

    public function test_unsubscribe_requires_endpoint(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->postJson('/dashboard/push/unsubscribe', [])
             ->assertStatus(422)
             ->assertJsonValidationErrors(['endpoint']);
    }

    public function test_user_cannot_remove_another_users_subscription(): void
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        PushSubscription::create([
            'user_id'  => $user1->id,
            'endpoint' => 'https://fcm.googleapis.com/fcm/send/u1',
            'p256dh'   => str_repeat('a', 87),
            'auth'     => str_repeat('b', 24),
        ]);

        // user2 tente de supprimer l'abonnement de user1
        $this->actingAs($user2)->postJson('/dashboard/push/unsubscribe', [
            'endpoint' => 'https://fcm.googleapis.com/fcm/send/u1',
        ])->assertStatus(200); // répond ok mais ne supprime rien

        $this->assertDatabaseHas('push_subscriptions', [
            'user_id'  => $user1->id,
            'endpoint' => 'https://fcm.googleapis.com/fcm/send/u1',
        ]);
    }

    // ── pollNotifications (#10) ───────────────────────────────────

    public function test_poll_notifications_returns_json(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->getJson('/dashboard/notifs/poll');

        $response->assertStatus(200)
                 ->assertJsonStructure(['unread', 'items']);
    }

    public function test_poll_notifications_counts_unread_outbound_messages(): void
    {
        $user  = User::factory()->create();
        $admin = User::factory()->create(['is_admin' => true]);

        // 2 messages non lus de l'admin vers le client
        Message::create(['user_id' => $user->id, 'direction' => 'outbound', 'body' => 'Msg 1', 'read' => false]);
        Message::create(['user_id' => $user->id, 'direction' => 'outbound', 'body' => 'Msg 2', 'read' => false]);
        // 1 message lu (ne doit pas compter)
        Message::create(['user_id' => $user->id, 'direction' => 'outbound', 'body' => 'Msg lu', 'read' => true]);
        // 1 message inbound (ne doit pas compter)
        Message::create(['user_id' => $user->id, 'direction' => 'inbound', 'body' => 'User msg', 'read' => false]);

        $response = $this->actingAs($user)->getJson('/dashboard/notifs/poll');

        $response->assertStatus(200)
                 ->assertJsonPath('unread', 2);
    }

    public function test_poll_notifications_returns_empty_for_no_unread(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->getJson('/dashboard/notifs/poll');

        $response->assertStatus(200)
                 ->assertJsonPath('unread', 0)
                 ->assertJsonPath('items', []);
    }

    public function test_guest_cannot_access_poll_notifications(): void
    {
        $this->get('/dashboard/notifs/poll')->assertRedirect('/espace-client');
    }
}
