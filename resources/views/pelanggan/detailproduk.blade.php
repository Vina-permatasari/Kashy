<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Detail Produk</title>
<script src="https://cdn.tailwindcss.com"></script>
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@600;700&family=DM+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<script>
  tailwind.config = {
    theme: {
      extend: {
        colors: {
          terra: '#C8966C', 'terra-l': '#E5B18A', 'terra-xs': '#FAF2EC',
          muted: '#9C8B7E', border: '#EAE0D6', bg: '#F5F0EB',
        },
        fontFamily: {
          display: ['Cormorant Garamond', 'serif'],
          body: ['DM Sans', 'sans-serif'],
        },
      }
    }
  }
</script>
<style>
  body { font-family: 'DM Sans', sans-serif; }
  .fade-up { animation: fadeUp 0.4s ease; }
  @keyframes fadeUp {
    from { opacity: 0; transform: translateY(12px); }
    to { opacity: 1; transform: translateY(0); }
  }
  .bn-item.active .bn-icon { background: #F0D7C7; }
  .bn-item.active .bn-icon svg { stroke: #C8966C; }
  .bn-item.active .bn-label { color: #C8966C; font-weight: 600; }
  .wish-btn.on { background: #C8966C !important; }
  .wish-btn.on svg path { stroke: white !important; fill: white !important; }
  .spec-list { list-style-type: none; padding-left: 0; }
  .spec-list li { margin-bottom: 0.5rem; display: flex; align-items: baseline; gap: 0.5rem; }
  .spec-label { font-weight: 600; min-width: 100px; color: #4b5563; }
</style>
</head>
<body class="bg-bg min-h-screen flex flex-col">

<!-- ════ TOPBAR ════ -->
<nav class="sticky top-0 z-50 bg-gray-900 px-5 py-3.5 flex items-center justify-center shadow-md">
  <a href="javascript:history.back()"  class="absolute left-5 flex items-center gap-1.5 text-xs text-gray-500 hover:text-white transition-colors no-underline">
    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M19 12H5m7-7-7 7 7 7"/></svg>
    Kembali
  </a>
  <span class="font-sans text-xl font-bold text-white tracking-normal">SND STORE</span>
</nav>

<!-- KONTEN UTAMA -->
<div class="flex-1 pb-24">
  <div class="max-w-7xl mx-auto px-4 md:px-8 py-5">
    <div id="detailContainer" class="flex flex-col lg:flex-row gap-8 items-start">
      <!-- akan diisi JavaScript -->
    </div>
  </div>
</div>

<script>
// ========== DATA PRODUK ==========
const BASE = [
  { name:'Kulot Modis',         cat:'celana',   price:'Rp 76.000',  old:'',           badge:'new',     bg:'linear-gradient(135deg,#e8ddd4,#d4c5b4)' },
  { name:'Kemeja Cokelat',      cat:'kemeja',   price:'Rp 52.000',  old:'',           badge:'',        bg:'linear-gradient(135deg,#d4c9bc,#c4b8a8)' },
  { name:'Rok Putih Layer',     cat:'rok',      price:'Rp 70.000',  old:'',           badge:'new',     bg:'linear-gradient(135deg,#ede0d4,#ddd0c4)' },
  { name:'Cardigan Rajut',      cat:'cardigan', price:'Rp 47.000',  old:'',           badge:'',        bg:'linear-gradient(135deg,#e0d4c9,#d0c4b9)' },
  { name:'Kemeja Flannel',      cat:'kemeja',   price:'Rp 85.000',  old:'',           badge:'branded', bg:'linear-gradient(135deg,#d9cfc4,#c9bfb4)' },
  { name:'Celana Cargo',        cat:'celana',   price:'Rp 120.000', old:'',           badge:'branded', bg:'linear-gradient(135deg,#cfc4b9,#bfb4a9)' },
  { name:'Jaket Denim',         cat:'jaket',    price:'Rp 150.000', old:'',           badge:'',        bg:'linear-gradient(135deg,#c9cfe0,#b9c2d4)' },
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
  { name:'Jaket Corduroy',      cat:'jaket',    price:'Rp 165.000', old:'',           badge:'',        bg:'linear-gradient(135deg,#c8b8a8,#b8a898)' },
  { name:'Rok Wrap',            cat:'rok',      price:'Rp 88.000',  old:'',           badge:'',        bg:'linear-gradient(135deg,#e0ccc0,#d0bcb0)' },
  { name:'Kemeja Linen',        cat:'kemeja',   price:'Rp 92.000',  old:'',           badge:'',        bg:'linear-gradient(135deg,#e8e0d0,#d8d0c0)' },
  { name:'Celana Palazzo',      cat:'celana',   price:'Rp 115.000', old:'',           badge:'new',     bg:'linear-gradient(135deg,#d0c8c0,#c0b8b0)' },
  { name:'Blouse Pita',         cat:'kemeja',   price:'Rp 58.000',  old:'',           badge:'',        bg:'linear-gradient(135deg,#eedde8,#decdd8)' },
  { name:'Rok Tutu Mini',       cat:'rok',      price:'Rp 72.000',  old:'Rp 90.000',  badge:'sale',    bg:'linear-gradient(135deg,#e8d8e8,#d8c8d8)' },
  { name:'Cardigan Oversize',   cat:'cardigan', price:'Rp 130.000', old:'',           badge:'branded', bg:'linear-gradient(135deg,#d8d0c8,#c8c0b8)' },
  { name:'Celana Chino',        cat:'celana',   price:'Rp 98.000',  old:'',           badge:'',        bg:'linear-gradient(135deg,#d4ccc0,#c4bcb0)' },
  { name:'Jaket Hoodie',        cat:'jaket',    price:'Rp 175.000', old:'',           badge:'new',     bg:'linear-gradient(135deg,#c8d0d8,#b8c0c8)' },
  { name:'Rok Floral',          cat:'rok',      price:'Rp 85.000',  old:'',           badge:'',        bg:'linear-gradient(135deg,#e8d0d0,#d8c0c0)' },
  { name:'Kemeja Motif',        cat:'kemeja',   price:'Rp 79.000',  old:'',           badge:'',        bg:'linear-gradient(135deg,#d8c8d0,#c8b8c0)' },
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
  { name:'Jaket Trucker',       cat:'jaket',    price:'Rp 160.000', old:'',           badge:'',        bg:'linear-gradient(135deg,#c8c0b8,#b8b0a8)' },
  { name:'Rok Ruffle',          cat:'rok',      price:'Rp 76.000',  old:'',           badge:'',        bg:'linear-gradient(135deg,#e4d8d0,#d4c8c0)' },
  { name:'Kemeja Batik Modern', cat:'kemeja',   price:'Rp 115.000', old:'',           badge:'',        bg:'linear-gradient(135deg,#d8c8b8,#c8b8a8)' },
  { name:'Celana Skirt',        cat:'celana',   price:'Rp 88.000',  old:'Rp 105.000', badge:'sale',    bg:'linear-gradient(135deg,#e0d0c8,#d0c0b8)' },
  { name:'Cardigan Stripes',    cat:'cardigan', price:'Rp 98.000',  old:'',           badge:'new',     bg:'linear-gradient(135deg,#d8d4cc,#c8c4bc)' },
  { name:'Jaket Varsity',       cat:'jaket',    price:'Rp 210.000', old:'',           badge:'branded', bg:'linear-gradient(135deg,#b8c4d0,#a8b4c0)' },
];

const PRODUCTS = BASE.map((p, i) => ({ id: i+1, ...p }));

// ========== TAMBAHKAN INFORMASI DETAIL PRODUK (UKURAN, BAHAN, WARNA, KONDISI, LINGKAR DADA, PANJANG) ==========
// Data tambahan untuk setiap produk (default berdasarkan kategori, bisa di-override per id)
const productExtra = {
  // default untuk semua produk
  default: {
    ukuran: 'All Size',
    bahan: 'Katun premium',
    warna: 'Netral',
    kondisi: 'Like New',
    lingkar_dada: '-',
    panjang_baju: '-'
  },
  // override berdasarkan id jika diperlukan
  1: { ukuran: 'M, L, XL', bahan: 'Linen', warna: 'Cokelat Tua', kondisi: 'Baru', lingkar_dada: '96 cm', panjang_baju: '98 cm' },
  2: { ukuran: 'S, M', bahan: 'Katun', warna: 'Cokelat Susu', kondisi: 'Like New', lingkar_dada: '88 cm', panjang_baju: '70 cm' },
  3: { ukuran: 'All Size', bahan: 'Polyester', warna: 'Putih', kondisi: 'Baru', lingkar_dada: '-', panjang_baju: '85 cm' },
  4: { ukuran: 'Free Size', bahan: 'Rajut', warna: 'Krem', kondisi: 'Like New', lingkar_dada: '100 cm', panjang_baju: '60 cm' },
  5: { ukuran: 'M, L', bahan: 'Flanel', warna: 'Merah Kotak', kondisi: 'Branded', lingkar_dada: '104 cm', panjang_baju: '72 cm' },
  8: { ukuran: 'S, M, L', bahan: 'Katun', warna: 'Plaid', kondisi: 'Like New', lingkar_dada: '90 cm', panjang_baju: '55 cm' },
  // tambahkan lainnya sesuai kebutuhan, untuk sisanya pakai default
};

PRODUCTS.forEach(p => {
  const extra = productExtra[p.id] || productExtra.default;
  p.ukuran = extra.ukuran;
  p.bahan = extra.bahan;
  p.warna = extra.warna;
  p.kondisi = extra.kondisi;
  p.lingkar_dada = extra.lingkar_dada;
  p.panjang_baju = extra.panjang_baju;
});

// Ikon kategori
const ICONS = {
  kemeja:   `<path d="M20.38 3.46 16 2a4 4 0 0 1-8 0L3.62 3.46a2 2 0 0 0-1.34 2.23l.58 3.57a1 1 0 0 0 .99.84H6v10c0 1.1.9 2 2 2h8a2 2 0 0 0 2-2V10h2.15a1 1 0 0 0 .99-.84l.58-3.57a2 2 0 0 0-1.34-2.23z"/>`,
  celana:   `<path d="M6 2h12v4l-3 16H9L6 6V2z"/><path d="M6 6h12M12 6v4"/>`,
  rok:      `<rect x="7" y="2" width="10" height="4" rx="1"/><path d="M7 6 4 20h16L17 6"/>`,
  cardigan: `<path d="M3 6.5 7.5 3h3L12 5l1.5-2h3L21 6.5l-3 2.5v11a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V9L3 6.5z"/><path d="M12 5v15"/>`,
  jaket:    `<path d="M3 7 7 3h2.5L12 6l2.5-3H17l4 4-2.5 2L17 7v13a1 1 0 0 1-1 1H8a1 1 0 0 1-1-1V7L4.5 9 3 7z"/><path d="M12 6v14"/>`,
  default:  `<rect x="3" y="3" width="7" height="7" rx="1.5"/><rect x="14" y="3" width="7" height="7" rx="1.5"/><rect x="3" y="14" width="7" height="7" rx="1.5"/><rect x="14" y="14" width="7" height="7" rx="1.5"/>`,
};

const BADGE_LABELS  = { new:'New', branded:'Branded', sale:'Sale' };
const BADGE_CLASSES = { new:'bg-gray-900 text-white', branded:'bg-terra text-white', sale:'bg-red-500 text-white' };

// Deskripsi singkat umum (akan ditambahkan dengan spesifikasi)
const DESCRIPTIONS = {
  kemeja:   'Kemeja premium dengan bahan adem dan nyaman dipakai seharian. Cocok untuk gaya kasual maupun semi-formal.',
  celana:   'Celana berkualitas tinggi dengan potongan modern. Memberikan kenyamanan maksimal dan tampilan stylish.',
  rok:      'Rok elegan dengan desain feminin yang jatuh sempurna. Bahan berkualitas untuk tampilan anggun setiap saat.',
  cardigan: 'Cardigan rajut lembut yang memberi kehangatan tanpa mengorbankan gaya. Material premium tahan lama.',
  jaket:    'Jaket trendy yang menjadi statement piece outfit kamu. Bahan kuat dengan jahitan rapi.',
  default:  'Produk fashion pilihan dengan kualitas terbaik. Desain mengikuti tren terkini.'
};

// STATUS STOK
const OUT_OF_STOCK_IDS = new Set([2, , 11, 14, 17, 19, 23, 29, 31, 37, 41, 43]); // ID 0 dihapus
function isInStock(productId) {
  return !OUT_OF_STOCK_IDS.has(productId);
}

// AMBIL ID DARI URL
function getProductId() {
  const path = window.location.pathname;
  const match = path.match(/\/detail-produk\/(\d+)/);
  if (match) return parseInt(match[1]);
  const params = new URLSearchParams(window.location.search);
  if (params.has('id')) return parseInt(params.get('id'));
  return null;
}

const productId = getProductId();
let product = null;
if (productId) product = PRODUCTS.find(p => p.id === productId);
const container = document.getElementById('detailContainer');

if (!product) {
  container.innerHTML = `<div class="w-full text-center py-20 text-muted">
    <svg class="w-16 h-16 mx-auto mb-4 stroke-border" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
    <p class="text-lg">Produk tidak ditemukan</p>
    <a href="/daftar-produk" class="inline-block mt-4 bg-terra text-white px-4 py-2 rounded-full text-sm">Lihat produk lain</a>
  </div>`;
} else {
  const inStock = isInStock(product.id);
  const icon = ICONS[product.cat] || ICONS.default;
  
  // Badge di gambar
  let badgeHtml = '';
  if (product.badge) {
    const badgeClass = BADGE_CLASSES[product.badge] || 'bg-gray-500 text-white';
    const badgeLabel = BADGE_LABELS[product.badge] || product.badge;
    badgeHtml = `<span class="absolute top-4 right-4 z-10 text-xs font-bold px-2.5 py-1 rounded-full ${badgeClass}">${badgeLabel}</span>`;
  }
  
  // Harga lama
  const oldPriceHtml = product.old ? `<span class="text-base text-muted line-through">${product.old}</span>` : '';
  
  // Deskripsi umum
  const descGeneral = DESCRIPTIONS[product.cat] || DESCRIPTIONS.default;
  
  // Spesifikasi detail dalam bentuk list (bahan, warna, kondisi, lingkar dada, panjang baju)
  const specItems = [
    { label: 'Bahan', value: product.bahan },
    { label: 'Warna', value: product.warna },
    { label: 'Kondisi', value: product.kondisi },
    { label: 'Lingkar Dada', value: product.lingkar_dada },
    { label: 'Panjang Baju', value: product.panjang_baju }
  ];
  const specListHtml = specItems.filter(item => item.value && item.value !== '-').map(item => `
    <li class="flex items-baseline gap-2 text-sm">
      <span class="font-semibold text-gray-700 min-w-[100px]">${item.label}:</span>
      <span class="text-gray-600">${item.value}</span>
    </li>
  `).join('');
  
  // Indikator stok
  const stockIndicator = inStock
    ? `<div class="flex items-center gap-2 mb-4">
         <div class="w-5 h-5 rounded-full bg-green-100 flex items-center justify-center">
           <svg class="w-3.5 h-3.5 text-green-600" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path d="M20 6L9 17l-5-5"/></svg>
         </div>
         <span class="text-sm font-medium text-green-700">Stok Tersedia</span>
       </div>`
    : `<div class="flex items-center gap-2 mb-4">
         <div class="w-5 h-5 rounded-full bg-red-100 flex items-center justify-center">
           <svg class="w-3.5 h-3.5 text-red-600" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path d="M18 6L6 18M6 6l12 12"/></svg>
         </div>
         <span class="text-sm font-medium text-red-700">Stok Habis</span>
       </div>`;
    
  container.innerHTML = `
<!-- GAMBAR PRODUK -->
  <div class="w-full lg:w-[45%] flex justify-center fade-up">
  <div class="relative w-full max-w-[380px] mx-auto lg:max-w-none lg:mx-0 rounded-3xl overflow-hidden shadow-md" style="aspect-ratio:4/4; background:${product.bg}">
        <div class="w-full h-full flex items-center justify-center">
          <svg width="140" height="140" viewBox="0 0 24 24" fill="rgba(255,255,255,0.12)" stroke="rgba(255,255,255,0.7)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">${icon}</svg>
        </div>
        ${badgeHtml}
      </div>
    </div>

    <!-- INFORMASI PRODUK -->
    <div class="w-full lg:w-1/2 fade-up">
      <!-- Baris kategori + stok -->
      <div class="flex items-center justify-between mb-4">
        <div class="flex items-center gap-2">
          <span class="text-xs text-muted">Kategori:</span>
          <span class="text-sm font-medium text-gray-800 capitalize">${product.cat}</span>
        </div>
        ${stockIndicator}
      </div>
      
      <!-- Nama produk -->
      <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-3">${product.name}</h1>
      
      <!-- Harga -->
      <div class="flex items-baseline gap-3 mb-4">
        <span class="text-2xl md:text-3xl font-bold text-terra">${product.price}</span>
        ${oldPriceHtml}
      </div>
      
      <!-- UKURAN (prioritas) ditampilkan menonjol -->
      <div class="mb-5 p-3 bg-white rounded-xl border border-border shadow-sm">
        <div class="flex items-center gap-2">
          <svg class="w-5 h-5 text-terra" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 6h16M4 12h16M4 18h16"/></svg>
          <span class="font-semibold text-gray-800">Ukuran:</span>
          <span class="text-gray-900 font-medium">${product.ukuran}</span>
        </div>
      </div>
      
      <!-- Deskripsi umum -->
      <p class="text-sm md:text-base leading-relaxed text-gray-600 mb-4">${descGeneral}</p>
      
      <!-- Detail spesifikasi (bahan, warna, kondisi, lingkar dada, panjang baju) -->
      <!-- Detail Produk dalam bentuk tabel -->
${specListHtml ? `
<div class="mb-6">
  <h3 class="text-base font-semibold text-gray-800 mb-3">
    Detail Produk
  </h3>
  <div class="overflow-hidden rounded-2xl border border-border bg-white shadow-sm">
    <table class="w-full text-sm">
      <tbody>
        <tr class="border-b border-border">
          <td class="bg-terra-xs px-4 py-3 font-semibold text-gray-700 w-[40%]">
            Bahan
          </td>
          <td class="px-4 py-3 text-gray-600">
            ${product.bahan}
          </td>
        </tr>
        <tr class="border-b border-border">
          <td class="bg-terra-xs px-4 py-3 font-semibold text-gray-700">
            Warna
          </td>
          <td class="px-4 py-3 text-gray-600">
            ${product.warna}
          </td>
        </tr>
        <tr class="border-b border-border">
          <td class="bg-terra-xs px-4 py-3 font-semibold text-gray-700">
            Kondisi
          </td>
          <td class="px-4 py-3 text-gray-600">
            ${product.kondisi}
          </td>
        </tr>
        <tr class="border-b border-border">
          <td class="bg-terra-xs px-4 py-3 font-semibold text-gray-700">
            Lingkar Dada
          </td>
          <td class="px-4 py-3 text-gray-600">
            ${product.lingkar_dada}
          </td>
        </tr>
        <tr class="border-b border-border">
          <td class="bg-terra-xs px-4 py-3 font-semibold text-gray-700">
            Panjang Baju
          </td>
          <td class="px-4 py-3 text-gray-600">
            ${product.panjang_baju}
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</div>
` : ''}
      
    </div>
  `;
}
</script>
</body>
</html>