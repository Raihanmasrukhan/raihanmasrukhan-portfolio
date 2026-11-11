@extends('layouts.admin')

@section('title', 'Manage Projects Portfolio')

@section('content')
<div class="space-y-6">

  <!-- Header -->
  <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-gray-800">
    <div>
      <h1 class="text-3xl font-display tracking-wider text-white">PROJECTS PORTFOLIO</h1>
      <p class="text-xs font-mono text-gray-400 mt-1">
        Kelola proyek unggulan yang ditampilkan di bagian "Selected Works" pada website portfolio.
      </p>
    </div>
    <a href="{{ route('admin.projects.create') }}" class="px-5 py-2.5 rounded-xl bg-[#ff5500] hover:bg-[#ff6e26] text-black font-bold font-mono text-xs uppercase tracking-wider transition-all shadow-lg shadow-[#ff5500]/25 flex items-center gap-2 self-start sm:self-auto">
      <span>+ Tambah Project Baru</span>
    </a>
  </div>

  <!-- Projects List Table -->
  <div class="rounded-2xl bg-[#121218] border border-gray-800 overflow-hidden shadow-xl">
    <div class="overflow-x-auto">
      <table class="w-full text-left text-sm">
        <thead class="bg-[#0e0e14] border-b border-gray-800 text-[11px] font-mono uppercase text-gray-400">
          <tr>
            <th class="py-3.5 px-4">Proyek & Klien</th>
            <th class="py-3.5 px-4">Kategori</th>
            <th class="py-3.5 px-4">Timeline</th>
            <th class="py-3.5 px-4">Tech Stack</th>
            <th class="py-3.5 px-4 text-center">Urutan</th>
            <th class="py-3.5 px-4 text-right">Aksi</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-800/80">
          @forelse($projects as $proj)
            <tr class="hover:bg-[#161622]/60 transition-colors">
              <td class="py-4 px-4">
                <div class="flex items-center gap-3">
                  <div class="w-16 h-12 rounded-lg bg-gray-900 border border-gray-800 overflow-hidden flex-shrink-0">
                    <img src="{{ asset($proj->image) }}" alt="{{ $proj->title }}" class="w-full h-full object-cover">
                  </div>
                  <div>
                    <div class="font-bold text-white text-sm hover:text-[#ff5500] transition-colors">
                      {{ $proj->title }}
                    </div>
                    <div class="text-xs font-mono text-gray-500">
                      {{ $proj->client ?? 'Independent' }}
                    </div>
                  </div>
                </div>
              </td>
              <td class="py-4 px-4 font-mono text-xs">
                <span class="px-2 py-0.5 rounded bg-gray-800 text-gray-300">
                  {{ $proj->badge ?? $proj->category }}
                </span>
              </td>
              <td class="py-4 px-4 font-mono text-xs text-gray-400">
                {{ $proj->timeline ?? '—' }}
              </td>
              <td class="py-4 px-4">
                <div class="flex flex-wrap gap-1 max-w-xs">
                  @if(is_array($proj->tech_stack))
                    @foreach(array_slice($proj->tech_stack, 0, 3) as $tech)
                      <span class="px-2 py-0.5 text-[10px] font-mono rounded bg-[#ff5500]/10 text-[#ff5500] border border-[#ff5500]/20">
                        {{ $tech }}
                      </span>
                    @endforeach
                    @if(count($proj->tech_stack) > 3)
                      <span class="px-1.5 py-0.5 text-[10px] font-mono text-gray-500">+{{ count($proj->tech_stack) - 3 }}</span>
                    @endif
                  @endif
                </div>
              </td>
              <td class="py-4 px-4 text-center font-mono text-xs text-gray-400">
                #{{ $proj->sort_order }}
              </td>
              <td class="py-4 px-4 text-right">
                <div class="flex items-center justify-end gap-2">
                  <a href="{{ route('admin.projects.edit', $proj) }}" class="px-3 py-1.5 rounded-lg bg-gray-800 hover:bg-gray-700 text-xs font-mono text-white transition-colors">
                    Edit
                  </a>
                  <form action="{{ route('admin.projects.destroy', $proj) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus project ini?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-3 py-1.5 rounded-lg bg-red-950/40 border border-red-500/30 text-red-400 hover:bg-red-900/50 text-xs font-mono transition-colors">
                      Hapus
                    </button>
                  </form>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="6" class="text-center py-12 text-gray-500 font-mono text-xs">
                Belum ada project. Klik tombol "+ Tambah Project Baru" untuk menambahkan.
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    @if($projects->hasPages())
      <div class="p-4 border-t border-gray-800">
        {{ $projects->links() }}
      </div>
    @endif
  </div>

</div>
@endsection

