@extends('layouts.admin')

@section('title', 'Tambah Project Baru')

@section('content')
<div class="space-y-6">

  <div class="flex items-center justify-between pb-6 border-b border-gray-800">
    <div>
      <h1 class="text-3xl font-display tracking-wider text-white">TAMBAH PROJECT BARU</h1>
      <p class="text-xs font-mono text-gray-400 mt-1">Lengkapi form berikut untuk mempublikasikan proyek baru di portfolio.</p>
    </div>
    <a href="{{ route('admin.projects.index') }}" class="text-xs font-mono text-gray-400 hover:text-white transition-colors">
      ← Kembali ke Daftar Proyek
    </a>
  </div>

  <form action="{{ route('admin.projects.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
    @csrf

    <div class="p-6 md:p-8 rounded-2xl bg-[#121218] border border-gray-800 shadow-xl space-y-6">
      
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
          <label class="block text-xs font-mono uppercase tracking-wider text-gray-400 mb-2">Judul Proyek *</label>
          <input type="text" name="title" value="{{ old('title') }}" required class="w-full px-4 py-3 rounded-xl bg-[#0a0a0d] border border-gray-700/80 text-white focus:outline-none focus:border-[#ff5500] text-sm font-mono" placeholder="Digital Progress & Geofencing SaaS">
        </div>

        <div>
          <label class="block text-xs font-mono uppercase tracking-wider text-gray-400 mb-2">Filter Kategori *</label>
          <select name="category" required class="w-full px-4 py-3 rounded-xl bg-[#0a0a0d] border border-gray-700/80 text-white focus:outline-none focus:border-[#ff5500] text-sm font-mono">
            <option value="saas" {{ old('category') == 'saas' ? 'selected' : '' }}>SaaS Platforms</option>
            <option value="enterprise" {{ old('category') == 'enterprise' ? 'selected' : '' }}>Management Systems</option>
            <option value="landing" {{ old('category') == 'landing' ? 'selected' : '' }}>Landing & CMS</option>
            <option value="other" {{ old('category') == 'other' ? 'selected' : '' }}>Other Applications</option>
          </select>
        </div>

        <div>
          <label class="block text-xs font-mono uppercase tracking-wider text-gray-400 mb-2">Badge Label (Tampil di kartu)</label>
          <input type="text" name="badge" value="{{ old('badge') }}" class="w-full px-4 py-3 rounded-xl bg-[#0a0a0d] border border-gray-700/80 text-white focus:outline-none focus:border-[#ff5500] text-sm font-mono" placeholder="SaaS & PWA">
        </div>

        <div>
          <label class="block text-xs font-mono uppercase tracking-wider text-gray-400 mb-2">Klien / Organisasi</label>
          <input type="text" name="client" value="{{ old('client') }}" class="w-full px-4 py-3 rounded-xl bg-[#0a0a0d] border border-gray-700/80 text-white focus:outline-none focus:border-[#ff5500] text-sm font-mono" placeholder="PT. BantuGrow Revolusi Digital">
        </div>

        <div>
          <label class="block text-xs font-mono uppercase tracking-wider text-gray-400 mb-2">Peran / Role Anda</label>
          <input type="text" name="role" value="{{ old('role') }}" class="w-full px-4 py-3 rounded-xl bg-[#0a0a0d] border border-gray-700/80 text-white focus:outline-none focus:border-[#ff5500] text-sm font-mono" placeholder="Lead Full-Stack Developer">
        </div>

        <div>
          <label class="block text-xs font-mono uppercase tracking-wider text-gray-400 mb-2">Timeline Pengerjaan</label>
          <input type="text" name="timeline" value="{{ old('timeline') }}" class="w-full px-4 py-3 rounded-xl bg-[#0a0a0d] border border-gray-700/80 text-white focus:outline-none focus:border-[#ff5500] text-sm font-mono" placeholder="Nov 2024 – Present">
        </div>

        <div class="md:col-span-2">
          <label class="block text-xs font-mono uppercase tracking-wider text-gray-400 mb-2">Overview / Deskripsi Ringkas *</label>
          <textarea name="overview" rows="3" required class="w-full px-4 py-3 rounded-xl bg-[#0a0a0d] border border-gray-700/80 text-white focus:outline-none focus:border-[#ff5500] text-sm font-mono leading-relaxed" placeholder="Jelaskan gambaran umum proyek, tantangan bisnis, dan arsitektur yang dibangun...">{{ old('overview') }}</textarea>
        </div>

        <div class="md:col-span-2">
          <label class="block text-xs font-mono uppercase tracking-wider text-gray-400 mb-2">Key Deliverables & Highlights (1 baris per poin)</label>
          <textarea name="highlights_text" rows="4" class="w-full px-4 py-3 rounded-xl bg-[#0a0a0d] border border-gray-700/80 text-white focus:outline-none focus:border-[#ff5500] text-sm font-mono leading-relaxed" placeholder="Real-time GPS geofencing radius validation&#10;Offline-first Progressive Web App (PWA)&#10;Automated executive PDF reporting engine">{{ old('highlights_text') }}</textarea>
        </div>

        <div class="md:col-span-2">
          <label class="block text-xs font-mono uppercase tracking-wider text-gray-400 mb-2">Technologies Used (Pisahkan dengan koma atau baris baru)</label>
          <input type="text" name="tech_stack_text" value="{{ old('tech_stack_text') }}" class="w-full px-4 py-3 rounded-xl bg-[#0a0a0d] border border-gray-700/80 text-white focus:outline-none focus:border-[#ff5500] text-sm font-mono" placeholder="PHP Laravel, React.js, MySQL, PWA, Tailwind CSS">
        </div>

        <div>
          <label class="block text-xs font-mono uppercase tracking-wider text-gray-400 mb-2">Gambar Mockup / Screenshot</label>
          <input type="file" name="image_file" accept="image/*" class="w-full px-4 py-2.5 rounded-xl bg-[#0a0a0d] border border-gray-700/80 text-white text-xs font-mono">
        </div>

        <div>
          <label class="block text-xs font-mono uppercase tracking-wider text-gray-400 mb-2">Urutan Tampil (Sort Order)</label>
          <input type="number" name="sort_order" value="{{ old('sort_order', 1) }}" class="w-full px-4 py-3 rounded-xl bg-[#0a0a0d] border border-gray-700/80 text-white focus:outline-none focus:border-[#ff5500] text-sm font-mono">
        </div>

        <div>
          <label class="block text-xs font-mono uppercase tracking-wider text-gray-400 mb-2">Live Demo URL (Opsional)</label>
          <input type="url" name="live_url" value="{{ old('live_url') }}" class="w-full px-4 py-3 rounded-xl bg-[#0a0a0d] border border-gray-700/80 text-white focus:outline-none focus:border-[#ff5500] text-sm font-mono" placeholder="https://example.com">
        </div>

        <div>
          <label class="block text-xs font-mono uppercase tracking-wider text-gray-400 mb-2">GitHub Repository URL (Opsional)</label>
          <input type="url" name="github_url" value="{{ old('github_url') }}" class="w-full px-4 py-3 rounded-xl bg-[#0a0a0d] border border-gray-700/80 text-white focus:outline-none focus:border-[#ff5500] text-sm font-mono" placeholder="https://github.com/...">
        </div>
      </div>

      <div class="pt-4 border-t border-gray-800 flex items-center justify-between">
        <label class="flex items-center gap-2 cursor-pointer select-none text-xs font-mono text-gray-300">
          <input type="checkbox" name="is_featured" value="1" checked class="rounded text-[#ff5500] focus:ring-[#ff5500]">
          <span>Tampilkan sebagai Featured Project di Portfolio</span>
        </label>

        <button type="submit" class="px-6 py-3 rounded-xl bg-[#ff5500] hover:bg-[#ff6e26] text-black font-bold font-mono text-xs uppercase tracking-wider transition-all shadow-lg shadow-[#ff5500]/25">
          SIMPAN PROJECT ➔
        </button>
      </div>

    </div>
  </form>

</div>
@endsection

