<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PublicPagesTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_page_loads(): void
    {
        $this->get('/')->assertStatus(200);
    }

    public function test_about_page_loads(): void
    {
        $this->get('/a-propos')->assertStatus(200);
    }

    public function test_contact_page_loads(): void
    {
        $this->get('/contact')->assertStatus(200);
    }

    public function test_rdv_page_loads(): void
    {
        $this->get('/contact/rdv')->assertStatus(200);
    }

    public function test_blog_index_loads(): void
    {
        $this->get('/blog')->assertStatus(200);
    }

    public function test_faq_page_loads(): void
    {
        $this->get('/faq')->assertStatus(200);
    }

    public function test_glossary_page_loads(): void
    {
        $this->get('/glossaire')->assertStatus(200);
    }

    public function test_guides_page_loads(): void
    {
        $this->get('/guides')->assertStatus(200);
    }

    public function test_simulator_page_loads(): void
    {
        $this->get('/simulateur')->assertStatus(200);
    }

    public function test_simulator_capacity_loads(): void
    {
        $this->get('/simulateur/capacite')->assertStatus(200);
    }

    public function test_simulator_compare_loads(): void
    {
        $this->get('/simulateur/comparateur')->assertStatus(200);
    }

    public function test_loans_index_loads(): void
    {
        $this->get('/prets')->assertStatus(200);
    }

    public function test_loan_immobilier_loads(): void
    {
        $this->get('/prets/immobilier')->assertStatus(200);
    }

    public function test_loan_automobile_loads(): void
    {
        $this->get('/prets/automobile')->assertStatus(200);
    }

    public function test_loan_personnel_loads(): void
    {
        $this->get('/prets/personnel')->assertStatus(200);
    }

    public function test_loan_entreprise_loads(): void
    {
        $this->get('/prets/entreprise')->assertStatus(200);
    }

    public function test_loan_microcredit_loads(): void
    {
        $this->get('/prets/microcredit')->assertStatus(200);
    }

    public function test_loan_agricole_loads(): void
    {
        $this->get('/prets/agricole')->assertStatus(200);
    }

    public function test_legal_page_loads(): void
    {
        $this->get('/mentions-legales')->assertStatus(200);
    }

    public function test_privacy_page_loads(): void
    {
        $this->get('/confidentialite')->assertStatus(200);
    }

    public function test_terms_page_loads(): void
    {
        $this->get('/cgu')->assertStatus(200);
    }

    public function test_cookies_page_loads(): void
    {
        $this->get('/cookies')->assertStatus(200);
    }

    public function test_sitemap_loads(): void
    {
        $this->get('/sitemap.xml')->assertStatus(200);
    }

    public function test_login_page_loads(): void
    {
        $this->get('/espace-client')->assertStatus(200);
    }

    public function test_register_page_loads(): void
    {
        $this->get('/espace-client/register')->assertStatus(200);
    }

    public function test_forgot_password_page_loads(): void
    {
        $this->get('/espace-client/mot-de-passe')->assertStatus(200);
    }
}
