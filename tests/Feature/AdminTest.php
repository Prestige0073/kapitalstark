<?php

namespace Tests\Feature;

use App\Models\AdminTemplateDocument;
use App\Models\Loan;
use App\Models\LoanRequest;
use App\Models\Message;
use App\Models\Transfer;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminTest extends TestCase
{
    use RefreshDatabase;

    private function adminUser(): User
    {
        return User::factory()->create(['is_admin' => true]);
    }

    private function regularUser(): User
    {
        return User::factory()->create(['is_admin' => false]);
    }

    public function test_admin_dashboard_loads_for_admin(): void
    {
        $this->actingAs($this->adminUser())->get('/admin')->assertStatus(200);
    }

    public function test_admin_requests_page_loads(): void
    {
        $this->actingAs($this->adminUser())->get('/admin/demandes')->assertStatus(200);
    }

    public function test_admin_loans_page_loads(): void
    {
        $this->actingAs($this->adminUser())->get('/admin/prets')->assertStatus(200);
    }

    public function test_admin_messages_page_loads(): void
    {
        $this->actingAs($this->adminUser())->get('/admin/messagerie')->assertStatus(200);
    }

    public function test_admin_appointments_page_loads(): void
    {
        $this->actingAs($this->adminUser())->get('/admin/rendez-vous')->assertStatus(200);
    }

    public function test_admin_users_page_loads(): void
    {
        $this->actingAs($this->adminUser())->get('/admin/utilisateurs')->assertStatus(200);
    }

    public function test_admin_contacts_page_loads(): void
    {
        $this->actingAs($this->adminUser())->get('/admin/contacts')->assertStatus(200);
    }

    public function test_regular_user_is_redirected_from_admin_routes(): void
    {
        $user = $this->regularUser();

        $routes = [
            '/admin',
            '/admin/demandes',
            '/admin/prets',
            '/admin/messagerie',
            '/admin/rendez-vous',
            '/admin/utilisateurs',
            '/admin/contacts',
        ];

        foreach ($routes as $route) {
            $this->actingAs($user)->get($route)->assertRedirect('/dashboard');
        }
    }

    public function test_guest_is_redirected_from_admin(): void
    {
        $this->get('/admin')->assertRedirect('/gestion-interne/connexion');
    }

    public function test_admin_can_view_user_detail(): void
    {
        $admin  = $this->adminUser();
        $client = $this->regularUser();

        $this->actingAs($admin)
             ->get("/admin/utilisateurs/{$client->id}")
             ->assertStatus(200);
    }

    // ── Suppressions ─────────────────────────────────────────────

    public function test_admin_can_delete_regular_user(): void
    {
        $admin  = $this->adminUser();
        $client = $this->regularUser();

        $this->actingAs($admin)
             ->delete("/admin/utilisateurs/{$client->id}")
             ->assertRedirect('/admin/utilisateurs');

        $this->assertDatabaseMissing('users', ['id' => $client->id]);
    }

    public function test_admin_cannot_delete_another_admin(): void
    {
        $admin1 = $this->adminUser();
        $admin2 = $this->adminUser();

        $this->actingAs($admin1)
             ->delete("/admin/utilisateurs/{$admin2->id}")
             ->assertStatus(403);

        $this->assertDatabaseHas('users', ['id' => $admin2->id]);
    }

    public function test_admin_can_delete_loan_request(): void
    {
        $admin  = $this->adminUser();
        $client = $this->regularUser();

        $lr = LoanRequest::create([
            'user_id'        => $client->id,
            'loan_type'      => 'personnel',
            'amount'         => 5000,
            'duration_months'=> 24,
            'purpose'        => 'Test',
            'income'         => 2000,
            'charges'        => 300,
            'employment'     => 'cdi',
            'status'         => 'pending',
        ]);

        $this->actingAs($admin)
             ->delete("/admin/demandes/{$lr->id}")
             ->assertRedirect();

        $this->assertDatabaseMissing('loan_requests', ['id' => $lr->id]);
    }

    public function test_admin_can_delete_loan(): void
    {
        $admin  = $this->adminUser();
        $client = $this->regularUser();

        $loan = Loan::create([
            'user_id'    => $client->id,
            'type'       => 'personnel',
            'amount'     => 5000,
            'remaining'  => 5000,
            'monthly'    => 220,
            'rate'       => 5.9,
            'start_date' => now()->toDateString(),
            'end_date'   => now()->addYears(2)->toDateString(),
            'progress'   => 0,
            'status'     => 'active',
        ]);

        $this->actingAs($admin)
             ->delete("/admin/prets/{$loan->id}")
             ->assertRedirect();

        $this->assertDatabaseMissing('loans', ['id' => $loan->id]);
    }

    public function test_admin_can_delete_message(): void
    {
        $admin  = $this->adminUser();
        $client = $this->regularUser();

        $msg = Message::create([
            'user_id'   => $client->id,
            'direction' => 'inbound',
            'body'      => 'Message de test',
        ]);

        $this->actingAs($admin)
             ->delete("/admin/messages/{$msg->id}")
             ->assertRedirect();

        $this->assertDatabaseMissing('messages', ['id' => $msg->id]);
    }

    // ── Virements admin ──────────────────────────────────────────

    public function test_admin_transfers_page_loads(): void
    {
        $this->actingAs($this->adminUser())
             ->get('/admin/virements')
             ->assertStatus(200);
    }

    public function test_admin_can_view_transfer_detail(): void
    {
        $admin  = $this->adminUser();
        $client = $this->regularUser();

        $transfer = Transfer::create([
            'user_id'        => $client->id,
            'amount'         => 800,
            'recipient_name' => 'Test Bénéficiaire',
            'recipient_iban' => 'FR7630006000011234567890189',
            'status'         => 'pending',
            'progress'       => 0,
        ]);

        $this->actingAs($admin)
             ->get("/admin/virements/{$transfer->id}")
             ->assertStatus(200);
    }

    public function test_admin_can_validate_transfer(): void
    {
        Queue::fake();

        $admin  = $this->adminUser();
        $client = $this->regularUser();

        $transfer = Transfer::create([
            'user_id'        => $client->id,
            'amount'         => 800,
            'recipient_name' => 'Test',
            'recipient_iban' => 'FR7630006000011234567890189',
            'status'         => 'pending',
            'progress'       => 0,
        ]);

        $this->actingAs($admin)
             ->post("/admin/virements/{$transfer->id}/valider", [
                 'completion_message' => 'Virement exécuté avec succès.',
                 'stop_levels'        => [],
             ])
             ->assertRedirect();

        $this->assertDatabaseHas('transfers', [
            'id'     => $transfer->id,
            'status' => 'approved',
        ]);
    }

    public function test_admin_validate_transfer_requires_completion_message(): void
    {
        $admin  = $this->adminUser();
        $client = $this->regularUser();

        $transfer = Transfer::create([
            'user_id'        => $client->id,
            'amount'         => 800,
            'recipient_name' => 'Test',
            'recipient_iban' => 'FR7630006000011234567890189',
            'status'         => 'pending',
            'progress'       => 0,
        ]);

        $this->actingAs($admin)
             ->post("/admin/virements/{$transfer->id}/valider", [])
             ->assertSessionHasErrors(['completion_message']);
    }

    public function test_admin_can_reject_transfer(): void
    {
        $admin  = $this->adminUser();
        $client = $this->regularUser();

        $transfer = Transfer::create([
            'user_id'        => $client->id,
            'amount'         => 800,
            'recipient_name' => 'Test',
            'recipient_iban' => 'FR7630006000011234567890189',
            'status'         => 'pending',
            'progress'       => 0,
        ]);

        $this->actingAs($admin)
             ->post("/admin/virements/{$transfer->id}/rejeter", [
                 'reason' => 'Informations insuffisantes.',
             ])
             ->assertRedirect();

        $this->assertDatabaseHas('transfers', [
            'id'     => $transfer->id,
            'status' => 'rejected',
        ]);
    }

    // ── Bibliothèque de documents ─────────────────────────────────

    public function test_admin_documents_page_loads(): void
    {
        $this->actingAs($this->adminUser())
             ->get('/admin/bibliotheque')
             ->assertStatus(200);
    }

    public function test_admin_can_upload_template_document(): void
    {
        Storage::fake('local');

        $admin = $this->adminUser();
        $file  = UploadedFile::fake()->create('contrat.pdf', 200, 'application/pdf');

        $response = $this->actingAs($admin)->post('/admin/bibliotheque', [
            'title'    => 'Contrat standard',
            'category' => 'Contrats',
            'file'     => $file,
        ]);

        $response->assertRedirect('/admin/bibliotheque');
        $this->assertDatabaseHas('admin_template_documents', [
            'title'    => 'Contrat standard',
            'category' => 'Contrats',
        ]);
    }

    public function test_admin_can_delete_template_document(): void
    {
        Storage::fake('local');

        $admin = $this->adminUser();
        Storage::disk('local')->put('admin-templates/test.pdf', 'fake content');

        $doc = AdminTemplateDocument::create([
            'title'         => 'Doc test',
            'category'      => 'Général',
            'file_path'     => 'admin-templates/test.pdf',
            'original_name' => 'test.pdf',
            'mime'          => 'application/pdf',
            'size_bytes'    => 12,
            'uploaded_by'   => $admin->id,
        ]);

        $this->actingAs($admin)
             ->delete("/admin/bibliotheque/{$doc->id}")
             ->assertRedirect('/admin/bibliotheque');

        $this->assertDatabaseMissing('admin_template_documents', ['id' => $doc->id]);
    }

    public function test_admin_documents_json_endpoint(): void
    {
        Storage::fake('local');

        $admin = $this->adminUser();

        AdminTemplateDocument::create([
            'title'         => 'Guide emprunt',
            'category'      => 'Guides',
            'file_path'     => 'admin-templates/guide.pdf',
            'original_name' => 'guide.pdf',
            'mime'          => 'application/pdf',
            'size_bytes'    => 50000,
            'uploaded_by'   => $admin->id,
        ]);

        $response = $this->actingAs($admin)
             ->getJson('/admin/bibliotheque/json');

        $response->assertStatus(200)
                 ->assertJsonFragment(['title' => 'Guide emprunt'])
                 ->assertJsonFragment(['category' => 'Guides'])
                 ->assertJsonFragment(['ext' => 'PDF']);
    }

    public function test_admin_can_send_message_with_library_doc(): void
    {
        Storage::fake('local');

        $admin  = $this->adminUser();
        $client = $this->regularUser();

        Storage::disk('local')->put('admin-templates/contrat.pdf', 'fake pdf content');

        $doc = AdminTemplateDocument::create([
            'title'         => 'Contrat modèle',
            'category'      => 'Contrats',
            'file_path'     => 'admin-templates/contrat.pdf',
            'original_name' => 'contrat.pdf',
            'mime'          => 'application/pdf',
            'size_bytes'    => 17,
            'uploaded_by'   => $admin->id,
        ]);

        $response = $this->actingAs($admin)->post('/admin/messagerie', [
            'user_id'        => $client->id,
            'body'           => 'Veuillez trouver ci-joint votre contrat.',
            'library_doc_id' => $doc->id,
        ]);

        $response->assertRedirect();

        $this->assertDatabaseHas('messages', [
            'user_id'         => $client->id,
            'direction'       => 'outbound',
            'attachment_name' => 'contrat.pdf',
        ]);
    }

    public function test_regular_user_cannot_access_documents_page(): void
    {
        $this->actingAs($this->regularUser())
             ->get('/admin/bibliotheque')
             ->assertRedirect('/dashboard');
    }
}
