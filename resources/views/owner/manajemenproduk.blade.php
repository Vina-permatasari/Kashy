<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover"/>
  <title>Kashy – Manajemen Produk & Stok</title>
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
            card:    '0 2px 12px 0 rgba(60,40,10,.08)',
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

    /* Sidebar */
    #sidebar {
      position:fixed; top:0; left:0; height:100vh; width:280px;
      background:#fff; box-shadow:2px 0 24px rgba(60,40,10,.12);
      z-index:60; transition:transform .3s cubic-bezier(0.2,0.9,0.4,1.1);
      display:flex; flex-direction:column; overflow-y:auto;
      transform:translateX(-100%);
    }
    #sidebar.sidebar-open { transform:translateX(0); }
    #overlay {
      display:none; position:fixed; inset:0; background:rgba(0,0,0,.45);
      z-index:55; backdrop-filter:blur(3px);
    }
    #overlay.show { display:block; }

    @keyframes fadeUp {
      from { opacity:0; transform:translateY(18px); }
      to   { opacity:1; transform:translateY(0); }
    }
    .fade-up { animation:fadeUp .4s ease both; }
    .d1 { animation-delay:.05s; } .d2 { animation-delay:.10s; }
    .d3 { animation-delay:.15s; } .d4 { animation-delay:.20s; }
    .d5 { animation-delay:.25s; }

    .nav-item {
      display:flex; align-items:center; gap:12px; padding:11px 18px;
      border-radius:12px; cursor:pointer; transition:all .15s;
      font-size:14px; font-weight:500; color:#1a1a1a;
      text-decoration:none; width:100%;
    }
    .nav-item:hover { background:#F5F0EB; }
    .nav-item.active { background:#F7EFE5; color:#7B4F2E; font-weight:600; }
    .nav-item.active svg { stroke:#7B4F2E; }

    .tab-btn {
      padding:10px 4px; font-size:13px; font-weight:600; color:#8A7968;
      border-bottom:2px solid transparent; cursor:pointer;
      transition:all .2s; background:none;
    }
    .tab-btn.active { color:#1a1a1a; border-bottom-color:#C49A6C; }

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
      padding-right:36px;
    }
    .form-label {
      font-size:11px; font-weight:700; color:#8A7968;
      text-transform:uppercase; letter-spacing:.07em; margin-bottom:6px;
      display:block;
    }
    .required-star { color: #ef4444; margin-left: 2px; }

    .product-grid {
      display: grid;
      grid-template-columns: repeat(2, minmax(0, 1fr));
      gap: 1rem;
    }
    .prod-img-wrap {
      width:100%; height:160px; border-radius:12px; overflow:hidden;
      position:relative; margin-bottom:8px;
    }
    .prod-img-wrap img { width:100%; height:100%; object-fit:cover; }
    .chip {
      display:inline-flex; align-items:center; gap:3px;
      padding:3px 8px; border-radius:8px;
      font-size:10px; font-weight:600;
      background:#F5F0EB; color:#8A7968; border:1px solid #E0D8CE;
    }
    .chip-remove {
      background:none; border:none; cursor:pointer;
      color:#8A7968; font-size:12px; line-height:1;
      padding:0;
    }
    .line-clamp-1 { display: -webkit-box; -webkit-line-clamp: 1; -webkit-box-orient: vertical; overflow: hidden; }
    .line-clamp-2 { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }

    .badge-produk {
      position: absolute; top: 8px; right: 8px;
      padding: 2px 8px; border-radius: 20px;
      font-size: 9px; font-weight: bold;
      background: #1a1a1a; color: white;
    }
    .badge-sale { background: #ef4444; }
    .badge-new { background: #3a9e6f; }
    .badge-branded { background: #c49a6c; }

    .img-dropzone {
      width:100%; border:2px dashed #E0D8CE; border-radius:14px;
      padding:28px 20px; text-align:center; cursor:pointer;
      transition:border-color .2s, background .2s; background:#FAF6F2;
      position:relative; overflow:hidden;
    }
    .img-dropzone:hover { border-color:#C49A6C; background:#FDF9F5; }
    .img-dropzone.has-image { border-color:#C49A6C; padding:0; height:180px; }
    .img-dropzone.has-image img {
      width:100%; height:100%; object-fit:cover; border-radius:12px; display:block;
    }
    .img-dropzone.has-image .dropzone-overlay {
      position:absolute; inset:0; background:rgba(0,0,0,.35);
      display:flex; align-items:center; justify-content:center;
      border-radius:12px; opacity:0; transition:opacity .2s;
    }
    .img-dropzone.has-image:hover .dropzone-overlay { opacity:1; }

    #toast {
      position: fixed; bottom: 2rem; left: 50%;
      transform: translateX(-50%) translateY(12px);
      background: #1c1c1c; color: white; font-size: 0.875rem; font-weight: 500;
      padding: 0.75rem 1.25rem; border-radius: 9999px;
      display: flex; align-items: center; gap: 0.5rem;
      z-index: 9999; opacity: 0;
      transition: opacity 0.25s ease, transform 0.3s cubic-bezier(0.34,1.56,0.64,1);
      pointer-events: none;
    }
    #toast.show { opacity: 1; transform: translateX(-50%) translateY(0); }

    .modal-confirm {
      position: fixed; top: 0; left: 0; width: 100%; height: 100%;
      background: rgba(0,0,0,0.5); backdrop-filter: blur(4px); z-index: 10000;
      display: flex; align-items: center; justify-content: center;
      visibility: hidden; opacity: 0; transition: visibility 0.2s, opacity 0.2s;
    }
    .modal-confirm.show { visibility: visible; opacity: 1; }
    .modal-confirm .modal-card {
      background: white; max-width: 380px; width: 90%; border-radius: 28px;
      padding: 24px; text-align: center; transform: scale(0.95);
      transition: transform 0.2s;
    }
    .modal-confirm.show .modal-card { transform: scale(1); }
    .modal-icon { background: #FEF2F2; width: 64px; height: 64px; border-radius: 60px;
      display: flex; align-items: center; justify-content: center; margin: 0 auto 16px; }
    .modal-icon svg { width: 32px; height: 32px; stroke: #D94F4F; stroke-width: 1.8; }
    .modal-title { font-size: 20px; font-weight: 800; color: #1a1a1a; margin-bottom: 12px; }
    .modal-message { font-size: 14px; color: #6B5E52; margin-bottom: 24px; line-height: 1.5; }
    .modal-buttons { display: flex; gap: 12px; }
    .modal-btn { flex: 1; padding: 12px; border-radius: 40px; font-weight: 700; font-size: 14px;
      cursor: pointer; transition: all 0.2s; border: none; }
    .modal-btn-cancel { background: #F5F0EB; color: #1a1a1a; }
    .modal-btn-confirm { background: #D94F4F; color: white; box-shadow: 0 4px 10px rgba(58,158,111,0.3); }
    .modal-btn-confirm:hover { background: #FEF2F2; transform: scale(0.97); }
    .modal-btn-cancel:hover { background: #EDE5DB; transform: scale(0.97); }

    .pg-btn {
      width: 36px; height: 36px; border-radius: 12px;
      border: 1.5px solid #E0D8CE; background: white;
      color: #8A7968; font-size: 13px; font-weight: 500;
      display: inline-flex; align-items: center; justify-content: center;
      cursor: pointer; transition: all 0.2s;
    }
    .pg-btn:hover { border-color: #C49A6C; color: #C49A6C; background: #FDF9F5; }
    .pg-btn.active { background: #1a1a1a; border-color: #1a1a1a; color: white; font-weight: 600; }
    .pg-btn:disabled { opacity: 0.4; cursor: not-allowed; }
    /* Hilangkan panah bawaan select */
    .no-arrow-select {
      appearance: none;
      background-image: none;
    }
  </style>
</head>
@include('owner.components.sidebar')
<body>

<main id="main" class="min-h-screen bg-kashy-cream transition-all duration-300">
  @include('owner.components.topbar')

  <div class="px-4 md:px-6 py-5 max-w-2xl mx-auto">

    <div class="fade-up d1 mb-4">
      <h1 class="text-2xl md:text-3xl font-extrabold text-kashy-dark">Manajemen Produk & Stok</h1>
      <p class="text-xs text-kashy-muted mt-1">Kelola dan pantau inventaris produk Anda.</p>
    </div>

    <div class="fade-up d2 mb-4">
      <button onclick="openProductModal()" class="w-full flex items-center justify-center gap-2 py-3 rounded-xl font-bold text-sm tracking-widest text-white uppercase transition-all duration-200 hover:opacity-90 active:scale-[.98]" style="background:#C49A6C; box-shadow:0 4px 14px 0 rgba(196,154,108,.35);">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
        Tambah Produk
      </button>
    </div>

    <div class="fade-up d2 flex gap-4 border-b border-kashy-border mb-4 overflow-x-auto whitespace-nowrap pb-0">
      <button class="tab-btn active" onclick="filterTab('semua', this)">Semua <span id="countSemua">(0)</span></button>
      <button class="tab-btn" onclick="filterTab('Dress', this)">Dress</button>
      <button class="tab-btn" onclick="filterTab('Cardigan', this)">Cardigan</button>
      <button class="tab-btn" onclick="filterTab('Kemeja', this)">Kemeja</button>
      <button class="tab-btn" onclick="filterTab('Celana', this)">Celana</button>
      <button class="tab-btn" onclick="filterTab('Aksesoris', this)">Aksesoris</button>
    </div>

    <div class="fade-up d2 mb-4">
      <div class="relative">
        <span class="absolute left-3 top-1/2 -translate-y-1/2 pointer-events-none">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#8A7968" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
        </span>
        <input type="text" id="searchProduct" class="form-input py-2.5 text-sm" style="padding-left:36px;" placeholder="Cari nama produk atau SKU..."/>
      </div>
    </div>
    
    <div class="fade-up d2 mb-4" id="categoryStatsContainer">
      <p class="text-[10px] font-bold tracking-widest text-kashy-muted uppercase mb-2">Ringkasan Stok</p>
      <div id="categoryStatsGrid" class="grid grid-cols-1 gap-2"></div>
    </div>

    <div id="productContainer" class="product-grid"></div>

    <!-- Pagination -->
    <div class="fade-up d5 mt-6 mb-4">
      <div class="flex flex-col items-center gap-3">
        <div class="flex items-center justify-center gap-2 text-xs text-kashy-muted">
          <span>Produk Per halaman:</span>
          <div class="relative">
            <select id="perPageSelect" class="border border-kashy-border rounded-lg px-2 py-1.5 pr-7 text-xs bg-white cursor-pointer focus:border-kashy-brown transition-colors no-arrow-select">
              <option value="6">6</option>
              <option value="12" selected>12</option>
              <option value="24">24</option>
              <option value="48">48</option>
            </select>
            <svg class="absolute right-2 top-1/2 -translate-y-1/2 pointer-events-none" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#8A7968" stroke-width="2.5"><path d="m6 9 6 6 6-6"/></svg>
          </div>
        </div>
        <div class="text-xs text-kashy-muted text-center" id="pageInfo"></div>
        <div class="flex items-center gap-1 flex-wrap justify-center" id="pagination"></div>
      </div>
    </div>

  </div>
</main>

<!-- MODAL TAMBAH/EDIT PRODUK -->
<div id="productModal" class="hidden fixed inset-0 z-[999] bg-black/40 backdrop-blur-sm flex items-center justify-center p-4">
  <div class="bg-white rounded-3xl w-full max-w-2xl max-h-[90vh] overflow-y-auto p-5 relative animate-fadeIn">
    <h2 id="modalTitle" class="text-xl font-bold text-kashy-dark mb-4">Tambah Produk</h2>
    <input type="hidden" id="editId" value="">

    <div class="mb-4">
      <label class="form-label">Foto Produk <span class="normal-case font-normal">(opsional)</span></label>
      <div class="img-dropzone" id="imgDropzone" onclick="document.getElementById('prodImage').click()">
        <input type="file" id="prodImage" accept="image/*" class="hidden" onchange="previewImage(this)"/>
        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#C49A6C" stroke-width="1.6" class="mx-auto mb-2">
          <rect x="3" y="3" width="18" height="18" rx="2"/>
          <circle cx="8.5" cy="8.5" r="1.5"/>
          <polyline points="21 15 16 10 5 21"/>
        </svg>
        <p class="text-sm font-semibold text-kashy-muted">Pilih atau seret gambar</p>
        <p class="text-xs text-kashy-muted mt-1">JPG, PNG — maks 5MB</p>
      </div>
    </div>

    <div class="mb-3">
      <label class="form-label">Nama Produk <span class="required-star">*</span></label>
      <input type="text" id="prodName" class="form-input py-2.5" placeholder="Nama produk..."/>
    </div>
    <div class="grid grid-cols-2 gap-3 mb-3">
      <div>
        <label class="form-label">Kategori <span class="required-star">*</span></label>
        <select id="prodCategory" class="form-input form-select py-2.5">
          <option>Dress</option><option>Cardigan</option><option>Kemeja</option><option>Celana</option><option>Aksesoris</option>
        </select>
      </div>
      <div><label class="form-label">Badge</label>
        <select id="prodBadge" class="form-input form-select py-2.5">
          <option value="">Tanpa Badge</option>
          <option value="new">New</option><option value="sale">Sale</option><option value="branded">Branded</option>
        </select>
      </div>
    </div>

    <div class="grid grid-cols-2 gap-3 mb-3">
      <div><label class="form-label">Harga (Rp) <span class="required-star">*</span></label><input type="text" id="prodPrice" class="form-input py-2.5" placeholder="0" oninput="formatRupiah(this)"/></div>
      <div><label class="form-label">Harga Coret</label><input type="text" id="prodOldPrice" class="form-input py-2.5" placeholder="Contoh: 120000" oninput="formatRupiah(this)"/></div>
    </div>

    <div class="grid grid-cols-2 gap-3 mb-3">
      <div><label class="form-label">Bahan</label><input type="text" id="prodBahan" class="form-input py-2.5" placeholder="Katun Premium"/></div>
      <div><label class="form-label">Warna</label><input type="text" id="prodWarna" class="form-input py-2.5" placeholder="Cream"/></div>
    </div>

    <div class="grid grid-cols-3 gap-2 mb-3">
      <div><label class="form-label">Kondisi</label><select id="prodKondisi" class="form-input form-select py-2.5"><option value="">Pilih</option><option>Baru</option><option>Like New</option><option>Second</option></select></div>
      <div><label class="form-label">Lingkar Dada</label><input type="text" id="prodLingkarDada" class="form-input py-2.5" placeholder="96 cm"/></div>
      <div><label class="form-label">Panjang Baju</label><input type="text" id="prodPanjangBaju" class="form-input py-2.5" placeholder="72 cm"/></div>
    </div>

    <div class="grid grid-cols-2 gap-3 mb-3">
      <div><label class="form-label">Stok</label><input type="number" id="prodStock" class="form-input py-2.5" placeholder="0"/></div>
      <div><label class="form-label">Ukuran (varian)</label>
        <div class="flex flex-wrap gap-1.5 mb-2" id="variantContainer">
          <span class="chip">S<button class="chip-remove" onclick="this.closest('.chip').remove()">×</button></span>
          <span class="chip">M<button class="chip-remove" onclick="this.closest('.chip').remove()">×</button></span>
        </div>
        <input type="text" id="variantInput" class="form-input py-2.5 text-sm" placeholder="Tambah ukuran lalu Enter" onkeydown="addVariant(event)"/>
      </div>
    </div>

    <div class="mb-3">
      <label class="form-label">Deskripsi</label>
      <textarea id="prodDesc" rows="2" class="form-input resize-none" placeholder="Deskripsi produk..."></textarea>
    </div>

    <div class="flex flex-col gap-2">
      <button id="saveProductBtn" class="w-full py-3 rounded-xl font-bold text-white text-sm tracking-wide transition-all duration-200 hover:opacity-90 active:scale-[.98]" style="background:#C49A6C; box-shadow:0 4px 14px rgba(196,154,108,.35);">Simpan Produk</button>
      <button onclick="closeProductModal()" class="w-full py-3 rounded-xl font-bold text-kashy-dark text-sm tracking-wide border-2 border-kashy-border transition-all duration-200 hover:bg-kashy-cream active:scale-[.98] bg-white">Batal</button>
    </div>
  </div>
</div>

<!-- MODAL KONFIRMASI HAPUS -->
<div id="confirmDeleteModal" class="modal-confirm">
  <div class="modal-card">
    <div class="modal-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6"/><line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/><path d="M9 6V4a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2v2"/></svg></div>
    <div class="modal-title">Konfirmasi Hapus</div>
    <div class="modal-message" id="confirmDeleteMessage">Apakah Anda yakin ingin menghapus produk ini?</div>
    <div class="modal-buttons">
      <button id="deleteCancelBtn" class="modal-btn modal-btn-cancel">Batal</button>
      <button id="deleteConfirmBtn" class="modal-btn modal-btn-confirm">Ya, Hapus</button>
    </div>
  </div>
</div>

<div id="toast"><span id="toastMsg"></span></div>

<script>
  // Sidebar
  const sidebar = document.getElementById('sidebar');
  const overlay = document.getElementById('overlay');
  const menuBtn = document.getElementById('global-menu-toggle');
  function openSidebar()  { sidebar.classList.add('sidebar-open'); overlay.classList.add('show'); document.body.style.overflow='hidden'; }
  function closeSidebar() { sidebar.classList.remove('sidebar-open'); overlay.classList.remove('show'); document.body.style.overflow=''; }
  if (menuBtn) menuBtn.addEventListener('click', e => { e.stopPropagation(); openSidebar(); });
  if (overlay) overlay.addEventListener('click', closeSidebar);
  document.addEventListener('keydown', e => { if (e.key==='Escape') closeSidebar(); });

  let products = [
    { id:1, name:"Artisan Linen Midi Dress", sku:"EG-001", category:"Dress", price:"1450000", oldPrice:"", badge:"", bahan:"Linen", warna:"Cream", kondisi:"Baru", lingkar_dada:"96 cm", panjang_baju:"110 cm", stock:142, desc:"Linen premium modern.", variants:["S","M","L"], img:"https://images.unsplash.com/photo-1572804013309-59a88b7e92f1?w=400&q=80" },
    { id:2, name:"Uniqlo Cardigan Pink", sku:"EG-002", category:"Cardigan", price:"890000", oldPrice:"", badge:"", bahan:"Rajut", warna:"Pink", kondisi:"Like New", lingkar_dada:"100 cm", panjang_baju:"60 cm", stock:22, desc:"Cardigan rajut pink.", variants:["M","L"], img:"https://images.unsplash.com/photo-1576566588028-4147f3842f27?w=400&q=80" },
    { id:3, name:"Organic Cotton Oxford", sku:"EG-003", category:"Kemeja", price:"780000", oldPrice:"", badge:"new", bahan:"Katun Organik", warna:"Putih", kondisi:"Baru", lingkar_dada:"104 cm", panjang_baju:"72 cm", stock:0, desc:"Kemeja katun organik.", variants:["S","M","L"], img:"https://images.unsplash.com/photo-1596755094514-f87e34085b2c?w=400&q=80" },
    { id:4, name:"Celana Palazzo Linen", sku:"EG-004", category:"Celana", price:"550000", oldPrice:"", badge:"", bahan:"Linen", warna:"Beige", kondisi:"Baru", lingkar_dada:"-", panjang_baju:"-", stock:15, desc:"Celana palazzo nyaman.", variants:["S","M","L","XL"], img:"https://images.unsplash.com/photo-1591195853828-11db59a44f6b?w=400&q=80" }
  ];

  let currentFilter = "semua";
  let searchKeyword = "";
  let currentPage = 1;
  let perPage = 12;

  function getFiltered() {
    let f = [...products];
    if (currentFilter !== "semua") f = f.filter(p => p.category === currentFilter);
    if (searchKeyword.trim()) {
      const kw = searchKeyword.toLowerCase();
      f = f.filter(p => p.name.toLowerCase().includes(kw) || (p.sku && p.sku.toLowerCase().includes(kw)));
    }
    return f;
  }

  function updateCounters() { document.getElementById("countSemua").innerHTML = `(${products.length})`; }

  function renderCategoryStats() {
    const filtered = getFiltered();
    const habis = filtered.filter(p => p.stock === 0).length;
    const menipis = filtered.filter(p => p.stock > 0 && p.stock <= 5).length;
    document.getElementById('categoryStatsGrid').innerHTML = `
      <div class="bg-white rounded-xl p-1 shadow-card border border-kashy-border">
        <div class="grid grid-cols-2 gap-2">
          <div class="rounded-lg bg-red-50 border border-red-200 p-1.5 text-center">
            <p class="text-[9px] text-red-500 font-semibold">Stok Habis</p>
            <p class="text-base font-extrabold text-red-600">${habis}</p>
          </div>
          <div class="rounded-lg bg-orange-50 border border-orange-200 p-1.5 text-center">
            <p class="text-[9px] text-orange-500 font-semibold">Stok Menipis</p>
            <p class="text-base font-extrabold text-orange-600">${menipis}</p>
          </div>
        </div>
      </div>
    `;
  }

  function renderPagination(total) {
    const totalPages = Math.max(1, Math.ceil(total / perPage));
    if (currentPage > totalPages) currentPage = totalPages;
    document.getElementById('pageInfo').innerHTML = total ? `Halaman ${currentPage} dari ${totalPages}` : '';
    const pgDiv = document.getElementById('pagination');
    if (totalPages <= 1) { pgDiv.innerHTML = ''; return; }
    let pages = [];
    if (totalPages <= 7) for (let i=1; i<=totalPages; i++) pages.push(i);
    else {
      pages.push(1);
      if (currentPage-1 > 2) pages.push('…');
      for (let i=Math.max(2, currentPage-1); i<=Math.min(totalPages-1, currentPage+1); i++) pages.push(i);
      if (currentPage+1 < totalPages-1) pages.push('…');
      pages.push(totalPages);
    }
    let html = `<button class="pg-btn" onclick="goPage(${currentPage-1})" ${currentPage===1 ? 'disabled' : ''}>‹</button>`;
    pages.forEach(p => {
      if (p === '…') html += `<span class="w-9 h-9 flex items-center justify-center text-sm text-muted">…</span>`;
      else html += `<button class="pg-btn ${p===currentPage ? 'active' : ''}" onclick="goPage(${p})">${p}</button>`;
    });
    html += `<button class="pg-btn" onclick="goPage(${currentPage+1})" ${currentPage===totalPages ? 'disabled' : ''}>›</button>`;
    pgDiv.innerHTML = html;
  }

  function goPage(page) {
    const total = getFiltered().length;
    const totalPages = Math.max(1, Math.ceil(total / perPage));
    if (page < 1 || page > totalPages) return;
    currentPage = page;
    renderProducts();
  }

  function changePerPage() {
    perPage = parseInt(document.getElementById('perPageSelect').value);
    currentPage = 1;
    renderProducts();
  }

  function renderProducts() {
    let filtered = getFiltered();
    const total = filtered.length;
    const totalPages = Math.max(1, Math.ceil(total / perPage));
    if (currentPage > totalPages) currentPage = totalPages;
    const start = (currentPage-1)*perPage;
    const paged = filtered.slice(start, start+perPage);
    const container = document.getElementById('productContainer');
    if (paged.length === 0) {
      container.innerHTML = `<div class="col-span-2 bg-white rounded-2xl p-6 text-center shadow-card"><p class="text-kashy-muted text-sm">Tidak ada produk ditemukan.</p></div>`;
    } else {
      container.innerHTML = paged.map(p => {
        const priceFormatted = `Rp ${parseInt(p.price).toLocaleString('id-ID')}`;
        const oldPriceHtml = p.oldPrice ? `<span class="text-[9px] text-kashy-muted line-through">Rp ${parseInt(p.oldPrice).toLocaleString('id-ID')}</span>` : '';
        let badgeHtml = '';
        if (p.badge === 'sale') badgeHtml = `<span class="badge-produk badge-sale">SALE</span>`;
        else if (p.badge === 'new') badgeHtml = `<span class="badge-produk badge-new">NEW</span>`;
        else if (p.badge === 'branded') badgeHtml = `<span class="badge-produk badge-branded">BRANDED</span>`;
        return `
          <div class="bg-white rounded-xl p-2 shadow-card fade-up">
            <div class="prod-img-wrap relative">
              <img src="${p.img}" loading="lazy">
              ${badgeHtml}
            </div>
            <p class="text-[9px] font-semibold text-kashy-muted uppercase mb-0.5">${p.category}</p>
            <h3 class="text-xs font-bold text-kashy-dark line-clamp-1 mb-0.5">${p.name}</h3>
            <div class="flex items-center gap-1 flex-wrap mb-1">
              <p class="text-sm font-extrabold text-kashy-brown">${priceFormatted}</p>
              ${oldPriceHtml}
            </div>
            <p class="text-[9px] text-kashy-muted line-clamp-2 mb-1.5">${p.desc}</p>
            <div class="flex items-center justify-between mb-1">
              <div>
                <p class="text-[9px] text-kashy-muted">Stok: ${p.stock}</p>
                ${p.stock === 0 ? `<p class="text-[8px] font-bold text-red-600 mt-0.5">⚠ Habis</p>` : (p.stock <=5 ? `<p class="text-[8px] font-bold text-orange-500 mt-0.5">⚠ Menipis</p>` : '')}
              </div>
              <div class="flex flex-wrap gap-1">${p.variants.map(v => `<span class="chip text-[9px] py-0 px-1.5">${v}</span>`).join('')}</div>
            </div>
            <div class="flex items-center gap-2 pt-2 border-t border-kashy-border">
              <button class="flex items-center gap-1 text-[9px] font-semibold text-kashy-muted hover:text-kashy-dark" onclick="editProduct(${p.id})">Edit</button>
              <button class="flex items-center gap-1 text-[9px] font-semibold text-red-600 hover:text-red-700" onclick="deleteProduct(${p.id})">Hapus</button>
            </div>
          </div>
        `;
      }).join('');
    }
    updateCounters();
    renderCategoryStats();
    renderPagination(total);
  }

  function filterTab(tab, btn) {
    currentFilter = tab;
    currentPage = 1;
    document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    renderProducts();
  }

  document.getElementById('searchProduct').addEventListener('input', e => { searchKeyword = e.target.value; currentPage = 1; renderProducts(); });
  document.getElementById('perPageSelect').addEventListener('change', changePerPage);

  function showToast(msg, success=true) {
    const toast = document.getElementById('toast');
    document.getElementById('toastMsg').innerText = msg;
    toast.style.background = success ? '#1c1c1c' : '#ef4444';
    toast.classList.add('show');
    clearTimeout(toast._t);
    toast._t = setTimeout(() => toast.classList.remove('show'), 2600);
  }

  function formatRupiah(input) {
    let val = input.value.replace(/[^0-9]/g, '');
    if (val === '') { input.value = ''; return; }
    input.value = new Intl.NumberFormat('id-ID').format(parseInt(val));
  }
  function parseRupiahToNumber(str) { return parseInt(str.replace(/[^0-9]/g, '')) || 0; }

  function addVariant(e) {
    if (e.key !== 'Enter') return;
    const val = e.target.value.trim();
    if (!val) return;
    const chip = document.createElement('span');
    chip.className = 'chip';
    chip.innerHTML = `${val}<button class="chip-remove" onclick="this.closest('.chip').remove()">×</button>`;
    document.getElementById('variantContainer').appendChild(chip);
    e.target.value = '';
  }
  function getVariants() { return Array.from(document.querySelectorAll('#variantContainer .chip')).map(ch => ch.innerText.replace('×','').trim()); }

  function previewImage(input) {
    if (!input.files[0]) return;
    const reader = new FileReader();
    reader.onload = e => {
      const dz = document.getElementById('imgDropzone');
      dz.innerHTML = `<img src="${e.target.result}" alt="preview"/><div class="dropzone-overlay"><span class="text-white text-xs font-semibold bg-black/50 px-3 py-1.5 rounded-lg">Ganti Gambar</span></div><input type="file" id="prodImage" accept="image/*" class="hidden" onchange="previewImage(this)"/>`;
      dz.classList.add('has-image');
      dz.onclick = () => document.getElementById('prodImage').click();
    };
    reader.readAsDataURL(input.files[0]);
  }
  function setPreviewFromUrl(url) {
    const dz = document.getElementById('imgDropzone');
    dz.innerHTML = `<img src="${url}" alt="preview"/><div class="dropzone-overlay"><span class="text-white text-xs font-semibold bg-black/50 px-3 py-1.5 rounded-lg">Ganti Gambar</span></div><input type="file" id="prodImage" accept="image/*" class="hidden" onchange="previewImage(this)"/>`;
    dz.classList.add('has-image');
    dz.onclick = () => document.getElementById('prodImage').click();
  }
  function resetDropzone() {
    const dz = document.getElementById('imgDropzone');
    dz.classList.remove('has-image');
    dz.innerHTML = `<input type="file" id="prodImage" accept="image/*" class="hidden" onchange="previewImage(this)"/><svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#C49A6C" stroke-width="1.6" class="mx-auto mb-2"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg><p class="text-sm font-semibold text-kashy-muted">Pilih atau seret gambar</p><p class="text-xs text-kashy-muted mt-1">JPG, PNG — maks 5MB</p>`;
    dz.onclick = () => document.getElementById('prodImage').click();
  }

  function openProductModal(id = null) {
    const modal = document.getElementById('productModal');
    modal.classList.remove('hidden');
    document.body.style.overflow = 'hidden';
    if (id) {
      const p = products.find(x => x.id === id);
      if (p) {
        document.getElementById('modalTitle').innerText = 'Edit Produk';
        document.getElementById('editId').value = p.id;
        document.getElementById('prodName').value = p.name;
        document.getElementById('prodCategory').value = p.category;
        document.getElementById('prodPrice').value = parseInt(p.price).toLocaleString('id-ID');
        document.getElementById('prodOldPrice').value = p.oldPrice ? parseInt(p.oldPrice).toLocaleString('id-ID') : '';
        document.getElementById('prodBadge').value = p.badge || '';
        document.getElementById('prodBahan').value = p.bahan || '';
        document.getElementById('prodWarna').value = p.warna || '';
        document.getElementById('prodKondisi').value = p.kondisi || '';
        document.getElementById('prodLingkarDada').value = p.lingkar_dada || '';
        document.getElementById('prodPanjangBaju').value = p.panjang_baju || '';
        document.getElementById('prodStock').value = p.stock;
        document.getElementById('prodDesc').value = p.desc;
        const vc = document.getElementById('variantContainer');
        vc.innerHTML = '';
        p.variants.forEach(v => {
          const chip = document.createElement('span');
          chip.className = 'chip';
          chip.innerHTML = `${v}<button class="chip-remove" onclick="this.closest('.chip').remove()">×</button>`;
          vc.appendChild(chip);
        });
        if (p.img) setPreviewFromUrl(p.img);
        else resetDropzone();
      }
    } else {
      document.getElementById('modalTitle').innerText = 'Tambah Produk';
      document.getElementById('editId').value = '';
      document.getElementById('prodName').value = '';
      document.getElementById('prodCategory').value = 'Dress';
      document.getElementById('prodPrice').value = '';
      document.getElementById('prodOldPrice').value = '';
      document.getElementById('prodBadge').value = '';
      document.getElementById('prodBahan').value = '';
      document.getElementById('prodWarna').value = '';
      document.getElementById('prodKondisi').value = '';
      document.getElementById('prodLingkarDada').value = '';
      document.getElementById('prodPanjangBaju').value = '';
      document.getElementById('prodStock').value = '';
      document.getElementById('prodDesc').value = '';
      document.getElementById('variantContainer').innerHTML = `<span class="chip">S<button class="chip-remove" onclick="this.closest('.chip').remove()">×</button></span><span class="chip">M<button class="chip-remove" onclick="this.closest('.chip').remove()">×</button></span>`;
      resetDropzone();
    }
  }
  function closeProductModal() {
    document.getElementById('productModal').classList.add('hidden');
    document.body.style.overflow = '';
  }

  document.getElementById('saveProductBtn').addEventListener('click', () => {
    const name = document.getElementById('prodName').value.trim();
    const category = document.getElementById('prodCategory').value;
    const priceRaw = document.getElementById('prodPrice').value;
    if (!name) { showToast('Nama produk wajib diisi', false); return; }
    if (!category) { showToast('Kategori wajib dipilih', false); return; }
    if (!priceRaw || parseRupiahToNumber(priceRaw) === 0) { showToast('Harga produk wajib diisi', false); return; }

    let image = '';
    const fileInput = document.getElementById('prodImage');
    const editId = document.getElementById('editId').value;
    if (fileInput.files && fileInput.files[0]) image = URL.createObjectURL(fileInput.files[0]);
    else if (editId) { const existing = products.find(p => p.id == editId); if (existing && existing.img) image = existing.img; }
    else image = 'https://images.unsplash.com/photo-1594938298603-c8148c4b4057?w=400&q=80';

    const newProduct = {
      name, category, price: parseRupiahToNumber(priceRaw).toString(),
      oldPrice: parseRupiahToNumber(document.getElementById('prodOldPrice').value) ? parseRupiahToNumber(document.getElementById('prodOldPrice').value).toString() : '',
      badge: document.getElementById('prodBadge').value,
      bahan: document.getElementById('prodBahan').value,
      warna: document.getElementById('prodWarna').value,
      kondisi: document.getElementById('prodKondisi').value,
      lingkar_dada: document.getElementById('prodLingkarDada').value,
      panjang_baju: document.getElementById('prodPanjangBaju').value,
      stock: parseInt(document.getElementById('prodStock').value) || 0,
      desc: document.getElementById('prodDesc').value || 'Deskripsi produk',
      variants: getVariants(),
      img: image,
      sku: editId ? (products.find(p => p.id == editId)?.sku || 'SKU-'+Date.now()) : 'SKU-'+Date.now()
    };
    if (editId) {
      const index = products.findIndex(p => p.id == editId);
      if (index !== -1) { newProduct.id = parseInt(editId); products[index] = newProduct; showToast(`Produk "${name}" berhasil diperbarui.`, true); }
    } else {
      newProduct.id = Date.now(); products.unshift(newProduct); showToast(`Produk "${name}" berhasil ditambahkan.`, true);
    }
    currentPage = 1;
    renderProducts();
    closeProductModal();
  });

  function editProduct(id) { openProductModal(id); }
  async function deleteProduct(id) {
    const p = products.find(x => x.id === id);
    if (!p) return;
    const modal = document.getElementById('confirmDeleteModal');
    document.getElementById('confirmDeleteMessage').innerText = `Apakah Anda yakin ingin menghapus produk "${p.name}"?`;
    modal.classList.add('show');
    const onConfirm = () => { modal.classList.remove('show'); products = products.filter(x => x.id !== id); renderProducts(); showToast(`Produk "${p.name}" dihapus.`, true); cleanup(); };
    const onCancel = () => { modal.classList.remove('show'); cleanup(); };
    const cleanup = () => { document.getElementById('deleteConfirmBtn').removeEventListener('click', onConfirm); document.getElementById('deleteCancelBtn').removeEventListener('click', onCancel); };
    document.getElementById('deleteConfirmBtn').addEventListener('click', onConfirm);
    document.getElementById('deleteCancelBtn').addEventListener('click', onCancel);
  }

  renderProducts();
</script>
</body>
</html>