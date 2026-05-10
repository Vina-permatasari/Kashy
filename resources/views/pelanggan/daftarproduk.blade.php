<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Daftar Produk</title>
<script src="https://cdn.tailwindcss.com"></script>
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,600;0,700;1,400&family=DM+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
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
          display: ['Cormorant Garamond', 'serif'],
          body:    ['DM Sans', 'sans-serif'],
        },
      }
    }
  }
</script>
<style>
  * { box-sizing: border-box; margin: 0; padding: 0; }
  body { font-family: 'DM Sans', sans-serif; }
  .hide-scroll::-webkit-scrollbar { display: none; }
  .hide-scroll { scrollbar-width: none; -webkit-overflow-scrolling: touch; }
  @keyframes fadeUp {
    from { opacity: 0; transform: translateY(12px); }
    to   { opacity: 1; transform: translateY(0); }
  }
  .card.selected { border-color: #C8966C !important; box-shadow: 0 0 0 4px rgba(200,150,108,.18), 0 12px 40px rgba(28,28,28,.18) !important; transform: translateY(-4px) !important; }
  .card.selected::after { content:''; position:absolute; inset:0; background:linear-gradient(180deg,rgba(200,150,108,.06) 0%,transparent 50%); pointer-events:none; }
  .bn-item.active .bn-icon { background: #F0D7C7; }
  .bn-item.active .bn-icon svg { stroke: #C8966C; }
  .bn-item.active .bn-label { color: #C8966C; font-weight: 600; }
  .filter-chip.active { background: #1C1C1C; border-color: #1C1C1C; color: white; }
  .pg-btn.active { background: #1C1C1C; border-color: #1C1C1C; color: white; font-weight: 600; }
</style>
</head>
<body class="bg-bg min-h-screen flex flex-col">

<!-- TOPBAR -->
<nav class="sticky top-0 z-50 bg-gray-900 px-5 py-3.5 flex items-center justify-center shadow-md">
  <a href="javascript:history.back()" class="absolute left-5 flex items-center gap-1.5 text-xs text-gray-400 hover:text-white transition">
    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M19 12H5m7-7-7 7 7 7"/></svg>
    Kembali
  </a>
  <span class="font-display text-xl font-bold text-white tracking-widest italic">SND STORE</span>
</nav>

<!-- SEARCH -->
<div class="w-full px-4 pt-4 pb-2.5">
  <div class="flex items-center gap-2.5 bg-white border-2 border-border rounded-full px-4 py-2.5 transition-all duration-200 focus-within:border-terra focus-within:shadow-[0_0_0_3px_rgba(200,150,108,0.12)]">
    <svg width="16" height="16" fill="none" stroke="#b0a090" stroke-width="2" viewBox="0 0 24 24" class="flex-shrink-0">
      <circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/>
    </svg>
    <input type="text" placeholder="Cari produk..." id="searchInput" oninput="onSearch()"
           class="border-0 outline-none bg-transparent font-body text-sm text-gray-900 w-full placeholder-stone-300">
  </div>
</div>

<!-- PAGE HEADER -->
<div class="px-4 pb-4 pt-1">
  <div class="text-xl font-bold text-gray-900 mb-1" id="pageTitle">Semua Produk</div>
  <div class="text-xs text-muted" id="pageSub">Menampilkan semua produk yang kami punya</div>
</div>

<!-- FILTER CHIPS -->
<div class="overflow-x-auto hide-scroll px-4 pb-4">
  <div class="inline-flex gap-2 min-w-full">
    <button class="filter-chip flex-shrink-0 px-3.5 py-1.5 rounded-full text-xs font-medium border-2 border-border bg-white text-muted cursor-pointer transition-all duration-200 hover:border-terra-l hover:text-terra hover:bg-terra-xs active font-body" data-cat="semua" onclick="setFilter(this)">Semua</button>
    <button class="filter-chip flex-shrink-0 px-3.5 py-1.5 rounded-full text-xs font-medium border-2 border-border bg-white text-muted cursor-pointer transition-all duration-200 hover:border-terra-l hover:text-terra hover:bg-terra-xs font-body" data-cat="kemeja" onclick="window.location.href='{{ route('daftar-produk') }}?cat=kemeja'">Kemeja</button>
    <button class="filter-chip flex-shrink-0 px-3.5 py-1.5 rounded-full text-xs font-medium border-2 border-border bg-white text-muted cursor-pointer transition-all duration-200 hover:border-terra-l hover:text-terra hover:bg-terra-xs font-body" data-cat="rok" onclick="window.location.href='{{ route('daftar-produk') }}?cat=rok'">Rok</button>
    <button class="filter-chip flex-shrink-0 px-3.5 py-1.5 rounded-full text-xs font-medium border-2 border-border bg-white text-muted cursor-pointer transition-all duration-200 hover:border-terra-l hover:text-terra hover:bg-terra-xs font-body" data-cat="cardigan" onclick="window.location.href='{{ route('daftar-produk') }}?cat=cardigan'">Cardigan</button>
    <button class="filter-chip flex-shrink-0 px-3.5 py-1.5 rounded-full text-xs font-medium border-2 border-border bg-white text-muted cursor-pointer transition-all duration-200 hover:border-terra-l hover:text-terra hover:bg-terra-xs font-body" data-cat="celana" onclick="window.location.href='{{ route('daftar-produk') }}?cat=celana'">Celana</button>
    <button class="filter-chip flex-shrink-0 px-3.5 py-1.5 rounded-full text-xs font-medium border-2 border-border bg-white text-muted cursor-pointer transition-all duration-200 hover:border-terra-l hover:text-terra hover:bg-terra-xs font-body" data-cat="jaket" onclick="window.location.href='{{ route('daftar-produk') }}?cat=jaket'">Jaket</button>
  </div>
</div>

<!-- PRODUCT GRID -->
<div class="grid grid-cols-2 gap-2 px-2 pb-4 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-5 2xl:grid-cols-5 md:gap-3 lg:gap-4 md:px-5 lg:px-7 flex-1" id="productGrid"></div>

<!-- PAGINATION -->
<div class="flex flex-col items-center gap-2.5 px-4 py-4 pb-5">
  <div class="flex items-center justify-center gap-2 text-xs text-muted">
    <div class="text-xs text-muted text-center" id="resultCount"></div>
    <span>Produk Per halaman:</span>
    <div class="relative">
      <select id="perPageSelect" onchange="onPerPageChange()"
              class="border-2 border-border rounded-lg px-2.5 py-1.5 pr-7 text-xs font-body text-gray-900 bg-white cursor-pointer outline-none appearance-none focus:border-terra transition-colors">
        <option value="8">8</option>
        <option value="12">12</option>
        <option value="24" selected>24</option>
        <option value="48">48</option>
      </select>
      <svg class="absolute right-2 top-1/2 -translate-y-1/2 pointer-events-none" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#9C8B7E" stroke-width="2.5"><path d="m6 9 6 6 6-6"/></svg>
    </div>
  </div>
  <div class="text-xs text-muted text-center" id="pageInfo"></div>
  <div class="flex items-center gap-1 flex-wrap justify-center" id="pagination"></div>
</div>

<div class="h-1.5 bg-bg"></div>

<!-- BOTTOM NAV -->
<nav class="sticky bottom-0 z-50 bg-white border-t border-border flex justify-around py-2.5 pb-4 shadow-[0_-2px_12px_rgba(28,28,28,0.06)]">
  <button class="bn-item flex flex-col items-center gap-1 flex-1 border-0 bg-transparent cursor-pointer font-body p-0"
          onclick="window.location.href='{{ route('katalog') }}'">
    <div class="bn-icon w-10 h-10 rounded-xl flex items-center justify-center transition-all duration-200 hover:bg-terra-xs hover:-translate-y-0.5">
      <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#9C8B7E" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
        <polyline points="9 22 9 12 15 12 15 22"/>
      </svg>
    </div>
    <span class="bn-label text-xs font-medium text-muted transition-colors">Beranda</span>
  </button>
  <button class="bn-item active flex flex-col items-center gap-1 flex-1 border-0 bg-transparent cursor-pointer font-body p-0">
    <div class="bn-icon w-10 h-10 rounded-xl flex items-center justify-center transition-all duration-200 hover:bg-terra-xs hover:-translate-y-0.5">
      <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#9C8B7E" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <path d="M4 6h16M4 12h16M4 18h16"/>
      </svg>
    </div>
    <span class="bn-label text-xs font-medium text-muted transition-colors">Daftar Produk</span>
  </button>
</nav>

<script>
const BASE = [
  { name:'Kulot Modis',         cat:'celana',   price:'Rp 76.000',  old:'',           badge:'new',     bg:'linear-gradient(135deg,#e8ddd4,#d4c5b4)' },
  { name:'Kemeja Cokelat',      cat:'kemeja',   price:'Rp 52.000',  old:'',           badge:'',        bg:'linear-gradient(135deg,#d4c9bc,#c4b8a8)' },
  { name:'Rok Putih Layer',     cat:'rok',      price:'Rp 70.000',  old:'',           badge:'new',     bg:'linear-gradient(135deg,#ede0d4,#ddd0c4)' },
  { name:'Cardigan Rajut',      cat:'cardigan', price:'Rp 47.000',  old:'',           badge:'',        bg:'linear-gradient(135deg,#e0d4c9,#d0c4b9)' },
  { name:'Kemeja Flannel',      cat:'kemeja',   price:'Rp 85.000',  old:'',           badge:'branded', bg:'linear-gradient(135deg,#d9cfc4,#c9bfb4)' },
  { name:'Celana Cargo',        cat:'celana',   price:'Rp 120.000', old:'',           badge:'branded', bg:'linear-gradient(135deg,#cfc4b9,#bfb4a9)' },
  { name:'Jaket Denim',         cat:'jaket',    price:'Rp 150.000', old:'',           badge:'',  bg:'linear-gradient(135deg,#c9cfe0,#b9c2d4)' },
  { name:'Rok Mini Plaid',      cat:'rok',      price:'Rp 95.000',  old:'Rp 120.000', badge:'sale',    bg:'linear-gradient(135deg,#e0c9c9,#d0b9b9)' },
  { name:'Kemeja Putih',        cat:'kemeja',   price:'Rp 65.000',  old:'',           badge:'new',     bg:'linear-gradient(135deg,#eee8e0,#ddd8d0)' },
  { name:'Celana Jeans Slim',   cat:'celana',   price:'Rp 135.000', old:'Rp 160.000', badge:'sale',    bg:'linear-gradient(135deg,#c5cdd8,#b5bdc8)' },
  { name:'Jaket Bomber',        cat:'jaket',    price:'Rp 185.000', old:'',           badge:'branded', bg:'linear-gradient(135deg,#c8c8c8,#b8b8b8)' },
  { name:'Rok Lipit Krem',      cat:'rok',      price:'Rp 78.000',  old:'',           badge:'',        bg:'linear-gradient(135deg,#ede5d8,#ddd5c8)' },
  { name:'Cardigan Krem',       cat:'cardigan', price:'Rp 95.000',  old:'Rp 120.000', badge:'sale',    bg:'linear-gradient(135deg,#e5ddd0,#d5cdc0)' },
  { name:'Kemeja Stripe',       cat:'kemeja',   price:'Rp 75.000',  old:'',           badge:'',        bg:'linear-gradient(135deg,#d8e0e8,#c8d0d8)' },
  { name:'Celana Kulot',        cat:'celana',   price:'Rp 90.000',  old:'',           badge:'new',     bg:'linear-gradient(135deg,#e0d8d0,#d0c8c0)' },
  { name:'Jaket Kulit Sintetis',cat:'jaket',    price:'Rp 220.000', old:'',           badge:'branded', bg:'linear-gradient(135deg,#c0c0c0,#b0b0b0)' },
  { name:'Rok A-Line',          cat:'rok',      price:'Rp 82.000',  old:'',           badge:'',        bg:'linear-gradient(135deg,#e8d8d0,#d8c8c0)' },
  { name:'Blouse Renda',        cat:'kemeja',   price:'Rp 68.000',  old:'',           badge:'new',     bg:'linear-gradient(135deg,#f0e8e0,#e0d8d0)' },
  { name:'Cardigan Knit',       cat:'cardigan', price:'Rp 110.000', old:'',           badge:'',        bg:'linear-gradient(135deg,#d8d0c8,#c8c0b8)' },
  { name:'Celana Pipa',         cat:'celana',   price:'Rp 105.000', old:'Rp 130.000', badge:'sale',    bg:'linear-gradient(135deg,#d8c8b8,#c8b8a8)' },
  { name:'Jaket Corduroy',      cat:'jaket',    price:'Rp 165.000', old:'',           badge:'',  bg:'linear-gradient(135deg,#c8b8a8,#b8a898)' },
  { name:'Rok Wrap',            cat:'rok',      price:'Rp 88.000',  old:'',           badge:'',        bg:'linear-gradient(135deg,#e0ccc0,#d0bcb0)' },
  { name:'Kemeja Linen',        cat:'kemeja',   price:'Rp 92.000',  old:'',           badge:'',        bg:'linear-gradient(135deg,#e8e0d0,#d8d0c0)' },
  { name:'Celana Palazzo',      cat:'celana',   price:'Rp 115.000', old:'',           badge:'new',     bg:'linear-gradient(135deg,#d0c8c0,#c0b8b0)' },
  { name:'Blouse Pita',         cat:'kemeja',   price:'Rp 58.000',  old:'',           badge:'',        bg:'linear-gradient(135deg,#eedde8,#decdd8)' },
  { name:'Rok Tutu Mini',       cat:'rok',      price:'Rp 72.000',  old:'Rp 90.000',  badge:'sale',    bg:'linear-gradient(135deg,#e8d8e8,#d8c8d8)' },
  { name:'Cardigan Oversize',   cat:'cardigan', price:'Rp 130.000', old:'',           badge:'branded', bg:'linear-gradient(135deg,#d8d0c8,#c8c0b8)' },
  { name:'Celana Chino',        cat:'celana',   price:'Rp 98.000',  old:'',           badge:'',        bg:'linear-gradient(135deg,#d4ccc0,#c4bcb0)' },
  { name:'Jaket Hoodie',        cat:'jaket',    price:'Rp 175.000', old:'',           badge:'new',     bg:'linear-gradient(135deg,#c8d0d8,#b8c0c8)' },
  { name:'Rok Floral',          cat:'rok',      price:'Rp 85.000',  old:'',           badge:'',        bg:'linear-gradient(135deg,#e8d0d0,#d8c0c0)' },
  { name:'Kemeja Motif',        cat:'kemeja',   price:'Rp 79.000',  old:'',           badge:'',  bg:'linear-gradient(135deg,#d8c8d0,#c8b8c0)' },
  { name:'Celana Linen',        cat:'celana',   price:'Rp 108.000', old:'',           badge:'',        bg:'linear-gradient(135deg,#dcd4c8,#ccc4b8)' },
  { name:'Cardigan V-Neck',     cat:'cardigan', price:'Rp 88.000',  old:'Rp 110.000', badge:'sale',    bg:'linear-gradient(135deg,#e4dcd0,#d4ccc0)' },
  { name:'Jaket Fleece',        cat:'jaket',    price:'Rp 140.000', old:'',           badge:'',        bg:'linear-gradient(135deg,#c8d4dc,#b8c4cc)' },
  { name:'Rok Midi',            cat:'rok',      price:'Rp 92.000',  old:'',           badge:'new',     bg:'linear-gradient(135deg,#e4d4cc,#d4c4bc)' },
  { name:'Kemeja Oversized',    cat:'kemeja',   price:'Rp 88.000',  old:'',           badge:'',        bg:'linear-gradient(135deg,#dcd8d0,#ccc8c0)' },
  { name:'Celana Rok Slit',     cat:'celana',   price:'Rp 125.000', old:'',           badge:'branded', bg:'linear-gradient(135deg,#c8c4bc,#b8b4ac)' },
  { name:'Jaket Rain Coat',     cat:'jaket',    price:'Rp 195.000', old:'Rp 240.000', badge:'sale',    bg:'linear-gradient(135deg,#c0c8d0,#b0b8c0)' },
  { name:'Blouse Puff Sleeve',  cat:'kemeja',   price:'Rp 72.000',  old:'',           badge:'new',     bg:'linear-gradient(135deg,#eae0d8,#dad0c8)' },
  { name:'Rok Asimetris',       cat:'rok',      price:'Rp 98.000',  old:'',           badge:'',        bg:'linear-gradient(135deg,#e0d4cc,#d0c4bc)' },
  { name:'Cardigan Panjang',    cat:'cardigan', price:'Rp 145.000', old:'',           badge:'branded', bg:'linear-gradient(135deg,#dcd0c4,#ccc0b4)' },
  { name:'Celana Mom Jeans',    cat:'celana',   price:'Rp 130.000', old:'',           badge:'',        bg:'linear-gradient(135deg,#c4ccd8,#b4bcc8)' },
  { name:'Jaket Trucker',       cat:'jaket',    price:'Rp 160.000', old:'',           badge:'',  bg:'linear-gradient(135deg,#c8c0b8,#b8b0a8)' },
  { name:'Rok Ruffle',          cat:'rok',      price:'Rp 76.000',  old:'',           badge:'',        bg:'linear-gradient(135deg,#e4d8d0,#d4c8c0)' },
  { name:'Kemeja Batik Modern', cat:'kemeja',   price:'Rp 115.000', old:'',           badge:'',        bg:'linear-gradient(135deg,#d8c8b8,#c8b8a8)' },
  { name:'Celana Skirt',        cat:'celana',   price:'Rp 88.000',  old:'Rp 105.000', badge:'sale',    bg:'linear-gradient(135deg,#e0d0c8,#d0c0b8)' },
  { name:'Cardigan Stripes',    cat:'cardigan', price:'Rp 98.000',  old:'',           badge:'new',     bg:'linear-gradient(135deg,#d8d4cc,#c8c4bc)' },
  { name:'Jaket Varsity',       cat:'jaket',    price:'Rp 210.000', old:'',           badge:'branded', bg:'linear-gradient(135deg,#b8c4d0,#a8b4c0)' },
];

const PRODUCTS = BASE.map((p, i) => ({ id: i+1, ...p }));

const ICONS = {
  kemeja:   `<path d="M20.38 3.46 16 2a4 4 0 0 1-8 0L3.62 3.46a2 2 0 0 0-1.34 2.23l.58 3.57a1 1 0 0 0 .99.84H6v10c0 1.1.9 2 2 2h8a2 2 0 0 0 2-2V10h2.15a1 1 0 0 0 .99-.84l.58-3.57a2 2 0 0 0-1.34-2.23z"/>`,
  celana:   `<path d="M6 2h12v4l-3 16H9L6 6V2z"/><path d="M6 6h12M12 6v4"/>`,
  rok:      `<rect x="7" y="2" width="10" height="4" rx="1"/><path d="M7 6 4 20h16L17 6"/>`,
  cardigan: `<path d="M3 6.5 7.5 3h3L12 5l1.5-2h3L21 6.5l-3 2.5v11a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V9L3 6.5z"/><path d="M12 5v15"/>`,
  jaket:    `<path d="M3 7 7 3h2.5L12 6l2.5-3H17l4 4-2.5 2L17 7v13a1 1 0 0 1-1 1H8a1 1 0 0 1-1-1V7L4.5 9 3 7z"/><path d="M12 6v14"/>`,
  default:  `<rect x="3" y="3" width="7" height="7" rx="1.5"/><rect x="14" y="3" width="7" height="7" rx="1.5"/><rect x="3" y="14" width="7" height="7" rx="1.5"/><rect x="14" y="14" width="7" height="7" rx="1.5"/>`,
};
const BADGE_LABELS  = { new:'New', branded:'Branded', sale:'Sale'};
const BADGE_CLASSES = { new:'bg-gray-900 text-white', branded:'bg-terra text-white', sale:'bg-red-500 text-white' };
const CAT_LABELS    = { semua:'Semua Produk', kemeja:'Kemeja', rok:'Rok', cardigan:'Cardigan', celana:'Celana', jaket:'Jaket' };

let currentCat    = 'semua';
let currentSearch = '';
let currentPage   = 1;
let perPage       = 24;
let selected      = null;

function getFiltered() {
  return PRODUCTS.filter(p => {
    const mc = currentCat === 'semua' || p.cat === currentCat;
    const ms = p.name.toLowerCase().includes(currentSearch.toLowerCase());
    return mc && ms;
  });
}

function render() {
  const filtered   = getFiltered();
  const total      = filtered.length;
  const totalPages = Math.max(1, Math.ceil(total / perPage));
  if (currentPage > totalPages) currentPage = totalPages;
  const start  = (currentPage - 1) * perPage;
  const paged  = filtered.slice(start, start + perPage);

  document.getElementById('pageTitle').textContent = CAT_LABELS[currentCat] || 'Semua Produk';
  document.getElementById('pageSub').textContent = `Menampilkan ${total} produk${currentSearch ? ` untuk "${currentSearch}"` : ''}`;
  document.getElementById('resultCount').textContent = total ? `${start+1}–${Math.min(start+perPage,total)} dari ${total} produk` : '';

  const grid = document.getElementById('productGrid');
  if (!paged.length) {
    grid.innerHTML = `<div class="col-span-full text-center py-14 text-muted">
      <svg class="w-12 h-12 mx-auto mb-3 stroke-stone-300" viewBox="0 0 24 24" fill="none" stroke-width="1.5"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
      <p class="text-sm">Produk tidak ditemukan</p>
    </div>`;
    renderPagination(total, totalPages);
    return;
  }

  grid.innerHTML = paged.map((p, i) => {
    const icon = ICONS[p.cat] || ICONS.default;
    const badgeHtml = p.badge
      ? `<span class="absolute top-2 right-2 z-20 text-[10px] font-bold px-2 py-0.5 rounded-full ${BADGE_CLASSES[p.badge]||'bg-gray-500 text-white'}">${BADGE_LABELS[p.badge]}</span>`
      : '';
    const isS = selected === p.id;

    return `
    <div class="card relative bg-white rounded-2xl overflow-hidden shadow-sm cursor-pointer border-2 transition-all duration-200 hover:-translate-y-1 hover:shadow-md hover:border-terra-l ${isS?'selected':'border-transparent'}" style="animation:fadeUp .3s ease ${i*.04}s both" onclick="window.location.href='/detail-produk/${p.id}'">
      ${badgeHtml}
      <div class="relative w-full overflow-hidden" style="aspect-ratio:3/3">
        <div class="absolute inset-0" style="background:${p.bg}"></div>
        <div class="relative z-10 w-full h-full flex items-center justify-center">
          <svg class="transition-transform duration-300 hover:scale-110" style="width:48%;height:48%" viewBox="0 0 24 24" fill="rgba(255,255,255,0.15)" stroke="rgba(255,255,255,0.6)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">${icon}</svg>
        </div>
      </div>
      <div class="p-2.5 pb-3">
        <div class="text-xs font-semibold text-gray-900 mb-1 leading-tight line-clamp-2">${p.name}</div>
        <div class="flex items-baseline gap-1.5 flex-wrap">
          <span class="text-sm font-bold text-gray-900">${p.price}</span>
          ${p.old ? `<span class="text-xs text-muted line-through">${p.old}</span>` : ''}
        </div>
      </div>
    </div>`;
  }).join('');

  renderPagination(total, totalPages);
}

function renderPagination(total, totalPages) {
  document.getElementById('pageInfo').textContent = total ? `Halaman ${currentPage} dari ${totalPages}` : '';
  const pg = document.getElementById('pagination');
  if (totalPages <= 1) { pg.innerHTML = ''; return; }

  const pages = buildPageList(currentPage, totalPages);
  let html = '';

  html += `<button onclick="goPage(${currentPage-1})" ${currentPage===1?'disabled':''} class="w-9 h-9 rounded-xl border-2 border-stone-200 bg-white text-muted flex items-center justify-center cursor-pointer transition-all duration-200 hover:border-terra-l hover:text-terra hover:bg-terra-xs disabled:opacity-30 disabled:cursor-not-allowed font-body">
    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="m15 18-6-6 6-6"/></svg>
  </button>`;

  pages.forEach(p => {
    if (p === '…') {
      html += `<span class="w-9 h-9 flex items-center justify-center text-sm text-muted">…</span>`;
    } else {
      html += `<button onclick="goPage(${p})" class="pg-btn w-9 h-9 rounded-xl border-2 border-stone-200 bg-white text-muted text-sm font-medium flex items-center justify-center cursor-pointer transition-all duration-200 hover:border-terra-l hover:text-terra hover:bg-terra-xs font-body ${p===currentPage?'active':''}">${p}</button>`;
    }
  });

  html += `<button onclick="goPage(${currentPage+1})" ${currentPage===totalPages?'disabled':''} class="w-9 h-9 rounded-xl border-2 border-stone-200 bg-white text-muted flex items-center justify-center cursor-pointer transition-all duration-200 hover:border-terra-l hover:text-terra hover:bg-terra-xs disabled:opacity-30 disabled:cursor-not-allowed font-body">
    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="m9 18 6-6-6-6"/></svg>
  </button>`;

  pg.innerHTML = html;
}

function buildPageList(cur, total) {
  if (total <= 7) return Array.from({length:total}, (_,i) => i+1);
  const pages = [1];
  if (cur - 1 > 2) pages.push('…');
  for (let i = Math.max(2, cur-1); i <= Math.min(total-1, cur+1); i++) pages.push(i);
  if (cur + 1 < total - 1) pages.push('…');
  pages.push(total);
  return pages;
}

function goPage(p) {
  const total = getFiltered().length;
  const totalPages = Math.max(1, Math.ceil(total / perPage));
  if (p < 1 || p > totalPages) return;
  currentPage = p;
  selected = null;
  render();
  document.getElementById('productGrid').scrollIntoView({ behavior:'smooth', block:'start' });
}
function selectCard(id) { selected = selected === id ? null : id; render(); }
function setFilter(el) {
  currentCat = el.dataset.cat;
  currentPage = 1;
  selected = null;
  document.querySelectorAll('.filter-chip').forEach(c => c.classList.remove('active'));
  el.classList.add('active');
  render();
}
function onSearch() { currentSearch = document.getElementById('searchInput').value; currentPage = 1; selected = null; render(); }
function onPerPageChange() { perPage = parseInt(document.getElementById('perPageSelect').value); currentPage = 1; selected = null; render(); }
function setNav(el) { document.querySelectorAll('.bn-item').forEach(b => b.classList.remove('active')); el.classList.add('active'); }

// AMBIL PARAMETER CATEGORY DARI URL
const params = new URLSearchParams(window.location.search);
const kategoriURL = params.get('cat');

if (kategoriURL) {
  currentCat = kategoriURL;
  document.querySelectorAll('.filter-chip').forEach(btn => {
    btn.classList.remove('active');
    if (btn.dataset.cat === kategoriURL) {
      btn.classList.add('active');
    }
  });
}

render();
</script>
</body>
</html>