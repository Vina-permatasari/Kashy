<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover"/>
  <title>Kashy – Laporan Keuangan</title>
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
              sidebar:      '#ffffff',
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
    .d7{animation-delay:.35s} .d8{animation-delay:.40s}

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

    /* ── Period Tabs ── */
    .period-tab {
      flex:1; padding:9px 4px; font-size:13px; font-weight:600;
      color:#8A7968; border-radius:10px; cursor:pointer;
      transition:all .2s; background:none; border:none;
      font-family:'Poppins',sans-serif; text-align:center;
    }
    .period-tab.active {
      background:#C49A6C; color:#fff;
      box-shadow:0 2px 10px rgba(196,154,108,.35);
    }

    /* ── Stat card left-border accent ── */
    .stat-card {
      background:#fff; border-radius:16px; padding:18px 20px;
      border-left:4px solid #C49A6C;
      box-shadow:0 2px 18px 0 rgba(60,40,10,.07);
      transition:transform .2s, box-shadow .2s;
    }
    .stat-card:hover { transform:translateY(-2px); box-shadow:0 6px 22px 0 rgba(60,40,10,.11); }

    /* ── Chart bars ── */
    .bar-wrap { display:flex; flex-direction:column; align-items:center; gap:6px; flex:1; }
    .bar {
      width:100%; max-width:34px; border-radius:6px 6px 0 0;
      transition:opacity .2s, transform .2s; cursor:pointer;
    }
    .bar:hover { opacity:.75; transform:scaleY(1.04); transform-origin:bottom; }
    .bar.highlight { background:#C49A6C; }
    .bar.normal    { background:#E0D8CE; }
    .bar-label { font-size:10px; color:#8A7968; font-weight:600; letter-spacing:.04em; }

    /* ── Dark distribusi card ── */
    .dark-card {
      background:#1a1a1a; border-radius:18px; padding:22px;
      color:#fff; box-shadow:0 4px 24px rgba(28,18,9,.22);
    }
    .time-bar-bg { height:5px; border-radius:99px; background:rgba(255,255,255,.1); overflow:hidden; }
    .time-bar-fill { height:100%; border-radius:99px; background:#C49A6C; transition:width .6s ease; }

    /* ── Product table ── */
    .product-row {
      display:grid; grid-template-columns:2fr 1fr;
      padding:13px 20px; align-items:center;
      border-bottom:1px solid #E0D8CE;
      transition:background .15s;
    }
    .product-row:last-child { border-bottom:none; }
    .product-row:hover { background:#FAF7F4; }
    .product-thumb-ph {
      width:36px; height:36px; border-radius:9px;
      background:#EDE5DB; display:flex; align-items:center;
      justify-content:center; flex-shrink:0;
    }

    /* ── Scrollbar ── */
    ::-webkit-scrollbar { width:4px; }
    ::-webkit-scrollbar-track { background:transparent; }
    ::-webkit-scrollbar-thumb { background:#C49A6C; border-radius:10px; }

    /* ── Date button ── */
    .date-btn {
      display:flex; align-items:center; gap:7px;
      padding:8px 14px; border-radius:10px;
      border:1.5px solid #E0D8CE; background:#fff;
      font-size:12px; font-weight:600; color:#1a1a1a;
      cursor:pointer; transition:border-color .2s, box-shadow .2s;
    }
    .date-btn:hover { border-color:#C49A6C; box-shadow:0 2px 8px rgba(196,154,108,.15); }

    /* ── Search input ── */
    .search-input {
      width:100%; padding:10px 12px 10px 36px;
      border:1.5px solid #E0D8CE; border-radius:12px;
      font-size:13px; font-family:'Poppins',sans-serif;
      color:#1a1a1a; background:#F5F0EB; outline:none;
      transition:border-color .2s;
    }
    .search-input:focus { border-color:#C49A6C; background:#fff; }
    .search-input::placeholder { color:#BFB4AC; }

    /* ── Modal ── */
    #dateModal { display:none; }
    #dateModal.show { display:flex; }
  </style>
</head>

@include('owner.components.sidebar')

<body>

<main id="main" class="min-h-screen bg-kashy-cream">
  @include('owner.components.topbar')

  <div class="px-5 md:px-8 py-6 max-w-2xl mx-auto">

    {{-- ── Header ── --}}
    <div class="fade-up d1 flex items-start justify-between gap-3 mb-5">
      <div>
        <h1 class="text-3xl font-extrabold text-kashy-dark leading-tight">Laporan Keuangan</h1>
        <p class="text-sm text-kashy-muted mt-1">Ringkasan performa bisnis dan analitik penjualan mendalam.</p>
      </div>
      {{-- Export button --}}
      <a href="#" id="exportBtn"
         class="flex-shrink-0 flex items-center gap-2 px-4 py-2.5 rounded-xl text-white text-xs font-bold tracking-wide transition-all hover:opacity-90 active:scale-95"
         style="background:#C49A6C; box-shadow:0 4px 14px 0 rgba(196,154,108,.35); margin-top:4px;">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
          <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
          <polyline points="7 10 12 15 17 10"/>
          <line x1="12" y1="15" x2="12" y2="3"/>
        </svg>
        Export
      </a>
    </div>

    {{-- ── Period Tabs ── --}}
    <div class="fade-up d2 mb-4">
      <div class="flex items-center gap-1 bg-white rounded-xl p-1.5 w-fit" style="box-shadow:0 2px 10px rgba(60,40,10,.07);">
        <button class="period-tab active" onclick="setPeriode('harian', this)">Harian</button>
        <button class="period-tab" onclick="setPeriode('bulanan', this)">Bulanan</button>
        <button class="period-tab" onclick="setPeriode('tahunan', this)">Tahunan</button>
      </div>
    </div>

    {{-- ── Date Range ── --}}
    <div class="fade-up d2 mb-5">
      <button class="date-btn" onclick="document.getElementById('dateModal').classList.add('show')">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#C49A6C" stroke-width="2">
          <rect x="3" y="4" width="18" height="18" rx="2"/>
          <line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/>
          <line x1="3" y1="10" x2="21" y2="10"/>
        </svg>
        <span id="dateRangeLabel">24 Oct – 30 Oct 2023</span>
        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#8A7968" stroke-width="2.5">
          <polyline points="6 9 12 15 18 9"/>
        </svg>
      </button>
    </div>

    {{-- ── Stat Cards ── --}}
    {{-- Total Pendapatan --}}
    <div class="fade-up d3 stat-card mb-4">
      <p class="text-[10px] font-bold uppercase tracking-widest text-kashy-muted mb-2">Total Pendapatan</p>
      <p class="text-3xl font-extrabold text-kashy-dark leading-tight">
        Rp {{ number_format($totalPendapatan ?? 128450000, 0, ',', '.') }}
      </p>
      <div class="flex items-center gap-1.5 mt-2">
        @php $trend = $pendapatanTrend ?? 12.4; @endphp
        @if($trend >= 0)
          <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#2D8A5E" stroke-width="2.5">
            <polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/>
            <polyline points="17 6 23 6 23 12"/>
          </svg>
          <span class="text-xs font-semibold" style="color:#2D8A5E">+{{ $trend }}% vs periode lalu</span>
        @else
          <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#C0392B" stroke-width="2.5">
            <polyline points="23 18 13.5 8.5 8.5 13.5 1 6"/>
            <polyline points="17 18 23 18 23 12"/>
          </svg>
          <span class="text-xs font-semibold" style="color:#C0392B">{{ $trend }}% vs periode lalu</span>
        @endif
      </div>
    </div>

    {{-- Produk Terjual --}}
    <div class="fade-up d4 stat-card mb-4">
      <p class="text-[10px] font-bold uppercase tracking-widest text-kashy-muted mb-2">Produk Terjual</p>
      <p class="text-3xl font-extrabold text-kashy-dark leading-tight">
        {{ number_format($totalProdukTerjual ?? 1248, 0, ',', '.') }} Units
      </p>
      <div class="flex items-center gap-1.5 mt-2 text-kashy-muted">
        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/>
          <line x1="3" y1="6" x2="21" y2="6"/>
          <path d="M16 10a4 4 0 0 1-8 0"/>
        </svg>
        <span class="text-xs font-semibold">{{ $produkTerlaris ?? 'Premium Silk Focus' }}</span>
      </div>
    </div>

    {{-- Jam Sibuk --}}
    <div class="fade-up d4 stat-card mb-5">
      <p class="text-[10px] font-bold uppercase tracking-widest text-kashy-muted mb-2">Jam Sibuk</p>
      <p class="text-3xl font-extrabold text-kashy-dark leading-tight">
        {{ $jamSibuk ?? '14:00 – 16:00' }}
      </p>
      <div class="flex items-center gap-1.5 mt-2 text-kashy-muted">
        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <circle cx="12" cy="12" r="10"/>
          <polyline points="12 6 12 12 16 14"/>
        </svg>
        <span class="text-xs font-semibold">Volume tertinggi hari ini</span>
      </div>
    </div>

    {{-- ── Bar Chart – Tren Pendapatan ── --}}
    <div class="fade-up d5 bg-white rounded-2xl p-5 mb-4" style="box-shadow:0 2px 18px 0 rgba(60,40,10,.07);">
      <div class="flex items-start justify-between mb-5">
        <div>
          <h3 class="text-base font-bold text-kashy-dark" id="chartTitle">Tren Pendapatan Mingguan</h3>
          <p class="text-xs text-kashy-muted mt-0.5" id="chartSubtitle">24 – 30 Oktober 2023</p>
        </div>
        <button class="text-kashy-muted hover:text-kashy-dark transition-colors p-1">
          <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24">
            <circle cx="12" cy="5" r="1.5"/>
            <circle cx="12" cy="12" r="1.5"/>
            <circle cx="12" cy="19" r="1.5"/>
          </svg>
        </button>
      </div>

      {{-- Bar group --}}
      <div class="flex items-end gap-2" style="height:140px;" id="chartBars">
        @php
          $chartData = $chartData ?? [
            ['label'=>'SEN','value'=>60000000,'highlight'=>false],
            ['label'=>'SEL','value'=>45000000,'highlight'=>false],
            ['label'=>'RAB','value'=>128450000,'highlight'=>true],
            ['label'=>'KAM','value'=>90000000,'highlight'=>false],
            ['label'=>'JUM','value'=>75000000,'highlight'=>false],
            ['label'=>'SAB','value'=>50000000,'highlight'=>false],
            ['label'=>'MIN','value'=>30000000,'highlight'=>false],
          ];
          $maxVal = max(array_column($chartData,'value')) ?: 1;
        @endphp
        @foreach($chartData as $bar)
          @php $h = max(18, (int)round(($bar['value']/$maxVal)*130)); @endphp
          <div class="bar-wrap">
            <div class="bar {{ $bar['highlight'] ? 'highlight' : 'normal' }}"
                 style="height:{{ $h }}px"
                 title="Rp {{ number_format($bar['value'],0,',','.') }}">
            </div>
            <span class="bar-label">{{ $bar['label'] }}</span>
          </div>
        @endforeach
      </div>
    </div>

    {{-- ── Distribusi Waktu (dark card) ── --}}
    <div class="fade-up d6 dark-card mb-5">
      <h3 class="text-base font-bold mb-1">Distribusi Waktu</h3>
      <p class="text-xs mb-5" style="color:rgba(255,255,255,.5)">Analisis jam operasional paling menguntungkan.</p>

      @php
        $distribusiWaktu = $distribusiWaktu ?? [
          ['label'=>'PAGI (08:00 – 12:00)',  'persen'=>25],
          ['label'=>'SIANG (12:00 – 17:00)', 'persen'=>58],
          ['label'=>'MALAM (17:00 – 22:00)', 'persen'=>17],
        ];
      @endphp

      <div class="flex flex-col gap-4">
        @foreach($distribusiWaktu as $slot)
          <div>
            <div class="flex justify-between mb-1.5">
              <span class="text-[11px] font-semibold tracking-wide" style="color:rgba(255,255,255,.65)">
                {{ $slot['label'] }}
              </span>
              <span class="text-[11px] font-bold" style="color:rgba(255,255,255,.85)">
                {{ $slot['persen'] }}%
              </span>
            </div>
            <div class="time-bar-bg">
              <div class="time-bar-fill" style="width:{{ $slot['persen'] }}%"></div>
            </div>
          </div>
        @endforeach
      </div>
    </div>

    {{-- ── Detail Penjualan Produk ── --}}
    <div class="fade-up d7 bg-white rounded-2xl overflow-hidden mb-6" style="box-shadow:0 2px 18px 0 rgba(60,40,10,.07);">

      {{-- Header + search --}}
      <div class="p-5 border-b border-kashy-border">
        <h3 class="text-base font-bold text-kashy-dark mb-3">Detail Penjualan Produk</h3>
        <div style="position:relative;">
          <span style="position:absolute;left:12px;top:50%;transform:translateY(-50%);">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#8A7968" stroke-width="2">
              <circle cx="11" cy="11" r="8"/>
              <line x1="21" y1="21" x2="16.65" y2="16.65"/>
            </svg>
          </span>
          <input type="text" class="search-input" id="productSearch"
                 placeholder="Cari produk..."
                 onkeyup="filterProducts(this.value)">
        </div>
      </div>

      {{-- Column headers --}}
      <div class="flex px-5 py-2.5" style="background:#F5F0EB;">
        <span class="flex-1 text-[10px] font-bold uppercase tracking-widest text-kashy-muted">Produk</span>
        <span class="w-24 text-[10px] font-bold uppercase tracking-widest text-kashy-muted">Kategori</span>
      </div>

      {{-- Rows --}}
      <div id="productRows">
        @php
          $produkData = $produkData ?? [
            ['nama'=>'Classic Silk Blouse',   'kategori'=>'Apparel',     'gambar'=>null],
            ['nama'=>'Earth Toned Sandals',   'kategori'=>'Footwear',    'gambar'=>null],
            ['nama'=>'Charcoal Tote Bag',     'kategori'=>'Accessories', 'gambar'=>null],
          ];
        @endphp

        @forelse($produkData as $produk)
          <div class="product-row" data-name="{{ strtolower($produk['nama']) }}">
            {{-- Produk --}}
            <div class="flex items-center gap-3">
              @if(!empty($produk['gambar']))
                <img src="{{ asset('storage/'.$produk['gambar']) }}"
                     alt="{{ $produk['nama'] }}"
                     class="w-9 h-9 rounded-lg object-cover flex-shrink-0">
              @else
                <div class="product-thumb-ph">
                  <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#8A7968" stroke-width="1.8">
                    <rect x="3" y="3" width="18" height="18" rx="2"/>
                    <circle cx="8.5" cy="8.5" r="1.5"/>
                    <polyline points="21 15 16 10 5 21"/>
                  </svg>
                </div>
              @endif
              <span class="text-sm font-semibold text-kashy-dark leading-tight">{{ $produk['nama'] }}</span>
            </div>
            {{-- Kategori --}}
            <div class="w-24">
              <span class="text-xs font-500 text-kashy-muted">{{ $produk['kategori'] }}</span>
            </div>
          </div>
        @empty
          <div class="px-5 py-8 text-center">
            <p class="text-sm text-kashy-muted">Belum ada data produk.</p>
          </div>
        @endforelse
      </div>

      {{-- See all --}}
      <a href="javascript:void(0)"
         class="flex items-center justify-center gap-2 w-full py-4 text-sm font-bold transition-colors hover:bg-kashy-cream"
         style="color:#C49A6C; border-top:1px solid #E0D8CE; text-decoration:none;">
        Lihat Semua Produk
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
          <line x1="5" y1="12" x2="19" y2="12"/>
          <polyline points="12 5 19 12 12 19"/>
        </svg>
      </a>
    </div>

  </div>{{-- /max-w --}}
</main>

{{-- ── Date Range Modal ── --}}
<div id="dateModal"
     class="fixed inset-0 z-50 items-end justify-center bg-black/40 px-4 pb-8"
     style="backdrop-filter:blur(3px);">
  <div class="bg-white rounded-2xl p-6 w-full max-w-sm" style="box-shadow:0 10px 40px rgba(0,0,0,.2);">
    <h4 class="font-bold text-kashy-dark mb-4">Pilih Rentang Tanggal</h4>
    <form method="GET" action="{{ route('owner.laporan.keuangan') }}">
      <input type="hidden" name="periode" id="hiddenPeriode" value="harian">
      <div class="space-y-3 mb-5">
        <div>
          <label class="text-[11px] font-bold uppercase tracking-wider text-kashy-muted mb-1.5 block">Dari Tanggal</label>
          <input type="date" name="start" id="modalStart"
                 class="w-full border-[1.5px] border-kashy-border rounded-xl px-3 py-2.5 text-sm text-kashy-dark outline-none transition-colors"
                 style="font-family:'Poppins',sans-serif;"
                 onfocus="this.style.borderColor='#C49A6C'" onblur="this.style.borderColor='#E0D8CE'">
        </div>
        <div>
          <label class="text-[11px] font-bold uppercase tracking-wider text-kashy-muted mb-1.5 block">Sampai Tanggal</label>
          <input type="date" name="end" id="modalEnd"
                 class="w-full border-[1.5px] border-kashy-border rounded-xl px-3 py-2.5 text-sm text-kashy-dark outline-none transition-colors"
                 style="font-family:'Poppins',sans-serif;"
                 onfocus="this.style.borderColor='#C49A6C'" onblur="this.style.borderColor='#E0D8CE'">
        </div>
      </div>
      <div class="flex gap-3">
        <button type="button"
                onclick="document.getElementById('dateModal').classList.remove('show')"
                class="flex-1 py-3 rounded-xl border-[1.5px] border-kashy-border text-kashy-muted font-semibold text-sm hover:bg-kashy-cream transition-colors">
          Batal
        </button>
        <button type="submit"
                class="flex-1 py-3 rounded-xl text-white font-bold text-sm transition-colors hover:opacity-90"
                style="background:#C49A6C;">
          Terapkan
        </button>
      </div>
    </form>
  </div>
</div>

{{-- ── Overlay sidebar ── --}}
<div id="overlay" onclick="closeSidebar()"></div>

<script>
  /* ── Sidebar ── */
  const sidebar = document.getElementById('sidebar');
  const overlay = document.getElementById('overlay');
  const menuBtn = document.getElementById('global-menu-toggle');

  function openSidebar()  { sidebar.classList.add('sidebar-open'); overlay.classList.add('show'); document.body.style.overflow='hidden'; }
  function closeSidebar() { sidebar.classList.remove('sidebar-open'); overlay.classList.remove('show'); document.body.style.overflow=''; }
  function toggleSidebar(){ sidebar.classList.contains('sidebar-open') ? closeSidebar() : openSidebar(); }

  if (menuBtn) menuBtn.addEventListener('click', e => { e.stopPropagation(); toggleSidebar(); });
  document.addEventListener('keydown', e => { if(e.key==='Escape') closeSidebar(); });

  /* ── Period tabs ── */
  const chartTitles = {
    harian:  { title:'Tren Pendapatan Mingguan',  sub:'7 hari terakhir' },
    bulanan: { title:'Tren Pendapatan Bulanan',   sub:'Per minggu bulan ini' },
    tahunan: { title:'Tren Pendapatan Tahunan',   sub:'Per bulan tahun ini' },
  };

  function setPeriode(val, btn) {
    document.querySelectorAll('.period-tab').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    document.getElementById('hiddenPeriode').value = val;

    const ct = chartTitles[val];
    document.getElementById('chartTitle').textContent   = ct.title;
    document.getElementById('chartSubtitle').textContent = ct.sub;

    // Re-fetch via form submit agar data baru
    const url = new URL(window.location.href);
    url.searchParams.set('periode', val);
    window.location.href = url.toString();
  }

  /* ── Filter produk ── */
  function filterProducts(q) {
    q = q.toLowerCase();
    document.querySelectorAll('#productRows .product-row').forEach(row => {
      row.style.display = row.dataset.name.includes(q) ? '' : 'none';
    });
  }

  /* ── Highlight active tab dari URL ── */
  (function(){
    const params = new URLSearchParams(window.location.search);
    const p = params.get('periode') || 'harian';
    document.querySelectorAll('.period-tab').forEach(btn => {
      const onclick = btn.getAttribute('onclick') || '';
      if(onclick.includes("'"+p+"'")) btn.classList.add('active');
      else btn.classList.remove('active');
    });
    const ct = chartTitles[p] || chartTitles.harian;
    document.getElementById('chartTitle').textContent    = ct.title;
    document.getElementById('chartSubtitle').textContent = ct.sub;
  })();

  /* ── Close date modal on backdrop click ── */
  document.getElementById('dateModal').addEventListener('click', function(e){
    if(e.target === this) this.classList.remove('show');
  });
</script>

</body>
</html>