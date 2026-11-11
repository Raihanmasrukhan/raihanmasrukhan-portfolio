@extends('layouts.admin')

@section('title', 'Manage Work Process')

@section('content')
<div class="space-y-6">

  <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-gray-800">
    <div>
      <h1 class="text-3xl font-display tracking-wider text-white">WORK PROCESS (HOW I WORK)</h1>
      <p class="text-xs font-mono text-gray-400 mt-1">Kelola langkah alur kerja 1-4 (Discovery, Planning, Production, Delivery).</p>
    </div>
  </div>

  <div class="p-6 rounded-2xl bg-[#121218] border border-gray-800 shadow-xl">
    <h2 class="text-sm font-display tracking-wider text-white mb-4">+ TAMBAH STEP ALUR KERJA</h2>
    <form action="{{ route('admin.processes.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-4">
      @csrf
      <div>
        <label class="block text-xs font-mono text-gray-400 mb-1">Nomor Step (misal: 1., 2.) *</label>
        <input type="text" name="step_number" required class="w-full px-4 py-2.5 rounded-xl bg-[#0a0a0d] border border-gray-700/80 text-white text-xs font-mono" placeholder="1.">
      </div>
      <div>
        <label class="block text-xs font-mono text-gray-400 mb-1">Judul Tahapan *</label>
        <input type="text" name="title" required class="w-full px-4 py-2.5 rounded-xl bg-[#0a0a0d] border border-gray-700/80 text-white text-xs font-mono" placeholder="DISCOVERY">
      </div>
      <div class="md:col-span-2">
        <label class="block text-xs font-mono text-gray-400 mb-1">Deskripsi Tahapan *</label>
        <textarea name="description" rows="2" required class="w-full px-4 py-2.5 rounded-xl bg-[#0a0a0d] border border-gray-700/80 text-white text-xs font-mono" placeholder="Jelaskan apa yang dilakukan di tahapan ini..."></textarea>
      </div>
      <div class="flex items-center gap-2">
        <label class="flex items-center gap-2 cursor-pointer text-xs font-mono text-gray-300">
          <input type="checkbox" name="is_featured" value="1" class="rounded text-[#ff5500]">
          <span>Sorot sebagai Kartu Oranye Menyala (Featured)</span>
        </label>
      </div>
      <div class="flex justify-end">
        <button type="submit" class="px-5 py-2.5 rounded-xl bg-[#ff5500] text-black font-bold font-mono text-xs uppercase">Simpan Step</button>
      </div>
    </form>
  </div>

  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
    @foreach($processes as $proc)
      <div class="p-6 rounded-2xl {{ $proc->is_featured ? 'bg-[#ff5500] text-black' : 'bg-[#121218] text-white border border-gray-800' }} flex flex-col justify-between">
        <div>
          <div class="text-3xl font-display {{ $proc->is_featured ? 'text-black/80' : 'text-[#ff5500]' }} mb-2">{{ $proc->step_number }}</div>
          <h3 class="text-lg font-bold mb-2">{{ $proc->title }}</h3>
          <p class="text-xs {{ $proc->is_featured ? 'text-black/90 font-medium' : 'text-gray-400' }} leading-relaxed">{{ $proc->description }}</p>
        </div>
        <div class="pt-4 mt-4 border-t {{ $proc->is_featured ? 'border-black/20' : 'border-gray-800' }} flex justify-end">
          <form action="{{ route('admin.processes.destroy', $proc) }}" method="POST" onsubmit="return confirm('Hapus step ini?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="text-xs font-mono {{ $proc->is_featured ? 'text-black hover:underline font-bold' : 'text-red-400 hover:text-red-300' }}">Hapus</button>
          </form>
        </div>
      </div>
    @endforeach
  </div>

</div>
@endsection

