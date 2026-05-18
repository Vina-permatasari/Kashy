<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
<title>Dashboard Kasir – Kashy</title>
<script src="https://cdn.tailwindcss.com"></script>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<script>
  tailwind.config = {
    theme: {
      extend: {
        colors: {
          terra:      '#C8966C',
          'terra-l':  '#E5B18A',
          'terra-ll': '#F0D7C7',
          'terra-xs': '#FAF2EC',
          muted:      '#9C8B7E',
          border:     '#EAE0D6',
          bg:         '#F5F0EB',
        },
        fontFamily: {
          display: ['Poppins', 'sans-serif'],
          body:    ['Poppins', 'sans-serif'],
        },
      }
    }
  }
</script>
<style>
  * { margin:0; padding:0; box-sizing:border-box; }
  body { font-family: 'Poppins',sans-serif; background:#F5F0EB; }
  @keyframes fadeUp {
    from { opacity:0; transform:translateY(16px); }
    to   { opacity:1; transform:translateY(0); }
  }
  .fade-up { animation: fadeUp 0.45s cubic-bezier(0.2,0.9,0.4,1.1) both; }
  .delay-1 { animation-delay:0.05s; }
  .delay-2 { animation-delay:0.12s; }
  .delay-3 { animation-delay:0.2s; }
  .delay-4 { animation-delay:0.28s; }
  @keyframes pulse { 0%,100%{ opacity:1; transform:scale(1); } 50%{ opacity:0.7; transform:scale(1.2); } }
  .pulse-dot { animation: pulse 1.4s infinite; }
  .shimmer-bar {
    background: linear-gradient(90deg, #C8966C, #E5B18A, #F0D7C7, #E5B18A, #C8966C);
    background-size: 200%;
    animation: shimmer 3s infinite;
  }
  @keyframes shimmer { 0%{background-position:100%} 100%{background-position:-100%} }
  .card-hover { transition: transform 0.2s, box-shadow 0.2s; }
  .card-hover:hover { transform: translateY(-2px); box-shadow: 0 12px 28px rgba(0,0,0,0.08); }
  .transaksi-disabled {
    opacity: 0.6;
    cursor: not-allowed;
    pointer-events: none;
    filter: grayscale(0.05);
  }
  .bn-item.active .bn-icon { background:#F0D7C7; }
  .bn-item.active .bn-icon svg { stroke:#C8966C; }
  .bn-item.active .bn-label { color:#C8966C; font-weight:600; }
</style>
</head>
@include('kasir.components.navbar')

<body class="bg-bg min-h-screen flex flex-col">

<!-- TOPBAR -->
<nav class="sticky top-0 z-20 bg-gray-900 px-5 py-3 flex items-center justify-between shadow-md">
  <div class="w-8"></div>
  <span class="font-display text-xl font-bold text-white tracking-widest">Kashy</span>
  <div class="flex items-center gap-2">
    <button class="relative w-8 h-8 flex items-center justify-center rounded-full hover:bg-white/10 transition">
      <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#9C8B7E" stroke-width="2">
        <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/>
        <path d="M13.73 21a2 2 0 0 1-3.46 0"/>
      </svg>
      <span class="absolute top-1 right-1 w-2 h-2 bg-terra rounded-full border border-gray-900"></span>
    </button>
  </div>
</nav>

<main class="flex-1 overflow-y-auto px-4 pt-5 pb-28 max-w-2xl mx-auto w-full">
  
  <!-- GREETING -->
  <div class="mb-6 fade-up delay-1">
    <p class="text-xs text-muted font-medium uppercase tracking-wide">Dashboard Kasir</p>
    <h1 class="font-display text-3xl sm:text-4xl font-bold text-gray-900 mt-0.5">
      Selamat Pagi, <span class="text-terra">Dewi Pratiwi</span>
    </h1>
    <p class="text-sm text-muted mt-2 leading-relaxed">Ringkasan aktivitas dan performa toko hari ini.</p>
  </div>

  <!-- ACTION BUTTONS (Transaksi & Shift) -->
  <div class="grid grid-cols-2 gap-3 mb-6 fade-up delay-2">
    <!-- Transaksi Baru (disable saat shift tutup) -->
    <button id="transaksiBtn" onclick="goTransaksi()"
      class="bg-gray-900 hover:bg-gray-800 text-white rounded-xl px-4 py-4 flex items-center gap-3 shadow-md transition-all card-hover">
      <div class="w-8 h-8 rounded-lg bg-white/10 flex items-center justify-center flex-shrink-0">
        <svg width="18" height="18" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
          <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
        </svg>
      </div>
      <span class="text-sm font-semibold leading-tight">Transaksi<br>Baru</span>
    </button>

    <!-- Tombol BUKA / TUTUP SHIFT (mengarah ke halaman shift) -->
    <button id="shiftActionBtn" onclick="window.location.href='{{ route('kasir.shiftkasir') }}'"
      class="bg-white hover:bg-terra-xs border border-border text-gray-900 rounded-xl px-4 py-4 flex items-center gap-3 shadow-sm transition-all card-hover">
      <div class="w-8 h-8 rounded-lg bg-terra-xs flex items-center justify-center flex-shrink-0">
        <svg width="18" height="18" fill="none" stroke="#C8966C" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
          <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
          <polyline points="16 17 21 12 16 7"/>
          <line x1="21" y1="12" x2="9" y2="12"/>
        </svg>
      </div>
      <span id="shiftBtnLabel" class="text-sm font-semibold leading-tight text-gray-900">Buka Shift</span>
    </button>
  </div>

  <!-- SHIFT CARD (dinamis) -->
  <div class="bg-white rounded-2xl shadow-sm border border-border overflow-hidden mb-6 fade-up delay-3">
    <div class="shimmer-bar h-1 w-full"></div>
    <div class="p-5">
      <!-- Header -->
      <div class="flex flex-wrap justify-between items-start gap-2 mb-4">
        <div class="flex items-center gap-3">
          <div class="w-11 h-11 rounded-xl bg-terra-xs flex items-center justify-center">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#C8966C" stroke-width="2">
              <circle cx="12" cy="12" r="10"/>
              <path d="M12 6v6l4 2"/>
            </svg>
          </div>
          <div>
            <h2 class="font-semibold text-gray-900 text-lg">Shift Saat Ini</h2>
            <p class="text-xs text-muted" id="shiftHariTanggal">Senin, 18 Mei 2026</p>
          </div>
        </div>
        <!-- Status badge -->
        <div id="shiftBadge" class="flex items-center gap-1.5 px-3 py-1.5 rounded-full border">
          <span id="badgeDot" class="w-2 h-2 rounded-full"></span>
          <span id="badgeText" class="text-[11px] font-semibold">Tidak Aktif</span>
        </div>
      </div>

      <!-- Waktu Mulai dan Berakhir (selalu ditampilkan) -->
      <div class="grid grid-cols-2 gap-4 mb-4">
        <div>
          <p class="text-[10px] text-muted uppercase tracking-wide">Mulai</p>
          <p class="text-base font-semibold text-gray-900" id="shiftMulai">08:00</p>
        </div>
        <div>
          <p class="text-[10px] text-muted uppercase tracking-wide">Berakhir</p>
          <p class="text-base font-semibold text-gray-900" id="shiftBerakhir">16:00</p>
        </div>
      </div>

      <!-- Timeline (hanya muncul saat shift aktif) -->
      <div id="shiftTimeline" class="mb-4 hidden">
        <div class="flex justify-between text-[10px] text-muted mb-1">
          <span id="timelineStart">08:00</span>
          <span class="text-terra font-semibold" id="currentTimeLabel">--:--</span>
          <span id="timelineEnd">16:00</span>
        </div>
        <div class="h-1.5 bg-stone-100 rounded-full overflow-hidden">
          <div id="shiftProgressBar" class="h-full bg-terra rounded-full" style="width:0%"></div>
        </div>
        <p class="text-[10px] text-muted mt-1 text-right" id="durasiLabel">Durasi: --j --m</p>
      </div>

      <!-- Informasi Kasir & Posisi (selalu ditampilkan) -->
      <div class="flex flex-col sm:flex-row sm:flex-wrap sm:items-center gap-3 text-xs text-muted border-t border-border pt-4">
        <div class="flex items-center gap-1.5">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
            <circle cx="12" cy="7" r="4"/>
          </svg>
          <span>Kasir: <strong class="text-gray-800">Dewi Pratiwi</strong></span>
        </div>
        <div class="flex items-center gap-1.5">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <rect x="3" y="4" width="18" height="16" rx="2"/>
            <path d="M3 10h18"/>
          </svg>
          <span>Posisi: <strong class="text-gray-800">Kasir</strong></span>
        </div>
      </div>
    </div>
  </div>

  <!-- PENJUALAN CARD (dinamis -> 0 jika shift belum buka) -->
  <div class="bg-white rounded-2xl shadow-sm border border-border overflow-hidden mb-6 fade-up delay-3">
    <div class="p-5">
      <div class="flex items-center gap-2.5 mb-3">
        <div class="w-8 h-8 rounded-xl bg-terra-xs flex items-center justify-center">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#C8966C" stroke-width="2"><rect x="2" y="5" width="20" height="14" rx="2"/><circle cx="12" cy="12" r="3"/></svg>
        </div>
        <h3 class="font-semibold text-gray-900">Penjualan Hari Ini</h3>
      </div>
      <p id="penjualanValue" class="text-3xl sm:text-4xl font-extrabold text-gray-900 mb-2">Rp 0</p>
      <div class="flex items-center gap-3 mt-1">
        <div class="flex-1 h-1.5 bg-stone-100 rounded-full overflow-hidden">
          <div id="penjualanProgress" class="h-full bg-terra rounded-full" style="width:0%"></div>
        </div>
        <span id="penjualanPercent" class="text-[10px] text-muted">0% dari target</span>
      </div>
      <div class="flex gap-2 mt-4 flex-wrap">
        <span class="text-[10px] font-medium px-2.5 py-1 rounded-full bg-terra-xs text-terra">💵 Tunai: Rp 0</span>
        <span class="text-[10px] font-medium px-2.5 py-1 rounded-full bg-terra-xs text-terra">📱 QRIS: Rp 0</span>
        <span class="text-[10px] font-medium px-2.5 py-1 rounded-full bg-terra-xs text-terra">💳 Debit: Rp 0</span>
      </div>
    </div>
  </div>

  <!-- STATS ROW (Transaksi + Item Terjual) tanpa perbandingan -->
  <div class="grid grid-cols-2 gap-3 mb-6 fade-up delay-3">
    <div class="bg-white rounded-2xl px-4 py-3 shadow-sm border border-border card-hover">
      <div class="flex items-center justify-between">
        <div class="flex items-center gap-3">
          <div class="w-10 h-10 rounded-xl bg-terra-xs flex items-center justify-center">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#C8966C" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
          </div>
          <div>
            <p class="text-xs text-muted font-medium">Transaksi</p>
            <h3 id="transaksiCount" class="text-lg font-bold text-gray-900">0</h3>
          </div>
        </div>
      </div>
    </div>
    <div class="bg-white rounded-2xl px-4 py-3 shadow-sm border border-border card-hover">
      <div class="flex items-center justify-between">
        <div class="flex items-center gap-3">
          <div class="w-10 h-10 rounded-xl bg-terra-xs flex items-center justify-center">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#C8966C" stroke-width="2"><path d="M20 6 9 17l-5-5"/></svg>
          </div>
          <div>
            <p class="text-xs text-muted font-medium">Item Terjual</p>
            <h3 id="itemCount" class="text-lg font-bold text-gray-900">0</h3>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- STOK MENIPIS -->
  <div class="bg-white rounded-2xl shadow-sm border border-border overflow-hidden mb-6 fade-up delay-4">
    <div class="px-5 pt-5 pb-4">
      <div class="flex items-center gap-2.5 mb-4">
        <div class="w-8 h-8 rounded-xl bg-terra-xs flex items-center justify-center">
          <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#C8966C" stroke-width="2"><path d="M20.38 3.46 16 2a4 4 0 0 1-8 0L3.62 3.46a2 2 0 0 0-1.34 2.23l.58 3.57a1 1 0 0 0 .99.84H6v10c0 1.1.9 2 2 2h8a2 2 0 0 0 2-2V10h2.15a1 1 0 0 0 .99-.84l.58-3.57a2 2 0 0 0-1.34-2.23z"/></svg>
        </div>
        <div>
          <h3 class="font-semibold text-gray-900">Stok Menipis</h3>
          <p class="text-[11px] text-muted">Perlu segera diisi ulang</p>
        </div>
      </div>
      <ul class="space-y-2">
        <li class="flex items-center gap-3 p-2 rounded-xl hover:bg-terra-xs transition">
          <div class="w-8 h-8 rounded-lg bg-terra-xs flex items-center justify-center"><svg width="14" height="14" fill="none" stroke="#C8966C" stroke-width="1.8" viewBox="0 0 24 24"><path d="M20.38 3.46 16 2a4 4 0 0 1-8 0L3.62 3.46a2 2 0 0 0-1.34 2.23l.58 3.57a1 1 0 0 0 .99.84H6v10c0 1.1.9 2 2 2h8a2 2 0 0 0 2-2V10h2.15a1 1 0 0 0 .99-.84l.58-3.57a2 2 0 0 0-1.34-2.23z"/></svg></div>
          <div class="flex-1"><p class="text-sm font-medium text-gray-800">Kaos Polos Putih – L</p><p class="text-[10px] text-muted">Sisa 3 pcs</p></div>
          <span class="text-[10px] font-bold text-red-600 bg-red-50 px-2 py-1 rounded-full">Habis</span>
        </li>
        <li class="flex items-center gap-3 p-2 rounded-xl hover:bg-terra-xs transition">
          <div class="w-8 h-8 rounded-lg bg-terra-xs flex items-center justify-center"><svg width="14" height="14" fill="none" stroke="#C8966C" stroke-width="1.8" viewBox="0 0 24 24"><path d="M3 7 7 3h2.5L12 6l2.5-3H17l4 4-2.5 2L17 7v13a1 1 0 0 1-1 1H8a1 1 0 0 1-1-1V7L4.5 9 3 7z"/><path d="M12 6v14"/></svg></div>
          <div class="flex-1"><p class="text-sm font-medium text-gray-800">Jaket Bomber Hitam</p><p class="text-[10px] text-muted">Sisa 5 pcs</p></div>
          <span class="text-[10px] font-bold text-amber-600 bg-amber-50 px-2 py-1 rounded-full">Menipis</span>
        </li>
        <li class="flex items-center gap-3 p-2 rounded-xl hover:bg-terra-xs transition">
          <div class="w-8 h-8 rounded-lg bg-terra-xs flex items-center justify-center"><svg width="14" height="14" fill="none" stroke="#C8966C" stroke-width="1.8" viewBox="0 0 24 24"><path d="M3 6.5 7.5 3h3L12 5l1.5-2h3L21 6.5l-3 2.5v11a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V9L3 6.5z"/><path d="M12 5v15"/></svg></div>
          <div class="flex-1"><p class="text-sm font-medium text-gray-800">Cardigan Rajut Krem</p><p class="text-[10px] text-muted">Sisa 7 pcs</p></div>
          <span class="text-[10px] font-bold text-amber-600 bg-amber-50 px-2 py-1 rounded-full">Menipis</span>
        </li>
      </ul>
    </div>
  </div>

  <!-- TRANSAKSI TERBARU -->
  <div class="bg-white rounded-2xl shadow-sm border border-border overflow-hidden fade-up delay-4">
    <div class="px-5 pt-5 pb-4">
      <div class="flex items-center justify-between mb-4">
        <div class="flex items-center gap-2.5">
          <div class="w-8 h-8 rounded-xl bg-terra-xs flex items-center justify-center">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#C8966C" stroke-width="2"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
          </div>
          <div>
            <h3 class="font-semibold text-gray-900">Transaksi Terbaru</h3>
            <p class="text-[11px] text-muted">Hari ini</p>
          </div>
        </div>
        <span class="text-[10px] font-semibold text-terra cursor-pointer" onclick="goRiwayat()">Lihat semua →</span>
      </div>
      <ul class="space-y-2">
        <li class="flex items-center justify-between p-2 rounded-xl hover:bg-terra-xs transition">
          <div class="flex items-center gap-3"><div class="w-8 h-8 rounded-full bg-emerald-50 flex items-center justify-center"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#10b981" stroke-width="2.5"><path d="M20 6 9 17l-5-5"/></svg></div><div><p class="text-xs font-semibold">#TRX-0048</p><p class="text-[9px] text-muted">12:45 · Tunai</p></div></div><span class="text-xs font-bold">Rp 393.000</span>
        </li>
        <li class="flex items-center justify-between p-2 rounded-xl hover:bg-terra-xs transition">
          <div class="flex items-center gap-3"><div class="w-8 h-8 rounded-full bg-emerald-50 flex items-center justify-center"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#10b981" stroke-width="2.5"><path d="M20 6 9 17l-5-5"/></svg></div><div><p class="text-xs font-semibold">#TRX-0047</p><p class="text-[9px] text-muted">12:30 · QRIS</p></div></div><span class="text-xs font-bold">Rp 215.000</span>
        </li>
        <li class="flex items-center justify-between p-2 rounded-xl hover:bg-terra-xs transition">
          <div class="flex items-center gap-3"><div class="w-8 h-8 rounded-full bg-red-50 flex items-center justify-center"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#E53935" stroke-width="2.5"><path d="M18 6 6 18M6 6l12 12"/></svg></div><div><p class="text-xs font-semibold">#TRX-0046</p><p class="text-[9px] text-muted">11:58 · Dibatalkan</p></div></div><span class="text-xs font-bold text-red-600">Rp 159.000</span>
        </li>
        <li class="flex items-center justify-between p-2 rounded-xl hover:bg-terra-xs transition">
          <div class="flex items-center gap-3"><div class="w-8 h-8 rounded-full bg-emerald-50 flex items-center justify-center"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#10b981" stroke-width="2.5"><path d="M20 6 9 17l-5-5"/></svg></div><div><p class="text-xs font-semibold">#TRX-0045</p><p class="text-[9px] text-muted">11:40 · Debit</p></div></div><span class="text-xs font-bold">Rp 534.000</span>
        </li>
      </ul>
    </div>
  </div>
</main>

<!-- TOAST NOTIF -->
<div id="toast" class="fixed bottom-24 left-1/2 -translate-x-1/2 z-30 bg-gray-900 text-white text-sm font-medium px-5 py-3 rounded-full shadow-xl flex items-center gap-2 pointer-events-none transition-all duration-300 opacity-0 translate-y-4">
  <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5"><path d="M20 6 9 17l-5-5"/></svg>
  <span id="toastMsg">—</span>
</div>

<script>
  // ========== AMBIL STATUS SHIFT DARI LOCALSTORAGE ==========
  // Key yang sama dengan halaman buka/tutup shift
  const SHIFT_STORAGE_KEY = 'kashy_shift';
  const SHIFT_DURATION_MIN = 480; // 8 jam
  const DEFAULT_START = "08:00";
  const DEFAULT_END = "16:00";

  let shiftOpen = false;
  let shiftStartTime = null;
  let initialBalance = 0;

  // Data penjualan demo (akan diupdate saat shift aktif)
  let salesData = {
    total: 0,
    tunai: 0,
    qris: 0,
    debit: 0,
    target: 15000000,
    transaksiCount: 0,
    itemCount: 0
  };

  // DOM elements
  const transaksiBtn = document.getElementById('transaksiBtn');
  const shiftBtnLabel = document.getElementById('shiftBtnLabel');
  const shiftBadge = document.getElementById('shiftBadge');
  const badgeDot = document.getElementById('badgeDot');
  const badgeText = document.getElementById('badgeText');
  const shiftTimeline = document.getElementById('shiftTimeline');
  const shiftProgressBar = document.getElementById('shiftProgressBar');
  const currentTimeLabel = document.getElementById('currentTimeLabel');
  const durasiLabelSpan = document.getElementById('durasiLabel');
  const timelineStart = document.getElementById('timelineStart');
  const timelineEnd = document.getElementById('timelineEnd');
  const shiftMulaiElem = document.getElementById('shiftMulai');
  const shiftBerakhirElem = document.getElementById('shiftBerakhir');
  const shiftHariTanggal = document.getElementById('shiftHariTanggal');
  
  // Elemen statistik
  const penjualanValue = document.getElementById('penjualanValue');
  const penjualanProgress = document.getElementById('penjualanProgress');
  const penjualanPercent = document.getElementById('penjualanPercent');
  const tunaiSpan = document.querySelector('.flex.gap-2.mt-4.flex-wrap span:first-child');
  const qrisSpan = document.querySelector('.flex.gap-2.mt-4.flex-wrap span:nth-child(2)');
  const debitSpan = document.querySelector('.flex.gap-2.mt-4.flex-wrap span:last-child');
  const transaksiCountSpan = document.getElementById('transaksiCount');
  const itemCountSpan = document.getElementById('itemCount');

  // Set hari/tanggal
  const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
  shiftHariTanggal.innerText = new Date().toLocaleDateString('id-ID', options);

  function updateGreeting() {
    const h = new Date().getHours();
    let greet = 'Selamat Pagi';
    if (h >= 11 && h < 15) greet = 'Selamat Siang';
    else if (h >= 15 && h < 18) greet = 'Selamat Sore';
    else if (h >= 18) greet = 'Selamat Malam';
    const greetElem = document.querySelector('#greetTime');
    if (greetElem) greetElem.innerText = greet;
    const heading = document.querySelector('h1');
    if(heading) heading.innerHTML = `${greet}, <span class="text-terra">Dewi Pratiwi</span>`;
  }
  updateGreeting();

  // Load status shift dari localStorage
  function loadShiftFromStorage() {
    const saved = localStorage.getItem(SHIFT_STORAGE_KEY);
    if (saved) {
      try {
        const data = JSON.parse(saved);
        shiftOpen = data.active || false;
        initialBalance = data.initialBalance || 0;
        if (data.startTime) {
          shiftStartTime = new Date(data.startTime);
          // Jika shift sudah melebihi 8 jam, anggap selesai
          if (shiftOpen && shiftStartTime) {
            const now = new Date();
            const diffMinutes = (now - shiftStartTime) / 60000;
            if (diffMinutes >= SHIFT_DURATION_MIN) {
              shiftOpen = false;
              shiftStartTime = null;
              initialBalance = 0;
              localStorage.removeItem(SHIFT_STORAGE_KEY);
            }
          }
        } else {
          shiftStartTime = null;
        }
      } catch(e) { console.warn(e); }
    } else {
      shiftOpen = false;
      shiftStartTime = null;
      initialBalance = 0;
    }
    updateUI();
  }

  // Update tampilan penjualan (demo)
  function updateSalesUI() {
    if (shiftOpen && shiftStartTime) {
      // Demo data: setelah shift dibuka, tampilkan angka contoh
      salesData.total = 12450000;
      salesData.tunai = 7200000;
      salesData.qris = 3800000;
      salesData.debit = 1450000;
      salesData.transaksiCount = 48;
      salesData.itemCount = 123;
      
      penjualanValue.innerText = `Rp ${salesData.total.toLocaleString('id-ID')}`;
      const percent = Math.round((salesData.total / salesData.target) * 100);
      penjualanProgress.style.width = `${percent}%`;
      penjualanPercent.innerText = `${percent}% dari target`;
      if (tunaiSpan) tunaiSpan.innerHTML = `💵 Tunai: Rp ${(salesData.tunai/1000000).toFixed(1)}jt`;
      if (qrisSpan) qrisSpan.innerHTML = `📱 QRIS: Rp ${(salesData.qris/1000000).toFixed(1)}jt`;
      if (debitSpan) debitSpan.innerHTML = `💳 Debit: Rp ${(salesData.debit/1000000).toFixed(1)}jt`;
      transaksiCountSpan.innerText = salesData.transaksiCount;
      itemCountSpan.innerText = salesData.itemCount;
    } else {
      salesData.total = 0;
      salesData.tunai = 0;
      salesData.qris = 0;
      salesData.debit = 0;
      salesData.transaksiCount = 0;
      salesData.itemCount = 0;
      
      penjualanValue.innerText = "Rp 0";
      penjualanProgress.style.width = "0%";
      penjualanPercent.innerText = "0% dari target";
      if (tunaiSpan) tunaiSpan.innerHTML = `💵 Tunai: Rp 0`;
      if (qrisSpan) qrisSpan.innerHTML = `📱 QRIS: Rp 0`;
      if (debitSpan) debitSpan.innerHTML = `💳 Debit: Rp 0`;
      transaksiCountSpan.innerText = "0";
      itemCountSpan.innerText = "0";
    }
  }

  // Update progress durasi shift
  function updateShiftProgress() {
    if (!shiftOpen || !shiftStartTime) return;
    const now = new Date();
    const elapsedMinutes = Math.floor((now - shiftStartTime) / 60000);
    const hours = Math.floor(elapsedMinutes / 60);
    const mins = elapsedMinutes % 60;
    durasiLabelSpan.innerText = `Durasi: ${hours}j ${mins}m`;
    let percent = (elapsedMinutes / SHIFT_DURATION_MIN) * 100;
    percent = Math.min(100, Math.max(0, percent));
    shiftProgressBar.style.width = `${percent}%`;
    
    const currentHours = now.getHours().toString().padStart(2,'0');
    const currentMins = now.getMinutes().toString().padStart(2,'0');
    if(currentTimeLabel) currentTimeLabel.innerText = `${currentHours}:${currentMins}`;
  }

  // Update seluruh UI shift
  function updateUI() {
    if (shiftOpen && shiftStartTime) {
      // Shift AKTIF
      badgeDot.className = "w-2 h-2 rounded-full bg-green-500 pulse-dot";
      badgeText.innerText = "Aktif";
      shiftBadge.className = "flex items-center gap-1.5 px-3 py-1.5 rounded-full border border-green-300 bg-green-100";
      
      const startH = shiftStartTime.getHours().toString().padStart(2,'0');
      const startM = shiftStartTime.getMinutes().toString().padStart(2,'0');
      const endDate = new Date(shiftStartTime.getTime() + SHIFT_DURATION_MIN * 60000);
      const endH = endDate.getHours().toString().padStart(2,'0');
      const endM = endDate.getMinutes().toString().padStart(2,'0');
      
      shiftMulaiElem.innerText = `${startH}:${startM}`;
      shiftBerakhirElem.innerText = `${endH}:${endM}`;
      timelineStart.innerText = `${startH}:${startM}`;
      timelineEnd.innerText = `${endH}:${endM}`;
      
      shiftTimeline.classList.remove('hidden');
      updateShiftProgress();
      
      shiftBtnLabel.innerText = "Tutup Shift";
      transaksiBtn.classList.remove('transaksi-disabled');
      transaksiBtn.disabled = false;
      
      updateSalesUI();
    } else {
      // Shift TIDAK AKTIF
      badgeDot.className = "w-2 h-2 rounded-full bg-red-500";
      badgeText.innerText = "Tidak Aktif";
      shiftBadge.className = "flex items-center gap-1.5 px-3 py-1.5 rounded-full border border-red-300 bg-red-100";
      
      shiftMulaiElem.innerText = DEFAULT_START;
      shiftBerakhirElem.innerText = DEFAULT_END;
      timelineStart.innerText = DEFAULT_START;
      timelineEnd.innerText = DEFAULT_END;
      
      shiftTimeline.classList.add('hidden');
      durasiLabelSpan.innerText = "Durasi: --j --m";
      shiftProgressBar.style.width = "0%";
      
      shiftBtnLabel.innerText = "Buka Shift";
      transaksiBtn.classList.add('transaksi-disabled');
      transaksiBtn.disabled = true;
      
      updateSalesUI();
    }
  }

  // Fungsi navigasi & toast
  function goTransaksi() {
    if (!shiftOpen) { showToast('Silakan buka shift terlebih dahulu!'); return; }
    showToast('Membuka halaman transaksi baru...');
  }
  function goRiwayat() { showToast('Membuka riwayat transaksi...'); }

  function showToast(msg) {
    const toast = document.getElementById('toast');
    document.getElementById('toastMsg').innerText = msg;
    toast.style.opacity = '1';
    toast.style.transform = 'translateX(-50%) translateY(0)';
    setTimeout(() => {
      toast.style.opacity = '0';
      toast.style.transform = 'translateX(-50%) translateY(16px)';
    }, 2600);
  }

  function setNav(el) {
    document.querySelectorAll('.bn-item').forEach(b => b.classList.remove('active'));
    el.classList.add('active');
  }

  // Interval untuk update progress (hanya saat shift aktif)
  let progressInterval = null;
  function startProgressInterval() {
    if (progressInterval) clearInterval(progressInterval);
    progressInterval = setInterval(() => {
      if (shiftOpen && shiftStartTime) {
        updateShiftProgress();
      } else if (progressInterval) {
        clearInterval(progressInterval);
        progressInterval = null;
      }
    }, 60000);
  }

  // Inisialisasi: baca storage, lalu update UI dan jalankan interval
  loadShiftFromStorage();
  startProgressInterval();

  // Jika ada perubahan storage dari tab lain (misal dari halaman shift), update otomatis
  window.addEventListener('storage', (event) => {
    if (event.key === SHIFT_STORAGE_KEY) {
      loadShiftFromStorage();
      startProgressInterval();
    }
  });
</script>
</body>
</html>