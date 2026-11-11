@extends('layouts.admin')

@section('title', 'Manage Education History')

@section('content')
<div class="space-y-6">

  <!-- Header -->
  <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-gray-800">
    <div>
      <h1 class="text-3xl font-display tracking-wider text-white">EDUCATION & ACADEMIC</h1>
      <p class="text-xs font-mono text-gray-400 mt-1">
        Kelola riwayat pendidikan formal dan akademik yang tampil di website.
      </p>
    </div>
    <a href="{{ route('admin.educations.create') }}" class="px-5 py-2.5 rounded-xl bg-[#ff5500] hover:bg-[#ff6e26] text-black font-bold font-mono text-xs uppercase tracking-wider transition-all shadow-lg shadow-[#ff5500]/25 flex items-center gap-2 self-start sm:self-auto">
      <span>+ Tambah Pendidikan Baru</span>
    </a>
  </div>

  <div class="space-y-4">
    @forelse($educations as $edu)
      <div class="p-6 rounded-2xl bg-[#121218] border border-gray-800 hover:border-gray-700 transition-all flex flex-col md:flex-row md:items-start justify-between gap-4">
        <div class="flex-1 space-y-2">
          <div class="text-xs font-mono text-[#ff5500]">{{ $edu->period }}</div>
          <h3 class="text-lg font-bold text-white">{{ $edu->school }}</h3>
          <div class="text-sm text-gray-300 font-medium">{{ $edu->degree }}</div>
          @if($edu->notes)
            <p class="text-xs text-gray-400 leading-relaxed max-w-2xl pt-1">
              {{ $edu->notes }}
            </p>
          @endif
        </div>

        <div class="flex items-center gap-2 md:self-center">
          <span class="text-xs font-mono text-gray-500 mr-2">#{{ $edu->sort_order }}</span>
          <a href="{{ route('admin.educations.edit', $edu) }}" class="px-3 py-1.5 rounded-lg bg-gray-800 hover:bg-gray-700 text-xs font-mono text-white transition-colors">
            Edit
          </a>
          <form action="{{ route('admin.educations.destroy', $edu) }}" method="POST" onsubmit="return confirm('Hapus riwayat pendidikan ini?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="px-3 py-1.5 rounded-lg bg-red-950/40 border border-red-500/30 text-red-400 hover:bg-red-900/50 text-xs font-mono transition-colors">
              Hapus
            </button>
          </form>
        </div>
      </div>
    @empty
      <div class="p-12 text-center rounded-2xl bg-[#121218] border border-gray-800 text-gray-500 font-mono text-xs">
        Belum ada riwayat pendidikan.
      </div>
    @endforelse
  </div>

</div>
@endsection

