@extends('layouts.admin')

@section('title', 'Manage Proven Milestones')

@section('content')
<div class="space-y-6">

  <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-gray-800">
    <div>
      <h1 class="text-3xl font-display tracking-wider text-white">PROVEN MILESTONES TABLE</h1>
      <p class="text-xs font-mono text-gray-400 mt-1">Kelola baris tabel rekam jejak "Proven Milestones".</p>
    </div>
  </div>

  <div class="p-6 rounded-2xl bg-[#121218] border border-gray-800 shadow-xl">
    <h2 class="text-sm font-display tracking-wider text-white mb-4">+ TAMBAH MILESTONE BARIS BARU</h2>
    <form action="{{ route('admin.milestones.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 items-end">
      @csrf
      <div>
        <label class="block text-xs font-mono text-gray-400 mb-1">Organisasi / Klien *</label>
        <input type="text" name="organization" required class="w-full px-4 py-2.5 rounded-xl bg-[#0a0a0d] border border-gray-700/80 text-white text-xs font-mono" placeholder="PT. BantuGrow...">
      </div>
      <div>
        <label class="block text-xs font-mono text-gray-400 mb-1">Project & Deliverable *</label>
        <input type="text" name="project_name" required class="w-full px-4 py-2.5 rounded-xl bg-[#0a0a0d] border border-gray-700/80 text-white text-xs font-mono" placeholder="SaaS Platform with Geofencing">
      </div>
      <div>
        <label class="block text-xs font-mono text-gray-400 mb-1">Teknologi Utama *</label>
        <input type="text" name="tech_stack" required class="w-full px-4 py-2.5 rounded-xl bg-[#0a0a0d] border border-gray-700/80 text-white text-xs font-mono" placeholder="Laravel, React, MySQL">
      </div>
      <div>
        <label class="block text-xs font-mono text-gray-400 mb-1">Periode / Status *</label>
        <input type="text" name="period" required class="w-full px-4 py-2.5 rounded-xl bg-[#0a0a0d] border border-gray-700/80 text-white text-xs font-mono" placeholder="Nov 2024 — Present">
      </div>
      <div class="lg:col-span-4 flex justify-end">
        <button type="submit" class="px-5 py-2.5 rounded-xl bg-[#ff5500] text-black font-bold font-mono text-xs uppercase">Simpan Baris Milestone</button>
      </div>
    </form>
  </div>

  <div class="rounded-2xl bg-[#121218] border border-gray-800 overflow-hidden shadow-xl">
    <table class="w-full text-left text-sm">
      <thead class="bg-[#0e0e14] border-b border-gray-800 text-[11px] font-mono uppercase text-gray-400">
        <tr>
          <th class="py-3 px-4">Organisasi / Klien</th>
          <th class="py-3 px-4">Project & Deliverable</th>
          <th class="py-3 px-4">Tech Stack</th>
          <th class="py-3 px-4">Periode</th>
          <th class="py-3 px-4 text-right">Aksi</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-800/80">
        @foreach($milestones as $m)
          <tr class="hover:bg-[#161622]/60">
            <td class="py-3.5 px-4 font-bold text-white text-xs">{{ $m->organization }}</td>
            <td class="py-3.5 px-4 text-xs text-gray-300">{{ $m->project_name }}</td>
            <td class="py-3.5 px-4 text-xs font-mono text-[#ff5500]">{{ $m->tech_stack }}</td>
            <td class="py-3.5 px-4 text-xs font-mono text-gray-400">{{ $m->period }}</td>
            <td class="py-3.5 px-4 text-right">
              <form action="{{ route('admin.milestones.destroy', $m) }}" method="POST" onsubmit="return confirm('Hapus baris ini?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-xs font-mono text-red-400 hover:text-red-300">Hapus</button>
              </form>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>

</div>
@endsection

