<?php

namespace Tests\Feature;

use App\Models\ContactMessage;
use App\Models\Education;
use App\Models\Experience;
use App\Models\Milestone;
use App\Models\ProfileSetting;
use App\Models\Project;
use App\Models\Service;
use App\Models\Skill;
use App\Models\Testimonial;
use App\Models\User;
use App\Models\WorkProcess;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminDashboardTest extends TestCase
{
    use RefreshDatabase;

    private function createAdmin(): User
    {
        return User::create([
            'name' => 'Raihan Admin',
            'email' => 'admin@raihan.dev',
            'password' => Hash::make('password123'),
        ]);
    }

    public function test_unauthenticated_users_cannot_access_any_admin_section(): void
    {
        $routes = [
            '/admin',
            '/admin/profile',
            '/admin/projects',
            '/admin/projects/create',
            '/admin/experiences',
            '/admin/experiences/create',
            '/admin/educations',
            '/admin/educations/create',
            '/admin/skills',
            '/admin/services',
            '/admin/processes',
            '/admin/milestones',
            '/admin/testimonials',
            '/admin/messages',
        ];

        foreach ($routes as $url) {
            $this->get($url)->assertRedirect('/login');
        }
    }

    public function test_admin_login_validation_and_logout_flow(): void
    {
        $this->createAdmin();

        $this->get('/login')->assertStatus(200);

        $this->post('/login', [
            'email' => 'admin@raihan.dev',
            'password' => 'wrong-password',
        ])->assertSessionHasErrors('email');

        $this->assertGuest();

        $this->post('/login', [
            'email' => 'admin@raihan.dev',
            'password' => 'password123',
        ])->assertRedirect('/admin');

        $this->assertAuthenticated();

        $this->get('/admin')
            ->assertStatus(200)
            ->assertSee('SYSTEM OPERATIONAL')
            ->assertDontSee('buku tamu');

        $this->post('/logout')->assertRedirect('/login');
        $this->assertGuest();

        $this->get('/admin')->assertRedirect('/login');
    }

    public function test_admin_can_update_profile_upload_avatar_and_change_password(): void
    {
        Storage::fake('public');
        $admin = $this->createAdmin();
        $this->actingAs($admin);

        $this->get('/admin/profile')->assertStatus(200);

        $response = $this->put('/admin/profile', [
            'full_name' => 'Raihan Adib Masrukhan',
            'hero_title_line1' => 'RAIHAN',
            'hero_title_prefix' => 'MAS',
            'hero_title_suffix' => 'RUKHAN',
            'headline' => 'Web Developer & Digital Creative',
            'sub_headline' => 'Subheadline terbaru.',
            'location' => 'Depok, Indonesia',
            'availability_status' => 'Available Now',
            'is_available' => '1',
            'about_statement' => 'Statement <span class="text-bold">lengkap</span>.',
            'hero_specialties_text' => "Laravel\nReact.js\nSaaS",
            'phone' => '+6285864459552',
            'whatsapp_number' => '6285864459552',
            'email' => 'raihan@example.com',
            'github_url' => 'https://github.com/Raihanmasrukhan',
            'linkedin_url' => 'https://www.linkedin.com/in/raihan-masrukhan-22626b316/',
            'instagram_url' => 'https://instagram.com/raihan.dev',
            'cv_file' => UploadedFile::fake()->create('cv-raihan.pdf', 256, 'application/pdf'),
            'avatar_file' => UploadedFile::fake()->image('portrait.png', 400, 400),
            'new_password' => 'newpass123',
            'new_password_confirmation' => 'newpass123',
        ]);

        $response->assertRedirect('/admin/profile');

        $profile = ProfileSetting::current();
        $this->assertSame('Available Now', $profile->availability_status);
        $this->assertSame(['Laravel', 'React.js', 'SaaS'], $profile->hero_specialties);
        $this->assertSame('https://instagram.com/raihan.dev', $profile->instagram_url);
        $this->assertStringStartsWith('storage/images/hero_', $profile->avatar);
        $this->assertStringStartsWith('storage/cv/cv_', $profile->cv_url);
        Storage::disk('public')->assertExists(str_replace('storage/', '', $profile->avatar));
        Storage::disk('public')->assertExists(str_replace('storage/', '', $profile->cv_url));
        $this->assertTrue(Hash::check('newpass123', $admin->fresh()->password));

        $homepage = $this->get('/');
        $homepage->assertStatus(200);
        $homepage->assertSee('Raihan Adib Masrukhan');
        $homepage->assertSee('Web Developer &amp; Digital Creative', false);
        $homepage->assertSee('Subheadline terbaru.');
        $homepage->assertSee('Depok, Indonesia');
        $homepage->assertSee('Available Now');
        $homepage->assertSee('Statement <span class="text-bold">lengkap</span>.', false);
        $homepage->assertSee('https://instagram.com/raihan.dev');
        $homepage->assertSee('RESUME / CV');
        $homepage->assertSee($profile->cv_url);

        // Verify clearing specialties, unchecking availability, and removing CV updates DB and homepage
        $this->put('/admin/profile', [
            'full_name' => 'Raihan Adib Masrukhan',
            'hero_title_line1' => 'RAIHAN',
            'hero_title_prefix' => 'MAS',
            'hero_title_suffix' => 'RUKHAN',
            'headline' => 'Web Developer & Digital Creative',
            'sub_headline' => 'Subheadline terbaru.',
            'location' => 'Depok, Indonesia',
            'availability_status' => 'Busy',
            'about_statement' => 'Statement baru.',
            'hero_specialties_text' => '',
            'remove_cv' => '1',
            'phone' => '+6285864459552',
            'whatsapp_number' => '6285864459552',
            'email' => 'raihan@example.com',
        ])->assertRedirect('/admin/profile');

        $profile->refresh();
        $this->assertFalse($profile->is_available);
        $this->assertSame([], $profile->hero_specialties);
        $this->assertNull($profile->cv_url);

        $updatedHome = $this->get('/');
        $updatedHome->assertStatus(200);
        $updatedHome->assertSee('Busy');
        $updatedHome->assertSee('Statement baru.');
        $updatedHome->assertDontSee('hero-badge-dot');
        $updatedHome->assertDontSee('RESUME / CV');
    }

    public function test_admin_projects_full_crud_and_image_upload(): void
    {
        Storage::fake('public');
        $this->actingAs($this->createAdmin());

        $this->get('/admin/projects')->assertStatus(200);
        $this->get('/admin/projects/create')->assertStatus(200);

        $this->post('/admin/projects', [
            'title' => 'Enterprise CRM Platform',
            'category' => 'enterprise',
            'badge' => 'CRM System',
            'client' => 'PT Klien Uji',
            'role' => 'Lead Developer',
            'timeline' => '2026',
            'overview' => 'Full enterprise CRM solution.',
            'highlights_text' => "Realtime reporting\nRBAC support",
            'tech_stack_text' => 'Laravel, React, MySQL',
            'live_url' => 'https://demo.crm-platform.test',
            'github_url' => 'https://github.com/raihan/enterprise-crm',
            'image_file' => UploadedFile::fake()->image('mockup.jpg', 800, 450),
            'sort_order' => 1,
            'is_featured' => '1',
        ])->assertRedirect('/admin/projects');

        $project = Project::where('slug', 'enterprise-crm-platform')->firstOrFail();
        $this->assertSame(['Realtime reporting', 'RBAC support'], $project->highlights);
        $this->assertSame(['Laravel', 'React', 'MySQL'], $project->tech_stack);
        $this->assertSame('https://demo.crm-platform.test', $project->live_url);
        $this->assertSame('https://github.com/raihan/enterprise-crm', $project->github_url);
        $this->assertTrue($project->is_featured);
        Storage::disk('public')->assertExists(str_replace('storage/', '', $project->image));

        $this->get('/admin/projects')
            ->assertStatus(200)
            ->assertSee('https://demo.crm-platform.test')
            ->assertSee('https://github.com/raihan/enterprise-crm');

        $homepage = $this->get('/');
        $homepage->assertStatus(200);
        $homepage->assertSee('href="https://demo.crm-platform.test"', false);
        $homepage->assertSee('href="https://github.com/raihan/enterprise-crm"', false);
        $homepage->assertSee('data-i18n="projects.live_demo"', false);
        $homepage->assertSee('data-i18n="projects.github_repo"', false);
        $homepage->assertSee('liveUrl:', false);
        $homepage->assertSee('githubUrl:', false);

        // Duplicate title gets unique slug suffix
        $this->post('/admin/projects', [
            'title' => 'Enterprise CRM Platform',
            'category' => 'saas',
            'overview' => 'Second copy.',
        ])->assertRedirect('/admin/projects');

        $this->assertDatabaseHas('projects', ['slug' => 'enterprise-crm-platform-1']);

        $this->get("/admin/projects/{$project->id}/edit")->assertStatus(200)->assertSee('Enterprise CRM Platform');

        $this->put("/admin/projects/{$project->id}", [
            'title' => 'Enterprise CRM V2',
            'category' => 'saas',
            'badge' => 'SaaS',
            'overview' => 'Updated overview.',
            'highlights_text' => 'Updated highlight',
            'tech_stack_text' => 'Laravel, Vue.js',
            'sort_order' => 2,
        ])->assertRedirect('/admin/projects');

        $project->refresh();
        $this->assertSame('Enterprise CRM V2', $project->title);
        $this->assertFalse($project->is_featured);
        $this->assertSame(['Updated highlight'], $project->highlights);

        $this->delete("/admin/projects/{$project->id}")->assertRedirect('/admin/projects');
        $this->assertDatabaseMissing('projects', ['id' => $project->id]);

        // Verify Design & Video Editing categories work in Admin & Homepage
        $this->post('/admin/projects', [
            'title' => 'Brand Identity Poster Pack',
            'category' => 'design',
            'badge' => 'Graphic Design',
            'role' => 'Lead UI Designer',
            'overview' => 'Visual identity dan desain konten promosi.',
            'tech_stack_text' => 'Figma, Canva',
            'live_url' => 'https://figma.com/file/brand-pack',
        ])->assertRedirect('/admin/projects');

        $this->post('/admin/projects', [
            'title' => 'Company Profile Reel 2026',
            'category' => 'video-editing',
            'badge' => 'Video Editing',
            'role' => 'Motion Designer',
            'overview' => 'Video highlight kampanye dan motion graphics.',
            'tech_stack_text' => 'CapCut, Premiere',
            'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
            'video_duration' => '01:30',
        ])->assertRedirect('/admin/projects');

        $videoProject = Project::where('slug', 'company-profile-reel-2026')->firstOrFail();
        $this->assertSame('https://www.youtube.com/watch?v=dQw4w9WgXcQ', $videoProject->video_url);
        $this->assertSame('01:30', $videoProject->video_duration);
        $this->assertSame('https://www.youtube-nocookie.com/embed/dQw4w9WgXcQ', $videoProject->youtubeEmbedUrl());

        $this->get('/admin/projects?category=design')
            ->assertStatus(200)
            ->assertSee('Brand Identity Poster Pack')
            ->assertDontSee('Company Profile Reel 2026');

        $this->get('/admin/projects?category=video-editing')
            ->assertStatus(200)
            ->assertSee('Company Profile Reel 2026')
            ->assertDontSee('Brand Identity Poster Pack');

        $home = $this->get('/');
        $home->assertStatus(200);
        $home->assertSee('data-filter="design"', false);
        $home->assertSee('data-filter="video-editing"', false);
        $home->assertSee('data-category="design"', false);
        $home->assertSee('data-category="video-editing"', false);
        $home->assertSee('Brand Identity Poster Pack');
        $home->assertSee('Company Profile Reel 2026');
        $home->assertSee('btn-project-design', false);
        $home->assertSee('btn-project-view-full', false);
        $home->assertSee('data-lightbox-src', false);
        $home->assertSee('btn-project-video', false);
        $home->assertSee('data-i18n="projects.view_design"', false);
        $home->assertSee('data-i18n="projects.watch_video"', false);
        $home->assertSee('data-i18n="projects.view_full"', false);
        $home->assertSee('⏱ 01:30');
        $home->assertSee('modal-video-wrap', false);
        $home->assertSee('modal-image-view-full-btn', false);
        $home->assertSee('id="design-lightbox"', false);

        // Edit video project and update duration & video URL
        $this->put("/admin/projects/{$videoProject->id}", [
            'title' => 'Company Profile Reel 2026 Remastered',
            'category' => 'video-editing',
            'badge' => 'Reel Promo',
            'overview' => 'Updated video reel overview.',
            'video_url' => 'https://youtu.be/dQw4w9WgXcQ',
            'video_duration' => '02:00',
        ])->assertRedirect('/admin/projects');

        $videoProject->refresh();
        $this->assertSame('02:00', $videoProject->video_duration);
        $this->assertSame('https://youtu.be/dQw4w9WgXcQ', $videoProject->video_url);
    }

    public function test_oversized_project_and_profile_images_are_auto_compressed_to_max_5mb(): void
    {
        Storage::fake('public');
        $this->actingAs($this->createAdmin());

        $this->get('/admin/projects/create')
            ->assertStatus(200)
            ->assertSee('data-auto-compress-mb="5"', false);

        $this->get('/admin/profile')
            ->assertStatus(200)
            ->assertSee('data-auto-compress-mb="5"', false);

        // Generate a valid >5MB (~7.7MB) uncompressed PNG using GD
        $canvas = imagecreatetruecolor(1600, 1600);
        $accent = imagecolorallocate($canvas, 255, 85, 0);
        imagefilledrectangle($canvas, 200, 200, 1400, 1400, $accent);
        ob_start();
        imagepng($canvas, null, 0);
        $oversizedPng = (string) ob_get_clean();
        unset($canvas);

        $this->assertGreaterThan(5 * 1024 * 1024, strlen($oversizedPng));

        $oversizedUpload = UploadedFile::fake()->createWithContent('oversized-mockup.png', $oversizedPng);

        $this->post('/admin/projects', [
            'title' => 'Large Mockup Auto Compress',
            'category' => 'saas',
            'overview' => 'Testing auto compression above 5MB.',
            'image_file' => $oversizedUpload,
        ])->assertRedirect('/admin/projects');

        $project = Project::where('slug', 'large-mockup-auto-compress')->firstOrFail();
        $storedPath = str_replace('storage/', '', $project->image);

        Storage::disk('public')->assertExists($storedPath);
        $this->assertLessThanOrEqual(5 * 1024 * 1024, Storage::disk('public')->size($storedPath));

        $this->get("/admin/projects/{$project->id}/edit")
            ->assertStatus(200)
            ->assertSee('data-auto-compress-mb="5"', false);

        // Also verify oversized profile avatar upload (>5MB) auto-compresses <= 5MB
        $profile = ProfileSetting::current();
        $oversizedAvatar = UploadedFile::fake()->createWithContent('oversized-avatar.png', $oversizedPng);

        $this->put('/admin/profile', [
            'full_name' => $profile->full_name,
            'hero_title_line1' => $profile->hero_title_line1,
            'hero_title_prefix' => $profile->hero_title_prefix,
            'hero_title_suffix' => $profile->hero_title_suffix,
            'headline' => $profile->headline,
            'sub_headline' => $profile->sub_headline,
            'location' => $profile->location,
            'availability_status' => $profile->availability_status,
            'is_available' => $profile->is_available ? '1' : '0',
            'about_statement' => $profile->about_statement,
            'phone' => $profile->phone,
            'whatsapp_number' => $profile->whatsapp_number,
            'email' => $profile->email,
            'avatar_file' => $oversizedAvatar,
        ])->assertRedirect('/admin/profile');

        $avatarPath = str_replace('storage/', '', $profile->fresh()->avatar);
        Storage::disk('public')->assertExists($avatarPath);
        $this->assertLessThanOrEqual(5 * 1024 * 1024, Storage::disk('public')->size($avatarPath));
    }

    public function test_admin_experiences_and_educations_full_crud(): void
    {
        $this->actingAs($this->createAdmin());

        // Experiences CRUD
        $this->get('/admin/experiences')->assertStatus(200);
        $this->get('/admin/experiences/create')->assertStatus(200);

        $this->post('/admin/experiences', [
            'role' => 'Senior Web Developer',
            'company' => 'PT Uji Karya',
            'date_span' => 'Jan 2025 - Present',
            'description' => 'Memimpin pengembangan aplikasi web.',
            'badges_text' => 'Laravel, Docker, CI/CD',
            'sort_order' => 1,
            'is_current' => '1',
        ])->assertRedirect('/admin/experiences');

        $experience = Experience::where('company', 'PT Uji Karya')->firstOrFail();
        $this->assertSame(['Laravel', 'Docker', 'CI/CD'], $experience->badges);
        $this->assertTrue($experience->is_current);

        $this->get("/admin/experiences/{$experience->id}/edit")->assertStatus(200);

        $this->put("/admin/experiences/{$experience->id}", [
            'role' => 'Principal Web Developer',
            'company' => 'PT Uji Karya Nusantara',
            'date_span' => 'Jan 2025 - Okt 2026',
            'description' => 'Deskripsi terbaru.',
            'badges_text' => 'Laravel, AWS',
            'sort_order' => 2,
        ])->assertRedirect('/admin/experiences');

        $experience->refresh();
        $this->assertSame('Principal Web Developer', $experience->role);
        $this->assertFalse($experience->is_current);

        $this->delete("/admin/experiences/{$experience->id}")->assertRedirect('/admin/experiences');
        $this->assertDatabaseMissing('experiences', ['id' => $experience->id]);

        // Educations CRUD
        $this->get('/admin/educations')->assertStatus(200);
        $this->get('/admin/educations/create')->assertStatus(200);

        $this->post('/admin/educations', [
            'school' => 'Institut Teknologi Uji',
            'degree' => 'Teknik Informatika',
            'period' => '2022 - 2026',
            'notes' => 'Fokus rekayasa sistem.',
            'sort_order' => 1,
        ])->assertRedirect('/admin/educations');

        $education = Education::where('school', 'Institut Teknologi Uji')->firstOrFail();

        $this->get("/admin/educations/{$education->id}/edit")->assertStatus(200);

        $this->put("/admin/educations/{$education->id}", [
            'school' => 'Institut Teknologi Uji Baru',
            'degree' => 'S.Tr.Kom Software Engineering',
            'period' => '2022 - 2026',
            'notes' => 'Catatan diperbarui.',
            'sort_order' => 3,
        ])->assertRedirect('/admin/educations');

        $this->assertDatabaseHas(Education::class, [
            'id' => $education->id,
            'school' => 'Institut Teknologi Uji Baru',
        ]);

        $this->delete("/admin/educations/{$education->id}")->assertRedirect('/admin/educations');
        $this->assertDatabaseMissing(Education::class, ['id' => $education->id]);
    }

    public function test_admin_skills_services_processes_and_milestones_full_crud(): void
    {
        $this->actingAs($this->createAdmin());

        // Skills CRUD + category validation
        $this->get('/admin/skills')->assertStatus(200);
        $this->post('/admin/skills', [
            'name' => 'Invalid Category Skill',
            'category' => 'invalid_cat',
        ])->assertSessionHasErrors('category');

        $this->post('/admin/skills', [
            'name' => 'Redis Cache',
            'category' => 'database_arch',
            'level' => 'Advanced',
            'sort_order' => 5,
        ])->assertRedirect('/admin/skills');

        $skill = Skill::where('name', 'Redis Cache')->firstOrFail();
        $this->put("/admin/skills/{$skill->id}", [
            'name' => 'Redis Cluster',
            'category' => 'tools_cloud',
            'level' => 'Expert',
            'sort_order' => 2,
        ])->assertRedirect('/admin/skills');
        $this->assertDatabaseHas('skills', ['id' => $skill->id, 'name' => 'Redis Cluster', 'category' => 'tools_cloud']);
        $this->delete("/admin/skills/{$skill->id}")->assertRedirect('/admin/skills');
        $this->assertDatabaseMissing('skills', ['id' => $skill->id]);

        // Services CRUD
        $this->get('/admin/services')->assertStatus(200);
        $this->post('/admin/services', [
            'number_label' => '05 // CLOUD',
            'title' => 'CLOUD DEVOPS',
            'description' => 'Deploy container skala produksi.',
            'tags_text' => 'Docker, Caddy, Linux',
            'sort_order' => 5,
        ])->assertRedirect('/admin/services');

        $service = Service::where('number_label', '05 // CLOUD')->firstOrFail();
        $this->assertSame(['Docker', 'Caddy', 'Linux'], $service->tags);

        $this->put("/admin/services/{$service->id}", [
            'number_label' => '05 // INFRA',
            'title' => 'CLOUD INFRASTRUCTURE',
            'description' => 'Updated infra service.',
            'tags_text' => 'Docker, CI/CD',
            'sort_order' => 6,
        ])->assertRedirect('/admin/services');
        $this->assertDatabaseHas('services', ['id' => $service->id, 'title' => 'CLOUD INFRASTRUCTURE']);

        $this->delete("/admin/services/{$service->id}")->assertRedirect('/admin/services');
        $this->assertDatabaseMissing('services', ['id' => $service->id]);

        // WorkProcess CRUD (explicitly guards route-model binding {process})
        $this->get('/admin/processes')->assertStatus(200);
        $this->post('/admin/processes', [
            'step_number' => '5.',
            'title' => 'SCALING',
            'description' => 'Monitoring & optimasi produksi.',
            'is_featured' => '1',
            'sort_order' => 5,
        ])->assertRedirect('/admin/processes');

        $process = WorkProcess::where('title', 'SCALING')->firstOrFail();
        $this->assertTrue($process->is_featured);

        $this->put("/admin/processes/{$process->id}", [
            'step_number' => '5.',
            'title' => 'MAINTENANCE',
            'description' => 'Pemeliharaan jangka panjang.',
            'sort_order' => 6,
        ])->assertRedirect('/admin/processes');

        $process->refresh();
        $this->assertSame('MAINTENANCE', $process->title);
        $this->assertFalse($process->is_featured);

        $this->delete("/admin/processes/{$process->id}")->assertRedirect('/admin/processes');
        $this->assertDatabaseMissing('work_processes', ['id' => $process->id]);

        // Milestones CRUD
        $this->get('/admin/milestones')->assertStatus(200);
        $this->post('/admin/milestones', [
            'organization' => 'PT Milestone Uji',
            'project_name' => 'ERP Dashboard',
            'tech_stack' => 'Laravel, React',
            'period' => '2026',
            'sort_order' => 5,
        ])->assertRedirect('/admin/milestones');

        $milestone = Milestone::where('organization', 'PT Milestone Uji')->firstOrFail();
        $this->put("/admin/milestones/{$milestone->id}", [
            'organization' => 'PT Milestone Baru',
            'project_name' => 'ERP v2',
            'tech_stack' => 'Laravel, Docker',
            'period' => '2026 - 2027',
            'sort_order' => 6,
        ])->assertRedirect('/admin/milestones');
        $this->assertDatabaseHas('milestones', ['id' => $milestone->id, 'organization' => 'PT Milestone Baru']);

        $this->delete("/admin/milestones/{$milestone->id}")->assertRedirect('/admin/milestones');
        $this->assertDatabaseMissing('milestones', ['id' => $milestone->id]);
    }

    public function test_admin_testimonials_filters_crud_and_contact_messages_inbox(): void
    {
        $this->actingAs($this->createAdmin());

        // Testimonials filters + CRUD + toggles
        $this->post('/admin/testimonials', [
            'name' => 'Dina Kusuma',
            'role_title' => 'VP Engineering',
            'company' => 'PT Uji Testimoni',
            'project_tag' => 'SaaS Platform',
            'message' => 'Kualitas arsitektur aplikasi sangat rapi dan cepat.',
            'rating' => 5,
            'is_approved' => '1',
        ])->assertRedirect('/admin/testimonials');

        $testimonial = Testimonial::where('name', 'Dina Kusuma')->firstOrFail();
        $this->assertTrue($testimonial->is_approved);
        $this->assertFalse($testimonial->is_pinned);

        $this->get('/admin/testimonials')->assertStatus(200)->assertSee('Dina Kusuma');
        $this->get('/admin/testimonials?filter=published')->assertStatus(200)->assertSee('Dina Kusuma');
        $this->get('/admin/testimonials?filter=draft')->assertStatus(200)->assertDontSee('Dina Kusuma');

        $this->patch("/admin/testimonials/{$testimonial->id}/toggle-approval")->assertRedirect();
        $this->assertFalse($testimonial->fresh()->is_approved);
        $this->get('/admin/testimonials?filter=draft')->assertStatus(200)->assertSee('Dina Kusuma');

        $this->patch("/admin/testimonials/{$testimonial->id}/toggle-pin")->assertRedirect();
        $this->assertTrue($testimonial->fresh()->is_pinned);
        $this->get('/admin/testimonials?filter=featured')->assertStatus(200)->assertSee('Dina Kusuma');

        $this->put("/admin/testimonials/{$testimonial->id}", [
            'name' => 'Dina Kusuma, M.Kom.',
            'role_title' => 'CTO',
            'company' => 'PT Uji Testimoni Tbk',
            'project_tag' => 'Enterprise SaaS',
            'message' => 'Testimoni telah diperbarui dengan detail baru.',
            'rating' => 4,
        ])->assertRedirect('/admin/testimonials');

        $this->assertDatabaseHas('testimonials', [
            'id' => $testimonial->id,
            'name' => 'Dina Kusuma, M.Kom.',
            'rating' => 4,
        ]);

        $this->delete("/admin/testimonials/{$testimonial->id}")->assertRedirect();
        $this->assertDatabaseMissing('testimonials', ['id' => $testimonial->id]);

        // Contact Messages Inbox
        $msg = ContactMessage::create([
            'name' => 'Budi Klien',
            'email_or_phone' => '081299988877',
            'project_type' => 'Custom Management System',
            'message' => 'Butuh penawaran pembuatan sistem manajemen.',
            'is_read' => false,
        ]);

        $this->get('/admin/messages')->assertStatus(200)->assertSee('Budi Klien');
        $this->get('/admin/messages?filter=unread')->assertStatus(200)->assertSee('Budi Klien');

        // Showing message automatically marks it as read and formats WhatsApp link
        $this->get("/admin/messages/{$msg->id}")
            ->assertStatus(200)
            ->assertSee('Budi Klien')
            ->assertSee('https://wa.me/6281299988877');

        $this->assertTrue($msg->fresh()->is_read);
        $this->get('/admin/messages?filter=unread')->assertStatus(200)->assertDontSee('Budi Klien');

        // Toggle back to unread
        $this->patch("/admin/messages/{$msg->id}/toggle-read")->assertRedirect();
        $this->assertFalse($msg->fresh()->is_read);

        // Delete message
        $this->delete("/admin/messages/{$msg->id}")->assertRedirect('/admin/messages');
        $this->assertDatabaseMissing('contact_messages', ['id' => $msg->id]);
    }
}
