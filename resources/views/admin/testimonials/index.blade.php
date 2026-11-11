@extends('layouts.admin')

@section('title', 'Kelola Client Testimonials')

@section('content')
<div class="space-y-8">

  <!-- Header -->
  <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-gray-800">
    <div>
      <h1 class="text-3xl font-display tracking-wider text-white">CLIENT TESTIMONIALS & ENDORSEMENTS</h1>
      <p class="text-xs font-mono text-gray-400 mt-1">
        Kelola testimoni dan ulasan profesional dari klien, pimpinan perusahaan, maupun mitra proyek Anda.
      </p>
    </div>

    <!-- Filter Tabs -->
    <div class="flex items-center gap-1.5 p-1 rounded-xl bg-gray-900 border border-gray-800 self-start sm:self-auto text-xs font-mono">
      <a href="{{ route('admin.testimonials.index') }}" class="px-3 py-1.5 rounded-lg transition-colors {{ !request('filter') ? 'bg-[#ff5500] text-black font-bold' : 'text-gray-400 hover:text-white' }}">
        Semua ({{ $testimonials->total() }})
      </a>
      <a href="{{ route('admin.testimonials.index', ['filter' => 'published']) }}" class="px-3 py-1.5 rounded-lg transition-colors {{ request('filter') == 'published' ? 'bg-[#ff5500] text-black font-bold' : 'text-gray-400 hover:text-white' }}">
        Published
      </a>
      <a href="{{ route('admin.testimonials.index', ['filter' => 'draft']) }}" class="px-3 py-1.5 rounded-lg transition-colors {{ request('filter') == 'draft' ? 'bg-[#ff5500] text-black font-bold' : 'text-gray-400 hover:text-white' }}">
        Draft ({{ $draftCount }})
      </a>
      <a href="{{ route('admin.testimonials.index', ['filter' => 'featured']) }}" class="px-3 py-1.5 rounded-lg transition-colors {{ request('filter') == 'featured' ? 'bg-[#ff5500] text-black font-bold' : 'text-gray-400 hover:text-white' }}">
        Featured
      </a>
    </div>
  </div>

  <!-- Add New Testimonial Card -->
  <div class="p-6 md:p-8 rounded-2xl bg-[#121218] border border-gray-800 shadow-xl">
    <h2 class="text-base font-display tracking-wider text-white mb-5 flex items-center gap-2">
      <span class="text-[#ff5500] font-mono text-sm">+</span> TAMBAH TESTIMONI KLIEN BARU
    </h2>

    <form action="{{ route('admin.testimonials.store') }}" method="POST" class="space-y-4">
      @csrf
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <div>
          <label class="block text-xs font-mono uppercase tracking-wider text-gray-400 mb-1.5">Nama Klien / Pemberi Testimoni *</label>
          <input type="text" name="name" required class="w-full px-4 py-2.5 rounded-xl bg-[#0a0a0d] border border-gray-700/80 text-white text-xs font-mono focus:outline-none focus:border-[#ff5500]" placeholder="e.g. Reza Pratama">
        </div>

        <div>
          <label class="block text-xs font-mono uppercase tracking-wider text-gray-400 mb-1.5">Jabatan / Role</label>
          <input type="text" name="role_title" class="w-full px-4 py-2.5 rounded-xl bg-[#0a0a0d] border border-gray-700/80 text-white text-xs font-mono focus:outline-none focus:border-[#ff5500]" placeholder="e.g. CEO / Product Director">
        </div>

        <div>
          <label class="block text-xs font-mono uppercase tracking-wider text-gray-400 mb-1.5">Perusahaan / Institusi</label>
          <input type="text" name="company" class="w-full px-4 py-2.5 rounded-xl bg-[#0a0a0d] border border-gray-700/80 text-white text-xs font-mono focus:outline-none focus:border-[#ff5500]" placeholder="e.g. PT. BantuGrow Digital">
        </div>

        <div class="grid grid-cols-2 gap-3">
          <div>
            <label class="block text-xs font-mono uppercase tracking-wider text-gray-400 mb-1.5">Tag Proyek</label>
            <input type="text" name="project_tag" class="w-full px-3 py-2.5 rounded-xl bg-[#0a0a0d] border border-gray-700/80 text-white text-xs font-mono focus:outline-none focus:border-[#ff5500]" placeholder="SaaS System">
          </div>
          <div>
            <label class="block text-xs font-mono uppercase tracking-wider text-gray-400 mb-1.5">Rating (1-5)</label>
            <select name="rating" class="w-full px-3 py-2.5 rounded-xl bg-[#0a0a0d] border border-gray-700/80 text-white text-xs font-mono focus:outline-none focus:border-[#ff5500]">
              <option value="5" selected>5 ★</option>
              <option value="4">4 ★</option>
              <option value="3">3 ★</option>
              <option value="2">2 ★</option>
              <option value="1">1 ★</option>
            </select>
          </div>
        </div>
      </div>

      <div>
        <label class="block text-xs font-mono uppercase tracking-wider text-gray-400 mb-1.5">Kutipan Testimoni *</label>
        <textarea name="message" rows="3" required class="w-full px-4 py-3 rounded-xl bg-[#0a0a0d] border border-gray-700/80 text-white text-xs font-mono leading-relaxed focus:outline-none focus:border-[#ff5500]" placeholder="Tuliskan testimoni profesional klien mengenai kinerja, kualitas arsitektur, dan dampak proyek..."></textarea>
      </div>

      <div class="flex flex-wrap items-center justify-between gap-4 pt-2">
        <div class="flex items-center gap-6">
          <label class="flex items-center gap-2 cursor-pointer text-xs font-mono text-gray-300">
            <input type="checkbox" name="is_approved" value="1" checked class="rounded text-[#ff5500] focus:ring-[#ff5500]">
            <span>Langsung Publikasikan</span>
          </label>
          <label class="flex items-center gap-2 cursor-pointer text-xs font-mono text-gray-300">
            <input type="checkbox" name="is_pinned" value="1" class="rounded text-[#ff5500] focus:ring-[#ff5500]">
            <span>Tandai sebagai Featured</span>
          </label>
        </div>

        <button type="submit" class="px-6 py-2.5 rounded-xl bg-[#ff5500] hover:bg-[#ff6e26] text-black font-bold font-mono text-xs uppercase tracking-wider transition-all shadow-lg shadow-[#ff5500]/20 cursor-pointer">
          SIMPAN TESTIMONI ➔
        </button>
      </div>
    </form>
  </div>

  <!-- Testimonials Grid -->
  <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
    @forelse($testimonials as $t)
      <div class="p-6 rounded-2xl bg-[#121218] border {{ $t->is_pinned ? 'border-[#ff5500]/60 ring-1 ring-[#ff5500]/25' : 'border-gray-800' }} hover:border-gray-700 transition-all flex flex-col justify-between">
        
        <div class="space-y-4">
          <!-- Top Bar -->
          <div class="flex items-start justify-between gap-2">
            <div class="flex items-center gap-3">
              <span class="w-10 h-10 rounded-full flex items-center justify-center text-sm font-black text-black shadow-md flex-shrink-0" style="background-color: {{ $t->avatar_color ?? '#ff5500' }}">
                {{ strtoupper(substr($t->name, 0, 1)) }}
              </span>
              <div>
                <div class="font-bold text-white text-sm flex items-center gap-2 flex-wrap">
                  <span>{{ $t->name }}</span>
                  @if($t->is_pinned)
                    <span class="text-[9px] font-mono bg-[#ff5500] text-black font-black px-1.5 py-0.5 rounded uppercase">Featured</span>
                  @endif
                </div>
                <div class="text-[11px] font-mono text-[#ff5500]">
                  {{ collect([$t->role_title, $t->company])->filter()->implode(' • ') ?: 'Client Partner' }}
                </div>
              </div>
            </div>

            <span class="px-2 py-0.5 text-[10px] font-mono rounded font-semibold {{ $t->is_approved ? 'bg-emerald-500/10 text-emerald-400 border border-emerald-500/20' : 'bg-amber-500/10 text-amber-400 border border-amber-500/20' }}">
              {{ $t->is_approved ? '✓ Published' : 'Draft' }}
            </span>
          </div>

          <div class="flex items-center justify-between text-[11px] font-mono">
            <span class="px-2 py-0.5 rounded bg-gray-800/80 text-gray-300 border border-gray-700/60">
              {{ $t->project_tag ?? 'General Endorsement' }}
            </span>
            <span class="text-amber-400">{{ str_repeat('★', $t->rating ?? 5) }}</span>
          </div>

          <!-- Quote -->
          <p class="text-xs text-gray-300 leading-relaxed bg-[#0a0a0d] p-4 rounded-xl border border-gray-800/80">
            "{{ $t->message }}"
          </p>
        </div>

        <!-- Actions & Quick Edit Toggle -->
        <div class="pt-4 mt-4 border-t border-gray-800/80 space-y-3">
          <div class="flex flex-wrap items-center justify-between gap-2 text-xs font-mono">
            <div class="flex items-center gap-2">
              <form action="{{ route('admin.testimonials.toggle-approval', $t) }}" method="POST">
                @csrf
                @method('PATCH')
                <button type="submit" class="px-2.5 py-1 rounded bg-gray-800 hover:bg-gray-700 text-gray-300 hover:text-white transition-colors">
                  {{ $t->is_approved ? 'Jadikan Draft' : '✓ Publikasikan' }}
                </button>
              </form>

              <form action="{{ route('admin.testimonials.toggle-pin', $t) }}" method="POST">
                @csrf
                @method('PATCH')
                <button type="submit" class="px-2.5 py-1 rounded bg-gray-800 hover:bg-gray-700 text-gray-300 hover:text-white transition-colors">
                  {{ $t->is_pinned ? 'Unfeature' : '★ Feature' }}
                </button>
              </form>

              <button type="button" onclick="document.getElementById('edit-t-{{ $t->id }}').classList.toggle('hidden')" class="px-2.5 py-1 rounded bg-blue-950/50 border border-blue-500/30 text-blue-400 hover:bg-blue-900/40 transition-colors">
                Edit
              </button>
            </div>

            <form action="{{ route('admin.testimonials.destroy', $t) }}" method="POST" onsubmit="return confirm('Hapus testimoni ini secara permanen?');">
              @csrf
              @method('DELETE')
              <button type="submit" class="text-red-400 hover:text-red-300 transition-colors p-1">
                Hapus
              </button>
            </form>
          </div>

          <!-- Inline Edit Form -->
          <form id="edit-t-{{ $t->id }}" action="{{ route('admin.testimonials.update', $t) }}" method="POST" class="hidden pt-3 border-t border-gray-800/60 space-y-3">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5">
              <input type="text" name="name" value="{{ $t->name }}" required placeholder="Nama Klien" class="px-3 py-2 rounded-lg bg-[#0a0a0d] border border-gray-700 text-white text-xs font-mono">
              <input type="text" name="role_title" value="{{ $t->role_title }}" placeholder="Jabatan" class="px-3 py-2 rounded-lg bg-[#0a0a0d] border border-gray-700 text-white text-xs font-mono">
              <input type="text" name="company" value="{{ $t->company }}" placeholder="Perusahaan" class="px-3 py-2 rounded-lg bg-[#0a0a0d] border border-gray-700 text-white text-xs font-mono">
              <input type="text" name="project_tag" value="{{ $t->project_tag }}" placeholder="Tag Proyek" class="px-3 py-2 rounded-lg bg-[#0a0a0d] border border-gray-700 text-white text-xs font-mono">
            </div>
            <textarea name="message" rows="3" required class="w-full px-3 py-2 rounded-lg bg-[#0a0a0d] border border-gray-700 text-white text-xs font-mono">{{ $t->message }}</textarea>
            <div class="flex justify-end gap-2">
              <button type="button" onclick="document.getElementById('edit-t-{{ $t->id }}').classList.add('hidden')" class="px-3 py-1.5 rounded bg-gray-800 text-gray-300 text-xs font-mono">Batal</button>
              <button type="submit" class="px-4 py-1.5 rounded bg-[#ff5500] text-black font-bold text-xs font-mono">Simpan Perubahan</button>
            </div>
          </form>
        </div>

      </div>
    @empty
      <div class="col-span-2 p-12 text-center rounded-2xl bg-[#121218] border border-gray-800 text-gray-500 font-mono text-xs">
        Belum ada testimoni pada kategori ini.
      </div>
    @endforelse
  </div>

  @if($testimonials->hasPages())
    <div class="p-4 rounded-xl bg-[#121218] border border-gray-800">
      {{ $testimonials->links() }}
    </div>
  @endif

</div>
@endsection

