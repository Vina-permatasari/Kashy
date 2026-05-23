<!-- ═══════════════ SIDEBAR (NAVIGASI TERSEMBUNYI) ═══════════════ -->
<aside id="sidebar">
  <!-- Logo & brand dalam sidebar -->
  <div class="flex items-center gap-3 px-5 py-5 border-b border-kashy-border">
    <span class="font-bold text-kashy-dark text-lg tracking-wide">Kashy</span>
  </div>

  <!-- Navigasi utama -->
  <nav class="flex-1 px-3 py-5 flex flex-col gap-1.5">

    <a href="{{ route('owner.dashboard') }}" class="nav-item {{ request()->routeIs('owner.dashboard') ? 'active' : '' }}" data-nav>
      <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="#7B4F2E" stroke-width="1.8" viewBox="0 0 24 24">
        <rect x="3" y="3" width="7" height="7" rx="1.5"/>
        <rect x="14" y="3" width="7" height="7" rx="1.5"/>
        <rect x="3" y="14" width="7" height="7" rx="1.5"/>
        <rect x="14" y="14" width="7" height="7" rx="1.5"/>
      </svg>
      Dashboard Admin
    </a>

    <a href="javascript:void(0)" class="nav-item" data-nav>
      <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
  <line x1="18" y1="20" x2="18" y2="10"/>
  <line x1="12" y1="20" x2="12" y2="4"/>
  <line x1="6" y1="20" x2="6" y2="14"/>
</svg>
      Laporan Keuangan
    </a>

    <a href="javascript:void(0)" class="nav-item" data-nav>
      <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
        <path d="M9 5H7a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-2"/>
        <rect x="9" y="3" width="6" height="4" rx="1"/>
        <line x1="9" y1="12" x2="15" y2="12"/><line x1="9" y1="16" x2="12" y2="16"/>
      </svg>
      Stock Opname
    </a>

    <a href="javascript:void(0)" class="nav-item" data-nav>
      <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
        <circle cx="9" cy="7" r="4"/>
        <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
        <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
      </svg>
      Manajemen Staff
    </a>

    <a href="javascript:void(0)" class="nav-item" data-nav>
      <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
        <polyline points="9 22 9 12 15 12 15 22"/>
      </svg>
      Manajemen Toko
    </a>

    <a href="{{ route('manajemen.diskon') }}" class="nav-item {{ request()->routeIs('manajemen.diskon') ? 'active' : '' }}" data-nav>
      <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
        <line x1="19" y1="5" x2="5" y2="19"/>
        <circle cx="6.5" cy="6.5" r="2.5"/>
        <circle cx="17.5" cy="17.5" r="2.5"/>
    </svg>
      Manajemen Diskon
    </a>

    <a href="javascript:void(0)" class="nav-item" data-nav>
      <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
        <path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/>
        <line x1="7" y1="7" x2="7.01" y2="7"/>
      </svg>
      Manajemen Kategori
    </a>

    <a href="javascript:void(0)" class="nav-item" data-nav>
      <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
        <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/>
        <polyline points="3.27 6.96 12 12.01 20.73 6.96"/>
        <line x1="12" y1="22.08" x2="12" y2="12"/>
      </svg>
      Manajemen Produk
    </a>

    <a href="javascript:void(0)" class="nav-item" data-nav>
      <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
        <line x1="4" y1="21" x2="4" y2="14"/>
        <line x1="4" y1="10" x2="4" y2="3"/>
        <line x1="12" y1="21" x2="12" y2="12"/>
        <line x1="12" y1="8" x2="12" y2="3"/>
        <line x1="20" y1="21" x2="20" y2="16"/>
        <line x1="20" y1="12" x2="20" y2="3"/>
        <line x1="1" y1="14" x2="7" y2="14"/>
        <line x1="9" y1="8" x2="15" y2="8"/>
        <line x1="17" y1="16" x2="23" y2="16"/>
      </svg>
      Pengaturan Transaksi
    </a>

    <a href="javascript:void(0)" class="nav-item" data-nav>
      <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
        <polyline points="14 2 14 8 20 8"/>
        <line x1="16" y1="13" x2="8" y2="13"/>
        <line x1="16" y1="17" x2="8" y2="17"/>
        <polyline points="10 9 9 9 8 9"/>
      </svg>
      Struk
    </a>

    <a href="javascript:void(0)" class="nav-item" data-nav>
      <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
        <polyline points="6 9 6 2 18 2 18 9"/>
        <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/>
        <rect x="6" y="14" width="12" height="8"/>
      </svg>
      Konfigurasi Printer
    </a>

    <a href="javascript:void(0)" class="nav-item" data-nav>
      <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
        <polyline points="1 4 1 10 7 10"/>
        <polyline points="23 20 23 14 17 14"/>
        <path d="M20.49 9A9 9 0 0 0 5.64 5.64L1 10M23 14l-4.64 4.36A9 9 0 0 1 3.51 15"/>
      </svg>
      Backup &amp; Restore
    </a>

  </nav>

  <!-- Profile bottom sidebar -->
  <div class="px-4 py-5 border-t border-kashy-border">
    <div class="flex items-center gap-3">
      <div class="w-9 h-9 rounded-full bg-kashy-brown flex items-center justify-center text-white font-bold text-sm flex-shrink-0">A</div>
      <div class="min-w-0">
        <p class="text-xs font-semibold text-kashy-dark truncate">Admin</p>
        <p class="text-[11px] text-kashy-muted truncate">admin@kashy.id</p>
      </div>
    </div>
  </div>
</aside>

<!-- Overlay saat sidebar terbuka -->
<div id="overlay" onclick="closeSidebar()"></div>