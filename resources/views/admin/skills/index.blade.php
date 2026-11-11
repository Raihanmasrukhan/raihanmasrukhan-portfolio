@extends('layouts.admin')

@section('title', 'Manage Skill Stack')

@section('content')
<div class="space-y-8">

  <!-- Header -->
  <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-gray-800">
    <div>
      <h1 class="text-3xl font-display tracking-wider text-white">SKILL STACK MATRIX</h1>
      <p class="text-xs font-mono text-gray-400 mt-1">
        Kelola keahlian teknologi, framework, basis data, dan tools pada matriks Core Competencies.
      </p>
    </div>
  </div>

  <!-- Quick Add Form -->
  <div class="p-6 rounded-2xl bg-[#121218] border border-gray-800 shadow-xl">
    <h2 class="text-base font-display tracking-wider text-white mb-4 flex items-center gap-2">
      <span class="text-[#ff5500] font-mono text-sm">+</span> TAMBAH SKILL CEPAT
    </h2>

    <form action="{{ route('admin.skills.store') }}" method="POST" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 items-end">
      @csrf

      <div>
        <label class="block text-xs font-mono uppercase tracking-wider text-gray-400 mb-2">Nama Skill / Stack *</label>
        <input type="text" name="name" required class="w-full px-4 py-2.5 rounded-xl bg-[#0a0a0d] border border-gray-700/80 text-white focus:outline-none focus:border-[#ff5500] text-sm font-mono" placeholder="misal: Redis, Vue.js, AWS">
      </div>

      <div>
        <label class="block text-xs font-mono uppercase tracking-wider text-gray-400 mb-2">Kategori *</label>
        <select name="category" required class="w-full px-4 py-2.5 rounded-xl bg-[#0a0a0d] border border-gray-700/80 text-white focus:outline-none focus:border-[#ff5500] text-sm font-mono">
          <option value="web_app">Web & App Development</option>
          <option value="database_arch">Database & Architecture</option>
          <option value="tools_cloud">Tools, Cloud & Creative</option>
        </select>
      </div>

      <div>
        <label class="block text-xs font-mono uppercase tracking-wider text-gray-400 mb-2">Tingkat Kemahiran (Opsional)</label>
        <input type="text" name="level" class="w-full px-4 py-2.5 rounded-xl bg-[#0a0a0d] border border-gray-700/80 text-white focus:outline-none focus:border-[#ff5500] text-sm font-mono" placeholder="Advanced / Expert / Proficient">
      </div>

      <button type="submit" class="py-2.5 px-6 rounded-xl bg-[#ff5500] hover:bg-[#ff6e26] text-black font-bold font-mono text-xs uppercase tracking-wider transition-all shadow-lg shadow-[#ff5500]/25 cursor-pointer">
        + Tambah Skill
      </button>
    </form>
  </div>

  <!-- Skill Categories Display -->
  <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

    <!-- Category 1: Web & App -->
    <div class="p-6 rounded-2xl bg-[#121218] border border-gray-800 shadow-xl flex flex-col justify-between">
      <div>
        <div class="flex items-center justify-between pb-3 border-b border-gray-800/80 mb-4">
          <h3 class="text-sm font-mono font-bold text-[#ff5500] uppercase">// Web & App Development</h3>
          <span class="text-xs font-mono text-gray-500">{{ $skills->where('category', 'web_app')->count() }} skills</span>
        </div>

        <div class="space-y-2">
          @forelse($skills->where('category', 'web_app') as $skill)
            <div class="flex items-center justify-between p-2.5 rounded-xl bg-[#0a0a0d] border border-gray-800/70 hover:border-gray-700">
              <div>
                <span class="font-bold text-sm text-white">{{ $skill->name }}</span>
                @if($skill->level)
                  <span class="text-[10px] font-mono text-gray-500 ml-1.5">• {{ $skill->level }}</span>
                @endif
              </div>
              <form action="{{ route('admin.skills.destroy', $skill) }}" method="POST" onsubmit="return confirm('Hapus skill {{ $skill->name }}?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-gray-500 hover:text-red-400 p-1 text-xs" title="Hapus">✕</button>
              </form>
            </div>
          @empty
            <div class="text-gray-500 text-xs font-mono py-4 text-center">Belum ada skill di kategori ini.</div>
          @endforelse
        </div>
      </div>
    </div>

    <!-- Category 2: Database & Architecture -->
    <div class="p-6 rounded-2xl bg-[#121218] border border-gray-800 shadow-xl flex flex-col justify-between">
      <div>
        <div class="flex items-center justify-between pb-3 border-b border-gray-800/80 mb-4">
          <h3 class="text-sm font-mono font-bold text-[#ff5500] uppercase">// Database & Architecture</h3>
          <span class="text-xs font-mono text-gray-500">{{ $skills->where('category', 'database_arch')->count() }} skills</span>
        </div>

        <div class="space-y-2">
          @forelse($skills->where('category', 'database_arch') as $skill)
            <div class="flex items-center justify-between p-2.5 rounded-xl bg-[#0a0a0d] border border-gray-800/70 hover:border-gray-700">
              <div>
                <span class="font-bold text-sm text-white">{{ $skill->name }}</span>
                @if($skill->level)
                  <span class="text-[10px] font-mono text-gray-500 ml-1.5">• {{ $skill->level }}</span>
                @endif
              </div>
              <form action="{{ route('admin.skills.destroy', $skill) }}" method="POST" onsubmit="return confirm('Hapus skill {{ $skill->name }}?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-gray-500 hover:text-red-400 p-1 text-xs" title="Hapus">✕</button>
              </form>
            </div>
          @empty
            <div class="text-gray-500 text-xs font-mono py-4 text-center">Belum ada skill di kategori ini.</div>
          @endforelse
        </div>
      </div>
    </div>

    <!-- Category 3: Tools & Cloud -->
    <div class="p-6 rounded-2xl bg-[#121218] border border-gray-800 shadow-xl flex flex-col justify-between">
      <div>
        <div class="flex items-center justify-between pb-3 border-b border-gray-800/80 mb-4">
          <h3 class="text-sm font-mono font-bold text-[#ff5500] uppercase">// Tools, Cloud & Creative</h3>
          <span class="text-xs font-mono text-gray-500">{{ $skills->where('category', 'tools_cloud')->count() }} skills</span>
        </div>

        <div class="space-y-2">
          @forelse($skills->where('category', 'tools_cloud') as $skill)
            <div class="flex items-center justify-between p-2.5 rounded-xl bg-[#0a0a0d] border border-gray-800/70 hover:border-gray-700">
              <div>
                <span class="font-bold text-sm text-white">{{ $skill->name }}</span>
                @if($skill->level)
                  <span class="text-[10px] font-mono text-gray-500 ml-1.5">• {{ $skill->level }}</span>
                @endif
              </div>
              <form action="{{ route('admin.skills.destroy', $skill) }}" method="POST" onsubmit="return confirm('Hapus skill {{ $skill->name }}?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-gray-500 hover:text-red-400 p-1 text-xs" title="Hapus">✕</button>
              </form>
            </div>
          @empty
            <div class="text-gray-500 text-xs font-mono py-4 text-center">Belum ada skill di kategori ini.</div>
          @endforelse
        </div>
      </div>
    </div>

  </div>

</div>
@endsection

