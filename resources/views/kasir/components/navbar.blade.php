<style>
  .bn-item{
    transition: all .2s ease;
  }

  .bn-icon{
    transition: all .2s ease;
  }

  .bn-label{
    transition: all .2s ease;
  }

  .bn-item svg{
    transition: all .2s ease;
    stroke: #9C8B7E;
  }

  /* HOVER */
  .bn-item:hover .bn-icon{
    background:#F0D7C7;
    transform: translateY(-2px);
  }

  .bn-item:hover svg{
    stroke:#C8966C;
  }

  .bn-item:hover .bn-label{
    color:#C8966C;
  }

  /* ACTIVE */
  .bn-item.active .bn-icon{
    background:#F0D7C7;
    box-shadow:0 4px 12px rgba(200,150,108,0.18);
  }

  .bn-item.active svg{
    stroke:#C8966C;
  }

  .bn-item.active .bn-label{
    color:#C8966C;
    font-weight:600;
  }
</style>

<nav class="fixed bottom-0 left-0 right-0 z-50 bg-white border-t border-border flex justify-around py-2 pb-4 shadow-[0_-2px_12px_rgba(28,28,28,0.06)]">

  <!-- Dashboard -->
  <a href="{{ route('dashboard-kasir') }}"
     class="bn-item {{ request()->routeIs('dashboard-kasir') ? 'active' : '' }} flex flex-col items-center gap-1 flex-1">

    <div class="bn-icon w-10 h-10 rounded-xl flex items-center justify-center">

      <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke-width="2">
        <path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
        <polyline points="9 22 9 12 15 12 15 22"/>
      </svg>

    </div>

    <span class="bn-label text-[10px] font-medium">
      Beranda
    </span>
  </a>

  <!-- Riwayat -->
  <a href="{{ route('kasir.riwayattransaksi') }}"
     class="bn-item {{ request()->routeIs('kasir.riwayattransaksi') ? 'active' : '' }} flex flex-col items-center gap-1 flex-1">
    <div class="bn-icon w-10 h-10 rounded-xl flex items-center justify-center">

      <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke-width="2">
        <rect x="3" y="4" width="18" height="18" rx="2"/>
        <path d="M16 2v4M8 2v4M3 10h18"/>
        <path d="m9 16 2 2 4-4"/>
      </svg>

    </div>

    <span class="bn-label text-[10px] font-medium">
      Riwayat
    </span>
  </a>

  <!-- Laporan -->
  <a href="{{ route('kasir.laporantransaksi') }}"
     class="bn-item {{ request()->routeIs('kasir.laporantransaksi') ? 'active' : '' }} flex flex-col items-center gap-1 flex-1">

    <div class="bn-icon w-10 h-10 rounded-xl flex items-center justify-center">

      <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke-width="2">
        <path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/>
        <line x1="3" y1="6" x2="21" y2="6"/>
        <path d="M16 10a4 4 0 0 1-8 0"/>
      </svg>

    </div>

    <span class="bn-label text-[10px] font-medium">
      Laporan
    </span>
  </a>

  <!-- Shift -->
  <a href="{{ route('kasir.shiftkasir') }}"
     class="bn-item {{ request()->routeIs('kasir.shiftkasir') ? 'active' : '' }} flex flex-col items-center gap-1 flex-1">

    <div class="bn-icon w-10 h-10 rounded-xl flex items-center justify-center">

      <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke-width="2">
        <circle cx="12" cy="12" r="10"/>
        <path d="M12 6v6l4 2"/>
      </svg>

    </div>

    <span class="bn-label text-[10px] font-medium">
      Shift
    </span>
  </a>

</nav>