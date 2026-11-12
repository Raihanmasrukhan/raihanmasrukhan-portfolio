<?php

namespace Tests\Feature;

use App\Models\Education;
use App\Models\ProfileSetting;
use App\Models\Testimonial;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class PortfolioTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_portfolio_loads_with_seeded_data(): void
    {
        $this->seed();

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('RAIHAN');
        $response->assertSee('RUKHAN');
        $response->assertSee('TESTIMONIALS');
        $response->assertSee('CLIENT ENDORSEMENTS');
        $response->assertDontSee('BUKU TAMU');
        $response->assertDontSee('live-time');
        $response->assertDontSee('location-badge');
        $response->assertDontSee('Admin Login');
        $response->assertDontSee('ADMIN LOGIN');
        $response->assertDontSee('nav-login-pill');
        $response->assertDontSee('nav-admin-pill');
        $response->assertDontSee('nav-link-admin');
        $response->assertDontSee('nav-mobile-prefs');
        $response->assertDontSee('mobile-lang-switcher');
        $response->assertDontSee('mobile-theme-toggle');
        $response->assertSee('id="lang-switcher"', false);
        $response->assertSee('id="theme-toggle"', false);
        $response->assertDontSee(route('login'), false);

        $this->get('/login')->assertStatus(200);
    }

    public function test_visitor_can_submit_contact_message(): void
    {
        $response = $this->postJson('/contact', [
            'name' => 'Client Company',
            'email_or_phone' => '081234567890',
            'project_type' => 'SaaS & Custom Web Application',
            'message' => 'Kami butuh pengembangan sistem SaaS custom.',
        ]);

        $response->assertStatus(200)->assertJson(['success' => true]);
        $this->assertDatabaseHas('contact_messages', [
            'name' => 'Client Company',
            'email_or_phone' => '081234567890',
            'is_read' => false,
        ]);
    }

    public function test_visitor_can_switch_language_locale(): void
    {
        $responseId = $this->get('/lang/id');
        $responseId->assertSessionHas('locale', 'id');

        $responseEn = $this->get('/lang/en');
        $responseEn->assertSessionHas('locale', 'en');
    }

    public function test_admin_routes_require_authentication(): void
    {
        $this->get('/admin')->assertRedirect('/login');
        $this->get('/admin/profile')->assertRedirect('/login');
        $this->get('/admin/projects')->assertRedirect('/login');
        $this->get('/admin/testimonials')->assertRedirect('/login');
    }

    public function test_admin_can_login_and_manage_portfolio(): void
    {
        $admin = User::create([
            'name' => 'Raihan Admin',
            'email' => 'admin@raihan.dev',
            'password' => Hash::make('password123'),
        ]);

        // Login
        $this->post('/login', [
            'email' => 'admin@raihan.dev',
            'password' => 'password123',
        ])->assertRedirect('/admin');

        $this->actingAs($admin);

        // Access dashboard
        $this->get('/admin')->assertStatus(200)->assertSee('SYSTEM OPERATIONAL');

        // Update Profile
        $this->put('/admin/profile', [
            'full_name' => 'Raihan Updated',
            'hero_title_line1' => 'RAIHAN',
            'hero_title_prefix' => 'MAS',
            'hero_title_suffix' => 'RUKHAN',
            'headline' => 'Lead Software Engineer',
            'sub_headline' => 'Building scalable cloud systems.',
            'location' => 'Depok, ID',
            'availability_status' => 'Available',
            'is_available' => '1',
            'about_statement' => 'Updated statement.',
            'phone' => '+62 858-6445-9552',
            'whatsapp_number' => '6285864459552',
            'email' => 'raihan@example.com',
        ])->assertRedirect('/admin/profile');

        $this->assertDatabaseHas('profile_settings', [
            'full_name' => 'Raihan Updated',
            'headline' => 'Lead Software Engineer',
        ]);

        // Create Project
        $this->post('/admin/projects', [
            'title' => 'New SaaS App',
            'category' => 'saas',
            'badge' => 'SaaS',
            'overview' => 'Full stack SaaS solution.',
            'tech_stack_text' => 'Laravel, Tailwind CSS',
            'is_featured' => '1',
        ])->assertRedirect('/admin/projects');

        $this->assertDatabaseHas('projects', ['title' => 'New SaaS App']);

        // Create Skill
        $this->post('/admin/skills', [
            'name' => 'TypeScript',
            'category' => 'web_app',
            'level' => 'Advanced',
        ])->assertRedirect('/admin/skills');

        $this->assertDatabaseHas('skills', ['name' => 'TypeScript']);

        // Create & Manage Client Testimonial
        $this->post('/admin/testimonials', [
            'name' => 'Siti Nurhaliza',
            'role_title' => 'CTO',
            'company' => 'PT. Digital Nusantara',
            'project_tag' => 'Enterprise Web App',
            'message' => 'Exceptional delivery speed and clean Laravel architecture.',
            'rating' => 5,
            'is_approved' => '1',
        ])->assertRedirect('/admin/testimonials');

        $testimonial = Testimonial::where('name', 'Siti Nurhaliza')->firstOrFail();

        $this->patch("/admin/testimonials/{$testimonial->id}/toggle-pin")->assertRedirect();
        $this->assertTrue($testimonial->fresh()->is_pinned);

        $this->patch("/admin/testimonials/{$testimonial->id}/toggle-approval")->assertRedirect();
        $this->assertFalse($testimonial->fresh()->is_approved);
    }

    public function test_cv_sync_updates_portfolio_without_overwriting_users_or_testimonials(): void
    {
        $admin = User::create([
            'name' => 'Custom Admin',
            'email' => 'custom@raihan.dev',
            'password' => Hash::make('secret-prod-pass'),
        ]);

        $customTestimonial = Testimonial::create([
            'name' => 'Klien Produksi',
            'role_title' => 'CEO',
            'company' => 'PT Mitra Nyata',
            'project_tag' => 'Custom App',
            'message' => 'Layanan sangat memuaskan.',
            'avatar_color' => '#ff5500',
            'rating' => 5,
            'is_approved' => true,
            'is_pinned' => false,
        ]);

        DatabaseSeeder::syncCvData();

        $this->assertTrue(Hash::check('secret-prod-pass', $admin->fresh()->password));
        $this->assertDatabaseHas('testimonials', ['id' => $customTestimonial->id, 'name' => 'Klien Produksi']);
        $this->assertDatabaseHas('profile_settings', [
            'headline' => 'Web Developer & Digital Creative',
            'phone' => '+6285864459552',
        ]);
        $this->assertDatabaseHas('experiences', ['company' => 'PT Bilcode Global Teknologi']);
        $this->assertDatabaseHas(Education::class, ['school' => 'Politeknik IDN Bogor']);

        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('PT Bilcode Global Teknologi');
        $response->assertSee('Politeknik IDN Bogor');
    }

    public function test_profile_and_cv_fields_render_verbatim_without_i18n_overwrite(): void
    {
        $this->seed();

        $profile = ProfileSetting::current();
        $profile->update([
            'full_name' => 'Nama Kustom Uji',
            'headline' => 'Principal Software Engineer',
            'sub_headline' => 'Principal Software Engineer. Membangun arsitektur cloud berkinerja tinggi.',
            'location' => 'Jakarta Selatan, ID',
            'availability_status' => 'Open for Consulting Q4',
            'is_available' => true,
            'about_statement' => 'Editorial kustom <span class="text-bold">langsung dari admin</span>.',
            'instagram_url' => 'https://instagram.com/custom.uji',
            'cv_url' => 'https://example.com/cv-kustom.pdf',
        ]);

        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('Nama Kustom Uji');
        $response->assertSee('Principal Software Engineer');
        $response->assertSee('Principal Software Engineer. Membangun arsitektur cloud berkinerja tinggi.');
        $response->assertSee('Jakarta Selatan, ID');
        $response->assertSee('Open for Consulting Q4');
        $response->assertSee('Editorial kustom <span class="text-bold">langsung dari admin</span>.', false);
        $response->assertSee('https://instagram.com/custom.uji');
        $response->assertSee('https://example.com/cv-kustom.pdf');
        $response->assertSee('RESUME / CV');

        // Ensure JS i18n dictionary will not overwrite admin-managed Profile fields
        $response->assertDontSee('data-i18n="hero.available"', false);
        $response->assertDontSee('data-i18n="hero.headline"', false);
        $response->assertDontSee('data-i18n="hero.sub_headline"', false);
        $response->assertDontSee('data-i18n="about.statement"', false);
    }

    public function test_bilingual_i18n_dictionary_and_db_pairs_are_complete(): void
    {
        $this->seed();

        $idDict = trans('portfolio', [], 'id');
        $enDict = trans('portfolio', [], 'en');

        $this->assertSame(array_keys($idDict), array_keys($enDict));
        foreach ($idDict as $section => $items) {
            $this->assertSame(array_keys($items), array_keys($enDict[$section]), "Missing keys in section [{$section}]");
        }

        $pairs = config('portfolio_i18n.pairs', []);
        $this->assertNotEmpty($pairs);

        $idIndexed = collect($pairs)->pluck('en', 'id');
        $profile = ProfileSetting::current();
        $this->assertTrue($idIndexed->has($profile->sub_headline));
        $this->assertTrue($idIndexed->has($profile->about_statement));

        $profile->update(['cv_url' => 'https://example.com/cv-raihan.pdf']);

        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('window.I18N_DICTIONARY', false);
        $response->assertSee('window.I18N_CONTENT_PAIRS', false);
        $response->assertSee('data-i18n-db="html"', false);
        $response->assertSee('data-i18n="hero.cv_btn"', false);
        $response->assertSee('data-i18n="contact.view_cv"', false);
        $response->assertSee('data-i18n="footer.rights"', false);
        $response->assertSee('data-filter="design"', false);
        $response->assertSee('data-filter="video-editing"', false);
    }
}
