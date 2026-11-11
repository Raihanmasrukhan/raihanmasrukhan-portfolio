<!DOCTYPE html>
<html lang="id" class="dark">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Admin — Raihan Adib Masrukhan Portfolio</title>
  
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=JetBrains+Mono:wght@400;500;700&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
  
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  
  <style>
    body {
      font-family: 'Plus Jakarta Sans', sans-serif;
      background-color: #0a0a0d;
      color: #f3f4f6;
    }
    .font-display { font-family: 'Bebas Neue', Impact, sans-serif; }
    .font-mono { font-family: 'JetBrains Mono', monospace; }
  </style>
</head>
<body class="min-h-screen bg-[#0a0a0d] flex items-center justify-center p-4 relative overflow-hidden">

  <!-- Background Glow & Grid -->
  <div class="absolute -top-40 -left-40 w-96 h-96 bg-[#ff5500]/15 rounded-full blur-3xl pointer-events-none"></div>
  <div class="absolute -bottom-40 -right-40 w-96 h-96 bg-[#ff5500]/10 rounded-full blur-3xl pointer-events-none"></div>

  <div class="w-full max-w-md relative z-10">
    <!-- Header / Brand -->
    <div class="text-center mb-8">
      <div class="inline-flex items-center justify-center w-14 h-14 rounded-2xl bg-[#ff5500] text-black font-black font-display text-3xl shadow-xl shadow-[#ff5500]/25 mb-4 transform -rotate-2">
        RM
      </div>
      <h1 class="text-3xl font-display tracking-wider text-white">ADMIN DASHBOARD</h1>
      <p class="text-xs font-mono text-gray-400 mt-1 uppercase tracking-widest">
        Portfolio Management System
      </p>
    </div>

    <!-- Login Card -->
    <div class="bg-[#121218]/90 border border-gray-800 rounded-2xl p-6 md:p-8 backdrop-blur-xl shadow-2xl relative">
      <div class="absolute top-0 left-8 right-8 h-[2px] bg-gradient-to-r from-transparent via-[#ff5500] to-transparent"></div>

      <!-- Error message -->
      @if($errors->any())
        <div class="mb-5 p-3.5 rounded-xl bg-red-950/70 border border-red-500/40 text-red-200 text-xs">
          <div class="font-bold mb-1">Gagal Masuk:</div>
          <ul class="list-disc list-inside">
            @foreach($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      @if(session('success'))
        <div class="mb-5 p-3.5 rounded-xl bg-emerald-950/70 border border-emerald-500/40 text-emerald-200 text-xs">
          {{ session('success') }}
        </div>
      @endif

      <form action="{{ route('login.post') }}" method="POST" class="space-y-5">
        @csrf

        <div>
          <label for="email" class="block text-xs font-mono uppercase tracking-wider text-gray-400 mb-2">Email Address</label>
          <input 
            type="email" 
            name="email" 
            id="email" 
            value="{{ old('email', 'admin@raihan.dev') }}" 
            required 
            autocomplete="email"
            class="w-full px-4 py-3 rounded-xl bg-[#0a0a0d] border border-gray-700/80 text-white placeholder-gray-600 focus:outline-none focus:border-[#ff5500] focus:ring-1 focus:ring-[#ff5500] text-sm font-mono transition-all"
            placeholder="admin@raihan.dev"
          >
        </div>

        <div>
          <div class="flex items-center justify-between mb-2">
            <label for="password" class="block text-xs font-mono uppercase tracking-wider text-gray-400">Password</label>
          </div>
          <input 
            type="password" 
            name="password" 
            id="password" 
            value="password123"
            required 
            autocomplete="current-password"
            class="w-full px-4 py-3 rounded-xl bg-[#0a0a0d] border border-gray-700/80 text-white placeholder-gray-600 focus:outline-none focus:border-[#ff5500] focus:ring-1 focus:ring-[#ff5500] text-sm font-mono transition-all"
            placeholder="••••••••"
          >
        </div>

        <div class="flex items-center justify-between text-xs">
          <label class="flex items-center text-gray-400 cursor-pointer select-none">
            <input type="checkbox" name="remember" class="rounded bg-gray-900 border-gray-700 text-[#ff5500] focus:ring-[#ff5500] mr-2">
            <span>Ingat sesi saya</span>
          </label>
        </div>

        <button 
          type="submit" 
          class="w-full py-3.5 px-6 rounded-xl bg-[#ff5500] hover:bg-[#ff6e26] text-black font-bold font-mono tracking-wider text-sm uppercase transition-all shadow-lg shadow-[#ff5500]/25 flex items-center justify-center gap-2 group cursor-pointer"
        >
          <span>MASUK KE DASHBOARD</span>
          <span class="transform group-hover:translate-x-1 transition-transform">➔</span>
        </button>
      </form>

      <!-- Demo Credentials Notice -->
      <div class="mt-6 pt-5 border-t border-gray-800/80 text-center">
        <div class="inline-block p-3 rounded-xl bg-gray-900/90 border border-gray-800 text-[11px] font-mono text-gray-400">
          <div class="text-[#ff5500] font-bold uppercase mb-1">Default Login Credentials:</div>
          <div>Email: <span class="text-white select-all">admin@raihan.dev</span></div>
          <div>Password: <span class="text-white select-all">password123</span></div>
        </div>
      </div>
    </div>

    <!-- Back to site link -->
    <div class="text-center mt-6">
      <a href="{{ route('portfolio') }}" class="text-xs font-mono text-gray-500 hover:text-white transition-colors flex items-center justify-center gap-1.5">
        <span>← Kembali ke Website Portfolio</span>
      </a>
    </div>
  </div>

</body>
</html>

