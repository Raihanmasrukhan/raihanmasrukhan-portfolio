# Portfolio — Raihan Adib Masrukhan
**Full-Stack Web Developer & Software Engineer**
*Powered by Laravel 11/12, Tailwind CSS, SQLite, and Vanilla JS*

Sebuah website portfolio dinamis bertema *Editorial Brutalist Dark Mode with Vivid Electric Orange Accent* yang kini telah berekspansi menjadi aplikasi full-stack **Laravel & Tailwind CSS** lengkap dengan **Admin Dashboard** untuk mengelola seluruh konten dan fitur secara dinamis dan real-time.

---

## 🚀 Fitur & Kemampuan Baru

### 1. ⚙️ Admin Dashboard Komprehensif (`/admin`)
- **Profile & Bio Management**:
  - Ganti nama lengkap, tipografi hero (*outline effect*), headline, sub-headline.
  - Unggah foto pribadi hero portrait baru (*automatic storage symlink*).
  - Kelola *Floating Specialties Pill* (1 item per baris).
  - Edit status ketersediaan (*live status dot*).
  - Kelola *About Me Editorial Statement* dengan format HTML.
  - Atur nomor WhatsApp, email, link GitHub, LinkedIn, Instagram, dan link CV/Resume.
  - Keamanan akun: ubah password akun admin.
- **Projects Portfolio Showcase (CRUD)**:
  - Tambah, edit, hapus proyek studi kasus.
  - Upload gambar mockup / screenshot.
  - Pengelompokan filter kategori (*SaaS Platforms*, *Management Systems*, *Landing & CMS*).
  - Input tags teknologi dan bullet points deliverables.
  - Link live demo dan repositori GitHub.
- **Work Experience (CRUD)**:
  - Kelola riwayat karir, posisi, perusahaan, status *Present*, deskripsi dampak, dan badge pills.
- **Academic Education (CRUD)**:
  - Kelola data sekolah/kampus, gelar, periode, dan catatan prestasi akademik.
- **Skill Stack Matrix (CRUD)**:
  - Form tambah cepat skill berdasarkan kategori (*Web & App*, *Database & Architecture*, *Tools, Cloud & Creative*).
- **Services & Work Process (CRUD)**:
  - Atur layanan (*What I Offer*) dan tahapan alur kerja (*How I Work*).
- **Proven Milestones Table (CRUD)**:
  - Kelola data tabel rekam jejak deliverable proyek.
- **Client Testimonials & Endorsements (CRUD)**:
  - Kelola testimoni klien profesional beserta jabatan, perusahaan/institusi, tag proyek, rating bintang, status publish/draft, dan fitur *Featured* badge.
- **Inbox Pesan Kontak**:
  - Semua pesan dari form website tersimpan ke database.
  - Tombol aksi balas langsung via WhatsApp dan Email.
- **Visitor Analytics**:
  - Pencatatan hit kunjungan website total dan hari ini.

### 2. 🎨 Frontend Dinamis (Editorial Brutalist + Tailwind)
- Semua data ditarik secara dinamis dari database.
- **Section Client Testimonials**: Menampilkan ulasan dan rekomendasi terkurasi dari klien, founder, dan mitra institusi.
- Form kontak terintegrasi: Menyimpan pesan ke database admin sekaligus membuka obrolan langsung ke WhatsApp.
- Custom magnetic cursor, live WIB clock real-time, scroll reveal animations, dan modal lightbox project.

---

## ⚡ Cara Menjalankan

### 1. Menjalankan Server Lokal Laravel
Buka terminal di folder proyek:
```bash
# Jalankan server Laravel:
php artisan serve --port=8080
```
Website portfolio dapat diakses di: **`http://localhost:8080`**

### 2. Akses Admin Dashboard
Buka browser dan akses:
👉 **`http://localhost:8080/admin`** atau **`http://localhost:8080/login`**

**Default Kredensial Login Admin:**
- **Email:** `admin@raihan.dev`
- **Password:** `password123`

*(Kredensial dan password dapat diubah kapan saja di menu Profile & Keamanan Dashboard).*

### 3. Build Aset CSS / Tailwind (Vite)
Jika melakukan perubahan styling Tailwind:
```bash
# Untuk mode development (live reload):
npm run dev

# Untuk build produksi:
npm run build
```

---

## 📁 Struktur Utama Proyek
```
Reyy-Portfolio/
├── app/
│   ├── Http/Controllers/
│   │   ├── PortfolioController.php      # Controller publik (Portfolio, Guestbook, Contact)
│   │   ├── AuthController.php           # Autentikasi Admin
│   │   └── Admin/                       # Dashboard Controllers (Profile, Project, Exp, Edu, Skill, Guestbook, Inbox, dll.)
│   └── Models/                          # Eloquent Models (Project, Experience, Education, Skill, Guestbook, dll.)
├── database/
│   ├── migrations/                      # 11 skema tabel database
│   ├── seeders/DatabaseSeeder.php       # Seeder lengkap kredensial & data CV Raihan
│   └── database.sqlite                  # SQLite Database
├── resources/
│   ├── views/
│   │   ├── portfolio.blade.php          # Frontend utama dinamis
│   │   ├── auth/login.blade.php         # Halaman login admin editorial brutalist
│   │   ├── layouts/admin.blade.php      # Layout dashboard admin modern dark-mode
│   │   └── admin/                       # Template manajemen CRUD dashboard
│   └── css/app.css                      # Tailwind CSS v4
├── routes/web.php                       # Definisi seluruh rute publik & admin
└── public/
    └── assets/                          # Style CSS, Vanilla JS cursor/clock, dan gambar proyek
```
