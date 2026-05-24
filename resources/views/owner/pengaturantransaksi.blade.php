<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Pengaturan Transaksi | Kashy</title>
<script src="https://cdn.tailwindcss.com"></script>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<script>
  tailwind.config = {
    theme: {
      extend: {
        colors: {
          'kashy-dark':   '#1C1008',
          'kashy-brown':  '#7B4F2E',
          'kashy-border': '#E8DDD4',
          'kashy-muted':  '#9C8B7E',
          'kashy-bg':     '#F7F3EF',
          'kashy-card':   '#FFFFFF',
          'kashy-accent': '#C8966C',
          'kashy-light':  '#F0D7C7',
        },
        fontFamily: {
          body: ['Poppins', 'sans-serif'],
        },
      }
    }
  }
</script>
<style>
  * { box-sizing: border-box; margin: 0; padding: 0; }
  body { font-family: 'Poppins', sans-serif; background-color: #F7F3EF; }

  /* ── SIDEBAR ── */
  #sidebar {
    position: fixed; top: 0; left: 0; height: 100vh; width: 260px;
    background: #fff; border-right: 1px solid #E8DDD4;
    display: flex; flex-direction: column;
    transform: translateX(-100%); transition: transform .28s cubic-bezier(.4,0,.2,1);
    z-index: 100; overflow-y: auto;
  }
  #sidebar.open { transform: translateX(0); }
  #overlay {
    display: none; position: fixed; inset: 0;
    background: rgba(28,16,8,.35); backdrop-filter: blur(2px);
    z-index: 99;
  }
  #overlay.show { display: block; }

  /* Nav items */
  .nav-item {
    display: flex; align-items: center; gap: 10px;
    padding: 9px 14px; border-radius: 10px;
    font-size: 13px; font-weight: 500; color: #6B5B4E;
    text-decoration: none; transition: background .15s, color .15s;
  }
  .nav-item:hover { background: #FAF2EC; color: #7B4F2E; }
  .nav-item.active { background: #F0D7C7; color: #7B4F2E; font-weight: 600; }
  .nav-item svg { flex-shrink: 0; }

  /* ── TOGGLE SWITCH ── */
  .toggle-input { display: none; }
  .toggle-label {
    display: inline-flex; align-items: center;
    width: 46px; height: 26px; border-radius: 999px;
    background: #D1C4B8; cursor: pointer;
    transition: background .2s; position: relative; flex-shrink: 0;
  }
  .toggle-label::after {
    content: ''; position: absolute; left: 3px;
    width: 20px; height: 20px; border-radius: 50%;
    background: #fff; transition: transform .2s;
    box-shadow: 0 1px 4px rgba(0,0,0,.18);
  }
  .toggle-input:checked + .toggle-label { background: #7B4F2E; }
  .toggle-input:checked + .toggle-label::after { transform: translateX(20px); }

  /* ── ROUNDING CARD ── */
  .rounding-card {
    border: 2px solid #E8DDD4; border-radius: 12px;
    padding: 14px 18px; cursor: pointer; transition: all .2s;
    background: #fff; flex: 1; text-align: center;
    position: relative;
  }
  .rounding-card:hover { border-color: #C8966C; background: #FAF2EC; }
  .rounding-card.selected { border-color: #7B4F2E; background: #F0D7C7; }
  .rounding-card .check {
    display: none; position: absolute; top: 8px; right: 8px;
    width: 18px; height: 18px; border-radius: 50%;
    background: #7B4F2E; align-items: center; justify-content: center;
  }
  .rounding-card.selected .check { display: flex; }

  /* ── SECTION CARD ── */
  .section-card {
    background: #fff; border-radius: 16px;
    border: 1px solid #E8DDD4;
    overflow: hidden; margin-bottom: 16px;
  }
  .section-header {
    display: flex; align-items: center; gap: 10px;
    padding: 16px 20px; border-bottom: 1px solid #F0EBE5;
    background: #FDFAF8;
  }
  .section-icon {
    width: 36px; height: 36px; border-radius: 10px;
    background: #F0D7C7; display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
  }

  /* Save button pulse */
  @keyframes pulse-brown {
    0%, 100% { box-shadow: 0 0 0 0 rgba(123,79,46,.4); }
    50%       { box-shadow: 0 0 0 8px rgba(123,79,46,0); }
  }
  .btn-save:hover { animation: pulse-brown 1s infinite; }
</style>
</head>
<body class="bg-kashy-bg min-h-screen">

    
@include('owner.components.sidebar')
@include('owner.components.topbar')

<!-- ══ MAIN CONTENT ══ -->
<main class="min-h-screen pt-16 px-4 pb-10 md:px-6 max-w-lg mx-auto">

  <!-- Page Title -->
  <div class="pt-6 pb-4">
    <h1 class="text-xl font-bold text-kashy-dark">Pengaturan Transaksi</h1>
    <p class="text-xs text-kashy-muted mt-0.5">Konfigurasi metode pembayaran & logika checkout</p>
  </div>

  <!-- ══ METODE PEMBAYARAN ══ -->
  <div class="section-card">
    <div class="section-header">
      <div class="section-icon">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#7B4F2E" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <rect x="1" y="4" width="22" height="16" rx="2" ry="2"/>
          <line x1="1" y1="10" x2="23" y2="10"/>
        </svg>
      </div>
      <div>
        <p class="text-sm font-semibold text-kashy-dark">Metode Pembayaran</p>
        <p class="text-xs text-kashy-muted">Aktifkan metode yang tersedia di toko</p>
      </div>
    </div>

    <div class="divide-y divide-[#F0EBE5]">

      <!-- Tunai -->
      <div class="flex items-center justify-between px-5 py-4">
        <div class="flex items-center gap-3">
          <div class="w-9 h-9 rounded-xl bg-green-50 flex items-center justify-center flex-shrink-0">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#16a34a" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
              <rect x="2" y="6" width="20" height="12" rx="2"/>
              <circle cx="12" cy="12" r="3"/>
              <path d="M6 12h.01M18 12h.01"/>
            </svg>
          </div>
          <div>
            <p class="text-sm font-semibold text-kashy-dark">Tunai</p>
            <p class="text-xs text-kashy-muted">Terima pembayaran uang tunai di kasir</p>
          </div>
        </div>
        <input type="checkbox" id="toggle-tunai" class="toggle-input" checked>
        <label for="toggle-tunai" class="toggle-label"></label>
      </div>

      <!-- QRIS -->
      <div class="flex items-center justify-between px-5 py-4">
        <div class="flex items-center gap-3">
          <div class="w-9 h-9 rounded-xl bg-blue-50 flex items-center justify-center flex-shrink-0">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#2563eb" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
              <rect x="3" y="3" width="5" height="5" rx="1"/><rect x="16" y="3" width="5" height="5" rx="1"/>
              <rect x="3" y="16" width="5" height="5" rx="1"/>
              <path d="M21 16h-3v3M21 21h-1M16 16v1M16 21h1M11 3v5M11 11v1M3 11h8M16 11h5M11 16v5"/>
            </svg>
          </div>
          <div>
            <p class="text-sm font-semibold text-kashy-dark">QRIS</p>
            <p class="text-xs text-kashy-muted">Pembayaran digital via kode QR standar nasional</p>
          </div>
        </div>
        <input type="checkbox" id="toggle-qris" class="toggle-input" checked>
        <label for="toggle-qris" class="toggle-label"></label>
      </div>

      <!-- Debit -->
      <div class="flex items-center justify-between px-5 py-4">
        <div class="flex items-center gap-3">
          <div class="w-9 h-9 rounded-xl bg-purple-50 flex items-center justify-center flex-shrink-0">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#7c3aed" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
              <rect x="1" y="4" width="22" height="16" rx="2"/>
              <line x1="1" y1="10" x2="23" y2="10"/>
              <path d="M7 15h2M15 15h2"/>
            </svg>
          </div>
          <div>
            <p class="text-sm font-semibold text-kashy-dark">Debit</p>
            <p class="text-xs text-kashy-muted">Proses transaksi kartu debit melalui terminal EDC</p>
          </div>
        </div>
        <input type="checkbox" id="toggle-debit" class="toggle-input">
        <label for="toggle-debit" class="toggle-label"></label>
      </div>
</div>
</div>



  <!-- ══ PEMBULATAN HARGA ══ -->
  <div class="section-card">
    <div class="section-header">
      <div class="section-icon">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#7B4F2E" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <line x1="4" y1="21" x2="4" y2="14"/><line x1="4" y1="10" x2="4" y2="3"/>
          <line x1="12" y1="21" x2="12" y2="12"/><line x1="12" y1="8" x2="12" y2="3"/>
          <line x1="20" y1="21" x2="20" y2="16"/><line x1="20" y1="12" x2="20" y2="3"/>
          <line x1="1" y1="14" x2="7" y2="14"/><line x1="9" y1="8" x2="15" y2="8"/>
          <line x1="17" y1="16" x2="23" y2="16"/>
        </svg>
      </div>
      <div>
        <p class="text-sm font-semibold text-kashy-dark">Pembulatan Harga</p>
        <p class="text-xs text-kashy-muted">Pilih tingkat pembulatan total transaksi akhir</p>
      </div>
    </div>

    <div class="px-5 py-5">
      <div class="flex gap-3">
        <!-- Rp 100 -->
        <div class="rounding-card selected" id="round-100" onclick="selectRounding('100')">
          <div class="check">
            <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="3.5"><polyline points="20 6 9 17 4 12"/></svg>
          </div>
          <p class="text-sm font-bold text-kashy-dark">Rp 100</p>
          <p class="text-xs text-kashy-muted mt-0.5">Terdekat</p>
        </div>
        <!-- Rp 500 -->
        <div class="rounding-card" id="round-500" onclick="selectRounding('500')">
          <div class="check">
            <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="3.5"><polyline points="20 6 9 17 4 12"/></svg>
          </div>
          <p class="text-sm font-bold text-kashy-dark">Rp 500</p>
          <p class="text-xs text-kashy-muted mt-0.5">Terdekat</p>
        </div>
        <!-- Rp 1000 -->
        <div class="rounding-card" id="round-1000" onclick="selectRounding('1000')">
          <div class="check">
            <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="3.5"><polyline points="20 6 9 17 4 12"/></svg>
          </div>
          <p class="text-sm font-bold text-kashy-dark">Rp 1.000</p>
          <p class="text-xs text-kashy-muted mt-0.5">Terdekat</p>
        </div>
      </div>
      <p class="text-xs text-kashy-muted mt-3">
        Total transaksi akan dibulatkan ke kelipatan nilai yang dipilih.
      </p>
    </div>
  </div>

  <!-- ══ BANTUAN ══ -->
  <div class="bg-kashy-dark rounded-2xl px-5 py-5 flex items-start gap-4 mb-6">
    <div class="w-10 h-10 rounded-xl bg-kashy-brown/40 flex items-center justify-center flex-shrink-0 mt-0.5">
      <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#F0D7C7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <circle cx="12" cy="12" r="10"/>
        <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/>
        <line x1="12" y1="17" x2="12.01" y2="17"/>
      </svg>
    </div>
    <div class="flex-1 min-w-0">
      <p class="text-sm font-semibold text-white mb-0.5">Butuh Bantuan?</p>
      <p class="text-xs text-gray-400 leading-relaxed">Tim kurasi kami siap membantu konfigurasi sistem kasir butik Anda.</p>
      <button class="mt-3 bg-kashy-brown text-white text-xs font-semibold px-4 py-2 rounded-xl hover:bg-kashy-accent transition-colors">
        Hubungi Dukungan
      </button>
    </div>
  </div>

  <!-- ══ TOMBOL SIMPAN ══ -->
  <button onclick="simpanPengaturan()"
          class="btn-save w-full bg-kashy-dark text-white font-semibold text-sm py-3.5 rounded-2xl transition-all duration-200 hover:bg-kashy-brown active:scale-[.98] flex items-center justify-center gap-2">
    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
      <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/>
      <polyline points="17 21 17 13 7 13 7 21"/>
      <polyline points="7 3 7 8 15 8"/>
    </svg>
    Simpan Pengaturan
  </button>

</main>

<!-- ══ TOAST NOTIFICATION ══ -->
<div id="toast"
     class="fixed bottom-6 left-1/2 -translate-x-1/2 bg-kashy-dark text-white text-xs font-medium px-5 py-3 rounded-xl shadow-lg flex items-center gap-2 opacity-0 pointer-events-none transition-all duration-300 z-[200]">
  <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#F0D7C7" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
  Pengaturan berhasil disimpan!
</div>

<script>
  // ── Sidebar toggle ──
  function openSidebar()  { document.getElementById('sidebar').classList.add('open'); document.getElementById('overlay').classList.add('show'); }
  function closeSidebar() { document.getElementById('sidebar').classList.remove('open'); document.getElementById('overlay').classList.remove('show'); }
  document.getElementById('global-menu-toggle')?.addEventListener('click', openSidebar);

  // ── Rounding selection ──
  function selectRounding(val) {
    ['100','500','1000'].forEach(v => {
      document.getElementById('round-'+v).classList.toggle('selected', v === val);
    });
  }

  // ── Save ──
  function simpanPengaturan() {
    const toast = document.getElementById('toast');
    toast.style.opacity = '1';
    toast.style.transform = 'translateX(-50%) translateY(-8px)';
    setTimeout(() => {
      toast.style.opacity = '0';
      toast.style.transform = 'translateX(-50%) translateY(0)';
    }, 2800);
  }

  // ── Active nav highlight ──
  document.querySelectorAll('.nav-item').forEach(el => {
    el.addEventListener('click', () => {
      document.querySelectorAll('.nav-item').forEach(e => e.classList.remove('active'));
      el.classList.add('active');
    });
  });
</script>

</body>
</html>