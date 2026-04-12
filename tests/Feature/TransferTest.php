<?php

namespace Tests\Feature;

use App\Models\Transfer;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class TransferTest extends TestCase
{
    use RefreshDatabase;

    private function user(): User
    {
        return User::factory()->create(['is_admin' => false, 'balance' => 10000]);
    }

    private function makeTransfer(User $user, array $overrides = []): Transfer
    {
        return Transfer::create(array_merge([
            'user_id'        => $user->id,
            'amount'         => 500.00,
            'recipient_name' => 'Jean Dupont',
            'recipient_iban' => 'FR7630006000011234567890189',
            'recipient_bic'  => null,
            'label'          => 'Loyer octobre',
            'status'         => 'pending',
            'progress'       => 0,
        ], $overrides));
    }

    // ── Pages ────────────────────────────────────────────────────

    public function test_transfers_index_loads(): void
    {
        $user = $this->user();
        $this->actingAs($user)->get('/dashboard/virements')->assertStatus(200);
    }

    public function test_transfer_create_page_loads(): void
    {
        $user = $this->user();
        $this->actingAs($user)->get('/dashboard/virements/nouveau')->assertStatus(200);
    }

    public function test_guest_cannot_access_transfers(): void
    {
        $this->get('/dashboard/virements')->assertRedirect('/espace-client');
        $this->get('/dashboard/virements/nouveau')->assertRedirect('/espace-client');
    }

    // ── Soumission ───────────────────────────────────────────────

    public function test_transfer_store_creates_record(): void
    {
        $user = $this->user();

        $response = $this->actingAs($user)->post('/dashboard/virements', [
            'amount'         => 1200,
            'recipient_name' => 'Marie Martin',
            'recipient_iban' => 'FR7630006000011234567890189',
            'label'          => 'Remboursement',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('transfers', [
            'user_id'        => $user->id,
            'recipient_name' => 'Marie Martin',
            'status'         => 'pending',
        ]);
    }

    public function test_transfer_store_validates_required_fields(): void
    {
        $user = $this->user();

        $response = $this->actingAs($user)->post('/dashboard/virements', []);

        $response->assertSessionHasErrors(['amount', 'recipient_name', 'recipient_iban']);
    }

    public function test_transfer_store_rejects_invalid_iban(): void
    {
        $user = $this->user();

        $response = $this->actingAs($user)->post('/dashboard/virements', [
            'amount'         => 500,
            'recipient_name' => 'Test',
            'recipient_iban' => 'INVALID',
        ]);

        $response->assertSessionHasErrors(['recipient_iban']);
    }

    public function test_transfer_store_rejects_amount_exceeding_max(): void
    {
        $user = $this->user();

        $response = $this->actingAs($user)->post('/dashboard/virements', [
            'amount'         => 200000,
            'recipient_name' => 'Test',
            'recipient_iban' => 'FR7630006000011234567890189',
        ]);

        $response->assertSessionHasErrors(['amount']);
    }

    // ── Détail / suivi ────────────────────────────────────────────

    public function test_transfer_show_loads(): void
    {
        $user     = $this->user();
        $transfer = $this->makeTransfer($user);

        $this->actingAs($user)
             ->get("/dashboard/virements/{$transfer->id}")
             ->assertStatus(200);
    }

    public function test_user_cannot_see_another_users_transfer(): void
    {
        $owner = $this->user();
        $other = $this->user();
        $transfer = $this->makeTransfer($owner);

        $this->actingAs($other)
             ->get("/dashboard/virements/{$transfer->id}")
             ->assertStatus(403);
    }

    // ── API status (polling) ──────────────────────────────────────

    public function test_transfer_status_returns_json(): void
    {
        $user     = $this->user();
        $transfer = $this->makeTransfer($user, ['status' => 'processing', 'progress' => 45]);

        $response = $this->actingAs($user)
             ->getJson("/dashboard/virements/{$transfer->id}/status");

        $response->assertStatus(200)
                 ->assertJsonStructure(['status', 'progress'])
                 ->assertJson(['status' => 'processing', 'progress' => 45]);
    }

    public function test_transfer_status_forbidden_for_other_user(): void
    {
        $owner = $this->user();
        $other = $this->user();
        $transfer = $this->makeTransfer($owner);

        $this->actingAs($other)
             ->getJson("/dashboard/virements/{$transfer->id}/status")
             ->assertStatus(403);
    }

    // ── Reçu PDF ─────────────────────────────────────────────────

    public function test_transfer_receipt_returns_404_when_not_completed(): void
    {
        $user     = $this->user();
        $transfer = $this->makeTransfer($user, ['status' => 'pending']);

        $this->actingAs($user)
             ->get("/dashboard/virements/{$transfer->id}/recu")
             ->assertStatus(404);
    }

    public function test_transfer_receipt_forbidden_for_other_user(): void
    {
        $owner = $this->user();
        $other = $this->user();
        $transfer = $this->makeTransfer($owner, [
            'status'             => 'completed',
            'completion_message' => 'Terminé',
            'completed_at'       => now(),
        ]);

        $this->actingAs($other)
             ->get("/dashboard/virements/{$transfer->id}/recu")
             ->assertStatus(403);
    }

    // ── Execute (approved → processing) ─────────────────────────

    public function test_execute_changes_status_to_processing(): void
    {
        $user     = $this->user();
        $transfer = $this->makeTransfer($user, ['status' => 'approved']);

        $this->actingAs($user)
             ->post("/dashboard/virements/{$transfer->id}/executer")
             ->assertRedirect("/dashboard/virements/{$transfer->id}");

        $this->assertDatabaseHas('transfers', [
            'id'     => $transfer->id,
            'status' => 'processing',
        ]);
    }

    public function test_execute_rejected_when_status_is_not_approved(): void
    {
        $user     = $this->user();
        $transfer = $this->makeTransfer($user, ['status' => 'pending']);

        $this->actingAs($user)
             ->post("/dashboard/virements/{$transfer->id}/executer")
             ->assertRedirect();

        // Le statut ne doit pas changer
        $this->assertDatabaseHas('transfers', [
            'id'     => $transfer->id,
            'status' => 'pending',
        ]);
    }

    // ── Show page — aucun entity HTML dans <script> ───────────────

    /**
     * Vérifie que le bloc <script> de la page de suivi ne contient pas
     * de &quot; ni &amp; — symptôme du double-escaping {{ json_encode() }}
     * qui causait "Uncaught SyntaxError: Unexpected token '&'".
     */
    public function test_show_processing_page_has_no_html_entities_in_script(): void
    {
        $user     = $this->user();
        $transfer = $this->makeTransfer($user, [
            'status'           => 'processing',
            'progress'         => 20,
            'started_at'       => now(),
            'base_progress'    => 0,
            'duration_seconds' => 300,
        ]);

        $html = $this->actingAs($user)
                     ->get("/dashboard/virements/{$transfer->id}")
                     ->assertStatus(200)
                     ->getContent();

        // Extraire uniquement le contenu des balises <script>
        preg_match_all('/<script\b[^>]*>(.*?)<\/script>/si', $html, $matches);
        $scriptContent = implode("\n", $matches[1]);

        $this->assertStringNotContainsString(
            '&quot;',
            $scriptContent,
            'Le script contient &quot; — json_encode() doit être appelé avec {!! !!}, pas {{ }}'
        );
        $this->assertStringNotContainsString(
            '&amp;',
            $scriptContent,
            'Le script contient &amp; — signe de double-escaping Blade dans <script>'
        );
    }

    public function test_show_approved_page_loads_without_error(): void
    {
        $user     = $this->user();
        $transfer = $this->makeTransfer($user, ['status' => 'approved']);

        $this->actingAs($user)
             ->get("/dashboard/virements/{$transfer->id}")
             ->assertStatus(200)
             ->assertSee(__('dashboard.transfers.launch_btn')); // locale-indépendant
    }

    // ── Modèle : activePausedLevel() ─────────────────────────────

    public function test_active_paused_level_returns_null_when_no_stop_levels(): void
    {
        $user     = $this->user();
        $transfer = $this->makeTransfer($user, ['stop_levels' => null]);

        $this->assertNull($transfer->activePausedLevel());
    }

    public function test_active_paused_level_returns_null_when_all_codes_used(): void
    {
        $user     = $this->user();
        $transfer = $this->makeTransfer($user, [
            'stop_levels' => [
                [
                    'percentage'   => 50,
                    'text'         => 'Palier 50%',
                    'reached_at'   => now()->toIso8601String(),
                    'unlock_code'  => 'ABC-1234',
                    'code_used_at' => now()->toIso8601String(),
                ],
            ],
        ]);

        $this->assertNull($transfer->activePausedLevel());
    }

    public function test_active_paused_level_returns_level_when_code_not_used(): void
    {
        $user     = $this->user();
        $transfer = $this->makeTransfer($user, [
            'status'      => 'paused',
            'progress'    => 50,
            'stop_levels' => [
                [
                    'percentage'   => 50,
                    'text'         => 'Vérification identité',
                    'reached_at'   => now()->toIso8601String(),
                    'unlock_code'  => 'XYZ-9999',
                    'code_used_at' => null,
                ],
            ],
        ]);

        $level = $transfer->activePausedLevel();

        $this->assertNotNull($level);
        $this->assertSame('XYZ-9999', $level['unlock_code']);
        $this->assertSame(50, $level['percentage']);
    }

    public function test_active_paused_level_returns_first_unresolved_when_multiple(): void
    {
        $user     = $this->user();
        $transfer = $this->makeTransfer($user, [
            'status'      => 'paused',
            'progress'    => 75,
            'stop_levels' => [
                [
                    'percentage'   => 50,
                    'text'         => 'Palier 50%',
                    'reached_at'   => now()->toIso8601String(),
                    'unlock_code'  => 'AAA-1111',
                    'code_used_at' => now()->toIso8601String(), // déjà utilisé
                ],
                [
                    'percentage'   => 75,
                    'text'         => 'Palier 75%',
                    'reached_at'   => now()->toIso8601String(),
                    'unlock_code'  => 'BBB-2222',
                    'code_used_at' => null, // actif
                ],
            ],
        ]);

        $level = $transfer->activePausedLevel();

        $this->assertNotNull($level);
        $this->assertSame('BBB-2222', $level['unlock_code']);
    }

    // ── Admin : page détail virement (activePausedLevel utilisé) ─

    public function test_admin_transfer_show_loads_for_paused_transfer(): void
    {
        $admin    = User::factory()->create(['is_admin' => true]);
        $user     = $this->user();
        $transfer = $this->makeTransfer($user, [
            'status'      => 'paused',
            'progress'    => 50,
            'stop_levels' => [
                [
                    'percentage'   => 50,
                    'text'         => 'Vérification',
                    'reached_at'   => now()->toIso8601String(),
                    'unlock_code'  => 'TST-0001',
                    'code_used_at' => null,
                ],
            ],
        ]);

        $this->actingAs($admin)
             ->get("/admin/virements/{$transfer->id}")
             ->assertStatus(200)
             ->assertSee('TST-0001');
    }

    // ── Chat fetch ────────────────────────────────────────────────

    public function test_send_message_returns_json_for_ajax_request(): void
    {
        $user = $this->user();

        $response = $this->actingAs($user)
             ->postJson('/dashboard/messagerie', [
                 'message' => 'Bonjour, question sur mon virement.',
                 'subject' => 'Virement',
             ]);

        $response->assertStatus(200)
                 ->assertJson(['success' => true])
                 ->assertJsonStructure(['success', 'message' => ['id', 'from', 'body', 'at', 'created_at']]);

        $this->assertDatabaseHas('messages', [
            'user_id'   => $user->id,
            'direction' => 'inbound',
            'body'      => 'Bonjour, question sur mon virement.',
        ]);
    }

    public function test_send_message_rejects_empty_body(): void
    {
        $user = $this->user();

        $this->actingAs($user)
             ->postJson('/dashboard/messagerie', ['message' => ''])
             ->assertStatus(422);
    }
}
