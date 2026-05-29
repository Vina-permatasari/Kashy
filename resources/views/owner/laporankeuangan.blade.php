<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover"/>
  <title>Kashy – Laporan Keuangan | Owner</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet"/>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
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

    #sidebar {
      position:fixed; top:0; left:0; height:100vh; width:280px;
      background:#fff; box-shadow:2px 0 24px rgba(60,40,10,.12);
      z-index:60; transition:transform .3s cubic-bezier(0.2, 0.9, 0.4, 1.1);
      display:flex; flex-direction:column; overflow-y:auto;
      transform:translateX(-100%);
    }
    #sidebar.sidebar-open { transform:translateX(0); }
    #overlay { display:none; position:fixed; inset:0; background:rgba(0,0,0,.45); z-index:55; backdrop-filter:blur(3px); }
    #overlay.show { display:block; }

    @keyframes fadeUp {
      from { opacity:0; transform:translateY(18px); }
      to   { opacity:1; transform:translateY(0); }
    }
    .fade-up { animation:fadeUp .4s ease both; }
    .d1{animation-delay:.04s} .d2{animation-delay:.08s} .d3{animation-delay:.12s}
    .d4{animation-delay:.16s} .d5{animation-delay:.20s} .d6{animation-delay:.24s}
    .d7{animation-delay:.28s} .d8{animation-delay:.32s} .d9{animation-delay:.36s}

    .nav-item {
      display:flex; align-items:center; gap:12px; padding:11px 18px;
      border-radius:12px; cursor:pointer; transition:all .15s;
      font-size:14px; font-weight:500; color:#1a1a1a;
      text-decoration:none; width:100%;
    }
    .nav-item:hover { background:#F5F0EB; }
    .nav-item.active { background:#F7EFE5; color:#7B4F2E; font-weight:600; }
    .nav-item.active svg { stroke:#7B4F2E; }

    .form-input {
      width:100%; padding:12px 14px; border:1.5px solid #E0D8CE;
      border-radius:12px; font-size:13px; font-family:'Poppins',sans-serif;
      color:#1a1a1a; background:#fff; outline:none;
      transition:border-color .2s;
    }
    .form-input:focus { border-color:#C49A6C; }
    .form-select {
      appearance:none; background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%238A7968' stroke-width='2'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E");
      background-repeat:no-repeat; background-position:right 12px center;
      padding-right:36px; cursor:pointer;
    }

    .bar-track { height:5px; background:#EDE5DB; border-radius:99px; flex:2; }
    .bar-fill-sm { height:5px; border-radius:99px; background:#C49A6C; transition:width .6s ease; }
    ::-webkit-scrollbar { width:4px; }
    ::-webkit-scrollbar-thumb { background:#C49A6C; border-radius:10px; }
  </style>
</head>
@include('owner.components.sidebar')

<body>
<main id="main" class="min-h-screen bg-kashy-cream">
  @include('owner.components.topbar')

  <div class="px-5 md:px-8 py-6 max-w-2xl mx-auto">
    
    <!-- Header + Export -->
    <div class="fade-up d1 flex flex-wrap items-start justify-between gap-3 mb-5">
      <div>
        <h1 class="text-2xl md:text-3xl font-extrabold text-kashy-dark leading-tight">Laporan Keuangan</h1>
        <p class="text-xs text-kashy-muted mt-1">Ringkasan performa bisnis & analitik penjualan mendalam.</p>
      </div>
      <button onclick="exportLaporan()" class="flex-shrink-0 flex items-center gap-2 px-3 py-2 md:px-4 md:py-2.5 rounded-xl text-white text-xs font-bold tracking-wide hover:opacity-90 active:scale-95 transition-all shadow-btn" style="background:#C49A6C; box-shadow:0 4px 14px 0 rgba(196,154,108,.35);">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
        <span class="hidden sm:inline">Export</span>
      </button>
    </div>

    <!-- Sync Banner -->
    <div class="fade-up d1 sync-banner mb-6 bg-gradient-to-r from-[#1a1a1a] to-[#2d2d2d] rounded-2xl p-4 flex items-center gap-3 text-white shadow-card">
      <div class="w-9 h-9 rounded-xl bg-kashy-brown/30 flex items-center justify-center flex-shrink-0">
        <svg class="w-4 h-4 text-kashy-brown" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><polyline points="1 4 1 10 7 10"/><polyline points="23 20 23 14 17 14"/><path d="M20.49 9A9 9 0 0 0 5.64 5.64L1 10M23 14l-4.64 4.36A9 9 0 0 1 3.51 15"/></svg>
      </div>
      <div class="flex-1 min-w-0">
        <p class="text-xs font-bold text-white/90 uppercase tracking-wider">Sinkronisasi Kasir</p>
        <p class="text-[11px] text-white/50 mt-0.5">Data real-time dari transaksi kasir · Terakhir diperbarui: <span id="lastSync">baru saja</span></p>
      </div>
      <div class="flex items-center gap-1.5 flex-shrink-0">
        <div class="w-2 h-2 rounded-full bg-green-400"></div>
        <span class="text-xs font-semibold text-green-400">Live</span>
      </div>
    </div>

<!-- FILTER: Tanpa ikon SVG, menggunakan kalender bawaan browser -->
<div class="fade-up d2 mb-6">
  <div class="flex flex-col sm:flex-row gap-4 items-stretch">
    <!-- Bagian kiri: Mulai & Berakhir -->
    <div class="flex-1 flex flex-col">
      <!-- Baris label -->
      <div class="flex gap-3 mb-1 px-1">
        <div class="flex-1 min-w-[120px]">
          <label class="block text-[10px] font-semibold text-kashy-muted uppercase tracking-wide">Mulai dari</label>
        </div>
        <div class="flex-1 min-w-[120px]">
          <label class="block text-[10px] font-semibold text-kashy-muted uppercase tracking-wide">Berakhir</label>
        </div>
        <div class="w-[82px]"></div>
      </div>
      <!-- Card putih berisi input tanggal (tanpa ikon) dan tombol Terapkan -->
      <div class="bg-white border border-kashy-border rounded-xl p-3 shadow-sm h-full flex items-center">
        <div class="flex flex-wrap items-center gap-3 w-full">
          <div class="flex-1 min-w-[120px]">
            <input type="date" id="startDate" class="border-none bg-transparent text-sm focus:outline-none w-full py-1" placeholder="mm/dd/yyyy">
          </div>
          <div class="flex-1 min-w-[120px]">
            <input type="date" id="endDate" class="border-none bg-transparent text-sm focus:outline-none w-full py-1" placeholder="mm/dd/yyyy">
          </div>
          <button onclick="terapkanRangeTanggal()" class="bg-[#C49A6C] text-white text-xs font-semibold px-4 py-2 rounded-lg hover:opacity-90 transition shadow-sm whitespace-nowrap">Terapkan</button>
        </div>
      </div>
    </div>

    <!-- Bagian kanan: Filter -->
    <div class="sm:w-48 w-full flex flex-col">
      <label class="block text-[10px] font-semibold text-kashy-muted uppercase tracking-wide mb-1">Filter</label>
      <div class="bg-white border border-kashy-border rounded-xl p-3 shadow-sm h-full flex items-center">
        <select id="periodeSelect" class="form-input form-select w-full py-2 pr-8 bg-white border-0 focus:ring-0" onchange="setPeriodeFromSelect(this.value)">
          <option value="harian">Harian</option>
          <option value="bulanan">Bulanan</option>
          <option value="tahunan">Tahunan</option>
        </select>
      </div>
    </div>
  </div>
</div>

    <!-- STAT CARDS -->
    <div class="mb-6">
      <div class="fade-up d3 bg-white rounded-2xl p-5 shadow-card border-l-4 border-kashy-brown w-full mb-4">
        <div class="flex items-start justify-between mb-3">
          <span class="text-[11px] font-semibold tracking-widest text-kashy-muted uppercase">Total Pendapatan</span>
          <div class="w-8 h-8 rounded-xl bg-kashy-cream flex items-center justify-center">
            <svg class="w-4 h-4 text-kashy-brown" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8"><rect x="2" y="6" width="20" height="12" rx="2"/><circle cx="12" cy="12" r="3"/><path d="M6 12h.01M18 12h.01"/></svg>
          </div>
        </div>
        <p class="text-2xl font-bold text-kashy-dark" id="statPendapatan">Rp 128.450.000</p>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div class="fade-up d3 bg-white rounded-2xl p-5 shadow-card border-l-4 border-kashy-brown">
          <div class="flex items-start justify-between mb-3">
            <span class="text-[11px] font-semibold tracking-widest text-kashy-muted uppercase">Transaksi</span>
            <div class="w-8 h-8 rounded-xl bg-kashy-cream flex items-center justify-center">
              <svg class="w-4 h-4 text-kashy-brown" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
            </div>
          </div>
          <p class="text-2xl font-bold text-kashy-dark" id="statTransaksi">1.248</p>
        </div>

        <div class="fade-up d3 bg-white rounded-2xl p-5 shadow-card border-l-4 border-emerald-600">
          <div class="flex items-start justify-between mb-3">
            <span class="text-[11px] font-semibold tracking-widest text-kashy-muted uppercase">Produk Terjual</span>
            <div class="w-8 h-8 rounded-xl bg-kashy-cream flex items-center justify-center">
              <svg class="w-4 h-4 text-emerald-700" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8"><path d="M20 7h-4.18A3 3 0 0 0 16 5.18V4a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v1.18A3 3 0 0 0 8.18 7H4a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2z"/><circle cx="12" cy="14" r="4"/></svg>
            </div>
          </div>
          <p class="text-2xl font-bold text-kashy-dark" id="statProduk">3.842</p>
        </div>
      </div>
    </div>

    <!-- Grafik Tren Pendapatan -->
    <div class="fade-up d5 bg-white rounded-2xl p-4 md:p-5 mb-6 shadow-card">
      <div class="flex flex-wrap items-start justify-between gap-2 mb-5">
        <div>
          <h3 class="text-base font-bold text-kashy-dark" id="chartTitle">Grafik Pendapatan Harian</h3>
          <p class="text-xs text-kashy-muted mt-0.5" id="chartSubtitle">7 hari terakhir</p>
        </div>
        <div class="flex gap-1">
          <button onclick="setChartType('bar')" id="btnBar" class="w-8 h-8 rounded-lg flex items-center justify-center transition-all text-kashy-muted hover:bg-kashy-cream" style="background:#F5F0EB;"><svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><rect x="3" y="12" width="4" height="9"/><rect x="10" y="7" width="4" height="14"/><rect x="17" y="3" width="4" height="18"/></svg></button>
          <button onclick="setChartType('line')" id="btnLine" class="w-8 h-8 rounded-lg flex items-center justify-center transition-all text-kashy-muted hover:bg-kashy-cream"><svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg></button>
        </div>
      </div>
      <div class="chart-container" style="height:210px;"><canvas id="mainChart"></canvas></div>
    </div>

    <!-- Metode Pembayaran -->
    <div class="fade-up d8 bg-white rounded-2xl p-4 md:p-5 mb-4 shadow-card">
      <div class="flex flex-wrap items-center justify-between gap-2 mb-4">
        <h3 class="text-base font-bold text-kashy-dark">Metode Pembayaran</h3>
        <span class="text-xs text-kashy-muted font-medium">Dari kasir realtime</span>
      </div>
      <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mb-4">
        <div class="chart-container flex items-center justify-center" style="height:140px;"><canvas id="donutChart"></canvas></div>
        <div class="flex flex-col justify-center gap-2.5" id="donutLegend"></div>
      </div>
      <div id="metodePembayaranList"></div>
    </div>

  </div>
</main>

<script>
  const sidebar = document.getElementById('sidebar');
  const overlay = document.getElementById('overlay');
  const menuBtn = document.getElementById('global-menu-toggle');
  function openSidebar()  { sidebar.classList.add('sidebar-open'); overlay.classList.add('show'); document.body.style.overflow='hidden'; }
  function closeSidebar() { sidebar.classList.remove('sidebar-open'); overlay.classList.remove('show'); document.body.style.overflow=''; }
  if (menuBtn) menuBtn.addEventListener('click', e => { e.stopPropagation(); openSidebar(); });
  if (overlay) overlay.addEventListener('click', closeSidebar);
  document.addEventListener('keydown', e => { if (e.key==='Escape') closeSidebar(); });

  const DATA = {
    harian: {
      labels: ['Sen','Sel','Rab','Kam','Jum','Sab','Min'],
      pendapatan: [60000000, 45000000, 128450000, 90000000, 75000000, 50000000, 30000000],
      pendapatan_total: 128450000,
      transaksi_total: 1248,
      produk_terjual: 3842,
    },
    bulanan: {
      labels: ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agt','Sep','Okt','Nov','Des'],
      pendapatan: [310000000,280000000,420000000,380000000,510000000,460000000,390000000,430000000,490000000,550000000,480000000,620000000],
      pendapatan_total: 5100000000,
      transaksi_total: 4860,
      produk_terjual: 14200,
    },
    tahunan: {
      labels: ['2021','2022','2023','2024','2025','2026'],
      pendapatan: [2100000000,3400000000,4200000000,5800000000,7200000000,8900000000],
      pendapatan_total: 8900000000,
      transaksi_total: 35600,
      produk_terjual: 95000,
    },
    custom: null
  };

  let currentPeriode = 'harian';
  let currentType = 'bar';
  let mainChart, donutChart;

  const METODE = [
    { name:'QRIS', pct:55, color:'#C49A6C' },
    { name:'Tunai', pct:30, color:'#1a1a1a' },
    { name:'Debit', pct:15, color:'#E0D8CE' },
  ];

  const fmt = n => 'Rp ' + new Intl.NumberFormat('id-ID').format(n);

  function buildMainChart(periode, customData = null) {
    const d = customData ? customData : DATA[periode];
    if (!d) return;
    if (mainChart) mainChart.destroy();
    const ctx = document.getElementById('mainChart').getContext('2d');
    const isBar = currentType === 'bar';
    mainChart = new Chart(ctx, {
      type: currentType,
      data: {
        labels: d.labels,
        datasets: [{
          label: 'Pendapatan',
          data: d.pendapatan,
          backgroundColor: isBar ? d.pendapatan.map((v,i) => i === d.pendapatan.indexOf(Math.max(...d.pendapatan)) ? '#C49A6C' : '#E0D8CE') : 'rgba(196,154,108,.12)',
          borderColor: '#C49A6C',
          borderWidth: isBar ? 0 : 2.2,
          borderRadius: isBar ? 6 : 0,
          tension: 0.4,
          fill: !isBar,
          pointBackgroundColor: '#C49A6C',
          pointRadius: isBar ? 0 : 3.5,
        }]
      },
      options: {
        responsive: true, maintainAspectRatio: false,
        plugins: { legend:{ display:false }, tooltip:{ callbacks:{ label: ctx => fmt(ctx.raw) }, backgroundColor:'#1a1a1a', titleFont:{family:'Poppins'}, bodyFont:{family:'Poppins'} } },
        scales: {
          x: { grid:{ display:false }, ticks:{ font:{family:'Poppins',size:10}, color:'#8A7968' } },
          y: { grid:{ color:'#F0EBE5' }, ticks:{ font:{family:'Poppins',size:10}, color:'#8A7968', callback: v => v >= 1e9 ? (v/1e9).toFixed(1)+'M' : v >= 1e6 ? (v/1e6).toFixed(0)+'jt' : v } }
        }
      }
    });
  }

  function buildDonutChart() {
    if (donutChart) donutChart.destroy();
    const ctx = document.getElementById('donutChart').getContext('2d');
    donutChart = new Chart(ctx, {
      type: 'doughnut',
      data: { labels: METODE.map(m => m.name), datasets: [{ data: METODE.map(m=>m.pct), backgroundColor: METODE.map(m=>m.color), borderWidth:0, hoverOffset:6 }] },
      options: { responsive: true, maintainAspectRatio: false, cutout:'72%', plugins: { legend:{ display:false }, tooltip:{ backgroundColor:'#1a1a1a', titleFont:{family:'Poppins'}, bodyFont:{family:'Poppins'}, callbacks:{ label: ctx => ctx.label + ': ' + ctx.raw + '%' } } } }
    });
    const legend = document.getElementById('donutLegend');
    legend.innerHTML = METODE.map(m => `<div class="flex items-center gap-2 justify-between"><div class="flex items-center gap-2"><div class="w-3 h-3 rounded-full flex-shrink-0" style="background:${m.color};"></div><span class="text-xs font-medium text-kashy-dark">${m.name}</span></div><span class="text-xs font-bold text-kashy-muted">${m.pct}%</span></div>`).join('');
  }

  function renderMetode() {
    document.getElementById('metodePembayaranList').innerHTML = METODE.map(m => `
      <div class="flex items-center gap-3 py-2.5 border-b border-kashy-border/70 last:border-0">
        <div class="w-2.5 h-2.5 rounded-full flex-shrink-0" style="background:${m.color};"></div>
        <div class="flex-1">
          <div class="flex justify-between mb-1.5"><span class="text-sm font-medium text-kashy-dark">${m.name}</span><span class="text-xs font-bold text-kashy-muted">${m.pct}%</span></div>
          <div class="bar-track"><div class="bar-fill-sm" style="width:${m.pct}%; background:${m.color};"></div></div>
        </div>
      </div>
    `).join('');
  }

  function updateStats(periode, customData = null) {
    const d = customData ? customData : DATA[periode];
    if (d) {
      document.getElementById('statPendapatan').textContent = fmt(d.pendapatan_total);
      document.getElementById('statTransaksi').textContent = new Intl.NumberFormat('id-ID').format(d.transaksi_total);
      document.getElementById('statProduk').textContent = new Intl.NumberFormat('id-ID').format(d.produk_terjual);
    }
  }

  const chartTitles = {
    harian:  { title:'Grafik Pendapatan Harian',   sub:'7 hari terakhir' },
    bulanan: { title:'Grafik Pendapatan Bulanan',  sub:'12 bulan terakhir' },
    tahunan: { title:'Grafik Pendapatan Tahunan',  sub:'6 tahun terakhir' },
    custom:  { title:'Grafik Pendapatan (Kustom)', sub:'Rentang tanggal pilihan' }
  };

  function setPeriode(periode) {
    currentPeriode = periode;
    document.getElementById('periodeSelect').value = periode;
    const ct = chartTitles[periode];
    document.getElementById('chartTitle').textContent = ct.title;
    document.getElementById('chartSubtitle').textContent = ct.sub;
    updateStats(periode);
    buildMainChart(periode);
    DATA.custom = null;
  }

  function setPeriodeFromSelect(val) { setPeriode(val); }

  function setChartType(type) {
    currentType = type;
    document.getElementById('btnBar').style.background = type==='bar' ? '#F5F0EB' : 'transparent';
    document.getElementById('btnLine').style.background = type==='line' ? '#F5F0EB' : 'transparent';
    buildMainChart(currentPeriode, DATA.custom);
  }

  function terapkanRangeTanggal() {
    const start = document.getElementById('startDate').value;
    const end = document.getElementById('endDate').value;
    if (!start || !end) { alert('Pilih tanggal mulai dan selesai terlebih dahulu.'); return; }
    const startDate = new Date(start), endDate = new Date(end);
    const diffDays = Math.ceil((endDate - startDate) / (1000 * 60 * 60 * 24)) + 1;
    const maxDays = Math.min(diffDays, 30);
    const labels = [], pendapatan = [];
    for (let i = 0; i < maxDays; i++) {
      const d = new Date(startDate);
      d.setDate(startDate.getDate() + i);
      labels.push(d.getDate() + '/' + (d.getMonth()+1));
      pendapatan.push(Math.floor(Math.random() * 100000000) + 20000000);
    }
    const customData = {
      labels, pendapatan,
      pendapatan_total: pendapatan.reduce((a,b)=>a+b,0),
      transaksi_total: Math.floor(pendapatan.reduce((a,b)=>a+b,0) / 100000),
      produk_terjual: Math.floor(pendapatan.reduce((a,b)=>a+b,0) / 45000),
    };
    DATA.custom = customData;
    currentPeriode = 'custom';
    document.getElementById('periodeSelect').value = 'harian';
    document.getElementById('chartTitle').textContent = chartTitles.custom.title;
    document.getElementById('chartSubtitle').textContent = chartTitles.custom.sub;
    updateStats(null, customData);
    buildMainChart(null, customData);
  }

  function exportLaporan() { alert('📥 Mengekspor laporan dalam format CSV/PDF (demo).'); }

  (function init() {
    setPeriode('harian');
    buildDonutChart();
    renderMetode();
    setInterval(() => {
      const now = new Date();
      document.getElementById('lastSync').textContent = now.getHours().toString().padStart(2,'0') + ':' + now.getMinutes().toString().padStart(2,'0') + ':' + now.getSeconds().toString().padStart(2,'0');
    }, 1000);
  })();
</script>
</body>
</html>