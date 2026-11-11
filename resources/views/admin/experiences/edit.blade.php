@extends('layouts.admin')

@section('title', 'Edit Pengalaman Kerja')

@section('content')
<div class="space-y-6">

  <div class="flex items-center justify-between pb-6 border-b border-gray-800">
    <div>
      <h1 class="text-3xl font-display tracking-wider text-white">EDIT PENGALAMAN: {{ strtoupper($experience->company) }}</h1>
      <p class="text-xs font-mono text-gray-400 mt-1">Perbarui data karir dan deskripsi pencapaian.</p>
    </div>
    <a href="{{ route('admin.experiences.index') }}" class="text-xs font-mono text-gray-400 hover:text-white transition-colors">
      ← Kembali ke Daftar Pengalaman
    </a>
  </div>

  <form action="{{ route('admin.experiences.update', $experience) }}" method="POST" class="space-y-6">
    @csrf
    @method('PUT')

    <div class="p-6 md:p-8 rounded-2xl bg-[#121218] border border-gray-800 shadow-xl space-y-6">
      
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
          <label class="block text-xs font-mono uppercase tracking-wider text-gray-400 mb-2">Posisi / Role *</label>
          <input type="text" name="role" value="{{ old('role', $experience->role) }}" required class="w-full px-4 py-3 rounded-xl bg-[#0a0a0d] border border-gray-700/80 text-white focus:outline-none focus:border-[#ff5500] text-sm font-mono">
        </div>

        <div>
          <label class="block text-xs font-mono uppercase tracking-wider text-gray-400 mb-2">Nama Perusahaan / Organisasi *</label>
          <input type="text" name="company" value="{{ old('company', $experience->company) }}" required class="w-full px-4 py-3 rounded-xl bg-[#0a0a0d] border border-gray-700/80 text-white focus:outline-none focus:border-[#ff5500] text-sm font-mono">
        </div>

        <div>
          <label class="block text-xs font-mono uppercase tracking-wider text-gray-400 mb-2">Periode / Rentang Waktu *</label>
          <input type="text" name="date_span" value="{{ old('date_span', $experience->date_span) }}" required class="w-full px-4 py-3 rounded-xl bg-[#0a0a0d] border border-gray-700/80 text-white focus:outline-none focus:border-[#ff5500] text-sm font-mono">
        </div>

        <div>
          <label class="block text-xs font-mono uppercase tracking-wider text-gray-400 mb-2">Urutan Tampil (Sort Order)</label>
          <input type="number" name="sort_order" value="{{ old('sort_order', $experience->sort_order) }}" class="w-full px-4 py-3 rounded-xl bg-[#0a0a0d] border border-gray-700/80 text-white focus:outline-none focus:border-[#ff5500] text-sm font-mono">
        </div>

        <div class="md:col-span-2">
          <label class="block text-xs font-mono uppercase tracking-wider text-gray-400 mb-2">Deskripsi Tanggung Jawab & Dampak *</label>
          <textarea name="description" rows="4" required class="w-full px-4 py-3 rounded-xl bg-[#0a0a0d] border border-gray-700/80 text-white focus:outline-none focus:border-[#ff5500] text-sm font-mono leading-relaxed">{{ old('description', $experience->description) }}</textarea>
        </div>

        <div class="md:col-span-2">
          <label class="block text-xs font-mono uppercase tracking-wider text-gray-400 mb-2">Badges Tag (Pisahkan dengan koma)</label>
          <input type="text" name="badges_text" value="{{ old('badges_text', is_array($experience->badges) ? implode(', ', $experience->badges) : '') }}" class="w-full px-4 py-3 rounded-xl bg-[#0a0a0d] border border-gray-700/80 text-white focus:outline-none focus:border-[#ff5500] text-sm font-mono">
        </div>
      </div>

      <div class="pt-4 border-t border-gray-800 flex items-center justify-between">
        <label class="flex items-center gap-2 cursor-pointer select-none text-xs font-mono text-gray-300">
          <input type="checkbox" name="is_current" value="1" {{ $experience->is_current ? 'checked' : '' }} class="rounded text-[#ff5500] focus:ring-[#ff5500]">
          <span>Masih aktif bekerja di posisi ini (Present)</span>
        </label>

        <button type="submit" class="px-6 py-3 rounded-xl bg-[#ff5500] hover:bg-[#ff6e26] text-black font-bold font-mono text-xs uppercase tracking-wider transition-all shadow-lg shadow-[#ff5500]/25">
          SIMPAN PERUBAHAN ➔
        </button>
      </div>

    </div>
  </form>

</div>
@endsection

