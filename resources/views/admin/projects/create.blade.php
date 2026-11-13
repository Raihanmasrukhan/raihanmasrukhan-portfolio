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
          <select id="project-category-select" name="category" required class="w-full px-4 py-3 rounded-xl bg-[#0a0a0d] border border-gray-700/80 text-white focus:outline-none focus:border-[#ff5500] text-sm font-mono">
            @foreach(\App\Models\Project::categoryOptions() as $catKey => $catLabel)
              <option value="{{ $catKey }}" {{ old('category') == $catKey ? 'selected' : '' }}>{{ $catLabel }}</option>
            @endforeach
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
          <label id="role-label" class="block text-xs font-mono uppercase tracking-wider text-gray-400 mb-2">Peran / Role Anda</label>
          <input type="text" id="role-input" name="role" value="{{ old('role') }}" class="w-full px-4 py-3 rounded-xl bg-[#0a0a0d] border border-gray-700/80 text-white focus:outline-none focus:border-[#ff5500] text-sm font-mono" placeholder="Lead Full-Stack Developer">
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
          <label id="highlights-label" class="block text-xs font-mono uppercase tracking-wider text-gray-400 mb-2">Key Deliverables & Highlights (1 baris per poin)</label>
          <textarea id="highlights-input" name="highlights_text" rows="4" class="w-full px-4 py-3 rounded-xl bg-[#0a0a0d] border border-gray-700/80 text-white focus:outline-none focus:border-[#ff5500] text-sm font-mono leading-relaxed" placeholder="Real-time GPS geofencing radius validation&#10;Offline-first Progressive Web App (PWA)&#10;Automated executive PDF reporting engine">{{ old('highlights_text') }}</textarea>
        </div>

        <div class="md:col-span-2">
          <label id="tech-stack-label" class="block text-xs font-mono uppercase tracking-wider text-gray-400 mb-2">Technologies Used (Pisahkan dengan koma)</label>
          <input type="text" id="tech-stack-input" name="tech_stack_text" value="{{ old('tech_stack_text') }}" class="w-full px-4 py-3 rounded-xl bg-[#0a0a0d] border border-gray-700/80 text-white focus:outline-none focus:border-[#ff5500] text-sm font-mono" placeholder="PHP Laravel, React.js, MySQL, PWA, Tailwind CSS">
        </div>

        <!-- Dedicated Video Editing Fields -->
        <div id="video-fields-wrap" class="md:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-6 p-4 rounded-xl bg-[#0a0a0d]/80 border border-[#ff5500]/30" style="display:none;">
          <div class="md:col-span-2 flex items-center gap-2 pb-2 border-b border-gray-800 text-[#ff5500] text-xs font-mono font-bold uppercase">
            <span>🎬 Konfigurasi Media Video</span>
          </div>
          <div>
            <label class="block text-xs font-mono uppercase tracking-wider text-gray-300 mb-2">Link Video URL *</label>
            <input type="url" name="video_url" value="{{ old('video_url') }}" class="w-full px-4 py-3 rounded-xl bg-[#121218] border border-gray-700/80 text-white focus:outline-none focus:border-[#ff5500] text-sm font-mono" placeholder="https://www.youtube.com/watch?v=... atau link TikTok / Drive">
            <span class="text-[11px] font-mono text-gray-500 mt-1 block">Link YouTube otomatis disematkan sebagai pemutar video (player) di modal proyek.</span>
          </div>
          <div>
            <label class="block text-xs font-mono uppercase tracking-wider text-gray-300 mb-2">Durasi Video (Opsional)</label>
            <input type="text" name="video_duration" value="{{ old('video_duration') }}" class="w-full px-4 py-3 rounded-xl bg-[#121218] border border-gray-700/80 text-white focus:outline-none focus:border-[#ff5500] text-sm font-mono" placeholder="Contoh: 01:30 atau 60 Detik">
            <span class="text-[11px] font-mono text-gray-500 mt-1 block">Tampil sebagai badge durasi di kartu proyek portfolio.</span>
          </div>
        </div>

        <div data-image-upload>
          <label class="block text-xs font-mono uppercase tracking-wider text-gray-400 mb-2">Gambar Mockup / Thumbnail</label>
          <input type="file" name="image_file" accept="image/*" data-auto-compress-mb="5" class="w-full px-4 py-2.5 rounded-xl bg-[#0a0a0d] border border-gray-700/80 text-white text-xs font-mono">
          <p class="text-[11px] font-mono text-gray-500 mt-1.5" data-compress-status>Maksimal 5 MB — gambar di atas 5 MB otomatis dikompres sebelum di-upload.</p>
        </div>

        <div>
          <label class="block text-xs font-mono uppercase tracking-wider text-gray-400 mb-2">Urutan Tampil (Sort Order)</label>
          <input type="number" name="sort_order" value="{{ old('sort_order', 1) }}" class="w-full px-4 py-3 rounded-xl bg-[#0a0a0d] border border-gray-700/80 text-white focus:outline-none focus:border-[#ff5500] text-sm font-mono">
        </div>

        <div id="live-url-wrap">
          <label id="live-url-label" class="block text-xs font-mono uppercase tracking-wider text-gray-400 mb-2">Live Demo URL (Opsional)</label>
          <input type="url" id="live-url-input" name="live_url" value="{{ old('live_url') }}" class="w-full px-4 py-3 rounded-xl bg-[#0a0a0d] border border-gray-700/80 text-white focus:outline-none focus:border-[#ff5500] text-sm font-mono" placeholder="https://example.com">
        </div>

        <div id="github-url-wrap">
          <label id="github-url-label" class="block text-xs font-mono uppercase tracking-wider text-gray-400 mb-2">GitHub Repository URL (Opsional)</label>
          <input type="url" id="github-url-input" name="github_url" value="{{ old('github_url') }}" class="w-full px-4 py-3 rounded-xl bg-[#0a0a0d] border border-gray-700/80 text-white focus:outline-none focus:border-[#ff5500] text-sm font-mono" placeholder="https://github.com/...">
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

