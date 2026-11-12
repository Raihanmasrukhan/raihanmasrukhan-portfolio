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
     * Seed the application's database with accurate CV profile data.
     */
    public function run(): void
    {
        // 1. Admin User (never overwrite existing admin credentials on re-seed)
        User::firstOrCreate(
            ['email' => env('ADMIN_EMAIL', 'admin@raihan.dev')],
            [
                'name' => 'Raihan Adib Masrukhan',
                'password' => Hash::make(env('ADMIN_PASSWORD', 'password123')),
            ]
        );

        self::syncCvData();

        // 10. Initial Client Testimonials
        $testimonials = [
            [
                'name' => 'Reza Pratama',
                'role_title' => 'Founder & Product Director',
                'company' => 'PT BantuGrow Revolusi Digital',
                'project_tag' => 'SaaS Geofencing & PWA',
                'email' => null,
                'message' => 'Raihan menunjukkan kedisiplinan arsitektur yang sangat luar biasa saat membangun sistem SaaS progress manajemen kami. Dari validasi geofencing GPS presisi hingga PWA offline-sync dan automasi PDF, setiap modul terkirim tepat waktu dengan keandalan tinggi.',
                'avatar_color' => '#ff5500',
                'rating' => 5,
                'is_approved' => true,
                'is_pinned' => true,
            ],
            [
                'name' => 'Ustadz Ahmad Fauzi, M.Pd.',
                'role_title' => 'Kepala Operasional Akademik',
                'company' => 'Pondok Pesantren Abdan Syakuro',
                'project_tag' => 'Sistem Tahfidz & PPDB',
                'email' => null,
                'message' => 'Sistem Manajemen Tahfidz dan portal PPDB yang dibangun Mas Raihan sangat membantu digitalisasi pencatatan hafalan santri serta transparansi laporan akademik bagi wali santri. Administrasi jadi rapi dan bebas dari resiko kehilangan data.',
                'avatar_color' => '#ff8800',
                'rating' => 5,
                'is_approved' => true,
                'is_pinned' => false,
            ],
            [
                'name' => 'H. Hendra Wijaya',
                'role_title' => 'Direktur Operasional',
                'company' => 'PT Ahsan Sabila Mumtaza',
                'project_tag' => 'Sistem Travel Umrah',
                'email' => null,
                'message' => 'Transformasi sistem manifest keberangkatan dan pelacakan inventori jamaah berjalan sangat lancar. Human error dalam pendataan jamaah berhasil ditekan hingga nol, dan reservasi online jadi sangat cepat dan aman.',
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

    /**
     * Synchronize public portfolio profile, projects, experience, education, skills,
     * services, work processes, and milestones directly from the CV without touching
     * user credentials or visitor testimonials.
     */
    public static function syncCvData(): void
    {
        // 2. Profile & Site Settings (Directly from CV)
        $profileData = [
            'full_name' => 'Raihan Adib Masrukhan',
            'hero_title_line1' => 'RAIHAN',
            'hero_title_prefix' => 'MAS',
            'hero_title_suffix' => 'RUKHAN',
            'headline' => 'Web Developer & Digital Creative',
            'sub_headline' => 'Praktisi teknologi dan digital dengan pengalaman 3 tahun di bidang Web Developer dan Digital Creative, serta terbiasa mengeksekusi proyek dari hulu ke hilir. Membangun aplikasi web berkinerja tinggi, sistem SaaS kustom, sistem manajemen terintegrasi, dan landing page berkonversi tinggi.',
            'location' => 'Based in Depok & Bogor, ID',
            'availability_status' => 'Available for Projects',
            'is_available' => true,
            'avatar' => 'images/hero-cutout.png',
            'hero_specialties' => [
                'Full-Stack Web Dev (PHP/Laravel & React)',
                'Multi-tenant SaaS Architecture',
                'Geofencing & PWA Systems',
                'Custom Management Systems',
                'Digital Creative & UI/UX',
            ],
            'about_statement' => 'Praktisi teknologi dan digital dengan pengalaman 3 tahun di bidang <span class="text-bold">Web Developer</span> dan <span class="text-highlight">Digital Creative</span>, serta terbiasa mengeksekusi proyek dari hulu ke hilir. Saya adalah sosok yang punya rasa ingin tahu tinggi, mudah beradaptasi di berbagai situasi, dan memiliki semangat belajar yang besar. Sangat terbuka untuk berkontribusi di bidang apa pun serta selalu antusias mengeksplorasi hal-hal baru untuk memberikan solusi terbaik yang efisien dan solutif.',
            'phone' => '+6285864459552',
            'whatsapp_number' => '6285864459552',
            'email' => 'Raihanmasrukhan56@gmail.com',
            'github_url' => 'https://github.com/Raihanmasrukhan',
            'linkedin_url' => 'https://www.linkedin.com/in/raihan-masrukhan-22626b316/',
            'instagram_url' => null,
        ];

        $existingProfile = ProfileSetting::query()->first();

        if ($existingProfile) {
            $existingProfile->update($profileData);
        } else {
            ProfileSetting::create(['id' => 1, ...$profileData]);
        }

        // 3. Projects (Matched to CV work history & flagship systems)
        $projects = [
            [
                'title' => 'Digital Progress & Geofencing SaaS',
                'slug' => 'saas-progress',
                'category' => 'saas',
                'badge' => 'SaaS & PWA',
                'client' => 'PT. BantuGrow Revolusi Digital',
                'role' => 'Web Developer & Desain Grafis (Remote)',
                'timeline' => 'Nov 2024 – Mei 2026',
                'overview' => 'Ekosistem Software-as-a-Service (SaaS) dan sistem manajemen kemajuan proyek digital terintegrasi. Dilengkapi dengan validasi radius geofencing polygon GPS presisi tinggi untuk presensi lapangan, dukungan Progressive Web App (PWA) offline-first dengan sinkronisasi otomatis, kontrol akses multi-role (RBAC), serta automasi pembuatan laporan harian dalam format PDF.',
                'highlights' => [
                    'Validasi radius geofencing GPS real-time untuk pemantauan presensi dan progres tugas lapangan',
                    'Progressive Web App (PWA) offline-first dengan sinkronisasi background otomatis',
                    'Automasi pembuatan laporan eksekutif PDF & dashboard visual analitik',
                    'Arsitektur multi-tenant terisolasi dengan hak akses dinamis per perusahaan',
                ],
                'tech_stack' => ['PHP / Laravel', 'JavaScript / React', 'MySQL', 'PWA', 'Tailwind CSS', 'Geofencing API'],
                'image' => 'images/project-saas.jpg',
                'sort_order' => 1,
                'is_featured' => true,
            ],
            [
                'title' => 'Custom Management System & High-Converting Landing Pages',
                'slug' => 'bilcode-management',
                'category' => 'enterprise',
                'badge' => 'Custom Management System',
                'client' => 'PT Bilcode Global Teknologi',
                'role' => 'Web Developer',
                'timeline' => 'Okt 2025 – Nov 2026',
                'overview' => 'Pengembangan sistem manajemen kustom (custom management system) yang disesuaikan secara presisi dengan alur kerja spesifik dan kebutuhan operasional bisnis klien, serta perancangan landing page responsif berkinerja tinggi untuk kampanye pemasaran terpadu.',
                'highlights' => [
                    'Membangun custom management system yang merampingkan operasional bisnis klien dari hulu ke hilir',
                    'Optimalisasi antarmuka web yang intuitif untuk memaksimalkan konversi prospek (lead conversion)',
                    'Landing page responsif berkecepatan tinggi dengan integrasi form prospek dinamis',
                    'Efisiensi operasional klien meningkat signifikan berkat digitalisasi sistem yang terintegrasi',
                ],
                'tech_stack' => ['PHP / Laravel', 'React.js', 'Tailwind CSS', 'MySQL', 'REST API', 'Figma UI/UX'],
                'image' => 'images/project-landing.jpg',
                'sort_order' => 2,
                'is_featured' => true,
            ],
            [
                'title' => 'Aplikasi Sistem Manajemen Tahfidz & Portal PPDB',
                'slug' => 'tahfidz-portal',
                'category' => 'enterprise',
                'badge' => 'Sistem Akademik & PPDB',
                'client' => 'Pondok Pesantren Abdan Syakuro',
                'role' => 'Web Developer & Multimedia',
                'timeline' => 'Okt 2024 – Nov 2025',
                'overview' => 'Aplikasi Sistem Manajemen Tahfidz untuk digitalisasi pencatatan hafalan santri, pemantauan absensi terpadu, dan pelaporan akademik periodik bagi wali santri. Sekaligus pemeliharaan website profil pesantren sebagai pusat informasi utama Penerimaan Peserta Didik Baru (PPDB) yang terintegrasi dengan kampanye digital ads.',
                'highlights' => [
                    'Mengubah administrasi hafalan menjadi sistematis dan aman dari resiko kehilangan data fisik',
                    'Pencatatan hafalan granular per Juz, Surah, dan Ayat dengan laporan perkembangan real-time',
                    'Menjamin kelancaran dan kestabilan sistem pendaftaran santri baru (PPDB)',
                    'Perluasan brand awareness pesantren secara signifikan melalui integrasi multimedia dan iklan digital',
                ],
                'tech_stack' => ['Laravel', 'MySQL', 'JavaScript', 'Tailwind CSS', 'cPanel / Cloud VPS'],
                'image' => 'images/project-tahfidz.jpg',
                'sort_order' => 3,
                'is_featured' => true,
            ],
            [
                'title' => 'Aplikasi Sistem Manajemen Travel Umrah End-to-End',
                'slug' => 'umrah-travel',
                'category' => 'enterprise',
                'badge' => 'Travel ERP System',
                'client' => 'PT Ahsan Sabila Mumtaza (Ahsan Tour & Travel)',
                'role' => 'Web Developer',
                'timeline' => 'Sep 2022 – Okt 2024',
                'overview' => 'Aplikasi sistem manajemen travel umrah komprehensif end-to-end yang mencakup pengelolaan basis data jamaah terpusat, pembuatan manifest keberangkatan otomatis, manajemen inventori perlengkapan, pelacakan status pembayaran, dan sistem informasi paket wisata terintegrasi.',
                'highlights' => [
                    'Mempercepat operasional dan meminimalisir human error dalam pendataan ratusan jamaah',
                    'Automasi pembuatan manifest penerbangan, akomodasi hotel, dan logistik perlengkapan umrah',
                    'Pelacakan status pembayaran dan penerbitan bukti reservasi online yang cepat dan aman',
                    'Pengelolaan infrastruktur server dan performa website untuk stabilitas saat traffic tinggi',
                ],
                'tech_stack' => ['PHP / Laravel', 'MySQL', 'REST API', 'JavaScript', 'cPanel', 'Responsive UI'],
                'image' => 'images/project-travel.jpg',
                'sort_order' => 4,
                'is_featured' => true,
            ],
            [
                'title' => 'High-Converting Landing Pages & Performance Architecture',
                'slug' => 'agency-landing',
                'category' => 'landing',
                'badge' => 'Landing Page Conversion',
                'client' => 'PT BantuGrow & Clients',
                'role' => 'Web Developer & Digital Creative',
                'timeline' => '2024 – 2026',
                'overview' => 'Suite arsitektur landing page dan portal profil perusahaan dengan skor Core Web Vitals 98+, fokus pada kecepatan load sub-detik, hierarki visual berbasis konversi psikologis, dan integrasi WhatsApp API direct form.',
                'highlights' => [
                    'Skor Google Lighthouse 98+ dengan waktu render antarmuka instan',
                    'Penempatan elemen UI/UX strategis untuk memaksimalkan lead conversion rate',
                    'Optimasi lengkap SEO on-page, open-graph metadata, dan structured JSON-LD',
                    'Desain visual terstandarisasi Figma dengan layout responsif lintas monitor',
                ],
                'tech_stack' => ['HTML5 / CSS3', 'Modern JS', 'Tailwind CSS', 'Figma', 'SEO & Speed Opt'],
                'image' => 'images/project-landing.jpg',
                'sort_order' => 5,
                'is_featured' => true,
            ],
        ];

        foreach ($projects as $proj) {
            Project::updateOrCreate(['slug' => $proj['slug']], $proj);
        }

        // 4. Work Experiences (Exact CV Records)
        // Clear previous experience table to ensure clean sort order
        Experience::query()->delete();

        $experiences = [
            [
                'role' => 'Web Developer',
                'company' => 'PT Bilcode Global Teknologi',
                'date_span' => 'Okt 2025 – Nov 2026',
                'description' => "• Merancang dan mengembangkan landing page yang responsif dan berkinerja tinggi untuk mendukung berbagai kampanye pemasaran klien.\n• Membangun sistem manajemen kustom (custom management system) yang disesuaikan dengan alur kerja spesifik dan kebutuhan operasional bisnis klien.\n\nDampak: Memaksimalkan konversi prospek (lead conversion) klien melalui optimalisasi antarmuka web yang intuitif, serta meningkatkan efisiensi operasional bisnis klien berkat digitalisasi sistem yang terintegrasi.",
                'badges' => ['Custom Management System', 'Landing Page Conversion', 'Lead Conversion', 'Business Ops Optimization', 'Integrated Systems'],
                'sort_order' => 1,
                'is_current' => true,
            ],
            [
                'role' => 'Web Developer & Desain Grafis (Remote)',
                'company' => 'PT BantuGrow Revolusi Digital',
                'date_span' => 'Nov 2024 – Mei 2026',
                'description' => "• Membangun dan mengembangkan ekosistem Software-as-a-Service (SaaS) serta solusi digital terintegrasi, termasuk perancangan Digital Progress Management System kustom dengan fitur geofencing, dukungan PWA, dan automasi laporan PDF.\n• Mengelola ekosistem media sosial perusahaan secara end-to-end, mulai dari perancangan visual (desain grafis), video editing untuk publikasi konten rutin, hingga eksekusi dan optimasi kampanye periklanan digital (Digital Ads).\n\nDampak: Meningkatkan efisiensi dan transparansi operasional klien melalui sistem terintegrasi, serta memaksimalkan konversi dan lead generation dari kampanye pemasaran digital.",
                'badges' => ['SaaS Ecosystem', 'Geofencing Radius', 'Progressive Web App (PWA)', 'Automasi Laporan PDF', 'Digital Ads & Creative'],
                'sort_order' => 2,
                'is_current' => false,
            ],
            [
                'role' => 'Web Developer & Multimedia',
                'company' => 'Pondok Pesantren Abdan Syakuro',
                'date_span' => 'Okt 2024 – Nov 2025',
                'description' => "• Merancang, mengembangkan, dan mengelola Aplikasi Sistem Manajemen Tahfidz untuk digitalisasi pencatatan hafalan santri, pemantauan absensi, dan pelaporan akademik.\n• Memelihara dan mengoptimalkan kinerja website profil pesantren sebagai pusat informasi utama Penerimaan Peserta Didik Baru (PPDB).\n• Mendesain, mengedit, dan mengintegrasikan konten visual publikasi ke ekosistem digital pesantren, sekaligus mengelola periklanan digital (Ads).\n\nDampak: Mengubah administrasi hafalan menjadi sistematis dan aman dari kehilangan data, menjamin kelancaran sistem pendaftaran santri baru, serta memperluas brand awareness pesantren secara signifikan di media sosial.",
                'badges' => ['Sistem Manajemen Tahfidz', 'Website PPDB', 'Pelaporan Akademik', 'Multimedia & Ads', 'Keamanan Basis Data'],
                'sort_order' => 3,
                'is_current' => false,
            ],
            [
                'role' => 'Web Developer',
                'company' => 'PT Ahsan Sabila Mumtaza (Ahsan Tour & Travel)',
                'date_span' => 'Sep 2022 – Okt 2024',
                'description' => "• Membangun dan mengembangkan Aplikasi Sistem Manajemen Travel Umrah secara end-to-end yang mencakup pengelolaan data jamaah, manifest keberangkatan, inventori perlengkapan, dan pelacakan status pembayaran.\n• Mengelola infrastruktur server dan performa website perusahaan, serta mengintegrasikan aset visual promosi ke dalam platform web.\n• Melakukan pembaruan sistem informasi paket wisata dan umrah secara berkala.\n• Menjalankan kampanye media sosial secara end-to-end (desain, distribusi konten, pemasangan iklan).\n\nDampak: Mempercepat operasional dan meminimalisir human error dalam pendataan jamaah, memberikan pengalaman reservasi online yang cepat dan aman, serta memperluas jangkauan pasar untuk layanan paket tour.",
                'badges' => ['Sistem Travel Umrah', 'Manifest Keberangkatan', 'Inventori Jamaah', 'Infrastruktur Server', 'Reservasi Online'],
                'sort_order' => 4,
                'is_current' => false,
            ],
        ];

        foreach ($experiences as $exp) {
            Experience::create($exp);
        }

        // 5. Education (Exact CV Records)
        Education::query()->delete();

        $educations = [
            [
                'school' => 'Politeknik IDN Bogor',
                'degree' => 'Software Engineering (Online)',
                'period' => '2024 – Sekarang',
                'notes' => 'Status: Mahasiswa Aktif Semester 5 (Online). Menjalani perkuliahan sepenuhnya secara online di luar jam kerja. Jadwal studi yang fleksibel ini dipastikan tidak akan mengganggu produktivitas, komitmen, maupun jam operasional profesional perusahaan.',
                'sort_order' => 1,
            ],
            [
                'school' => 'SMK Asyifa Depok',
                'degree' => 'Rekayasa Perangkat Lunak (Software Engineering)',
                'period' => '2019 – 2022',
                'notes' => 'Mempelajari fondasi menyeluruh pemrograman perangkat lunak, pengembangan aplikasi web terstruktur, algoritma, basis data relasional, dan metodologi rekayasa sistem.',
                'sort_order' => 2,
            ],
        ];

        foreach ($educations as $edu) {
            Education::create($edu);
        }

        // 6. Skills (Grouped exactly as in CV)
        Skill::query()->delete();

        $skills = [
            // Web & App Development
            ['name' => 'PHP', 'category' => 'web_app', 'level' => 'Advanced', 'sort_order' => 1],
            ['name' => 'Laravel', 'category' => 'web_app', 'level' => 'Expert', 'sort_order' => 2],
            ['name' => 'JavaScript', 'category' => 'web_app', 'level' => 'Advanced', 'sort_order' => 3],
            ['name' => 'React.js', 'category' => 'web_app', 'level' => 'Proficient', 'sort_order' => 4],
            ['name' => 'Node.js', 'category' => 'web_app', 'level' => 'Intermediate', 'sort_order' => 5],
            ['name' => 'HTML5', 'category' => 'web_app', 'level' => 'Expert', 'sort_order' => 6],
            ['name' => 'CSS3', 'category' => 'web_app', 'level' => 'Expert', 'sort_order' => 7],
            ['name' => 'Tailwind CSS', 'category' => 'web_app', 'level' => 'Advanced', 'sort_order' => 8],

            // Database & Architecture
            ['name' => 'MySQL', 'category' => 'database_arch', 'level' => 'Advanced', 'sort_order' => 9],
            ['name' => 'MongoDB', 'category' => 'database_arch', 'level' => 'Intermediate', 'sort_order' => 10],
            ['name' => 'Multi-tenant SaaS Architecture', 'category' => 'database_arch', 'level' => 'Advanced', 'sort_order' => 11],
            ['name' => 'Progressive Web Apps (PWA)', 'category' => 'database_arch', 'level' => 'Advanced', 'sort_order' => 12],
            ['name' => 'Multi-role Access Control (RBAC)', 'category' => 'database_arch', 'level' => 'Advanced', 'sort_order' => 13],

            // Tools & Deployment
            ['name' => 'Git & GitHub', 'category' => 'tools_cloud', 'level' => 'Advanced', 'sort_order' => 14],
            ['name' => 'Docker', 'category' => 'tools_cloud', 'level' => 'Intermediate', 'sort_order' => 15],
            ['name' => 'VS Code', 'category' => 'tools_cloud', 'level' => 'Expert', 'sort_order' => 16],
            ['name' => 'cPanel', 'category' => 'tools_cloud', 'level' => 'Advanced', 'sort_order' => 17],
            ['name' => 'Laragon', 'category' => 'tools_cloud', 'level' => 'Advanced', 'sort_order' => 18],
            ['name' => 'Ngrok', 'category' => 'tools_cloud', 'level' => 'Intermediate', 'sort_order' => 19],
            ['name' => 'Figma (UI/UX)', 'category' => 'tools_cloud', 'level' => 'Advanced', 'sort_order' => 20],
            ['name' => 'Canva & CapCut', 'category' => 'tools_cloud', 'level' => 'Advanced', 'sort_order' => 21],
            ['name' => 'Google Workspace', 'category' => 'tools_cloud', 'level' => 'Advanced', 'sort_order' => 22],
        ];

        foreach ($skills as $skill) {
            Skill::create($skill);
        }

        // 7. Services
        $services = [
            [
                'number_label' => '01 // FULL-STACK APPS',
                'title' => 'WEB & APP DEVELOPMENT',
                'description' => 'Membangun aplikasi web berperforma tinggi dan terukur menggunakan ekosistem PHP, Laravel, JavaScript, React.js, Node.js, dan Tailwind CSS dengan arsitektur bersih dan responsif.',
                'tags' => ['Laravel', 'React.js', 'Node.js', 'Tailwind CSS'],
                'sort_order' => 1,
            ],
            [
                'number_label' => '02 // ARCHITECTURE',
                'title' => 'SAAS & CUSTOM MANAGEMENT',
                'description' => 'Merancang arsitektur Software-as-a-Service multi-tenant, kontrol akses berbasis peran (RBAC), validasi geofencing GPS real-time, dan automasi reporting PDF.',
                'tags' => ['Multi-tenant SaaS', 'Geofencing', 'Custom ERP', 'MySQL'],
                'sort_order' => 2,
            ],
            [
                'number_label' => '03 // PROGRESSIVE TECH',
                'title' => 'PWA & DATABASE ENGINEERING',
                'description' => 'Mengembangkan Progressive Web Apps (PWA) offline-first dengan sinkronisasi background, desain skema basis data relasional & non-relasional (MySQL, MongoDB), dan deployment server.',
                'tags' => ['PWA', 'MongoDB', 'Docker', 'cPanel / VPS'],
                'sort_order' => 3,
            ],
            [
                'number_label' => '04 // DIGITAL CREATIVE',
                'title' => 'LANDING PAGE & UI/UX',
                'description' => 'Merancang antarmuka web intuitif berbasis Figma, landing page berkonversi tinggi, pengoptimalan kecepatan Google Core Web Vitals, dan integrasi aset kreatif.',
                'tags' => ['Figma UI/UX', 'Lead Conversion', 'Canva / CapCut', 'SEO Opt'],
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
                'description' => 'Mengeksplorasi kebutuhan bisnis, alur kerja operasional, batasan sistem, dan struktur data untuk memastikan fondasi teknis yang tepat sasaran.',
                'is_featured' => false,
                'sort_order' => 1,
            ],
            [
                'step_number' => '2.',
                'title' => 'PLANNING',
                'description' => 'Merancang arsitektur basis data, pemetaan endpoint API modular, serta wireframe UI/UX Figma untuk roadmap pengembangan yang terarah.',
                'is_featured' => true,
                'sort_order' => 2,
            ],
            [
                'step_number' => '3.',
                'title' => 'PRODUCTION',
                'description' => 'Menulis kode bersih dan terstruktur dengan standar tinggi, mengintegrasikan backend bisnis logika, tampilan responsif, dan pengamanan sistem.',
                'is_featured' => false,
                'sort_order' => 3,
            ],
            [
                'step_number' => '4.',
                'title' => 'DELIVERY',
                'description' => 'Menguji menyeluruh setiap skenario alur kerja, mendistribusikan ke server produksi, dan memastikan pemeliharaan performa sistem berkelanjutan.',
                'is_featured' => false,
                'sort_order' => 4,
            ],
        ];

        foreach ($processes as $proc) {
            WorkProcess::updateOrCreate(['step_number' => $proc['step_number']], $proc);
        }

        // 9. Milestones (Direct Match to CV Companies & Deliverables)
        Milestone::query()->delete();

        $milestones = [
            [
                'organization' => 'PT Bilcode Global Teknologi',
                'project_name' => 'Custom Management System & High-Converting Landing Page',
                'tech_stack' => 'Laravel, React.js, Tailwind, MySQL',
                'period' => 'Okt 2025 – Nov 2026',
                'sort_order' => 1,
            ],
            [
                'organization' => 'PT BantuGrow Revolusi Digital',
                'project_name' => 'Multi-tenant SaaS Architecture with Geofencing & PWA',
                'tech_stack' => 'Laravel, React, PWA, MySQL, PDF Engine',
                'period' => 'Nov 2024 – Mei 2026',
                'sort_order' => 2,
            ],
            [
                'organization' => 'Pondok Pesantren Abdan Syakuro',
                'project_name' => 'Aplikasi Sistem Manajemen Tahfidz & Portal Resmi PPDB',
                'tech_stack' => 'Laravel, MySQL, JavaScript, Multimedia',
                'period' => 'Okt 2024 – Nov 2025',
                'sort_order' => 3,
            ],
            [
                'organization' => 'PT Ahsan Sabila Mumtaza (Ahsan Tour & Travel)',
                'project_name' => 'Aplikasi Sistem Manajemen Travel Umrah End-to-End',
                'tech_stack' => 'Laravel, REST API, cPanel, Manifest',
                'period' => 'Sep 2022 – Okt 2024',
                'sort_order' => 4,
            ],
        ];

        foreach ($milestones as $m) {
            Milestone::create($m);
        }
    }
}
