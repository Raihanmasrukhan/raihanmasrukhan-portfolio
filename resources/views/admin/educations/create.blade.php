@extends('layouts.admin')

@section('title', 'Tambah Pendidikan Baru')

@section('content')
<div class="space-y-6">

  <div class="flex items-center justify-between pb-6 border-b border-gray-800">
    <div>
      <h1 class="text-3xl font-display tracking-wider text-white">TAMBAH PENDIDIKAN BARU</h1>
      <p class="text-xs font-mono text-gray-400 mt-1">Tambahkan institusi, jurusan/gelar, periode, dan catatan prestasi.</p>
    </div>
    <a href="{{ route('admin.educations.index') }}" class="text-xs font-mono text-gray-400 hover:text-white transition-colors">
      ← Kembali ke Daftar Pendidikan
    </a>
  </div>

  <form action="{{ route('admin.educations.store') }}" method="POST" class="space-y-6">
    @csrf

    <div class="p-6 md:p-8 rounded-2xl bg-[#121218] border border-gray-800 shadow-xl space-y-6">
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
          <label class="block text-xs font-mono uppercase tracking-wider text-gray-400 mb-2">Nama Sekolah / Kampus *</label>
          <input type="text" name="school" value="{{ old('school') }}" required class="w-full px-4 py-3 rounded-xl bg-[#0a0a0d] border border-gray-700/80 text-white focus:outline-none focus:border-[#ff5500] text-sm font-mono" placeholder="Politeknik IDN Bogor">
        </div>

        <div>
          <label class="block text-xs font-mono uppercase tracking-wider text-gray-400 mb-2">Gelar / Jurusan *</label>
          <input type="text" name="degree" value="{{ old('degree') }}" required class="w-full px-4 py-3 rounded-xl bg-[#0a0a0d] border border-gray-700/80 text-white focus:outline-none focus:border-[#ff5500] text-sm font-mono" placeholder="Software Engineering (Online)">
        </div>

        <div>
          <label class="block text-xs font-mono uppercase tracking-wider text-gray-400 mb-2">Periode *</label>
          <input type="text" name="period" value="{{ old('period') }}" required class="w-full px-4 py-3 rounded-xl bg-[#0a0a0d] border border-gray-700/80 text-white focus:outline-none focus:border-[#ff5500] text-sm font-mono" placeholder="2024 — Sekarang">
        </div>

        <div>
          <label class="block text-xs font-mono uppercase tracking-wider text-gray-400 mb-2">Urutan Tampil (Sort Order)</label>
          <input type="number" name="sort_order" value="{{ old('sort_order', 1) }}" class="w-full px-4 py-3 rounded-xl bg-[#0a0a0d] border border-gray-700/80 text-white focus:outline-none focus:border-[#ff5500] text-sm font-mono">
        </div>

        <div class="md:col-span-2">
          <label class="block text-xs font-mono uppercase tracking-wider text-gray-400 mb-2">Keterangan / Catatan Aktivitas</label>
          <textarea name="notes" rows="4" class="w-full px-4 py-3 rounded-xl bg-[#0a0a0d] border border-gray-700/80 text-white focus:outline-none focus:border-[#ff5500] text-sm font-mono leading-relaxed" placeholder="Mahasiswa Aktif Semester 4... atau fokus pembelajaran...">{{ old('notes') }}</textarea>
        </div>
      </div>

      <div class="pt-4 border-t border-gray-800 flex justify-end">
        <button type="submit" class="px-6 py-3 rounded-xl bg-[#ff5500] hover:bg-[#ff6e26] text-black font-bold font-mono text-xs uppercase tracking-wider transition-all shadow-lg shadow-[#ff5500]/25">
          SIMPAN PENDIDIKAN ➔
        </button>
      </div>
    </div>
  </form>

</div>
@endsection

