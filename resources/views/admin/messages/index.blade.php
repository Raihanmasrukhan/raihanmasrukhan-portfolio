@extends('layouts.admin')

@section('title', 'Inbox Pesan Kontak')

@section('content')
<div class="space-y-6">

  <!-- Header -->
  <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-gray-800">
    <div>
      <h1 class="text-3xl font-display tracking-wider text-white">INBOX PESAN KONTAK</h1>
      <p class="text-xs font-mono text-gray-400 mt-1">
        Daftar formulir penawaran proyek dan pertanyaan dari calon klien.
      </p>
    </div>

    <!-- Filter -->
    <div class="flex items-center gap-2 p-1 rounded-xl bg-gray-900 border border-gray-800 text-xs font-mono">
      <a href="{{ route('admin.messages.index') }}" class="px-3 py-1.5 rounded-lg transition-colors {{ !request('filter') ? 'bg-[#ff5500] text-black font-bold' : 'text-gray-400 hover:text-white' }}">
        Semua ({{ $messages->total() }})
      </a>
      <a href="{{ route('admin.messages.index', ['filter' => 'unread']) }}" class="px-3 py-1.5 rounded-lg transition-colors {{ request('filter') == 'unread' ? 'bg-[#ff5500] text-black font-bold' : 'text-gray-400 hover:text-white' }}">
        Belum Dibaca ({{ $unreadCount }})
      </a>
    </div>
  </div>

  <div class="space-y-3">
    @forelse($messages as $msg)
      <div class="p-5 rounded-2xl {{ $msg->is_read ? 'bg-[#121218] border border-gray-800' : 'bg-[#181824] border border-[#ff5500]/40' }} hover:border-gray-700 transition-all flex flex-col md:flex-row md:items-center justify-between gap-4">
        
        <div class="flex items-start gap-4 flex-1">
          <div class="w-10 h-10 rounded-xl {{ $msg->is_read ? 'bg-gray-800 text-gray-400' : 'bg-[#ff5500] text-black' }} font-mono font-bold text-sm flex items-center justify-center flex-shrink-0">
            ✉
          </div>
          <div>
            <div class="flex items-center gap-2">
              <span class="font-bold text-sm text-white">{{ $msg->name }}</span>
              @if(!$msg->is_read)
                <span class="px-1.5 py-0.5 text-[9px] font-mono bg-[#ff5500] text-black font-black rounded uppercase">Baru</span>
              @endif
            </div>
            <div class="text-xs font-mono text-[#ff5500] mt-0.5">
              {{ $msg->email_or_phone }} • <span class="text-gray-400">{{ $msg->project_type ?? 'Inquiry' }}</span>
            </div>
            <p class="text-xs text-gray-300 line-clamp-1 mt-1.5">
              "{{ $msg->message }}"
            </p>
          </div>
        </div>

        <div class="flex items-center gap-3 font-mono text-xs text-gray-400">
          <span class="text-[11px] text-gray-500 whitespace-nowrap">{{ $msg->created_at->diffForHumans() }}</span>
          
          <a href="{{ route('admin.messages.show', $msg) }}" class="px-3 py-1.5 rounded-lg bg-gray-800 hover:bg-gray-700 text-white transition-colors">
            Lihat Detail
          </a>

          <form action="{{ route('admin.messages.destroy', $msg) }}" method="POST" onsubmit="return confirm('Hapus pesan ini?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="text-red-400 hover:text-red-300 p-1" title="Hapus">
              ✕
            </button>
          </form>
        </div>

      </div>
    @empty
      <div class="p-12 text-center rounded-2xl bg-[#121218] border border-gray-800 text-gray-500 font-mono text-xs">
        Tidak ada pesan kontak.
      </div>
    @endforelse
  </div>

  @if($messages->hasPages())
    <div class="p-4 rounded-xl bg-[#121218] border border-gray-800">
      {{ $messages->links() }}
    </div>
  @endif

</div>
@endsection

