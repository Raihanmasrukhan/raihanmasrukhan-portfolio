<?php

namespace Database\Seeders;

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
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Admin User
        User::firstOrCreate(
            ['email' => env('ADMIN_EMAIL', 'admin@raihan.dev')],
            [
                'name' => 'Raihan Adib Masrukhan',
                'password' => Hash::make(env('ADMIN_PASSWORD', 'password123')),
            ]
        );

        // 2. Profile & Site Settings
        ProfileSetting::firstOrCreate(
            ['id' => 1],
            [
                'full_name' => 'Raihan Adib Masrukhan',
                'hero_title_line1' => 'RAIHAN',
                'hero_title_prefix' => 'MAS',
                'hero_title_suffix' => 'RUKHAN',
                'headline' => 'Software Engineer & Full-Stack Web Developer',
                'sub_headline' => 'Software Engineer & Full-Stack Web Developer. Transforming complex business logic into high-performance web applications, scalable SaaS systems, and intuitive digital experiences.',
                'location' => 'Based in Depok & Bogor, ID',
                'availability_status' => 'Available for Projects',
                'is_available' => true,
                'avatar' => 'images/hero.jpg',
                'hero_specialties' => [
                    'Full-Stack Web Dev',
                    'SaaS Architecture',
                    'Laravel & React Ecosystem',
                    'Geofencing & PWA Systems',
                    'Creative UI/UX Engineering',
                ],
                'about_statement' => 'I build <span class="text-bold">production-grade web platforms</span> and <span class="text-highlight">robust SaaS systems</span> that empower businesses and communities. Every solution begins with a <span class="text-bold">clean architectural foundation</span>, <span class="text-highlight">intuitive UI/UX</span>, and <span class="text-bold">rock-solid reliability</span> throughout.',
                'phone' => '+62 858-6445-9552',
                'whatsapp_number' => '6285864459552',
                'email' => 'Raihanmasrukhan56@gmail.com',
                'github_url' => 'https://github.com/Raihanmasrukhan',
                'linkedin_url' => 'https://www.linkedin.com/in/raihan-masrukhan-22626b316/',
                'instagram_url' => null,
            ]
        );

        // 3. Projects
        $projects = [
            [
                'title' => 'Digital Progress & Geofencing SaaS',
                'slug' => 'saas-progress',
                'category' => 'saas',
                'badge' => 'SaaS & PWA',
                'client' => 'PT. BantuGrow Revolusi Digital',
                'role' => 'Web Developer & UI/UX Designer',
                'timeline' => 'Nov 2024 – Present',
                'overview' => 'An end-to-end multi-tenant Software-as-a-Service (SaaS) and progress management system. Engineered for high-accuracy workforce tracking with live geofencing polygon boundaries, offline Progressive Web App (PWA) sync, dynamic multi-role authorization, and automated daily PDF reporting engine.',
                'highlights' => [
                    'Real-time GPS geofencing radius validation for field task attendance',
                    'Offline-first Progressive Web App (PWA) with background sync',
                    'Automated executive PDF report generator & analytics charts',
                    'Streamlined multi-company tenant architecture and role-based permissions',
                ],
                'tech_stack' => ['PHP / Laravel', 'JavaScript / React', 'MySQL', 'PWA', 'Tailwind CSS', 'Geofencing API'],
                'image' => 'images/project-saas.jpg',
                'sort_order' => 1,
                'is_featured' => true,
            ],
            [
                'title' => 'Umrah Travel Manifest & Operations System',
                'slug' => 'umrah-travel',
                'category' => 'enterprise',
                'badge' => 'Enterprise System',
                'client' => 'PT. Ahsan Sabila Mumtaza (Ahsan Tour & Travel)',
                'role' => 'Web Developer',
                'timeline' => 'Sep 2023 – Oct 2024',
                'overview' => 'Comprehensive travel management platform built to orchestrate large-scale Umrah pilgrimages. Features automated flight manifest generation, baggage & luggage inventory tracker, passenger milestone payments, and live hotel booking management.',
                'highlights' => [
                    'Automated passenger manifest and flight scheduling with zero human error',
                    'Equipment & inventory logistics tracking across departure hubs',
                    'End-to-end payment status tracking and dynamic invoicing',
                    'High performance portal with integrated promotional assets and fast mobile UX',
                ],
                'tech_stack' => ['PHP / Laravel', 'MySQL', 'REST API', 'JavaScript', 'cPanel', 'Responsive UI'],
                'image' => 'images/project-travel.jpg',
                'sort_order' => 2,
                'is_featured' => true,
            ],
            [
                'title' => 'Tahfidz & Academic Attendance Portal',
                'slug' => 'tahfidz-portal',
                'category' => 'enterprise',
                'badge' => 'Academic Portal',
                'client' => 'Pondok Pesantren Abdan Syakuro',
                'role' => 'Web Developer & Multimedia',
                'timeline' => 'Oct 2024 – Present',
                'overview' => 'Specialized educational management software designed to digitalize Quran memorization (Tahfidz) tracking, student daily attendance, and real-time academic report cards for parents and administrators. Also powers the institution\'s PPDB student admissions.',
                'highlights' => [
                    'Granular Juz, Surah, and Ayah memorization progress logging with visual charts',
                    'Digitalized daily attendance reducing paper-based administrative workload',
                    'Parent portal for instant academic and memorization milestone updates',
                    'Integrated official portal with admission inquiry conversion funnels',
                ],
                'tech_stack' => ['Laravel', 'MySQL', 'JavaScript', 'Bootstrap / CSS3', 'Laragon / Cloud VPS'],
                'image' => 'images/project-tahfidz.jpg',
                'sort_order' => 3,
                'is_featured' => true,
            ],
            [
                'title' => 'High-Converting Digital Agency Architecture',
                'slug' => 'agency-landing',
                'category' => 'landing',
                'badge' => 'Landing & Performance',
                'client' => 'PT. BantuGrow Revolusi Digital & Clients',
                'role' => 'Full-Stack Developer & UI/UX Designer',
                'timeline' => '2024',
                'overview' => 'A suite of ultra-high performance landing pages and conversion-optimized websites built for high-stakes marketing and ad campaigns. Focused on sub-second load times, Core Web Vitals optimization, interactive micro-animations, and lead capture funnels.',
                'highlights' => [
                    '98+ Google Lighthouse performance score with sub-second page loads',
                    'High conversion rates with strategic UI/UX placement and interactive CTA forms',
                    'End-to-end meta tags, OpenGraph social sharing, and structured JSON-LD SEO',
                    'Pixel-perfect responsive layout across mobile, tablet, and desktop monitors',
                ],
                'tech_stack' => ['HTML5 / CSS3', 'Modern JS', 'Figma UI/UX', 'Core Web Vitals', 'Tailwind CSS'],
                'image' => 'images/project-landing.jpg',
                'sort_order' => 4,
                'is_featured' => true,
            ],
            [
                'title' => 'Foundation Portal & Custom Editorial CMS',
                'slug' => 'alqolam-cms',
                'category' => 'landing',
                'badge' => 'Web Portal & CMS',
                'client' => 'Pondok Pesantren Al Qolam Yatim & Dhuafa',
                'role' => 'Web Developer',
                'timeline' => 'Jun 2022 – Jul 2023',
                'overview' => 'Official institutional portal and customized content management system (CMS) created to amplify digital presence and facilitate public fundraising for orphan empowerment programs.',
                'highlights' => [
                    'Custom Laravel CMS allowing non-technical staff to publish articles and financial transparency reports',
                    'Integrated digital fundraising appeal and campaign tracking',
                    'Robust multi-role dashboard for administrative staff',
                ],
                'tech_stack' => ['Laravel', 'PHP', 'MySQL', 'CSS3', 'Git'],
                'image' => 'images/project-tahfidz.jpg',
                'sort_order' => 5,
                'is_featured' => false,
            ],
        ];

        foreach ($projects as $proj) {
            Project::updateOrCreate(['slug' => $proj['slug']], $proj);
        }

        // 4. Work Experiences
        $experiences = [
            [
                'role' => 'Web Developer & Desain Grafis',
                'company' => 'PT. BantuGrow Revolusi Digital',
                'date_span' => 'Nov 2024 — Present (Remote)',
                'description' => 'Membangun dan mengembangkan ekosistem Software-as-a-Service (SaaS) serta solusi digital terintegrasi, termasuk perancangan Digital Progress Management System kustom dengan fitur geofencing, dukungan PWA, dan automasi laporan PDF. Men-deploy arsitektur landing page berkinerja tinggi serta mengelola aset digital.',
                'badges' => ['SaaS Ecosystem', 'Geofencing', 'PWA', 'PDF Automation', 'Landing Pages'],
                'sort_order' => 1,
                'is_current' => true,
            ],
            [
                'role' => 'Web Developer & Multimedia',
                'company' => 'Pondok Pesantren Abdan Syakuro',
                'date_span' => 'Okt 2024 — Present',
                'description' => 'Merancang, mengembangkan, dan mengelola Aplikasi Sistem Manajemen Tahfidz untuk digitalisasi pencatatan hafalan santri, pemantauan absensi, dan pelaporan akademik. Memelihara dan mengoptimalkan performa website profil pesantren sebagai pusat informasi utama PPDB.',
                'badges' => ['Tahfidz System', 'Academic Portal', 'PPDB Traffic Hub', 'Multimedia'],
                'sort_order' => 2,
                'is_current' => true,
            ],
            [
                'role' => 'Web Developer',
                'company' => 'PT. Ahsan Sabila Mumtaza',
                'date_span' => 'Sep 2023 — Okt 2024',
                'description' => 'Membangun dan mengembangkan Aplikasi Sistem Manajemen Travel Umrah end-to-end (manifest keberangkatan, inventori perlengkapan, dan pelacakan status pembayaran). Mengelola server, kecepatan akses, dan sistem informasi paket wisata.',
                'badges' => ['Travel Umrah SaaS', 'Manifest Automation', 'Inventory Tracking', 'Server Ops'],
                'sort_order' => 3,
                'is_current' => false,
            ],
            [
                'role' => 'Web Developer',
                'company' => 'Pondok Pesantren Al Qolam Yatim',
                'date_span' => 'Jun 2022 — Jul 2023',
                'description' => 'Membangun website resmi yayasan menggunakan Laravel dari tahap perancangan hingga deployment. Mengembangkan Dashboard Admin dan CMS kustom untuk pengelolaan artikel, berita, dan transparansi donasi digital.',
                'badges' => ['Laravel Framework', 'Custom CMS', 'Digital Fundraising'],
                'sort_order' => 4,
                'is_current' => false,
            ],
        ];

        foreach ($experiences as $exp) {
            Experience::updateOrCreate(['company' => $exp['company'], 'role' => $exp['role']], $exp);
        }

        // 5. Education
        $educations = [
            [
                'school' => 'Politeknik IDN Bogor',
                'degree' => 'Software Engineering (Online)',
                'period' => '2024 — Sekarang',
                'notes' => 'Mahasiswa Aktif Semester 4. Menjalani perkuliahan sepenuhnya secara online di luar jam kerja untuk terus memperkuat fondasi rekayasa perangkat lunak tanpa mengganggu komitmen profesional.',
                'sort_order' => 1,
            ],
            [
                'school' => 'SMK Asyifa Depok',
                'degree' => 'Rekayasa Perangkat Lunak (Software Engineering)',
                'period' => '2019 — 2022',
                'notes' => 'Membangun fondasi komprehensif dalam pemrograman web, basis data terstruktur, algoritma perangkat lunak, dan metodologi pengembangan aplikasi.',
                'sort_order' => 2,
            ],
        ];

        foreach ($educations as $edu) {
            Education::updateOrCreate(['school' => $edu['school']], $edu);
        }

        // 6. Skills
        $skills = [
            // Web & App
            ['name' => 'PHP', 'category' => 'web_app', 'level' => 'Advanced', 'sort_order' => 1],
            ['name' => 'Laravel', 'category' => 'web_app', 'level' => 'Expert', 'sort_order' => 2],
            ['name' => 'JavaScript (ES6+)', 'category' => 'web_app', 'level' => 'Advanced', 'sort_order' => 3],
            ['name' => 'React.js', 'category' => 'web_app', 'level' => 'Proficient', 'sort_order' => 4],
            ['name' => 'Node.js', 'category' => 'web_app', 'level' => 'Intermediate', 'sort_order' => 5],
            ['name' => 'HTML5 & CSS3', 'category' => 'web_app', 'level' => 'Expert', 'sort_order' => 6],
            ['name' => 'Tailwind CSS', 'category' => 'web_app', 'level' => 'Advanced', 'sort_order' => 7],

            // Database & Architecture
            ['name' => 'MySQL', 'category' => 'database_arch', 'level' => 'Advanced', 'sort_order' => 8],
            ['name' => 'MongoDB', 'category' => 'database_arch', 'level' => 'Intermediate', 'sort_order' => 9],
            ['name' => 'Multi-tenant SaaS', 'category' => 'database_arch', 'level' => 'Advanced', 'sort_order' => 10],
            ['name' => 'PWA Systems', 'category' => 'database_arch', 'level' => 'Advanced', 'sort_order' => 11],
            ['name' => 'RBAC Permissions', 'category' => 'database_arch', 'level' => 'Advanced', 'sort_order' => 12],

            // Tools & Cloud
            ['name' => 'Git & GitHub', 'category' => 'tools_cloud', 'level' => 'Advanced', 'sort_order' => 13],
            ['name' => 'Docker', 'category' => 'tools_cloud', 'level' => 'Intermediate', 'sort_order' => 14],
            ['name' => 'cPanel & Laragon', 'category' => 'tools_cloud', 'level' => 'Advanced', 'sort_order' => 15],
            ['name' => 'Figma UI/UX', 'category' => 'tools_cloud', 'level' => 'Proficient', 'sort_order' => 16],
            ['name' => 'RESTful APIs', 'category' => 'tools_cloud', 'level' => 'Advanced', 'sort_order' => 17],
        ];

        foreach ($skills as $skill) {
            Skill::updateOrCreate(['name' => $skill['name']], $skill);
        }

        // 7. Services
        $services = [
            [
                'number_label' => '01 // FULL-STACK APPS',
                'title' => 'WEB & APP DEVELOPMENT',
                'description' => 'Engineering high-throughput, maintainable web applications using PHP, Laravel, React.js, Node.js, and modern REST APIs with seamless state management and responsive UI.',
                'tags' => ['Laravel', 'React.js', 'Node.js', 'Tailwind'],
                'sort_order' => 1,
            ],
            [
                'number_label' => '02 // ARCHITECTURE',
                'title' => 'SAAS & MANAGEMENT SYSTEMS',
                'description' => 'Architecting multi-tenant Software-as-a-Service, Role-Based Access Control (RBAC), live GPS geofencing perimeter validation, and automated PDF reporting engines.',
                'tags' => ['Multi-tenant', 'Geofencing', 'PDF Automation', 'MySQL'],
                'sort_order' => 2,
            ],
            [
                'number_label' => '03 // PROGRESSIVE TECH',
                'title' => 'PWA & DATABASE ENGINEERING',
                'description' => 'Building offline-ready Progressive Web Apps (PWA) with reliable background sync, relational & document database schemas (MySQL, MongoDB), and cloud deployment.',
                'tags' => ['PWA', 'MongoDB', 'Docker', 'cPanel / VPS'],
                'sort_order' => 3,
            ],
            [
                'number_label' => '04 // CREATIVE DIGITAL',
                'title' => 'LANDING PAGES & UI/UX',
                'description' => 'Translating Figma prototypes into ultra-fast, conversion-optimized landing pages with Core Web Vitals optimization, micro-animations, and complete SEO setup.',
                'tags' => ['Figma', 'Conversion Rate', 'SEO', 'Speed Opt'],
                'sort_order' => 4,
            ],
        ];

        foreach ($services as $srv) {
            Service::updateOrCreate(['number_label' => $srv['number_label']], $srv);
        }

        // 8. Work Processes
        $processes = [
            [
                'step_number' => '1.',
                'title' => 'DISCOVERY',
                'description' => 'I explore your business objectives, system workflows, operational constraints, and database relationships to ensure a perfect technical fit.',
                'is_featured' => false,
                'sort_order' => 1,
            ],
            [
                'step_number' => '2.',
                'title' => 'PLANNING',
                'description' => 'I thoroughly architect your database schemas, define modular API endpoints, and establish UI/UX wireframes for a clear, focused roadmap.',
                'is_featured' => true,
                'sort_order' => 2,
            ],
            [
                'step_number' => '3.',
                'title' => 'PRODUCTION',
                'description' => 'I build clean, maintainable code with precision, integrating backend business logic, responsive views, and robust security protocols.',
                'is_featured' => false,
                'sort_order' => 3,
            ],
            [
                'step_number' => '4.',
                'title' => 'DELIVERY',
                'description' => 'I meticulously test every workflow, deploy onto optimized production servers, and ensure seamless delivery with ongoing performance tuning.',
                'is_featured' => false,
                'sort_order' => 4,
            ],
        ];

        foreach ($processes as $proc) {
            WorkProcess::updateOrCreate(['step_number' => $proc['step_number']], $proc);
        }

        // 9. Milestones
        $milestones = [
            [
                'organization' => 'PT. BantuGrow Revolusi Digital',
                'project_name' => 'Multi-tenant SaaS Architecture with Geofencing & PWA',
                'tech_stack' => 'Laravel, React, PWA, MySQL',
                'period' => 'Nov 2024 — Present',
                'sort_order' => 1,
            ],
            [
                'organization' => 'Pondok Pesantren Abdan Syakuro',
                'project_name' => 'Tahfidz Quran Digital Memorization & PPDB System',
                'tech_stack' => 'Laravel, MySQL, JavaScript',
                'period' => 'Okt 2024 — Present',
                'sort_order' => 2,
            ],
            [
                'organization' => 'PT. Ahsan Sabila Mumtaza',
                'project_name' => 'End-to-End Umrah Travel Operations & Manifest Tracker',
                'tech_stack' => 'Laravel, REST API, cPanel',
                'period' => 'Sep 2023 — Okt 2024',
                'sort_order' => 3,
            ],
            [
                'organization' => 'Pondok Pesantren Al Qolam Yatim',
                'project_name' => 'Official Web Portal & Custom Content Management System',
                'tech_stack' => 'Laravel, PHP, Custom CMS',
                'period' => 'Jun 2022 — Jul 2023',
                'sort_order' => 4,
            ],
            [
                'organization' => 'Independent Client Projects',
                'project_name' => 'High-Converting Company Profiles & Landing Page Conversions',
                'tech_stack' => 'Tailwind, React, Figma, SEO',
                'period' => 'Continuous',
                'sort_order' => 5,
            ],
        ];

        foreach ($milestones as $m) {
            Milestone::updateOrCreate(['organization' => $m['organization']], $m);
        }

        // 10. Initial Client Testimonials
        $testimonials = [
            [
                'name' => 'Reza Pratama',
                'role_title' => 'Founder & Product Director',
                'company' => 'PT. BantuGrow Revolusi Digital',
                'project_tag' => 'SaaS Geofencing & PWA',
                'email' => null,
                'message' => 'Raihan demonstrated exceptional architectural discipline when engineering our multi-tenant SaaS progress system. From real-time GPS geofencing to offline PWA synchronization and automated PDF reporting, every module shipped on schedule with rock-solid reliability.',
                'avatar_color' => '#ff5500',
                'rating' => 5,
                'is_approved' => true,
                'is_pinned' => true,
            ],
            [
                'name' => 'Ustadz Ahmad Fauzi, M.Pd.',
                'role_title' => 'Head of Academic Operations',
                'company' => 'Pondok Pesantren Abdan Syakuro',
                'project_tag' => 'Tahfidz & Academic Portal',
                'email' => null,
                'message' => 'Sistem Manajemen Tahfidz dan portal PPDB yang dibangun sangat membantu digitalisasi pencatatan hafalan santri serta transparansi laporan akademik bagi wali santri. Antarmukanya intuitif dan sangat cepat diakses.',
                'avatar_color' => '#ff8800',
                'rating' => 5,
                'is_approved' => true,
                'is_pinned' => false,
            ],
            [
                'name' => 'H. Hendra Wijaya',
                'role_title' => 'Operations Director',
                'company' => 'PT. Ahsan Sabila Mumtaza',
                'project_tag' => 'Umrah Operations Platform',
                'email' => null,
                'message' => 'Transformasi sistem manifest keberangkatan dan pelacakan inventori jamaah berjalan sangat mulus. Kesalahan input manual berhasil ditekan hingga nol, dan performa portal tetap stabil di jam sibuk pendaftaran.',
                'avatar_color' => '#10b981',
                'rating' => 5,
                'is_approved' => true,
                'is_pinned' => false,
            ],
        ];

        foreach ($testimonials as $t) {
            Testimonial::updateOrCreate(['name' => $t['name']], $t);
        }
    }
}
