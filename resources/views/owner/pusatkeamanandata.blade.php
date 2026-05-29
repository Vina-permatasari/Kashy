<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover"/>
  <title>Kashy – Pusat Keamanan Data</title>
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
    .d5{animation-delay:.25s} .d6{animation-delay:.30s}
    .d7{animation-delay:.35s}

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

    /* ── Upload dropzone ── */
    .dropzone {
      border:2px dashed #E0D8CE; border-radius:14px;
      padding:32px 20px; text-align:center;
      cursor:pointer; transition:border-color .2s, background .2s;
      background:#FAFAF8;
    }
    .dropzone:hover { border-color:#C49A6C; background:#FDF9F5; }
    .dropzone.drag-over { border-color:#C49A6C; background:#FDF1E8; }

    /* ── History table ── */
    .hist-table { width:100%; border-collapse:collapse; }
    .hist-table thead th {
      font-size:11px; font-weight:700; color:#8A7968;
      padding-bottom:10px; text-align:left; border-bottom:1.5px solid #E0D8CE;
    }
    .hist-table tbody tr { border-bottom:1px solid #E0D8CE; }
    .hist-table tbody tr:last-child { border-bottom:none; }
    .hist-table tbody td {
      padding:12px 0; font-size:12px; color:#1a1a1a;
      vertical-align:top;
    }
    .hist-table tbody td:last-child { text-align:right; }

    /* ── Status badge ── */
    .status-berhasil {
      display:inline-flex; align-items:center; gap:4px;
      font-size:11px; font-weight:600; color:#2E7D32;
    }
    .status-berhasil::before { content:''; width:7px; height:7px; border-radius:50%; background:#2E7D32; display:inline-block; }
    .status-tertunda {
      display:inline-flex; align-items:center; gap:4px;
      font-size:11px; font-weight:600; color:#C62828;
    }
    .status-tertunda::before { content:''; width:7px; height:7px; border-radius:50%; background:#C62828; display:inline-block; }

    /* ── Feature item ── */
    .feature-item {
      display:flex; flex-direction:column; align-items:center;
      text-align:center; padding:20px 10px;
      border-bottom:1px solid #E0D8CE;
    }
    .feature-item:last-child { border-bottom:none; }
    .feature-icon {
      width:44px; height:44px; border-radius:50%;
      background:#F5F0EB; display:flex; align-items:center; justify-content:center;
      margin-bottom:10px;
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
      <h1 class="text-3xl font-extrabold text-kashy-dark leading-tight">Pusat Keamanan Data</h1>
      <p class="mt-2 text-sm text-kashy-muted leading-relaxed max-w-sm">
        Lindungi warisan Anda. Pastikan koleksi, riwayat, dan preferensi Anda
        diarsipkan dengan aman dan mudah dipulihkan kapan saja.
      </p>
    </div>

    <!-- ══════════════════════════════
         CARD 1 — Arsip Cloud Instan
         ══════════════════════════════ -->
    <div class="fade-up d2 bg-white rounded-2xl p-5 mb-4" style="box-shadow:0 2px 18px 0 rgba(60,40,10,.07);">

      <h2 class="text-xl font-bold text-kashy-dark mb-3">Arsip Cloud Instan</h2>
      <p class="text-sm text-kashy-muted leading-relaxed mb-5">
        Buat foto terenkripsi secara instan dari seluruh akun anda. Data anda disimpan
        secara aman dan redundan untuk menjamin ketersediaan 99,9%.
      </p>

      <button
        onclick="cadangkanSekarang()"
        class="w-full py-4 rounded-2xl font-bold text-white text-sm tracking-wide mb-3 transition-all hover:opacity-90 active:scale-[.98]"
        style="background:#C49A6C; box-shadow:0 4px 14px 0 rgba(196,154,108,.35);">
        Cadangkan Sekarang
      </button>

      <button
        onclick="unduhSalinanLokal()"
        class="w-full py-4 rounded-2xl font-bold text-kashy-dark text-sm tracking-wide border-2 border-kashy-border bg-white transition-all hover:bg-kashy-cream active:scale-[.98]">
        Unduh Salinan Lokal
      </button>

    </div>

    <!-- ══════════════════════════════
         CARD 2 — Pulihkan dari File
         ══════════════════════════════ -->
    <div class="fade-up d3 bg-white rounded-2xl p-5 mb-4" style="box-shadow:0 2px 18px 0 rgba(60,40,10,.07);">

      <div class="flex items-center gap-3 mb-3">
        <div style="width:36px;height:36px;border-radius:50%;background:#F5F0EB;display:flex;align-items:center;justify-content:center;">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#C49A6C" stroke-width="2">
            <polyline points="1 4 1 10 7 10"/>
            <path d="M3.51 15a9 9 0 1 0 .49-3.5"/>
          </svg>
        </div>
        <h2 class="text-xl font-bold text-kashy-dark">Pulihkan dari File</h2>
      </div>

      <p class="text-sm text-kashy-muted leading-relaxed mb-5">
        Punya arsip lokal? Unggah file .grace Anda untuk memulihkan pengaturan
        dan koleksi Anda secara instan.
      </p>

      <!-- Dropzone -->
      <div
        class="dropzone"
        id="dropzone"
        onclick="document.getElementById('fileInput').click()"
        ondragover="onDragOver(event)"
        ondragleave="onDragLeave(event)"
        ondrop="onDrop(event)"
      >
        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#C49A6C" stroke-width="1.6" class="mx-auto mb-2">
          <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
          <polyline points="14 2 14 8 20 8"/>
          <line x1="12" y1="18" x2="12" y2="12"/>
          <line x1="9" y1="15" x2="15" y2="15"/>
        </svg>
        <p class="text-sm font-semibold text-kashy-muted" id="dropzoneText">Pilih File Arsip</p>
        <p class="text-xs text-kashy-muted mt-1">atau seret & lepas file .grace di sini</p>
        <input type="file" id="fileInput" accept=".grace" class="hidden" onchange="onFileSelected(this)"/>
      </div>

    </div>

    <!-- ══════════════════════════════
         CARD 3 — Arsip History
         ══════════════════════════════ -->
    <div class="fade-up d4 bg-white rounded-2xl p-5 mb-4" style="box-shadow:0 2px 18px 0 rgba(60,40,10,.07);">

      <div class="flex items-center justify-between mb-4">
        <h2 class="text-base font-bold text-kashy-dark">Arsip History</h2>
        <span class="text-xs font-600 text-kashy-muted bg-kashy-cream px-3 py-1 rounded-full font-semibold">30 hari terakhir</span>
      </div>

      <table class="hist-table">
        <thead>
          <tr>
            <th>Tanggal/<br/>Waktu</th>
            <th>Tipe<br/>Backup</th>
            <th style="text-align:right;">Status</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>
              <span class="font-semibold">21 Maret,<br/>2026</span><br/>
              <span class="text-kashy-muted">· 14:32</span>
            </td>
            <td>Backup<br/>Cloud<br/>Otomatis</td>
            <td><span class="status-berhasil">Berhasil</span></td>
          </tr>
          <tr>
            <td>
              <span class="font-semibold">23 Mei,<br/>2026</span><br/>
              <span class="text-kashy-muted">· 09:15</span>
            </td>
            <td>Unduh<br/>Lokal</td>
            <td><span class="status-berhasil">Berhasil</span></td>
          </tr>
          <tr>
            <td>
              <span class="font-semibold">19 Juli,<br/>2026</span><br/>
              <span class="text-kashy-muted">· 14:30</span>
            </td>
            <td>Backup<br/>Cloud<br/>Otomatis</td>
            <td><span class="status-tertunda">Tertanggu</span></td>
          </tr>
        </tbody>
      </table>

      <button
        class="mt-4 flex items-center gap-1 text-sm font-semibold text-kashy-dark hover:text-kashy-brown transition-colors"
        onclick="lihatRiwayat()">
        Lihat riwayat
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
          <polyline points="9 18 15 12 9 6"/>
        </svg>
      </button>

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

  /* ── Dropzone ── */
  function onDragOver(e)  { e.preventDefault(); document.getElementById('dropzone').classList.add('drag-over'); }
  function onDragLeave(e) { document.getElementById('dropzone').classList.remove('drag-over'); }
  function onDrop(e) {
    e.preventDefault();
    document.getElementById('dropzone').classList.remove('drag-over');
    const file = e.dataTransfer.files[0];
    if (file) handleFile(file);
  }
  function onFileSelected(input) {
    if (input.files[0]) handleFile(input.files[0]);
  }
  function handleFile(file) {
    document.getElementById('dropzoneText').textContent = file.name;
    // TODO: upload file ke route('owner.restore.upload')
  }

  /* ── Actions ── */
  function cadangkanSekarang() {
    // TODO: POST ke route('owner.backup.cloud')
    alert('Mencadangkan ke cloud...');
  }
  function unduhSalinanLokal() {
    // TODO: GET ke route('owner.backup.download')
    alert('Mengunduh salinan lokal...');
  }
  function lihatRiwayat() {
    // TODO: navigasi ke halaman riwayat backup lengkap
    alert('Lihat semua riwayat...');
  }
</script>
</body>
</html>