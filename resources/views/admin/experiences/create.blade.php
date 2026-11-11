@extends('layouts.admin')

@section('title', 'Tambah Pengalaman Kerja')

@section('content')
<div class="space-y-6">

  <div class="flex items-center justify-between pb-6 border-b border-gray-800">
    <div>
      <h1 class="text-3xl font-display tracking-wider text-white">TAMBAH PENGALAMAN KERJA</h1>
      <p class="text-xs font-mono text-gray-400 mt-1">Tambahkan posisi, nama perusahaan, periode, dan pencapaian.</p>
    </div>
    <a href="{{ route('admin.experiences.index') }}" class="text-xs font-mono text-gray-400 hover:text-white transition-colors">
      ← Kembali ke Daftar Pengalaman
    </a>
  </div>

  <form action="{{ route('admin.experiences.store') }}" method="POST" class="space-y-6">
    @csrf

    <div class="p-6 md:p-8 rounded-2xl bg-[#121218] border border-gray-800 shadow-xl space-y-6">
      
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
          <label class="block text-xs font-mono uppercase tracking-wider text-gray-400 mb-2">Posisi / Role *</label>
          <input type="text" name="role" value="{{ old('role') }}" required class="w-full px-4 py-3 rounded-xl bg-[#0a0a0d] border border-gray-700/80 text-white focus:outline-none focus:border-[#ff5500] text-sm font-mono" placeholder="Web Developer & Desain Grafis">
        </div>

        <div>
          <label class="block text-xs font-mono uppercase tracking-wider text-gray-400 mb-2">Nama Perusahaan / Organisasi *</label>
          <input type="text" name="company" value="{{ old('company') }}" required class="w-full px-4 py-3 rounded-xl bg-[#0a0a0d] border border-gray-700/80 text-white focus:outline-none focus:border-[#ff5500] text-sm font-mono" placeholder="PT. BantuGrow Revolusi Digital">
        </div>

        <div>
          <label class="block text-xs font-mono uppercase tracking-wider text-gray-400 mb-2">Periode / Rentang Waktu *</label>
          <input type="text" name="date_span" value="{{ old('date_span') }}" required class="w-full px-4 py-3 rounded-xl bg-[#0a0a0d] border border-gray-700/80 text-white focus:outline-none focus:border-[#ff5500] text-sm font-mono" placeholder="Nov 2024 — Present (Remote)">
        </div>

        <div>
          <label class="block text-xs font-mono uppercase tracking-wider text-gray-400 mb-2">Urutan Tampil (Sort Order)</label>
          <input type="number" name="sort_order" value="{{ old('sort_order', 1) }}" class="w-full px-4 py-3 rounded-xl bg-[#0a0a0d] border border-gray-700/80 text-white focus:outline-none focus:border-[#ff5500] text-sm font-mono">
        </div>

        <div class="md:col-span-2">
          <label class="block text-xs font-mono uppercase tracking-wider text-gray-400 mb-2">Deskripsi Tanggung Jawab & Dampak *</label>
          <textarea name="description" rows="4" required class="w-full px-4 py-3 rounded-xl bg-[#0a0a0d] border border-gray-700/80 text-white focus:outline-none focus:border-[#ff5500] text-sm font-mono leading-relaxed" placeholder="Jelaskan kontribusi Anda, sistem yang dibangun, arsitektur teknis, dan hasil yang dicapai...">{{ old('description') }}</textarea>
        </div>

        <div class="md:col-span-2">
          <label class="block text-xs font-mono uppercase tracking-wider text-gray-400 mb-2">Badges Tag (Pisahkan dengan koma)</label>
          <input type="text" name="badges_text" value="{{ old('badges_text') }}" class="w-full px-4 py-3 rounded-xl bg-[#0a0a0d] border border-gray-700/80 text-white focus:outline-none focus:border-[#ff5500] text-sm font-mono" placeholder="SaaS Ecosystem, Geofencing, PWA, PDF Automation, Landing Pages">
        </div>
      </div>

      <div class="pt-4 border-t border-gray-800 flex items-center justify-between">
        <label class="flex items-center gap-2 cursor-pointer select-none text-xs font-mono text-gray-300">
          <input type="checkbox" name="is_current" value="1" class="rounded text-[#ff5500] focus:ring-[#ff5500]">
          <span>Masih aktif bekerja di posisi ini (Present)</span>
        </label>

        <button type="submit" class="px-6 py-3 rounded-xl bg-[#ff5500] hover:bg-[#ff6e26] text-black font-bold font-mono text-xs uppercase tracking-wider transition-all shadow-lg shadow-[#ff5500]/25">
          SIMPAN PENGALAMAN ➔
        </button>
      </div>

    </div>
  </form>

</div>
@endsection

