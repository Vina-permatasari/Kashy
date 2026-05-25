<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Laporan Penjualan – Kashy</title>
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
  body { font-family:'Poppins',sans-serif; background:#F5F0EB; }
  @keyframes fadeUp {
    from { opacity:0; transform:translateY(14px); }
    to   { opacity:1; transform:translateY(0); }
  }
  .fade-up { animation:fadeUp .4s cubic-bezier(.2,.9,.4,1.1) both; }
  .delay-1 { animation-delay:.05s; }
  .delay-2 { animation-delay:.12s; }
  .delay-3 { animation-delay:.20s; }
  .delay-4 { animation-delay:.28s; }
  .delay-5 { animation-delay:.36s; }
  .stat-card {
    background:#fff;
    border-radius:20px;
    border:1.5px solid #EAE0D6;
    padding:20px;
    transition:box-shadow .2s;
  }
  .stat-card:hover { box-shadow:0 6px 24px rgba(200,150,108,.12); }
  .stat-label {
    font-size:11px; font-weight:600; color:#9C8B7E;
    letter-spacing:.07em; text-transform:uppercase;
    display:flex; align-items:center; justify-content:space-between;
  }
  .stat-value {
    font-size:28px; font-weight:800; color:#1C1C1C; margin-top:8px; line-height:1.1;
  }
  .stat-sub {
    font-size:12px; color:#9C8B7E; margin-top:6px;
  }
  .section-header {
    font-size:14px; font-weight:700; color:#1C1C1C;
    margin-bottom:16px;
  }
  .cat-row {
    display:flex; align-items:center; gap:10px; padding:10px 0;
    border-bottom:1px solid #EAE0D6;
  }
  .cat-row:last-child { border-bottom:none; }
  .cat-name { font-size:13px; font-weight:500; color:#1C1C1C; flex:1; }
  .cat-amount { font-size:13px; font-weight:700; color:#1C1C1C; text-align:right; white-space:nowrap; }
  .bar-track { height:4px; background:#EAE0D6; border-radius:99px; flex:2; }
  .bar-fill  { height:4px; background:#C8966C; border-radius:99px; transition:width .6s cubic-bezier(.2,.9,.4,1.1); }
  .rank-table { width:100%; border-collapse:collapse; }
  .rank-table thead tr { border-bottom:1.5px solid #EAE0D6; }
  .rank-table thead th {
    font-size:10px; font-weight:700; color:#9C8B7E;
    text-transform:uppercase; letter-spacing:.07em;
    padding:0 0 12px; text-align:left;
  }
  .rank-table thead th:last-child { text-align:right; }
  .rank-table tbody tr { border-bottom:1px solid #EAE0D6; }
  .rank-table tbody tr:last-child { border-bottom:none; }
  .rank-table tbody td { padding:12px 0; font-size:13px; color:#1C1C1C; vertical-align:middle; }
  .rank-table tbody td:last-child { text-align:right; font-weight:700; }
  .rank-num {
    width:24px; height:24px; border-radius:50%;
    background:#F5F0EB; display:inline-flex; align-items:center; justify-content:center;
    font-size:11px; font-weight:700; color:#9C8B7E;
    flex-shrink:0;
  }
  .rank-num.top { background:#FDF1E8; color:#C8966C; }
  .cetak-btn-main {
    display:flex; align-items:center; gap:8px;
    background:#1C1C1C; color:#fff;
    font-size:14px; font-weight:700;
    padding:14px 20px; border-radius:16px;
    border:none; cursor:pointer;
    font-family:'Poppins',sans-serif;
    transition:background .2s;
    width:100%; justify-content:center;
  }
  .cetak-btn-main:hover { background:#333; }
  .stats-two-column {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px;
  }
  .loading-spinner {
    display: inline-block;
    width: 20px;
    height: 20px;
    border: 2px solid #C8966C;
    border-radius: 50%;
    border-top-color: transparent;
    animation: spin 0.6s linear infinite;
  }
  @keyframes spin {
    to { transform: rotate(360deg); }
  }
  .loading-state {
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 40px;
    gap: 12px;
  }
</style>
</head>

<body class="bg-bg min-h-screen flex flex-col">

@include('kasir.components.navbar')

<!-- TOPBAR -->
<nav class="sticky top-0 z-20 bg-gray-900 px-5 py-3 flex items-center justify-between shadow-md">
  <div class="w-8"></div>
  <span class="font-display text-xl font-bold text-white tracking-widest">Kashy</span>
  <div class="w-8"></div>
</nav>

<main class="flex-1 overflow-y-auto pb-28 max-w-2xl mx-auto w-full">

  <div class="px-4 pt-5 pb-3 fade-up delay-1">
    <h1 class="text-2xl font-bold text-gray-900">Laporan Penjualan</h1>
    <p class="text-sm text-muted mt-1" id="dateLabel"></p>
  </div>

  <div class="px-4 flex flex-col gap-5">
    <!-- Loading State -->
    <div id="loadingState" class="loading-state">
      <div class="loading-spinner"></div>
      <span class="text-muted">Memuat data laporan...</span>
    </div>

    <!-- Data akan diisi oleh JavaScript -->
    <div id="laporanContent" style="display: none;"></div>
  </div>

</main>

<script>
  // Set tanggal otomatis
  (function() {
    const days = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
    const months = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
    const d = new Date();
    const dateLabel = document.getElementById('dateLabel');
    if (dateLabel) {
      dateLabel.textContent = days[d.getDay()] + ', ' + d.getDate() + ' ' + months[d.getMonth()] + ' ' + d.getFullYear();
    }
  })();

  function formatRupiah(angka) {
    return 'Rp ' + new Intl.NumberFormat('id-ID').format(angka);
  }

  async function loadLaporan() {
    const loadingState = document.getElementById('loadingState');
    const laporanContent = document.getElementById('laporanContent');
    
    try {
      const response = await fetch('/kasir/laporan/hari-ini');
      const result = await response.json();
      
      if (result.success) {
        const data = result.data;
        
        let html = `
          <div class="fade-up delay-2">
            <button class="cetak-btn-main" onclick="window.location.href='{{ route('kasir.laporan.export-pdf') }}'">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <polyline points="6 9 6 2 18 2 18 9"/>
                <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/>
                <rect x="6" y="14" width="12" height="8"/>
              </svg>
              Cetak Laporan
            </button>
          </div>

          <div class="stats-two-column fade-up delay-2">
            <div class="stat-card">
              <div class="stat-label"><span>Total Penjualan</span></div>
              <p class="stat-value">${formatRupiah(data.total_penjualan)}</p>
            </div>
            <div class="stat-card">
              <div class="stat-label"><span>Total Transaksi</span></div>
              <p class="stat-value">${data.total_transaksi}</p>
              <p class="stat-sub">Transaksi sukses</p>
            </div>
          </div>

          <div class="stat-card fade-up delay-3">
            <p class="section-header">Penjualan per Kategori</p>
            ${data.penjualan_per_kategori.length > 0 ? data.penjualan_per_kategori.map(kat => `
              <div class="cat-row">
                <div class="flex-1">
                  <div class="cat-name">${kat.name}</div>
                  <div class="bar-track mt-2"><div class="bar-fill" style="width:${kat.percentage}%"></div></div>
                </div>
                <span class="cat-amount">${formatRupiah(kat.total)}</span>
              </div>
            `).join('') : '<div class="text-center text-muted py-4">Belum ada data penjualan</div>'}
          </div>

          <div class="stat-card fade-up delay-4">
            <p class="section-header">Produk Terlaris Hari Ini</p>
            <table class="rank-table">
              <thead>
                <tr><th style="width:32px;">#</th><th>Kategori</th><th>Terjual</th></tr>
              </thead>
              <tbody>
                ${data.produk_terlaris.length > 0 ? data.produk_terlaris.map(prod => `
                  <tr>
                    <td><span class="rank-num ${prod.rank <= 3 ? 'top' : ''}">${prod.rank}</span></td>
                    <td>${prod.name}</td>
                    <td>${prod.terjual}</td>
                  </tr>
                `).join('') : '<tr><td colspan="3" class="text-center text-muted py-4">Belum ada data produk terjual</td></tr>'}
              </tbody>
            </table>
          </div>

          <div class="stat-card fade-up delay-5">
            <p class="section-header">Metode Pembayaran</p>
            ${data.metode_pembayaran.length > 0 ? data.metode_pembayaran.map(met => `
              <div class="cat-row">
                <div class="flex-1">
                  <div class="cat-name">${met.name}</div>
                  <div class="bar-track mt-2"><div class="bar-fill" style="width:${met.percentage}%"></div></div>
                </div>
                <span class="cat-amount">${met.percentage}%</span>
              </div>
            `).join('') : '<div class="text-center text-muted py-4">Belum ada data pembayaran</div>'}
          </div>
        `;
        
        laporanContent.innerHTML = html;
        loadingState.style.display = 'none';
        laporanContent.style.display = 'block';
      } else {
        throw new Error('Gagal memuat data');
      }
    } catch (error) {
      console.error('Error:', error);
      loadingState.innerHTML = '<div class="text-center text-red-500 py-4">Gagal memuat data laporan</div>';
    }
  }

  loadLaporan();
</script>
</body>
</html>