@extends('layouts.admin')

@section('title', 'Profile & Site Settings')

@section('content')
<div class="space-y-8">

  <!-- Header -->
  <div class="flex items-center justify-between pb-6 border-b border-gray-800">
    <div>
      <h1 class="text-3xl font-display tracking-wider text-white">PROFILE & BIO SETTINGS</h1>
      <p class="text-xs font-mono text-gray-400 mt-1">
        Kelola identitas, foto profil hero, tipografi editorial, status ketersediaan, dan link kontak Anda.
      </p>
    </div>
    <a href="{{ route('portfolio') }}" target="_blank" class="px-4 py-2 rounded-xl bg-gray-900 border border-[#ff5500]/40 text-[#ff5500] hover:text-white font-mono text-xs uppercase tracking-wider flex items-center gap-1.5 transition-all">
      <span>Preview Website ↗</span>
    </a>
  </div>

  <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
    @csrf
    @method('PUT')

    <!-- Section 1: Hero Identity & Headline -->
    <div class="p-6 md:p-8 rounded-2xl bg-[#121218] border border-gray-800 shadow-xl space-y-6">
      <div class="flex items-center gap-3 pb-4 border-b border-gray-800/80">
        <span class="w-8 h-8 rounded-lg bg-[#ff5500]/10 text-[#ff5500] flex items-center justify-center font-mono font-bold text-sm">01</span>
        <div>
          <h2 class="text-lg font-display tracking-wider text-white">IDENTITAS & TIPOGRAFI HERO</h2>
          <span class="text-xs font-mono text-gray-500">Pengaturan nama besar dan teks headline pada halaman utama</span>
        </div>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
          <label class="block text-xs font-mono uppercase tracking-wider text-gray-400 mb-2">Nama Lengkap</label>
          <input type="text" name="full_name" value="{{ old('full_name', $profile->full_name) }}" required class="w-full px-4 py-3 rounded-xl bg-[#0a0a0d] border border-gray-700/80 text-white focus:outline-none focus:border-[#ff5500] text-sm font-mono">
        </div>

        <div>
          <label class="block text-xs font-mono uppercase tracking-wider text-gray-400 mb-2">Profesi / Headline Utama</label>
          <input type="text" name="headline" value="{{ old('headline', $profile->headline) }}" required class="w-full px-4 py-3 rounded-xl bg-[#0a0a0d] border border-gray-700/80 text-white focus:outline-none focus:border-[#ff5500] text-sm font-mono">
        </div>

        <!-- Hero Typography Breakdown -->
        <div>
          <label class="block text-xs font-mono uppercase tracking-wider text-gray-400 mb-2">Hero Line 1 (Huruf Besar Pertama)</label>
          <input type="text" name="hero_title_line1" value="{{ old('hero_title_line1', $profile->hero_title_line1) }}" required class="w-full px-4 py-3 rounded-xl bg-[#0a0a0d] border border-gray-700/80 text-white focus:outline-none focus:border-[#ff5500] text-sm font-mono" placeholder="RAIHAN">
          <span class="text-[11px] font-mono text-gray-500 mt-1 block">Tampil solid pada baris pertama nama di Hero</span>
        </div>

        <div class="grid grid-cols-2 gap-4">
          <div>
            <label class="block text-xs font-mono uppercase tracking-wider text-gray-400 mb-2">Hero Prefix (Outline Effect)</label>
            <input type="text" name="hero_title_prefix" value="{{ old('hero_title_prefix', $profile->hero_title_prefix) }}" required class="w-full px-4 py-3 rounded-xl bg-[#0a0a0d] border border-gray-700/80 text-white focus:outline-none focus:border-[#ff5500] text-sm font-mono" placeholder="MAS">
            <span class="text-[11px] font-mono text-gray-500 mt-1 block">Efek huruf bergaris luar</span>
          </div>
          <div>
            <label class="block text-xs font-mono uppercase tracking-wider text-gray-400 mb-2">Hero Suffix (Solid)</label>
            <input type="text" name="hero_title_suffix" value="{{ old('hero_title_suffix', $profile->hero_title_suffix) }}" required class="w-full px-4 py-3 rounded-xl bg-[#0a0a0d] border border-gray-700/80 text-white focus:outline-none focus:border-[#ff5500] text-sm font-mono" placeholder="RUKHAN">
            <span class="text-[11px] font-mono text-gray-500 mt-1 block">Teks solid penutup</span>
          </div>
        </div>

        <div>
          <label class="block text-xs font-mono uppercase tracking-wider text-gray-400 mb-2">Lokasi / Base</label>
          <input type="text" name="location" value="{{ old('location', $profile->location) }}" required class="w-full px-4 py-3 rounded-xl bg-[#0a0a0d] border border-gray-700/80 text-white focus:outline-none focus:border-[#ff5500] text-sm font-mono">
        </div>

        <div>
          <label class="block text-xs font-mono uppercase tracking-wider text-gray-400 mb-2">Status Ketersediaan</label>
          <div class="flex items-center gap-4">
            <input type="text" name="availability_status" value="{{ old('availability_status', $profile->availability_status) }}" required class="flex-1 px-4 py-3 rounded-xl bg-[#0a0a0d] border border-gray-700/80 text-white focus:outline-none focus:border-[#ff5500] text-sm font-mono">
            <label class="flex items-center gap-2 cursor-pointer select-none px-3 py-3 rounded-xl bg-[#0a0a0d] border border-gray-700/80 text-xs font-mono text-gray-300">
              <input type="checkbox" name="is_available" value="1" {{ $profile->is_available ? 'checked' : '' }} class="rounded text-[#ff5500] focus:ring-[#ff5500]">
              <span>Active Dot</span>
            </label>
          </div>
        </div>

        <div class="md:col-span-2">
          <label class="block text-xs font-mono uppercase tracking-wider text-gray-400 mb-2">Deskripsi Ringkas Hero (Sub-headline)</label>
          <textarea name="sub_headline" rows="3" class="w-full px-4 py-3 rounded-xl bg-[#0a0a0d] border border-gray-700/80 text-white focus:outline-none focus:border-[#ff5500] text-sm font-mono leading-relaxed">{{ old('sub_headline', $profile->sub_headline) }}</textarea>
        </div>
      </div>
    </div>

    <!-- Section 2: Personal Photo & Floating Specialties -->
    <div class="p-6 md:p-8 rounded-2xl bg-[#121218] border border-gray-800 shadow-xl space-y-6">
      <div class="flex items-center gap-3 pb-4 border-b border-gray-800/80">
        <span class="w-8 h-8 rounded-lg bg-[#ff5500]/10 text-[#ff5500] flex items-center justify-center font-mono font-bold text-sm">02</span>
        <div>
          <h2 class="text-lg font-display tracking-wider text-white">FOTO PRIBADI & SPECIALTIES PILL</h2>
          <span class="text-xs font-mono text-gray-500">Unggah foto hero studio dan kelola label floating specialties</span>
        </div>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-start">
        <!-- Photo Preview & Upload -->
        <div class="p-4 rounded-xl bg-[#0a0a0d] border border-gray-800 text-center">
          <div class="text-xs font-mono text-gray-400 uppercase mb-3">Foto Saat Ini</div>
          <div class="w-40 h-40 mx-auto rounded-2xl overflow-hidden border-2 border-[#ff5500]/40 shadow-xl mb-4 bg-gray-900">
            <img src="{{ asset($profile->avatar) }}" alt="Preview" class="w-full h-full object-cover" onerror="this.onerror=null; this.src='{{ asset('images/hero.jpg') }}';">
          </div>
          <label class="block text-xs font-mono text-[#ff5500] hover:underline cursor-pointer">
            <span>Pilih Foto Baru (JPG, PNG, WebP)</span>
            <input type="file" name="avatar_file" accept="image/*" class="hidden" onchange="const f=this.files[0];if(f){this.parentElement.querySelector('span').textContent=f.name;}">
          </label>
          <span class="text-[10px] font-mono text-gray-500 block mt-1">Maksimal 5MB. Disarankan rasio 1:1</span>
        </div>

        <!-- Floating Specialties Tags -->
        <div class="md:col-span-2">
          <label class="block text-xs font-mono uppercase tracking-wider text-gray-400 mb-2">
            Floating Specialties (1 item per baris)
          </label>
          <textarea name="hero_specialties_text" rows="7" class="w-full px-4 py-3 rounded-xl bg-[#0a0a0d] border border-gray-700/80 text-white focus:outline-none focus:border-[#ff5500] text-sm font-mono leading-relaxed" placeholder="Full-Stack Web Dev&#10;SaaS Architecture&#10;Laravel & React Ecosystem">{{ old('hero_specialties_text', is_array($profile->hero_specialties) ? implode("\n", $profile->hero_specialties) : '') }}</textarea>
          <span class="text-[11px] font-mono text-gray-500 mt-1 block">Item ini akan tampil pada kotak floating 'Specialties' di samping foto hero Anda.</span>
        </div>
      </div>
    </div>

    <!-- Section 3: About Me Editorial Statement -->
    <div class="p-6 md:p-8 rounded-2xl bg-[#121218] border border-gray-800 shadow-xl space-y-6">
      <div class="flex items-center gap-3 pb-4 border-b border-gray-800/80">
        <span class="w-8 h-8 rounded-lg bg-[#ff5500]/10 text-[#ff5500] flex items-center justify-center font-mono font-bold text-sm">03</span>
        <div>
          <h2 class="text-lg font-display tracking-wider text-white">SUMMARY / ABOUT ME STATEMENT</h2>
          <span class="text-xs font-mono text-gray-500">Pernyataan editorial utama di section About Me (bisa memakai tag HTML seperti &lt;span class="text-bold"&gt; atau &lt;span class="text-highlight"&gt;)</span>
        </div>
      </div>

      <div>
        <label class="block text-xs font-mono uppercase tracking-wider text-gray-400 mb-2">Editorial About Statement</label>
        <textarea name="about_statement" rows="5" class="w-full px-4 py-3 rounded-xl bg-[#0a0a0d] border border-gray-700/80 text-white focus:outline-none focus:border-[#ff5500] text-sm font-mono leading-relaxed" required>{{ old('about_statement', $profile->about_statement) }}</textarea>
        <span class="text-[11px] font-mono text-gray-500 mt-2 block">
          Tip: Gunakan <code class="text-[#ff5500]">&lt;span class="text-bold"&gt;kata tebal&lt;/span&gt;</code> dan <code class="text-[#ff5500]">&lt;span class="text-highlight"&gt;kata oranye&lt;/span&gt;</code> untuk styling editorial.
        </span>
      </div>
    </div>

    <!-- Section 4: Contact & Social Links -->
    <div class="p-6 md:p-8 rounded-2xl bg-[#121218] border border-gray-800 shadow-xl space-y-6">
      <div class="flex items-center gap-3 pb-4 border-b border-gray-800/80">
        <span class="w-8 h-8 rounded-lg bg-[#ff5500]/10 text-[#ff5500] flex items-center justify-center font-mono font-bold text-sm">04</span>
        <div>
          <h2 class="text-lg font-display tracking-wider text-white">LINK KONTAK & MEDIA SOSIAL</h2>
          <span class="text-xs font-mono text-gray-500">Nomor WhatsApp, email, GitHub, LinkedIn, dan CV</span>
        </div>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
          <label class="block text-xs font-mono uppercase tracking-wider text-gray-400 mb-2">WhatsApp / Telepon Tampil</label>
          <input type="text" name="phone" value="{{ old('phone', $profile->phone) }}" required class="w-full px-4 py-3 rounded-xl bg-[#0a0a0d] border border-gray-700/80 text-white focus:outline-none focus:border-[#ff5500] text-sm font-mono" placeholder="+62 858-6445-9552">
        </div>

        <div>
          <label class="block text-xs font-mono uppercase tracking-wider text-gray-400 mb-2">Nomor WhatsApp Api (Format: 628xxx)</label>
          <input type="text" name="whatsapp_number" value="{{ old('whatsapp_number', $profile->whatsapp_number) }}" required class="w-full px-4 py-3 rounded-xl bg-[#0a0a0d] border border-gray-700/80 text-white focus:outline-none focus:border-[#ff5500] text-sm font-mono" placeholder="6285864459552">
        </div>

        <div>
          <label class="block text-xs font-mono uppercase tracking-wider text-gray-400 mb-2">Email Address</label>
          <input type="email" name="email" value="{{ old('email', $profile->email) }}" required class="w-full px-4 py-3 rounded-xl bg-[#0a0a0d] border border-gray-700/80 text-white focus:outline-none focus:border-[#ff5500] text-sm font-mono" placeholder="Raihanmasrukhan56@gmail.com">
        </div>

        <div>
          <label class="block text-xs font-mono uppercase tracking-wider text-gray-400 mb-2">GitHub Profile URL</label>
          <input type="url" name="github_url" value="{{ old('github_url', $profile->github_url) }}" class="w-full px-4 py-3 rounded-xl bg-[#0a0a0d] border border-gray-700/80 text-white focus:outline-none focus:border-[#ff5500] text-sm font-mono" placeholder="https://github.com/Raihanmasrukhan">
        </div>

        <div>
          <label class="block text-xs font-mono uppercase tracking-wider text-gray-400 mb-2">LinkedIn Profile URL</label>
          <input type="url" name="linkedin_url" value="{{ old('linkedin_url', $profile->linkedin_url) }}" class="w-full px-4 py-3 rounded-xl bg-[#0a0a0d] border border-gray-700/80 text-white focus:outline-none focus:border-[#ff5500] text-sm font-mono" placeholder="https://linkedin.com/in/raihan-masrukhan-22626b316">
        </div>

        <div>
          <label class="block text-xs font-mono uppercase tracking-wider text-gray-400 mb-2">Instagram Profile URL (Opsional)</label>
          <input type="url" name="instagram_url" value="{{ old('instagram_url', $profile->instagram_url) }}" class="w-full px-4 py-3 rounded-xl bg-[#0a0a0d] border border-gray-700/80 text-white focus:outline-none focus:border-[#ff5500] text-sm font-mono">
        </div>

        <div class="md:col-span-2 pt-2 border-t border-gray-800/80 space-y-4">
          <div>
            <label class="block text-xs font-mono uppercase tracking-wider text-gray-400 mb-2">Link Download CV / Resume (URL Eksternal / Path File)</label>
            <input type="text" name="cv_url" value="{{ old('cv_url', $profile->cv_url) }}" class="w-full px-4 py-3 rounded-xl bg-[#0a0a0d] border border-gray-700/80 text-white focus:outline-none focus:border-[#ff5500] text-sm font-mono" placeholder="https://drive.google.com/file/... atau upload file CV di bawah">
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-4 items-start">
            <div>
              <label class="block text-xs font-mono uppercase tracking-wider text-gray-400 mb-2">Upload File Resume / CV (PDF / DOC / DOCX, Maks. 10MB)</label>
              <input type="file" name="cv_file" accept=".pdf,.doc,.docx,application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document" class="w-full px-3 py-2.5 rounded-xl bg-[#0a0a0d] border border-gray-700/80 text-gray-300 text-xs font-mono file:mr-4 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-[#ff5500] file:text-white hover:file:bg-[#e64d00]">
              <p class="mt-1.5 text-[11px] font-mono text-gray-500">Jika mengupload file baru, link CV akan otomatis diarahkan ke file ini.</p>
            </div>

            @if(!empty($profile->cv_url))
              @php
                $cvPreviewUrl = \Illuminate\Support\Str::startsWith($profile->cv_url, ['http://', 'https://', '/']) ? $profile->cv_url : asset($profile->cv_url);
              @endphp
              <div class="p-3.5 rounded-xl bg-[#0a0a0d] border border-gray-800 flex flex-col gap-2.5">
                <div class="flex items-center justify-between gap-2">
                  <span class="text-[11px] font-mono uppercase tracking-wider text-emerald-400">CV Aktif Terpasang</span>
                  <a href="{{ $cvPreviewUrl }}" target="_blank" rel="noopener" class="text-xs font-mono text-[#ff5500] hover:underline">Lihat / Unduh CV &rarr;</a>
                </div>
                <p class="text-xs font-mono text-gray-400 truncate">{{ $profile->cv_url }}</p>
                <label class="inline-flex items-center gap-2 text-xs font-mono text-red-400 cursor-pointer pt-1">
                  <input type="checkbox" name="remove_cv" value="1" class="rounded bg-[#111216] border-gray-700 text-red-500 focus:ring-red-500">
                  <span>Hapus CV saat ini</span>
                </label>
              </div>
            @endif
          </div>
        </div>
      </div>
    </div>

    <!-- Section 5: Security / Password Change -->
    <div class="p-6 md:p-8 rounded-2xl bg-[#121218] border border-gray-800 shadow-xl space-y-6">
      <div class="flex items-center gap-3 pb-4 border-b border-gray-800/80">
        <span class="w-8 h-8 rounded-lg bg-red-500/10 text-red-400 flex items-center justify-center font-mono font-bold text-sm">05</span>
        <div>
          <h2 class="text-lg font-display tracking-wider text-white">KEAMANAN AKUN ADMIN</h2>
          <span class="text-xs font-mono text-gray-500">Kosongkan jika tidak ingin mengubah password akun admin</span>
        </div>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
          <label class="block text-xs font-mono uppercase tracking-wider text-gray-400 mb-2">Password Baru</label>
          <input type="password" name="new_password" class="w-full px-4 py-3 rounded-xl bg-[#0a0a0d] border border-gray-700/80 text-white focus:outline-none focus:border-[#ff5500] text-sm font-mono" placeholder="Minimal 6 karakter">
        </div>

        <div>
          <label class="block text-xs font-mono uppercase tracking-wider text-gray-400 mb-2">Konfirmasi Password Baru</label>
          <input type="password" name="new_password_confirmation" class="w-full px-4 py-3 rounded-xl bg-[#0a0a0d] border border-gray-700/80 text-white focus:outline-none focus:border-[#ff5500] text-sm font-mono" placeholder="Ketik ulang password baru">
        </div>
      </div>
    </div>

    <!-- Submit Button Floating Bar -->
    <div class="sticky bottom-4 z-30 p-4 rounded-2xl bg-[#121218]/95 border border-[#ff5500]/50 backdrop-blur-xl flex items-center justify-between shadow-2xl">
      <span class="text-xs font-mono text-gray-400">Pastikan semua data sudah sesuai sebelum menyimpan</span>
      <button type="submit" class="px-8 py-3 rounded-xl bg-[#ff5500] hover:bg-[#ff6e26] text-black font-bold font-mono text-xs uppercase tracking-wider transition-all shadow-lg shadow-[#ff5500]/25 cursor-pointer">
        SIMPAN SEMUA PERUBAHAN PROFIL ➔
      </button>
    </div>

  </form>
</div>
@endsection

