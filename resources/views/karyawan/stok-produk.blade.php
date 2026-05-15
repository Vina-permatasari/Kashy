<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
<title>Stok Produk – Kashy</title>
<script src="https://cdn.tailwindcss.com"></script>
<script>history.scrollRestoration = 'manual';</script> 
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
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
          body: ['Poppins', 'sans-serif'],
        },
      }
    }
  }
</script>
<style>
  * { margin:0; padding:0; box-sizing:border-box; }
  body { font-family: 'Poppins', sans-serif; background:#F5F0EB; }
  @keyframes fadeUp {
    from { opacity:0; transform:translateY(16px); }
    to   { opacity:1; transform:translateY(0); }
  }
  .fade-up { animation: fadeUp 0.4s cubic-bezier(0.2,0.9,0.4,1.1) both; }
  .delay-1 { animation-delay:0.05s; }
  .delay-2 { animation-delay:0.12s; }
  .delay-3 { animation-delay:0.2s; }
  .bn-item.active .bn-icon { background:#F0D7C7; }
  .bn-item.active .bn-icon svg { stroke:#C8966C; }
  .bn-item.active .bn-label { color:#C8966C; font-weight:600; }
  .hide-scroll::-webkit-scrollbar { display:none; }
  .hide-scroll { scrollbar-width:none; }
  .card-hover { transition: transform 0.2s, box-shadow 0.2s; }
  .card-hover:hover { transform: translateY(-2px); box-shadow: 0 12px 28px rgba(0,0,0,0.08); }
  .badge-aman { background:#dcfce7; color:#166534; border:1px solid #bbf7d0; }
  .badge-menipis { background:#fef9c3; color:#854d0e; border:1px solid #fde68a; }
  .badge-habis { background:#fee2e2; color:#991b1b; border:1px solid #fecaca; }
</style>
</head>
<body class="bg-bg min-h-screen flex flex-col">

<!-- TOPBAR -->
<nav class="fixed bottom-0 left-0 right-0 z-50 bg-gray-900 px-5 py-3 flex items-center justify-between shadow-md h-[52px]">
  <a href="javascript:history.back()" class="flex items-center gap-1.5 text-xs text-gray-400 hover:text-white transition-colors">
    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M19 12H5m7-7-7 7 7 7"/></svg>
    Kembali
  </a>
  <span class="text-lg font-semibold text-white tracking-widest">Kashy</span>
  <button class="relative w-8 h-8 flex items-center justify-center rounded-full hover:bg-white/10 transition">
    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="#9C8B7E" stroke-width="2"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
    <span class="absolute top-1 right-1 w-2 h-2 bg-terra rounded-full border-2 border-gray-900"></span>
  </button>
</nav>

<main class="flex-1 overflow-y-auto pb-28">
  <div class="max-w-md mx-auto px-4 pt-5 space-y-4">

  <!-- HEADER -->
<div class="fade-up delay-1">
  <h1 class="text-xl font-bold text-gray-900 mt-0.5">Pencarian Stok</h1>
</div>


    <!-- SEARCH -->
    <div class="fade-up delay-1">
      <div class="flex items-center gap-2.5 bg-white border-2 border-border rounded-xl px-4 py-2.5 focus-within:border-terra transition-all">
        <svg width="16" height="16" fill="none" stroke="#9C8B7E" stroke-width="2" viewBox="0 0 24 24">
          <circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/>
        </svg>
        <input type="text" id="searchInput" placeholder="Search product name or SKU..."
               class="border-0 outline-none bg-transparent text-sm text-gray-900 w-full placeholder-stone-300"
               oninput="filterProducts()">
      </div>
    </div>

    <!-- FILTER CHIPS -->
    <div class="overflow-x-auto hide-scroll fade-up delay-2">
      <div class="inline-flex gap-2 pb-1">
        <button class="filter-chip flex-shrink-0 px-4 py-1.5 rounded-full text-xs font-semibold border-2 bg-gray-900 border-gray-900 text-white transition-all" data-filter="semua" onclick="setFilter(this)">Semua Produk</button>
        <button class="filter-chip flex-shrink-0 px-4 py-1.5 rounded-full text-xs font-medium border-2 border-border bg-white text-muted hover:border-terra transition-all" data-filter="habis" onclick="setFilter(this)">Stok Habis</button>
      </div>
    </div>

    <!-- PRODUCT LIST -->
    <div class="fade-up delay-3 space-y-2.5" id="productList"></div>

    <!-- EMPTY STATE -->
    <div id="emptyState" class="hidden text-center py-14 fade-up">
      <svg class="w-12 h-12 mx-auto mb-3" viewBox="0 0 24 24" fill="none" stroke="#EAE0D6" stroke-width="1.5">
        <path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/>
        <line x1="3" y1="6" x2="21" y2="6"/>
        <path d="M16 10a4 4 0 0 1-8 0"/>
      </svg>
      <p class="text-sm font-medium text-muted">Produk tidak ditemukan</p>
    </div>

  </div>
</main>

<!-- BOTTOM NAV -->
<nav class="fixed bottom-0 left-0 right-0 z-50 bg-white border-t border-border flex justify-around py-2 pb-4 shadow-[0_-2px_12px_rgba(0,0,0,0.05)]">
  <button class="bn-item flex flex-col items-center gap-1 flex-1" onclick="window.location.href='{{ route('dashboard-karyawan') }}'">
    <div class="bn-icon w-10 h-10 rounded-xl flex items-center justify-center transition hover:bg-terra-xs">
      <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#9C8B7E" stroke-width="2"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
    </div>
    <span class="bn-label text-[10px] font-medium text-muted">Beranda</span>
  </button>
  <button class="bn-item flex flex-col items-center gap-1 flex-1" onclick="window.location.href='{{ route('absensi') }}'">
    <div class="bn-icon w-10 h-10 rounded-xl flex items-center justify-center transition hover:bg-terra-xs">
      <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#9C8B7E" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/><path d="m9 16 2 2 4-4"/></svg>
    </div>
    <span class="bn-label text-[10px] font-medium text-muted">Absensi</span>
  </button>
  <button class="bn-item active flex flex-col items-center gap-1 flex-1">
    <div class="bn-icon w-10 h-10 rounded-xl flex items-center justify-center transition">
      <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#9C8B7E" stroke-width="2"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
    </div>
    <span class="bn-label text-[10px] font-medium text-muted">Stok Produk</span>
  </button>
  <button class="bn-item flex flex-col items-center gap-1 flex-1">
    <div class="bn-icon w-10 h-10 rounded-xl flex items-center justify-center transition hover:bg-terra-xs">
      <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#9C8B7E" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
    </div>
    <span class="bn-label text-[10px] font-medium text-muted">Profil</span>
  </button>
</nav>

<script>
const PRODUCTS = [
  { id:1,  name:'Kaos Lengan Panjang',  sku:'SKU-001', cat:'Atasan',  stok:24, min:10, img:'https://images.unsplash.com/photo-1594938298603-c8148c4dae35?w=200&q=80' },
  { id:2,  name:'Celana Kulot',          sku:'SKU-002', cat:'Bawahan', stok:8,  min:10, img:'https://images.unsplash.com/photo-1509631179647-0177331693ae?w=200&q=80' },
  { id:3,  name:'Totebag Krem',          sku:'SKU-003', cat:'Aksesori',stok:3,  min:5,  img:'https://images.unsplash.com/photo-1544816155-12df9643f363?w=200&q=80' },
  { id:4,  name:'Kemeja Silk',           sku:'SKU-004', cat:'Atasan',  stok:0,  min:5,  img:'https://images.unsplash.com/photo-1602810318383-e386cc2a3ccf?w=200&q=80' },
  { id:5,  name:'Rok Midi Floral',       sku:'SKU-005', cat:'Bawahan', stok:15, min:8,  img:'https://images.unsplash.com/photo-1551163943-3f6a855d1153?w=200&q=80' },
  { id:6,  name:'Cardigan Rajut',        sku:'SKU-006', cat:'Atasan',  stok:2,  min:5,  img:'https://images.unsplash.com/photo-1620799140408-edc6dcb6d633?w=200&q=80' },
  { id:7,  name:'Celana Jeans Slim',     sku:'SKU-007', cat:'Bawahan', stok:20, min:8,  img:'https://images.unsplash.com/photo-1542272604-787c3835535d?w=200&q=80' },
  { id:8,  name:'Kemeja Flannel',        sku:'SKU-008', cat:'Atasan',  stok:0,  min:5,  img:'https://images.unsplash.com/photo-1589310243389-96a5483213a8?w=200&q=80' },
];

const ICONS = {
  Atasan:   `<path d="M20.38 3.46 16 2a4 4 0 0 1-8 0L3.62 3.46a2 2 0 0 0-1.34 2.23l.58 3.57a1 1 0 0 0 .99.84H6v10c0 1.1.9 2 2 2h8a2 2 0 0 0 2-2V10h2.15a1 1 0 0 0 .99-.84l.58-3.57a2 2 0 0 0-1.34-2.23z"/>`,
  Bawahan:  `<path d="M6 2h12v4l-3 16H9L6 6V2z"/><path d="M6 6h12M12 6v4"/>`,
  Aksesori: `<path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/>`,
};

let currentFilter = 'semua';
let currentSearch = '';

function getStatus(p) {
  if (p.stok === 0) return 'habis';
  if (p.stok < p.min) return 'menipis';
  return 'aman';
}

function filterProducts() {
  currentSearch = document.getElementById('searchInput').value.toLowerCase();
  render();
}

function setFilter(el) {
  currentFilter = el.dataset.filter;
  document.querySelectorAll('.filter-chip').forEach(c => {
    c.classList.remove('bg-gray-900', 'border-gray-900', 'text-white');
    c.classList.add('bg-white', 'border-border', 'text-muted');
  });
  el.classList.remove('bg-white', 'border-border', 'text-muted');
  el.classList.add('bg-gray-900', 'border-gray-900', 'text-white');
  render();
}

function render() {
  let filtered = PRODUCTS.filter(p => {
    const matchSearch =
      p.name.toLowerCase().includes(currentSearch) ||
      p.sku.toLowerCase().includes(currentSearch);

    const matchFilter =
      currentFilter === 'semua' || getStatus(p) === currentFilter;

    return matchSearch && matchFilter;
  });

  const list = document.getElementById('productList');
  const empty = document.getElementById('emptyState');

  if (!filtered.length) {
    list.innerHTML = '';
    empty.classList.remove('hidden');
    return;
  }

  empty.classList.add('hidden');

  list.innerHTML = `
    <div class="grid grid-cols-2 gap-3">
      ${filtered.map((p, i) => {
        const status = getStatus(p);
        const badgeClass =
          status === 'aman'
            ? 'badge-aman'
            : status === 'menipis'
            ? 'badge-menipis'
            : 'badge-habis';

        return `
          <div class="bg-white rounded-2xl border border-border shadow-sm overflow-hidden card-hover"
               style="animation:fadeUp 0.35s ease ${i * 0.05}s both">

            <div class="relative w-full overflow-hidden" style="aspect-ratio:3/3.5">
  <img src="${p.img}" alt="${p.name}"
       class="w-full h-full object-cover">
  <span class="absolute top-2 right-2 text-[10px] font-bold px-2 py-0.5 rounded-full ${badgeClass}">
    ${status === 'aman' ? 'Aman' : status === 'menipis' ? 'Menipis' : 'Habis'}
  </span>
</div>

            <div class="p-3">
              <p class="text-sm font-semibold text-gray-900 leading-tight line-clamp-2">
                ${p.name}
              </p>

              <p class="text-[11px] text-muted mt-1">
                ${p.sku}
              </p>

              <div class="flex items-center justify-between mt-2">
                <span class="text-xs font-semibold text-gray-900">
                  ${p.stok} pcs
                </span>

                <span class="text-[10px] px-2 py-1 rounded-full bg-terra-xs text-terra font-medium">
                  ${p.cat}
                </span>
              </div>

              <p class="text-xs text-muted mt-2">
                Rp.${p.stok > 0
                  ? (p.stok * 15000).toLocaleString('id-ID')
                  : '0'}
              </p>
            </div>
          </div>
        `;
      }).join('')}
    </div>
  `;
}

render();
window.scrollTo(0, 0);
</script>
</body>
</html>