<script>
  document.addEventListener('DOMContentLoaded', () => {
    const categorySelect = document.getElementById('project-category-select');
    const roleLabel = document.getElementById('role-label');
    const roleInput = document.getElementById('role-input');
    const highlightsLabel = document.getElementById('highlights-label');
    const highlightsInput = document.getElementById('highlights-input');
    const techStackLabel = document.getElementById('tech-stack-label');
    const techStackInput = document.getElementById('tech-stack-input');
    const liveUrlWrap = document.getElementById('live-url-wrap');
    const liveUrlLabel = document.getElementById('live-url-label');
    const liveUrlInput = document.getElementById('live-url-input');
    const githubUrlWrap = document.getElementById('github-url-wrap');
    const videoFieldsWrap = document.getElementById('video-fields-wrap');

    function syncCategoryFields() {
      const cat = categorySelect.value;
      const isVideo = cat === 'video-editing';
      const isDesign = cat === 'design';

      // Video fields & GitHub visibility
      videoFieldsWrap.style.display = isVideo ? 'grid' : 'none';
      githubUrlWrap.style.display = (isVideo || isDesign) ? 'none' : 'block';

      if (isVideo) {
        roleLabel.textContent = 'Peran / Role Video *';
        roleInput.placeholder = 'Video Editor, Motion Graphic Designer, Colorist';
        techStackLabel.textContent = 'Software / Tools Video Editing (Pisahkan dengan koma)';
        techStackInput.placeholder = 'Adobe Premiere Pro, After Effects, CapCut, DaVinci Resolve';
        highlightsLabel.textContent = 'Key Deliverables & Scope Video Editing (Opsional, 1 baris per poin)';
        highlightsInput.placeholder = 'Color Grading & Audio Mastering\nVertical 9:16 Reels Optimization\nDynamic Kinetic Typography & Sound Effects';
        liveUrlWrap.style.display = 'none';
      } else if (isDesign) {
        roleLabel.textContent = 'Peran / Role Desain *';
        roleInput.placeholder = 'UI/UX Designer, Graphic Designer, Brand Identity Designer';
        techStackLabel.textContent = 'Software / Tools Desain (Pisahkan dengan koma)';
        techStackInput.placeholder = 'Figma, Adobe Photoshop, Adobe Illustrator, Canva';
        highlightsLabel.textContent = 'Key Deliverables & Scope Desain (Opsional, 1 baris per poin)';
        highlightsInput.placeholder = 'Design System & Component Library\nInteractive High-Fidelity Prototype\nVisual Brand Identity & Assets Export';
        liveUrlWrap.style.display = 'block';
        liveUrlLabel.textContent = 'Link Desain / Mockup URL (Figma / Behance / Google Drive / Live Demo)';
        liveUrlInput.placeholder = 'https://www.figma.com/file/... atau https://behance.net/...';
      } else {
        roleLabel.textContent = 'Peran / Role Anda';
        roleInput.placeholder = 'Lead Full-Stack Developer';
        techStackLabel.textContent = 'Technologies Used (Pisahkan dengan koma)';
        techStackInput.placeholder = 'PHP Laravel, React.js, MySQL, PWA, Tailwind CSS';
        highlightsLabel.textContent = 'Key Deliverables & Highlights (1 baris per poin)';
        highlightsInput.placeholder = 'Real-time GPS geofencing radius validation\nOffline-first Progressive Web App (PWA)\nAutomated executive PDF reporting engine';
        liveUrlWrap.style.display = 'block';
        liveUrlLabel.textContent = 'Live Demo URL (Opsional)';
        liveUrlInput.placeholder = 'https://example.com';
      }
    }

    categorySelect.addEventListener('change', syncCategoryFields);
    syncCategoryFields();
  });
</script>
@endsection
