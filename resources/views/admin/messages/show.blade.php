@extends('layouts.admin')

@section('title', 'Detail Pesan — ' . $contactMessage->name)

@section('content')
<div class="space-y-6 max-w-4xl">

  <div class="flex items-center justify-between pb-6 border-b border-gray-800">
    <div>
      <h1 class="text-3xl font-display tracking-wider text-white">PESAN DARI: {{ strtoupper($contactMessage->name) }}</h1>
      <p class="text-xs font-mono text-gray-400 mt-1">Diterima pada {{ $contactMessage->created_at->format('l, d F Y - H:i:s') }} WIB</p>
    </div>
    <a href="{{ route('admin.messages.index') }}" class="text-xs font-mono text-gray-400 hover:text-white transition-colors">
      ← Kembali ke Inbox
    </a>
  </div>

  <div class="p-6 md:p-8 rounded-2xl bg-[#121218] border border-gray-800 shadow-xl space-y-6">
    
    <!-- Sender Metadata Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 p-4 rounded-xl bg-[#0a0a0d] border border-gray-800/80">
      <div>
        <div class="text-[10px] font-mono uppercase text-gray-500 mb-1">Pengirim</div>
        <div class="font-bold text-sm text-white">{{ $contactMessage->name }}</div>
      </div>

      <div>
        <div class="text-[10px] font-mono uppercase text-gray-500 mb-1">Kontak (Email / HP)</div>
        <div class="font-mono text-sm text-[#ff5500]">{{ $contactMessage->email_or_phone }}</div>
      </div>

      <div>
        <div class="text-[10px] font-mono uppercase text-gray-500 mb-1">Layanan Diminati</div>
        <div class="font-mono text-sm text-gray-300">{{ $contactMessage->project_type ?? 'Umum' }}</div>
      </div>
    </div>

    <!-- Message Body -->
    <div>
      <div class="text-xs font-mono uppercase tracking-wider text-gray-400 mb-2">Isi Pesan / Kebutuhan Proyek:</div>
      <div class="p-6 rounded-xl bg-[#0a0a0d] border border-gray-800 text-sm text-gray-200 leading-relaxed font-mono whitespace-pre-wrap">
{{ $contactMessage->message }}
      </div>
    </div>

    <!-- Quick Reply Actions -->
    <div class="pt-6 border-t border-gray-800 flex flex-wrap items-center justify-between gap-4">
      <div class="flex items-center gap-3">
        <!-- Direct WA button -->
        @php
          $cleanPhone = preg_replace('/[^0-9]/', '', $contactMessage->email_or_phone);
          if (str_starts_with($cleanPhone, '0')) {
            $cleanPhone = '62' . substr($cleanPhone, 1);
          }
        @endphp
        @if(strlen($cleanPhone) >= 9)
          <a href="https://wa.me/{{ $cleanPhone }}?text=Halo%20{{ urlencode($contactMessage->name) }},%20terima%20kasih%20telah%20menghubungi%20saya%20terkait%20{{ urlencode($contactMessage->project_type ?? 'proyek') }}..." target="_blank" class="px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white font-mono text-xs font-bold uppercase tracking-wider flex items-center gap-2 shadow-lg shadow-emerald-600/20">
            <span>Balas Langsung via WhatsApp</span>
            <span>↗</span>
          </a>
        @endif

        @if(filter_var($contactMessage->email_or_phone, FILTER_VALIDATE_EMAIL))
          <a href="mailto:{{ $contactMessage->email_or_phone }}?subject=Re:%20Proyek%20{{ urlencode($contactMessage->project_type ?? 'Portfolio') }}" class="px-5 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-500 text-white font-mono text-xs font-bold uppercase tracking-wider flex items-center gap-2 shadow-lg shadow-blue-600/20">
            <span>Balas via Email</span>
            <span>✉</span>
          </a>
        @endif

        <!-- Toggle Read -->
        <form action="{{ route('admin.messages.toggle-read', $contactMessage) }}" method="POST">
          @csrf
          @method('PATCH')
          <button type="submit" class="px-4 py-2.5 rounded-xl bg-gray-800 hover:bg-gray-700 text-gray-300 text-xs font-mono">
            {{ $contactMessage->is_read ? 'Tandai Belum Dibaca' : 'Tandai Sudah Dibaca' }}
          </button>
        </form>
      </div>

      <!-- Delete -->
      <form action="{{ route('admin.messages.destroy', $contactMessage) }}" method="POST" onsubmit="return confirm('Hapus pesan ini secara permanen?');">
        @csrf
        @method('DELETE')
        <button type="submit" class="px-4 py-2.5 rounded-xl bg-red-950/40 border border-red-500/30 text-red-400 hover:bg-red-900/50 text-xs font-mono">
          Hapus Pesan
        </button>
      </form>
    </div>

  </div>

</div>
@endsection

