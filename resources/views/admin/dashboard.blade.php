@extends('layouts.admin')

@section('title', 'Dashboard Overview')

@section('content')
<div class="space-y-8">

  <!-- Header Banner -->
  <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 p-6 rounded-2xl bg-gradient-to-r from-[#14141c] via-[#121218] to-[#171722] border border-gray-800 shadow-xl relative overflow-hidden">
    <div class="absolute right-0 top-0 w-80 h-full bg-[#ff5500]/5 -skew-x-12 pointer-events-none"></div>
    
    <div>
      <div class="inline-flex items-center gap-2 px-2.5 py-1 rounded-full bg-[#ff5500]/10 border border-[#ff5500]/30 text-[#ff5500] text-xs font-mono font-semibold mb-2">
        <span class="w-2 h-2 rounded-full bg-[#ff5500] animate-pulse"></span>
        SYSTEM OPERATIONAL
      </div>
      <h1 class="text-3xl font-display tracking-wider text-white">SELAMAT DATANG, {{ strtoupper($profile->full_name) }}</h1>
      <p class="text-xs font-mono text-gray-400 mt-1">
        Kelola profil, proyek portofolio, pengalaman kerja, skill stack, buku tamu, dan pesan kontak secara real-time.
      </p>
    </div>

    <div class="flex items-center gap-3">
      <a href="{{ route('admin.projects.create') }}" class="px-4 py-2.5 rounded-xl bg-[#ff5500] hover:bg-[#ff6e26] text-black font-bold font-mono text-xs uppercase tracking-wider transition-all shadow-lg shadow-[#ff5500]/20 flex items-center gap-1.5">
        <span>+ Tambah Project</span>
      </a>
      <a href="{{ route('admin.profile.index') }}" class="px-4 py-2.5 rounded-xl bg-gray-800 hover:bg-gray-700 text-white font-mono text-xs uppercase tracking-wider transition-all border border-gray-700 flex items-center gap-1.5">
        <span>Edit Profil</span>
      </a>
    </div>
  </div>

  <!-- Stat Cards Grid -->
  <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
    <!-- Projects -->
    <a href="{{ route('admin.projects.index') }}" class="p-5 rounded-2xl bg-[#121218] border border-gray-800/80 hover:border-[#ff5500]/50 transition-all group block">
      <div class="flex items-center justify-between mb-3">
        <span class="text-xs font-mono text-gray-400 uppercase">Projects</span>
        <span class="p-2 rounded-lg bg-[#ff5500]/10 text-[#ff5500] group-hover:scale-110 transition-transform">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
        </span>
      </div>
      <div class="text-3xl font-display tracking-wider text-white">{{ $stats['projects'] }}</div>
      <span class="text-[11px] font-mono text-gray-500 mt-1 block">Selected Works</span>
    </a>

    <!-- Work Experience -->
    <a href="{{ route('admin.experiences.index') }}" class="p-5 rounded-2xl bg-[#121218] border border-gray-800/80 hover:border-[#ff5500]/50 transition-all group block">
      <div class="flex items-center justify-between mb-3">
        <span class="text-xs font-mono text-gray-400 uppercase">Experience</span>
        <span class="p-2 rounded-lg bg-blue-500/10 text-blue-400 group-hover:scale-110 transition-transform">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
        </span>
      </div>
      <div class="text-3xl font-display tracking-wider text-white">{{ $stats['experiences'] }}</div>
      <span class="text-[11px] font-mono text-gray-500 mt-1 block">Work Tracks</span>
    </a>

    <!-- Skills -->
    <a href="{{ route('admin.skills.index') }}" class="p-5 rounded-2xl bg-[#121218] border border-gray-800/80 hover:border-[#ff5500]/50 transition-all group block">
      <div class="flex items-center justify-between mb-3">
        <span class="text-xs font-mono text-gray-400 uppercase">Skills</span>
        <span class="p-2 rounded-lg bg-purple-500/10 text-purple-400 group-hover:scale-110 transition-transform">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path></svg>
        </span>
      </div>
      <div class="text-3xl font-display tracking-wider text-white">{{ $stats['skills'] }}</div>
      <span class="text-[11px] font-mono text-gray-500 mt-1 block">Tech Matrix</span>
    </a>

    <!-- Testimonials -->
    <a href="{{ route('admin.testimonials.index') }}" class="p-5 rounded-2xl bg-[#121218] border border-gray-800/80 hover:border-[#ff5500]/50 transition-all group block">
      <div class="flex items-center justify-between mb-3">
        <span class="text-xs font-mono text-gray-400 uppercase">Testimonials</span>
        <span class="p-2 rounded-lg bg-amber-500/10 text-amber-400 group-hover:scale-110 transition-transform">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
        </span>
      </div>
      <div class="flex items-baseline gap-2">
        <div class="text-3xl font-display tracking-wider text-white">{{ $stats['total_testimonials'] }}</div>
        @if($stats['draft_testimonials'] > 0)
          <span class="text-[10px] font-mono font-bold text-amber-400">({{ $stats['draft_testimonials'] }} draft)</span>
        @endif
      </div>
      <span class="text-[11px] font-mono text-gray-500 mt-1 block">Client Endorsements</span>
    </a>

    <!-- Inbox Messages -->
    <a href="{{ route('admin.messages.index') }}" class="p-5 rounded-2xl bg-[#121218] border border-gray-800/80 hover:border-[#ff5500]/50 transition-all group block">
      <div class="flex items-center justify-between mb-3">
        <span class="text-xs font-mono text-gray-400 uppercase">Inbox</span>
        <span class="p-2 rounded-lg bg-emerald-500/10 text-emerald-400 group-hover:scale-110 transition-transform">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
        </span>
      </div>
      <div class="flex items-baseline gap-2">
        <div class="text-3xl font-display tracking-wider text-white">{{ $stats['total_messages'] }}</div>
        @if($stats['unread_messages'] > 0)
          <span class="text-[10px] font-mono font-bold text-[#ff5500]">({{ $stats['unread_messages'] }} baru)</span>
        @endif
      </div>
      <span class="text-[11px] font-mono text-gray-500 mt-1 block">Contact Inquiries</span>
    </a>

    <!-- Visitor Hits -->
    <div class="p-5 rounded-2xl bg-[#121218] border border-gray-800/80 block">
      <div class="flex items-center justify-between mb-3">
        <span class="text-xs font-mono text-gray-400 uppercase">Hits</span>
        <span class="p-2 rounded-lg bg-pink-500/10 text-pink-400">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
        </span>
      </div>
      <div class="text-3xl font-display tracking-wider text-white">{{ $stats['total_views'] }}</div>
      <span class="text-[11px] font-mono text-gray-500 mt-1 block">{{ $stats['today_views'] }} hari ini</span>
    </div>
  </div>

  <!-- Two Column: Recent Messages & Guestbooks -->
  <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    
    <!-- Recent Contact Inquiries -->
    <div class="p-6 rounded-2xl bg-[#121218] border border-gray-800 shadow-xl">
      <div class="flex items-center justify-between pb-4 border-b border-gray-800/80 mb-4">
        <div>
          <h2 class="text-lg font-display tracking-wider text-white flex items-center gap-2">
            <span>INBOX PESAN KONTAK</span>
            @if($stats['unread_messages'] > 0)
              <span class="px-2 py-0.5 text-[10px] font-mono bg-[#ff5500] text-black font-bold rounded-full">{{ $stats['unread_messages'] }} Baru</span>
            @endif
          </h2>
          <span class="text-xs font-mono text-gray-500">Pesan langsung dari form website</span>
        </div>
        <a href="{{ route('admin.messages.index') }}" class="text-xs font-mono text-[#ff5500] hover:underline">Semua Inbox ➔</a>
      </div>

      <div class="space-y-3">
        @forelse($recentMessages as $msg)
          <div class="p-4 rounded-xl {{ $msg->is_read ? 'bg-[#0d0d12] border border-gray-800/60' : 'bg-[#181824] border border-[#ff5500]/40' }} transition-all">
            <div class="flex items-center justify-between mb-1.5">
              <span class="font-bold text-sm text-white">{{ $msg->name }}</span>
              <span class="text-[10px] font-mono text-gray-500">{{ $msg->created_at->diffForHumans() }}</span>
            </div>
            <div class="text-xs font-mono text-[#ff5500] mb-2">{{ $msg->email_or_phone }} • {{ $msg->project_type ?? 'Inquiry' }}</div>
            <p class="text-xs text-gray-300 line-clamp-2 leading-relaxed mb-3">"{{ $msg->message }}"</p>
            <div class="flex items-center justify-between pt-2 border-t border-gray-800/60">
              <a href="{{ route('admin.messages.show', $msg) }}" class="text-xs font-mono text-gray-400 hover:text-white">Baca Detail ➔</a>
              <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $msg->email_or_phone) }}" target="_blank" class="px-2.5 py-1 text-[11px] font-mono bg-emerald-600/20 text-emerald-400 border border-emerald-500/30 rounded-lg hover:bg-emerald-600/30">
                Balas via WA
              </a>
            </div>
          </div>
        @empty
          <div class="text-center py-8 text-gray-500 text-xs font-mono">
            Belum ada pesan kontak masuk.
          </div>
        @endforelse
      </div>
    </div>

    <!-- Recent Testimonials Entries -->
    <div class="p-6 rounded-2xl bg-[#121218] border border-gray-800 shadow-xl">
      <div class="flex items-center justify-between pb-4 border-b border-gray-800/80 mb-4">
        <div>
          <h2 class="text-lg font-display tracking-wider text-white flex items-center gap-2">
            <span>CLIENT TESTIMONIALS</span>
            @if($stats['draft_testimonials'] > 0)
              <span class="px-2 py-0.5 text-[10px] font-mono bg-amber-500 text-black font-bold rounded-full">{{ $stats['draft_testimonials'] }} Draft</span>
            @endif
          </h2>
          <span class="text-xs font-mono text-gray-500">Testimoni klien & mitra bisnis</span>
        </div>
        <a href="{{ route('admin.testimonials.index') }}" class="text-xs font-mono text-[#ff5500] hover:underline">Kelola Testimoni ➔</a>
      </div>

      <div class="space-y-3">
        @forelse($recentTestimonials as $t)
          <div class="p-4 rounded-xl bg-[#0d0d12] border border-gray-800/60 transition-all">
            <div class="flex items-center justify-between mb-2">
              <div class="flex items-center gap-2">
                <span class="w-6 h-6 rounded-full flex items-center justify-center text-[10px] font-bold text-black" style="background-color: {{ $t->avatar_color }}">
                  {{ strtoupper(substr($t->name, 0, 1)) }}
                </span>
                <div>
                  <span class="font-bold text-sm text-white block leading-tight">{{ $t->name }}</span>
                  <span class="text-[10px] font-mono text-gray-500">{{ collect([$t->role_title, $t->company])->filter()->implode(' • ') }}</span>
                </div>
              </div>
              <div class="flex items-center gap-2">
                @if($t->is_pinned)
                  <span class="text-[10px] font-mono bg-[#ff5500]/20 text-[#ff5500] px-1.5 py-0.5 rounded">Featured</span>
                @endif
                <span class="text-[10px] font-mono {{ $t->is_approved ? 'text-emerald-400' : 'text-amber-400' }}">
                  {{ $t->is_approved ? '● Published' : '● Draft' }}
                </span>
              </div>
            </div>
            <p class="text-xs text-gray-300 line-clamp-2 leading-relaxed mb-3">"{{ $t->message }}"</p>
            <div class="flex items-center justify-between pt-2 border-t border-gray-800/60 text-xs font-mono text-gray-500">
              <span>{{ $t->project_tag ?? 'Verified Client' }}</span>
              <form action="{{ route('admin.testimonials.toggle-approval', $t) }}" method="POST">
                @csrf
                @method('PATCH')
                <button type="submit" class="text-xs text-[#ff5500] hover:underline">
                  {{ $t->is_approved ? 'Sembunyikan' : 'Publikasikan' }}
                </button>
              </form>
            </div>
          </div>
        @empty
          <div class="text-center py-8 text-gray-500 text-xs font-mono">
            Belum ada testimoni klien.
          </div>
        @endforelse
      </div>
    </div>
  </div>

  <!-- Featured Projects Quick Row -->
  <div class="p-6 rounded-2xl bg-[#121218] border border-gray-800 shadow-xl">
    <div class="flex items-center justify-between pb-4 border-b border-gray-800/80 mb-6">
      <div>
        <h2 class="text-lg font-display tracking-wider text-white">PROJECTS SHOWCASE</h2>
        <span class="text-xs font-mono text-gray-500">Daftar proyek yang saat ini tayang di portfolio</span>
      </div>
      <a href="{{ route('admin.projects.index') }}" class="text-xs font-mono text-[#ff5500] hover:underline">Kelola Semua Proyek ➔</a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
      @foreach($recentProjects as $proj)
        <div class="rounded-xl bg-[#0d0d12] border border-gray-800/80 overflow-hidden group hover:border-[#ff5500]/50 transition-all">
          <div class="h-32 bg-gray-900 overflow-hidden relative">
            <img src="{{ asset($proj->image) }}" alt="{{ $proj->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
            <span class="absolute top-2 left-2 px-2 py-0.5 text-[10px] font-mono font-bold bg-black/80 text-[#ff5500] rounded backdrop-blur">
              {{ $proj->badge ?? $proj->category }}
            </span>
          </div>
          <div class="p-4">
            <div class="text-[11px] font-mono text-gray-500 mb-1">{{ $proj->client ?? 'Client Project' }}</div>
            <h3 class="text-sm font-bold text-white mb-2 line-clamp-1">{{ $proj->title }}</h3>
            <div class="flex items-center justify-between pt-2 border-t border-gray-800/60">
              <span class="text-[11px] font-mono text-gray-500">Urutan: #{{ $proj->sort_order }}</span>
              <a href="{{ route('admin.projects.edit', $proj) }}" class="text-xs font-mono text-[#ff5500] hover:underline">Edit ➔</a>
            </div>
          </div>
        </div>
      @endforeach
    </div>
  </div>

</div>
@endsection

