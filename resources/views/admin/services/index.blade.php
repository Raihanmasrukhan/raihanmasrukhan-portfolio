@extends('layouts.admin')

@section('title', 'Manage Services (What I Offer)')

@section('content')
<div class="space-y-6">

  <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-gray-800">
    <div>
      <h1 class="text-3xl font-display tracking-wider text-white">SERVICES & WHAT I OFFER</h1>
      <p class="text-xs font-mono text-gray-400 mt-1">Kelola 4 pilar layanan utama yang ditawarkan kepada klien.</p>
    </div>
  </div>

  <!-- Add New Service -->
  <div class="p-6 rounded-2xl bg-[#121218] border border-gray-800 shadow-xl">
    <h2 class="text-sm font-display tracking-wider text-white mb-4">+ TAMBAH LAYANAN BARU</h2>
    <form action="{{ route('admin.services.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-4">
      @csrf
      <div>
        <label class="block text-xs font-mono text-gray-400 mb-1">Kode / Nomor Label *</label>
        <input type="text" name="number_label" required class="w-full px-4 py-2.5 rounded-xl bg-[#0a0a0d] border border-gray-700/80 text-white text-xs font-mono" placeholder="01 // FULL-STACK APPS">
      </div>
      <div>
        <label class="block text-xs font-mono text-gray-400 mb-1">Judul Layanan *</label>
        <input type="text" name="title" required class="w-full px-4 py-2.5 rounded-xl bg-[#0a0a0d] border border-gray-700/80 text-white text-xs font-mono" placeholder="WEB & APP DEVELOPMENT">
      </div>
      <div class="md:col-span-2">
        <label class="block text-xs font-mono text-gray-400 mb-1">Deskripsi Layanan *</label>
        <textarea name="description" rows="2" required class="w-full px-4 py-2.5 rounded-xl bg-[#0a0a0d] border border-gray-700/80 text-white text-xs font-mono" placeholder="Deskripsikan layanan..."></textarea>
      </div>
      <div>
        <label class="block text-xs font-mono text-gray-400 mb-1">Tech Tags (Pisahkan koma)</label>
        <input type="text" name="tags_text" class="w-full px-4 py-2.5 rounded-xl bg-[#0a0a0d] border border-gray-700/80 text-white text-xs font-mono" placeholder="Laravel, React, Node.js">
      </div>
      <div>
        <label class="block text-xs font-mono text-gray-400 mb-1">Urutan</label>
        <input type="number" name="sort_order" value="1" class="w-full px-4 py-2.5 rounded-xl bg-[#0a0a0d] border border-gray-700/80 text-white text-xs font-mono">
      </div>
      <div class="md:col-span-2 flex justify-end">
        <button type="submit" class="px-5 py-2.5 rounded-xl bg-[#ff5500] text-black font-bold font-mono text-xs uppercase">Simpan Layanan</button>
      </div>
    </form>
  </div>

  <!-- Services Grid -->
  <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    @foreach($services as $srv)
      <div class="p-6 rounded-2xl bg-[#121218] border border-gray-800 flex flex-col justify-between">
        <div class="space-y-2">
          <div class="text-xs font-mono text-[#ff5500]">{{ $srv->number_label }}</div>
          <h3 class="text-base font-bold text-white">{{ $srv->title }}</h3>
          <p class="text-xs text-gray-300 leading-relaxed">{{ $srv->description }}</p>
          @if(is_array($srv->tags))
            <div class="flex flex-wrap gap-1 pt-2">
              @foreach($srv->tags as $t)
                <span class="px-2 py-0.5 text-[10px] font-mono rounded bg-gray-800 text-gray-300">{{ $t }}</span>
              @endforeach
            </div>
          @endif
        </div>
        <div class="pt-4 mt-4 border-t border-gray-800 flex justify-between items-center text-xs font-mono">
          <span class="text-gray-500">#{{ $srv->sort_order }}</span>
          <form action="{{ route('admin.services.destroy', $srv) }}" method="POST" onsubmit="return confirm('Hapus layanan ini?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="text-red-400 hover:text-red-300">Hapus</button>
          </form>
        </div>
      </div>
    @endforeach
  </div>

</div>
@endsection

