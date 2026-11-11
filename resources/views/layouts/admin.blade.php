<!DOCTYPE html>
<html lang="id" class="dark">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Admin Dashboard') — Raihan Adib Masrukhan Portfolio</title>
  
  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=JetBrains+Mono:wght@400;500;700&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
  
  <!-- Tailwind CSS & Vite -->
  @vite(['resources/css/app.css', 'resources/js/app.js'])

  <style>
    :root {
      --accent-orange: #ff5500;
    }
    body {
      font-family: 'Plus Jakarta Sans', sans-serif;
      background-color: #0a0a0d;
      color: #f3f4f6;
    }
    .font-display { font-family: 'Bebas Neue', Impact, sans-serif; }
    .font-mono { font-family: 'JetBrains Mono', monospace; }
    
    /* Custom Scrollbar */
    ::-webkit-scrollbar { width: 6px; height: 6px; }
    ::-webkit-scrollbar-track { background: #0e0e14; }
    ::-webkit-scrollbar-thumb { background: #272732; border-radius: 3px; }
    ::-webkit-scrollbar-thumb:hover { background: #ff5500; }
  </style>
</head>
<body class="min-h-screen bg-[#0a0a0d] text-gray-200 flex flex-col md:flex-row antialiased">

  <!-- Mobile Top Bar -->
  <div class="md:hidden flex items-center justify-between p-4 bg-[#121218] border-b border-gray-800 sticky top-0 z-50">
    <div class="flex items-center space-x-3">
      <span class="w-8 h-8 rounded-lg bg-[#ff5500] text-black font-extrabold flex items-center justify-center font-display text-xl">RM</span>
      <span class="font-bold tracking-wider text-sm uppercase text-white font-mono">Reyy Dashboard</span>
    </div>
    <button id="mobile-menu-btn" class="p-2 rounded bg-gray-800 text-gray-300 hover:text-white" aria-label="Toggle menu">
      <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
    </button>
  </div>

  <!-- Sidebar -->
  <aside id="sidebar" class="hidden md:flex flex-col w-64 bg-[#111117] border-r border-gray-800/80 min-h-screen p-5 sticky top-0 h-screen overflow-y-auto z-40">
    <!-- Brand / Logo -->
    <div class="flex items-center justify-between pb-6 border-b border-gray-800/70 mb-6">
      <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3">
        <span class="w-9 h-9 rounded-lg bg-[#ff5500] text-black font-black flex items-center justify-center font-display text-2xl shadow-lg shadow-[#ff5500]/20">RM</span>
        <div>
          <div class="font-bold tracking-wider text-sm text-white font-mono uppercase">Portfolio Admin</div>
          <div class="text-[11px] text-[#ff5500] font-mono tracking-wide flex items-center gap-1.5">
            <span class="w-1.5 h-1.5 rounded-full bg-[#ff5500] animate-pulse"></span> SYSTEM ACTIVE
          </div>
        </div>
      </a>
    </div>

    <!-- Navigation Menu -->
    <nav class="space-y-1.5 flex-1 text-sm font-medium">
      <div class="text-[10px] uppercase font-mono tracking-wider text-gray-500 px-3 py-1 font-semibold">General</div>
      
      <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all {{ request()->routeIs('admin.dashboard') ? 'bg-[#ff5500] text-black font-semibold shadow-md shadow-[#ff5500]/20' : 'text-gray-400 hover:text-white hover:bg-gray-800/60' }}">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
        <span>Overview</span>
      </a>

      <a href="{{ route('admin.profile.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all {{ request()->routeIs('admin.profile.*') ? 'bg-[#ff5500] text-black font-semibold shadow-md shadow-[#ff5500]/20' : 'text-gray-400 hover:text-white hover:bg-gray-800/60' }}">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
        <span>Profile & Bio</span>
      </a>

      <div class="text-[10px] uppercase font-mono tracking-wider text-gray-500 px-3 pt-4 py-1 font-semibold">Content Management</div>

      <a href="{{ route('admin.projects.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all {{ request()->routeIs('admin.projects.*') ? 'bg-[#ff5500] text-black font-semibold shadow-md shadow-[#ff5500]/20' : 'text-gray-400 hover:text-white hover:bg-gray-800/60' }}">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
        <span>Projects Portfolio</span>
      </a>

      <a href="{{ route('admin.experiences.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all {{ request()->routeIs('admin.experiences.*') ? 'bg-[#ff5500] text-black font-semibold shadow-md shadow-[#ff5500]/20' : 'text-gray-400 hover:text-white hover:bg-gray-800/60' }}">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
        <span>Work Experience</span>
      </a>

      <a href="{{ route('admin.educations.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all {{ request()->routeIs('admin.educations.*') ? 'bg-[#ff5500] text-black font-semibold shadow-md shadow-[#ff5500]/20' : 'text-gray-400 hover:text-white hover:bg-gray-800/60' }}">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path></svg>
        <span>Education</span>
      </a>

      <a href="{{ route('admin.skills.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all {{ request()->routeIs('admin.skills.*') ? 'bg-[#ff5500] text-black font-semibold shadow-md shadow-[#ff5500]/20' : 'text-gray-400 hover:text-white hover:bg-gray-800/60' }}">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path></svg>
        <span>Skill Stack</span>
      </a>

      <a href="{{ route('admin.services.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all {{ request()->routeIs('admin.services.*') ? 'bg-[#ff5500] text-black font-semibold shadow-md shadow-[#ff5500]/20' : 'text-gray-400 hover:text-white hover:bg-gray-800/60' }}">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
        <span>Services</span>
      </a>

      <a href="{{ route('admin.processes.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all {{ request()->routeIs('admin.processes.*') ? 'bg-[#ff5500] text-black font-semibold shadow-md shadow-[#ff5500]/20' : 'text-gray-400 hover:text-white hover:bg-gray-800/60' }}">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
        <span>Work Process</span>
      </a>

      <a href="{{ route('admin.milestones.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all {{ request()->routeIs('admin.milestones.*') ? 'bg-[#ff5500] text-black font-semibold shadow-md shadow-[#ff5500]/20' : 'text-gray-400 hover:text-white hover:bg-gray-800/60' }}">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        <span>Milestones Table</span>
      </a>

      <div class="text-[10px] uppercase font-mono tracking-wider text-gray-500 px-3 pt-4 py-1 font-semibold">Endorsements & Inquiries</div>

      <a href="{{ route('admin.testimonials.index') }}" class="flex items-center justify-between px-3 py-2.5 rounded-lg transition-all {{ request()->routeIs('admin.testimonials.*') ? 'bg-[#ff5500] text-black font-semibold shadow-md shadow-[#ff5500]/20' : 'text-gray-400 hover:text-white hover:bg-gray-800/60' }}">
        <div class="flex items-center gap-3">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
          <span>Client Testimonials</span>
        </div>
        @php $draftCount = \App\Models\Testimonial::where('is_approved', false)->count(); @endphp
        @if($draftCount > 0)
          <span class="px-2 py-0.5 text-[10px] font-mono font-bold bg-amber-500 text-black rounded-full">{{ $draftCount }}</span>
        @endif
      </a>

      <a href="{{ route('admin.messages.index') }}" class="flex items-center justify-between px-3 py-2.5 rounded-lg transition-all {{ request()->routeIs('admin.messages.*') ? 'bg-[#ff5500] text-black font-semibold shadow-md shadow-[#ff5500]/20' : 'text-gray-400 hover:text-white hover:bg-gray-800/60' }}">
        <div class="flex items-center gap-3">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
          <span>Inbox Pesan</span>
        </div>
        @php $unreadCount = \App\Models\ContactMessage::where('is_read', false)->count(); @endphp
        @if($unreadCount > 0)
          <span class="px-2 py-0.5 text-[10px] font-mono font-bold bg-[#ff5500] text-black rounded-full">{{ $unreadCount }}</span>
        @endif
      </a>
    </nav>

    <!-- Bottom Actions -->
    <div class="pt-5 border-t border-gray-800/80 mt-auto space-y-3">
      <a href="{{ route('portfolio') }}" target="_blank" class="flex items-center justify-between text-xs font-mono text-[#ff5500] hover:text-white transition-colors bg-gray-900/90 px-3 py-2 rounded-lg border border-[#ff5500]/30 hover:border-[#ff5500]">
        <span>Lihat Website Live</span>
        <span>↗</span>
      </a>

      <div class="flex items-center justify-between pt-2">
        <div class="flex items-center space-x-2 truncate">
          <div class="w-7 h-7 rounded-full bg-gray-800 border border-gray-700 flex items-center justify-center text-xs font-bold text-gray-300">
            {{ strtoupper(substr(Auth::user()->name ?? 'R', 0, 1)) }}
          </div>
          <span class="text-xs text-gray-300 truncate max-w-[100px]">{{ Auth::user()->name ?? 'Admin' }}</span>
        </div>

        <form action="{{ route('logout') }}" method="POST">
          @csrf
          <button type="submit" class="text-xs text-red-400 hover:text-red-300 transition-colors px-2 py-1 rounded hover:bg-red-500/10 font-mono">
            Logout
          </button>
        </form>
      </div>
    </div>
  </aside>

  <!-- Main Content Area -->
  <main class="flex-1 min-h-screen bg-[#0a0a0d] p-4 md:p-8 overflow-y-auto">
    <div class="max-w-6xl mx-auto">
      <!-- Flash Alert Notices -->
      @if(session('success'))
        <div class="mb-6 p-4 rounded-xl bg-emerald-950/60 border border-emerald-500/40 text-emerald-300 flex items-center justify-between shadow-lg">
          <div class="flex items-center gap-3">
            <svg class="w-5 h-5 text-emerald-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            <span class="text-sm font-medium">{{ session('success') }}</span>
          </div>
          <button onclick="this.parentElement.remove()" class="text-emerald-400 hover:text-white text-sm">✕</button>
        </div>
      @endif

      @if($errors->any())
        <div class="mb-6 p-4 rounded-xl bg-red-950/60 border border-red-500/40 text-red-300 shadow-lg">
          <div class="flex items-center gap-3 mb-2">
            <svg class="w-5 h-5 text-red-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <span class="text-sm font-bold">Terjadi kesalahan validasi:</span>
          </div>
          <ul class="list-disc list-inside text-xs space-y-1 text-red-200 pl-2">
            @foreach($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <!-- Page Content -->
      @yield('content')
    </div>
  </main>

  <script>
    // Mobile menu toggle
    const mobileBtn = document.getElementById('mobile-menu-btn');
    const sidebar = document.getElementById('sidebar');
    if (mobileBtn && sidebar) {
      mobileBtn.addEventListener('click', () => {
        sidebar.classList.toggle('hidden');
        sidebar.classList.toggle('fixed');
        sidebar.classList.toggle('inset-0');
        sidebar.classList.toggle('w-full');
      });
    }
  </script>
  @stack('scripts')
</body>
</html>

