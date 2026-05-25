<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover"/>
  <title>Kashy – Dashboard Admin</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet"/>
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          fontFamily: { poppins: ['Poppins','sans-serif'] },
          colors: {
            kashy: {
              dark:        '#1a1a1a',
              brown:       '#C49A6C',
              'brown-deep':'#7B4F2E',
              cream:       '#F5F0EB',
              'cream-dark':'#EDE5DB',
              muted:       '#8A7968',
              border:      '#E0D8CE',
              sidebar:     '#ffffff',
            }
          },
          boxShadow: {
            card:    '0 2px 18px 0 rgba(60,40,10,.07)',
            sidebar: '2px 0 20px 0 rgba(60,40,10,.08)',
            btn:     '0 4px 14px 0 rgba(196,154,108,.35)',
          }
        }
      }
    }
  </script>
  <style>
    * { font-family:'Poppins',sans-serif; box-sizing:border-box; }
    body { background:#F5F0EB; margin:0; }

    /* ── Sidebar (sliding drawer) ── */
    #sidebar {
      position: fixed; top:0; left:0; height:100vh; width:280px;
      background:#fff; box-shadow: 2px 0 24px rgba(60,40,10,.12);
      z-index:60; transition: transform .3s cubic-bezier(0.2, 0.9, 0.4, 1.1);
      display:flex; flex-direction:column; overflow-y:auto;
      transform: translateX(-100%);
    }
    #sidebar.sidebar-open {
      transform: translateX(0%);
    }

    /* Overlay gelap */
    #overlay {
      display:none; position:fixed; inset:0; background:rgba(0,0,0,.45);
      z-index:55; backdrop-filter:blur(3px);
    }
    #overlay.show { display:block; }

    /* Animasi fade-up */
    @keyframes fadeUp {
      from { opacity:0; transform:translateY(18px); }
      to   { opacity:1; transform:translateY(0); }
    }
    .fade-up { animation: fadeUp .45s ease both; }
    .d1 { animation-delay:.05s; }
    .d2 { animation-delay:.10s; }
    .d3 { animation-delay:.15s; }
    .d4 { animation-delay:.20s; }
    .d5 { animation-delay:.25s; }

    /* Stat card left accent (dipertahankan) */
    .stat-card { position:relative; overflow:hidden; }
    .stat-card::before {
      content:''; position:absolute; left:0; top:0; bottom:0; width:4px;
      background:#C49A6C; border-radius:4px 0 0 4px;
    }

    /* Nav items sidebar */
    .nav-item {
      display:flex; align-items:center; gap:12px; padding:11px 18px;
      border-radius:12px; cursor:pointer; transition: all .15s;
      font-size:14px; font-weight:500; color:#1a1a1a;
      text-decoration:none; width:100%;
    }
    .nav-item:hover { background:#F5F0EB; }
    .nav-item.active { background:#F7EFE5; color:#7B4F2E; font-weight:600; }
    .nav-item.active svg { stroke:#7B4F2E; }

    /* Module buttons (sama seperti staff) */
    .mod-btn {
      display:flex; align-items:center; gap:12px; width:100%;
      background:rgba(255,255,255,.07); border:1px solid rgba(255,255,255,.12);
      border-radius:12px; padding:14px 16px; cursor:pointer;
      transition: background .18s, transform .12s;
      color:#fff; font-size:13.5px; font-weight:500;
    }
    .mod-btn:hover { background:rgba(255,255,255,.13); transform:translateX(3px); }

    /* Scrollbar */
    ::-webkit-scrollbar { width:4px; }
    ::-webkit-scrollbar-track { background:transparent; }
    ::-webkit-scrollbar-thumb { background:#C49A6C; border-radius:10px; }
    
    /* Penyesuaian stat card agar rapi di tablet */
    @media (min-width: 768px) {
      .stat-card {
  position: relative;
  overflow: hidden;
  min-height: 135px;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  transition: transform 0.2s, box-shadow 0.2s;
}
      .stat-card .text-3xl {
        font-size: 1.9rem;
      }
    }
    @media (max-width: 640px) {
      .stat-card {
        padding: 1.25rem;
      }
    }
    .rupiah-number {
      word-break: break-word;
      line-height: 1.2;
      letter-spacing: -0.01em;
    }
  </style>
</head>
@include('owner.components.sidebar')
<body>

<!-- ================= MAIN CONTENT ================= -->
<main id="main" class="min-h-screen bg-kashy-cream">
  @include('owner.components.topbar')

  <!-- Dashboard Content – DISESUAIKAN DENGAN UKURAN MANAJEMEN STAFF (max-w-2xl) -->
  <div class="px-5 md:px-8 py-6 max-w-2xl mx-auto">
    
    <!-- Hero / Judul -->
    <div class="fade-up mb-6">
      <p class="text-[11px] font-bold tracking-widest text-kashy-brown uppercase mb-1">Dashboard Owner</p>
      <h1 class="text-3xl md:text-3xl font-extrabold text-kashy-dark leading-tight">
        Selamat Datang Kembali, Owner
      </h1>
      <p class="mt-2 text-kashy-muted text-sm leading-relaxed max-w-md">
        Berikut ringkasan terkurasi tentang aktivitas terkini sistem Anda.
      </p>
    </div>

    <!-- Stat Cards Grid (responsif: 1 kolom mobile, 2 tablet, 3 desktop) -->
<div class="flex flex-col gap-4 mb-6">
  
<!-- Total Pendapatan -->
<div class="fade-up d1 stat-card bg-white rounded-2xl p-5 shadow-card">
  
  <div class="flex items-start justify-between mb-3">
    <span class="text-[11px] font-semibold tracking-widest text-kashy-muted uppercase">
      Total Pendapatan
    </span>

    <div class="w-9 h-9 rounded-xl bg-kashy-cream flex items-center justify-center">
      <svg class="w-5 h-5 text-kashy-brown"
           fill="none"
           stroke="currentColor"
           viewBox="0 0 24 24"
           stroke-width="1.8">
        <rect x="2" y="6" width="20" height="12" rx="2"/>
        <circle cx="12" cy="12" r="3"/>
        <path d="M6 12h.01M18 12h.01"/>
      </svg>
    </div>
  </div>

  <p class="text-2xl font-bold text-kashy-dark rupiah-number">
    Rp 2.150.000.000
  </p>

</div>
      <!-- Total Pesanan -->
      <div class="fade-up d2 stat-card bg-white rounded-2xl p-5 shadow-card">
        <div class="flex items-start justify-between mb-3">
          <span class="text-[11px] font-semibold tracking-widest text-kashy-muted uppercase">Total Pesanan</span>
          <div class="w-9 h-9 rounded-xl bg-kashy-cream flex items-center justify-center">
            <svg class="w-5 h-5 text-kashy-brown" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8">
              <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/>
              <line x1="3" y1="6" x2="21" y2="6"/>
              <path d="M16 10a4 4 0 0 1-8 0"/>
            </svg>
          </div>
        </div>
        <p class="text-2xl font-bold text-kashy-dark">1,284</p>
      </div>

      <!-- Diskon Aktif -->
      <div class="fade-up d3 stat-card bg-white rounded-2xl p-5 shadow-card">
        <div class="flex items-start justify-between mb-3">
          <span class="text-[11px] font-semibold tracking-widest text-kashy-muted uppercase">Diskon Aktif</span>
          <div class="w-9 h-9 rounded-xl bg-kashy-cream flex items-center justify-center">
            <svg class="w-5 h-5 text-kashy-brown" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8">
              <path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/>
              <line x1="7" y1="7" x2="7.01" y2="7"/>
            </svg>
          </div>
        </div>
        <p class="text-2xl font-bold text-kashy-dark">8</p>
      </div>
    </div>

    <!-- Akses Cepat (module buttons, sama persis dengan manajemen staff style) -->
    <div class="fade-up d4 bg-kashy-dark rounded-2xl p-6 mb-6">
      <p class="text-[11px] font-semibold tracking-widest text-white/50 uppercase mb-4">
        Akses Cepat
      </p>

      <div class="flex flex-col gap-4 mb-6">
        <!-- Laporan Keuangan -->
        <a href="{{ route('owner.laporan.keuangan') }}" class="mod-btn">
          <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
            <line x1="18" y1="20" x2="18" y2="10"/>
            <line x1="12" y1="20" x2="12" y2="4"/>
            <line x1="6" y1="20" x2="6" y2="14"/>
          </svg>
          Laporan Keuangan
        </a>

        <!-- Manajemen Toko -->
        <a href="{{ route('manajemen.toko') }}" class="mod-btn">
          <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
            <polyline points="9 22 9 12 15 12 15 22"/>
          </svg>
          Manajemen Toko
        </a>

        <!-- Manajemen Produk -->
        <a href="{{ route('manajemen.produk') }}" class="mod-btn">
          <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
            <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/>
            <polyline points="3.27 6.96 12 12.01 20.73 6.96"/>
            <line x1="12" y1="22.08" x2="12" y2="12"/>
          </svg>
          Manajemen Produk
        </a>

        <!-- Manajemen Diskon -->
        <a href="{{ route('manajemen.diskon') }}" class="mod-btn">
          <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
            <line x1="19" y1="5" x2="5" y2="19"/>
            <circle cx="6.5" cy="6.5" r="2.5"/>
            <circle cx="17.5" cy="17.5" r="2.5"/>
          </svg>
          Manajemen Diskon
        </a>
      </div>
    </div>

    <!-- (Optional) Jika ingin tambahan komentar atau footer, bisa ditambahkan di sini, 
         namun sesuai permintaan tidak mengubah isi, hanya ukuran. -->
  </div>
</main>

<script>
  const sidebar = document.getElementById('sidebar');
  const overlay = document.getElementById('overlay');
  const menuBtn = document.getElementById('global-menu-toggle');
  const navLinks = document.querySelectorAll('[data-nav]');

  function openSidebar() {
    sidebar.classList.add('sidebar-open');
    overlay.classList.add('show');
    document.body.style.overflow = 'hidden';
  }

  function closeSidebar() {
    sidebar.classList.remove('sidebar-open');
    overlay.classList.remove('show');
    document.body.style.overflow = '';
  }

  function toggleSidebar() {
    if (sidebar.classList.contains('sidebar-open')) {
      closeSidebar();
    } else {
      openSidebar();
    }
  }

  if (menuBtn) {
    menuBtn.addEventListener('click', (e) => {
      e.stopPropagation();
      toggleSidebar();
    });
  }

  function setActiveNavItem(clickedItem) {
    navLinks.forEach(link => {
      link.classList.remove('active');
      const svg = link.querySelector('svg');
      if (svg) svg.setAttribute('stroke', 'currentColor');
    });
    clickedItem.classList.add('active');
    const activeSvg = clickedItem.querySelector('svg');
    if (activeSvg) activeSvg.setAttribute('stroke', '#7B4F2E');
    if (sidebar.classList.contains('sidebar-open')) closeSidebar();
  }

  navLinks.forEach(link => {
    link.addEventListener('click', () => {
      closeSidebar(); 
    });
    if (link.classList.contains('active')) {
      const svg = link.querySelector('svg');
      if (svg) svg.setAttribute('stroke', '#7B4F2E');
    } else {
      const svg = link.querySelector('svg');
      if (svg) svg.setAttribute('stroke', 'currentColor');
    }
  });

  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape' && sidebar.classList.contains('sidebar-open')) closeSidebar();
  });

  // Pastikan sidebar tertutup saat load
  sidebar.classList.remove('sidebar-open');
  overlay.classList.remove('show');
  document.body.style.overflow = '';
</script>
</body>
</html>