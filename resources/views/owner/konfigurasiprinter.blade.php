<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover"/>
  <title>Kashy – Konfigurasi Printer</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet"/>
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          fontFamily: { poppins: ['Poppins','sans-serif'] },
          colors: {
            kashy: {
              dark:         '#1a1a1a',
              brown:        '#C49A6C',
              'brown-deep': '#7B4F2E',
              cream:        '#F5F0EB',
              'cream-dark': '#EDE5DB',
              muted:        '#8A7968',
              border:       '#E0D8CE',
            }
          },
          boxShadow: {
            card: '0 2px 18px 0 rgba(60,40,10,.07)',
            btn:  '0 4px 14px 0 rgba(196,154,108,.35)',
          }
        }
      }
    }
  </script>
  <style>
    * { font-family:'Poppins',sans-serif; box-sizing:border-box; }
    body { background:#F5F0EB; margin:0; }

    /* ── Sidebar ── */
    #sidebar {
      position:fixed; top:0; left:0; height:100vh; width:280px;
      background:#fff; box-shadow:2px 0 24px rgba(60,40,10,.12);
      z-index:60; transition:transform .3s cubic-bezier(0.2,0.9,0.4,1.1);
      display:flex; flex-direction:column; overflow-y:auto;
      transform:translateX(-100%);
    }
    #sidebar.sidebar-open { transform:translateX(0); }
    #overlay { display:none; position:fixed; inset:0; background:rgba(0,0,0,.45); z-index:55; backdrop-filter:blur(3px); }
    #overlay.show { display:block; }

    /* ── Animations ── */
    @keyframes fadeUp {
      from { opacity:0; transform:translateY(18px); }
      to   { opacity:1; transform:translateY(0); }
    }
    .fade-up { animation:fadeUp .4s ease both; }
    .d1{animation-delay:.05s} .d2{animation-delay:.10s}
    .d3{animation-delay:.15s} .d4{animation-delay:.20s}
    .d5{animation-delay:.25s}

    /* ── Nav items ── */
    .nav-item {
      display:flex; align-items:center; gap:12px; padding:11px 18px;
      border-radius:12px; cursor:pointer; transition:all .15s;
      font-size:14px; font-weight:500; color:#1a1a1a;
      text-decoration:none; width:100%;
    }
    .nav-item:hover { background:#F5F0EB; }
    .nav-item.active { background:#F7EFE5; color:#7B4F2E; font-weight:600; }
    .nav-item.active svg { stroke:#7B4F2E; }

    /* ── Search input ── */
    .search-wrap { position:relative; flex:1; }
    .search-wrap svg { position:absolute; left:12px; top:50%; transform:translateY(-50%); pointer-events:none; }
    .search-input {
      width:100%; padding:13px 14px 13px 38px;
      border:1.5px solid #E0D8CE; border-radius:12px;
      font-size:13px; font-family:'Poppins',sans-serif;
      color:#1a1a1a; background:#FAF6F2; outline:none;
      transition:border-color .2s;
    }
    .search-input:focus { border-color:#C49A6C; background:#fff; }
    .search-input::placeholder { color:#BFB4AC; }

    /* ── Refresh btn ── */
    .refresh-btn {
      width:46px; height:46px; border-radius:12px;
      background:#1a1a1a; border:none; cursor:pointer;
      display:flex; align-items:center; justify-content:center;
      flex-shrink:0; transition:background .2s;
    }
    .refresh-btn:hover { background:#333; }
    .refresh-btn.spinning svg { animation:spin .6s linear; }
    @keyframes spin { from{transform:rotate(0deg)} to{transform:rotate(360deg)} }

    /* ── Printer device row ── */
    .device-row {
      display:flex; align-items:center; gap:12px;
      background:#FAF6F2; border-radius:14px; padding:14px;
    }
    .device-icon-wrap {
      width:40px; height:40px; border-radius:10px;
      background:#F0E8DF; display:flex; align-items:center; justify-content:center;
      flex-shrink:0;
    }

    /* ── Badge ── */
    .badge-aktif {
      display:inline-flex; align-items:center; gap:5px;
      font-size:11px; font-weight:700; color:#2E7D32;
      background:#E8F5E9; padding:4px 10px; border-radius:20px;
    }
    .badge-dot { width:7px; height:7px; border-radius:50%; background:#2E7D32; }

    .badge-nonaktif {
      display:inline-flex; align-items:center; justify-content:center;
      font-size:12px; font-weight:700; color:#C49A6C;
      border:1.5px solid #C49A6C; padding:5px 14px; border-radius:10px;
      cursor:pointer; transition:background .15s;
    }
    .badge-nonaktif:hover { background:#FDF1E8; }

    /* ── Scan result rows ── */
    .printer-row {
      display:flex; align-items:center; gap:10px;
      padding:14px 16px; background:#fff;
      border:1.5px solid #E0D8CE; border-radius:12px;
      cursor:pointer; transition:border-color .2s, background .2s;
    }
    .printer-row:hover { border-color:#C49A6C; background:#FAF6F2; }
    .printer-row.selected { border-color:#C49A6C; background:#FDF1E8; }

    /* ── Paper size chip ── */
    .paper-chip {
      flex:1; padding:12px; border-radius:12px; text-align:center;
      font-size:14px; font-weight:600; cursor:pointer;
      border:1.5px solid #E0D8CE; background:#fff; color:#1a1a1a;
      transition:all .2s; font-family:'Poppins',sans-serif;
    }
    .paper-chip.active {
      border-color:#C49A6C; background:#FDF1E8; color:#C49A6C;
    }
    .paper-chip .check {
      display:none; margin-right:6px;
    }
    .paper-chip.active .check { display:inline; }

    /* ── Section label ── */
    .section-label {
      font-size:10px; font-weight:700; color:#8A7968;
      text-transform:uppercase; letter-spacing:.08em; margin-bottom:12px;
    }

    /* ── Scrollbar ── */
    ::-webkit-scrollbar { width:4px; }
    ::-webkit-scrollbar-track { background:transparent; }
    ::-webkit-scrollbar-thumb { background:#C49A6C; border-radius:10px; }
  </style>
</head>

@include('owner.components.sidebar')

<body>
<main id="main" class="min-h-screen bg-kashy-cream">
  @include('owner.components.topbar')

  <div class="px-5 md:px-8 py-6 max-w-2xl mx-auto">

    <!-- ── Header ── -->
    <div class="fade-up d1 mb-6">
      <h1 class="text-3xl font-extrabold text-kashy-dark">Konfigurasi Printer</h1>
    </div>

    <!-- ══════════════════════════════
         CARD 1 — Perangkat Terhubung
         ══════════════════════════════ -->
    <div class="fade-up d2 bg-white rounded-2xl p-5 mb-4" style="box-shadow:0 2px 18px 0 rgba(60,40,10,.07);">

      <div class="flex items-start justify-between mb-1">
        <h2 class="text-base font-bold text-kashy-dark">Perangkat Terhubung</h2>
        <span class="badge-aktif">
          <span class="badge-dot"></span>
          Aktif
        </span>
      </div>
      <p class="text-sm text-kashy-muted mb-4">Kelola koneksi printer POS aktif Anda</p>

      <!-- Device row -->
      <div class="device-row">
        <div class="device-icon-wrap">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#C49A6C" stroke-width="1.8">
            <polyline points="6 9 6 2 18 2 18 9"/>
            <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/>
            <rect x="6" y="14" width="12" height="8"/>
          </svg>
        </div>
        <div class="flex-1 min-w-0">
          <p class="text-sm font-bold text-kashy-dark">Epson TM-T82X</p>
          <p class="text-xs text-kashy-muted">Bluetooth •</p>
          <p class="text-xs text-kashy-muted">Terhubung: 13:42:18</p>
        </div>
        <button class="badge-nonaktif" onclick="nonaktifkanPrinter()">Nonaktif</button>
      </div>

    </div>

    <!-- ══════════════════════════════
         CARD 2 — Pindai Printer
         ══════════════════════════════ -->
    <div class="fade-up d3 bg-white rounded-2xl p-5 mb-4" style="box-shadow:0 2px 18px 0 rgba(60,40,10,.07);">

      <h2 class="text-base font-bold text-kashy-dark mb-4">Pindai Printer</h2>

      <!-- Search + refresh -->
      <div class="flex gap-3 mb-4">
        <div class="search-wrap">
          <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#8A7968" stroke-width="2">
            <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
          </svg>
          <input
            type="text"
            class="search-input"
            placeholder="Cari melalui Bluetooth atau Jaringan..."
            oninput="filterPrinter(this.value)"
          />
        </div>
        <button class="refresh-btn" id="refreshBtn" onclick="refreshScan()" title="Refresh">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2.2">
            <polyline points="23 4 23 10 17 10"/>
            <polyline points="1 20 1 14 7 14"/>
            <path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"/>
          </svg>
        </button>
      </div>

      <!-- Scan results -->
      <div class="flex flex-col gap-2" id="printerList">
        <div class="printer-row" onclick="pilihPrinter(this, 'Rongta RP326')">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#8A7968" stroke-width="2">
            <path d="M12 2C8 2 5 6 5 10c0 4.5 4 8 7 11 3-3 7-6.5 7-11 0-4-3-8-7-8z"/>
            <line x1="8.5" y1="12" x2="15.5" y2="12"/>
          </svg>
          <span class="text-sm font-medium text-kashy-dark">Rongta RP326</span>
        </div>
        <div class="printer-row" onclick="pilihPrinter(this, 'POS-58 Printer')">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#8A7968" stroke-width="2">
            <path d="M12 2C8 2 5 6 5 10c0 4.5 4 8 7 11 3-3 7-6.5 7-11 0-4-3-8-7-8z"/>
            <line x1="8.5" y1="12" x2="15.5" y2="12"/>
          </svg>
          <span class="text-sm font-medium text-kashy-dark">POS-58 Printer</span>
        </div>
      </div>

    </div>

    <!-- ══════════════════════════════
         CARD 3 — Spesifikasi Kertas
         ══════════════════════════════ -->
    <div class="fade-up d4 bg-white rounded-2xl p-5 mb-4" style="box-shadow:0 2px 18px 0 rgba(60,40,10,.07);">

      <h2 class="text-base font-bold text-kashy-dark mb-4">Spesifikasi Kertas</h2>

      <p class="section-label">Pengaturan Margin</p>

      <div class="flex gap-3 mb-6">
        <button class="paper-chip active" onclick="pilihKertas(this, '80mm')">
          <span class="check">✓</span>80mm
        </button>
        <button class="paper-chip" onclick="pilihKertas(this, '58mm')">
          <span class="check">✓</span>58mm
        </button>
      </div>

      <!-- Tes Print -->
      <button
        onclick="jalankanTesPrint()"
        class="w-full py-4 rounded-2xl font-bold text-white text-sm tracking-wide mb-2 transition-all hover:opacity-90 active:scale-[.98]"
        style="background:#C49A6C; box-shadow:0 4px 14px 0 rgba(196,154,108,.35);">
        Jalankan Tes Print
      </button>
      <p class="text-center text-xs text-kashy-muted">Memverifikasi koneksi dan penyelarasan</p>

    </div>

  </div>
</main>

<script>
  /* ── Sidebar ── */
  const sidebar = document.getElementById('sidebar');
  const overlay = document.getElementById('overlay');
  const menuBtn = document.getElementById('global-menu-toggle');

  function openSidebar()  { sidebar.classList.add('sidebar-open'); overlay.classList.add('show'); document.body.style.overflow='hidden'; }
  function closeSidebar() { sidebar.classList.remove('sidebar-open'); overlay.classList.remove('show'); document.body.style.overflow=''; }
  function toggleSidebar() { sidebar.classList.contains('sidebar-open') ? closeSidebar() : openSidebar(); }

  if (menuBtn) menuBtn.addEventListener('click', e => { e.stopPropagation(); toggleSidebar(); });
  if (overlay)  overlay.addEventListener('click', closeSidebar);
  document.addEventListener('keydown', e => { if (e.key==='Escape') closeSidebar(); });

  /* ── Pilih printer dari list ── */
  function pilihPrinter(el, nama) {
    document.querySelectorAll('.printer-row').forEach(r => r.classList.remove('selected'));
    el.classList.add('selected');
    // TODO: kirim ke controller untuk connect ke printer `nama`
  }

  /* ── Filter pencarian printer ── */
  function filterPrinter(q) {
    document.querySelectorAll('.printer-row').forEach(row => {
      const name = row.querySelector('span').textContent.toLowerCase();
      row.style.display = name.includes(q.toLowerCase()) ? '' : 'none';
    });
  }

  /* ── Refresh scan ── */
  function refreshScan() {
    const btn = document.getElementById('refreshBtn');
    btn.classList.add('spinning');
    setTimeout(() => btn.classList.remove('spinning'), 700);
    // TODO: hit endpoint scan bluetooth/network
  }

  /* ── Pilih ukuran kertas ── */
  function pilihKertas(el, ukuran) {
    document.querySelectorAll('.paper-chip').forEach(c => c.classList.remove('active'));
    el.classList.add('active');
    // TODO: simpan preferensi ukuran kertas
  }

  /* ── Nonaktifkan printer ── */
  function nonaktifkanPrinter() {
    if (confirm('Nonaktifkan printer ini?')) {
      // TODO: hit endpoint disconnect
      alert('Printer dinonaktifkan.');
    }
  }

  /* ── Jalankan tes print ── */
  function jalankanTesPrint() {
    // TODO: hit endpoint test print
    alert('Mengirim tes print...');
  }
</script>
</body>
</html>