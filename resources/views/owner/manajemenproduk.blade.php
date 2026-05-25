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

    /* Sidebar (sama persis) */
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

    /* Navigasi sidebar */
    .nav-item {
      display:flex; align-items:center; gap:12px; padding:11px 18px;
      border-radius:12px; cursor:pointer; transition:all .15s;
      font-size:14px; font-weight:500; color:#1a1a1a;
      text-decoration:none; width:100%;
    }
    .nav-item:hover { background:#F5F0EB; }
    .nav-item.active { background:#F7EFE5; color:#7B4F2E; font-weight:600; }
    .nav-item.active svg { stroke:#7B4F2E; }

    /* Tab kategori */
    .tab-btn {
      padding:10px 4px; font-size:13px; font-weight:600; color:#8A7968;
      border-bottom:2px solid transparent; cursor:pointer;
      transition:all .2s; background:none;
    }
    .tab-btn.active { color:#1a1a1a; border-bottom-color:#C49A6C; }

    /* Form */
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

    /* Produk card grid */
    .prod-img-wrap {
      width:100%; height:220px; border-radius:14px; overflow:hidden;
      position:relative; margin-bottom:12px;
    }
    .prod-img-wrap img { width:100%; height:100%; object-fit:cover; }
    .chip {
      display:inline-flex; align-items:center; gap:5px;
      padding:5px 12px; border-radius:8px;
      font-size:12px; font-weight:600;
      background:#F5F0EB; color:#8A7968; border:1.5px solid #E0D8CE;
    }
    .chip-terra { background:#FDF1E8; color:#C49A6C; border-color:#C49A6C; }
    .chip-remove {
      background:none; border:none; cursor:pointer;
      color:#8A7968; font-size:14px; line-height:1;
      padding:0;
    }
    .line-clamp-1 { display: -webkit-box; -webkit-line-clamp: 1; -webkit-box-orient: vertical; overflow: hidden; }
    .line-clamp-2 { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }

    .badge-produk {
      position: absolute; top: 12px; right: 12px;
      padding: 4px 12px; border-radius: 20px;
      font-size: 10px; font-weight: bold;
      background: #1a1a1a; color: white;
    }
    .badge-sale { background: #ef4444; }
    .badge-new { background: #3a9e6f; }
    .badge-branded { background: #c49a6c; }

    @keyframes fadeIn {
      from { opacity:0; transform:scale(0.96); }
      to   { opacity:1; transform:scale(1); }
    }
    .animate-fadeIn { animation: fadeIn 0.2s ease-out; }

    ::-webkit-scrollbar { width:4px; }
    ::-webkit-scrollbar-track { background:transparent; }
    ::-webkit-scrollbar-thumb { background:#C49A6C; border-radius:10px; }
  </style>
</head>
@include('owner.components.sidebar')
<body>

<main id="main" class="min-h-screen bg-kashy-cream transition-all duration-300">
  @include('owner.components.topbar')

  <div class="px-5 md:px-8 py-6 max-w-2xl mx-auto">

    <!-- Header -->
    <div class="fade-up d1 mb-5">
      <h1 class="text-3xl font-extrabold text-kashy-dark">Manajemen Produk & Stok</h1>
      <p class="text-sm text-kashy-muted mt-1">Kelola dan pantau inventaris produk Anda.</p>
    </div>

    <!-- Tombol Tambah Produk (buka modal) -->
    <div class="fade-up d2 mb-5">
      <button onclick="openProductModal()" class="w-full flex items-center justify-center gap-2 py-4 rounded-2xl font-bold text-sm tracking-widest text-white uppercase transition-all duration-200 hover:opacity-90 active:scale-[.98]" style="background:#C49A6C; box-shadow:0 4px 14px 0 rgba(196,154,108,.35);">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
        Tambah Produk
      </button>
    </div>
    <!-- Tabs Kategori -->
    <div class="fade-up d2 flex gap-6 border-b border-kashy-border mb-5 overflow-x-auto whitespace-nowrap">
      <button class="tab-btn active" onclick="filterTab('semua', this)">Semua <span id="countSemua">(0)</span></button>
      <button class="tab-btn" onclick="filterTab('Dress', this)">Dress</button>
      <button class="tab-btn" onclick="filterTab('Cardigan', this)">Cardigan</button>
      <button class="tab-btn" onclick="filterTab('Kemeja', this)">Kemeja</button>
      <button class="tab-btn" onclick="filterTab('Celana', this)">Celana</button>
      <button class="tab-btn" onclick="filterTab('Aksesoris', this)">Aksesoris</button>
    </div>

    <!-- Search -->
    <div class="fade-up d2 mb-4">
      <div class="relative">
        <span class="absolute left-3 top-1/2 -translate-y-1/2 pointer-events-none">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#8A7968" stroke-width="2">
            <circle cx="11" cy="11" r="8"/>
            <line x1="21" y1="21" x2="16.65" y2="16.65"/>
          </svg>
        </span>
        <input type="text" id="searchProduct" class="form-input" style="padding-left:36px;" placeholder="Cari nama produk atau SKU..."/>
      </div>
    </div>
    
    <!-- Ringkasan Stok per Kategori (diperkecil ukurannya) -->
    <div class="fade-up d2 mb-5" id="categoryStatsContainer">
      <p class="text-[11px] font-bold tracking-widest text-kashy-muted uppercase mb-3">Ringkasan Stok</p>
      <div id="categoryStatsGrid" class="grid grid-cols-1 gap-3">
        <!-- akan diisi javascript -->
      </div>
    </div>

    <!-- Grid Produk (2 kolom) -->
    <div id="productContainer" class="grid grid-cols-1 sm:grid-cols-2 gap-4"></div>

  </div>
</main>

<!-- MODAL TAMBAH/EDIT PRODUK -->
<div id="productModal" class="hidden fixed inset-0 z-[999] bg-black/40 backdrop-blur-sm flex items-center justify-center p-4">
  <div class="bg-white rounded-3xl w-full max-w-2xl max-h-[90vh] overflow-y-auto p-6 relative animate-fadeIn">
    <h2 id="modalTitle" class="text-2xl font-bold text-kashy-dark mb-6">Tambah Produk</h2>
    <input type="hidden" id="editId" value="">

    <div class="mb-4">
      <label class="form-label">Foto Produk (Opsional)</label>
      <input type="file" id="prodImage" accept="image/*" class="form-input"/>
    </div>
    <div class="mb-4">
      <label class="form-label">Nama Produk <span class="text-red-500">*</span></label>
      <input type="text" id="prodName" class="form-input" placeholder="Nama produk..."/>
    </div>
    <div class="grid grid-cols-2 gap-3 mb-4">
      <div><label class="form-label">Kategori</label><select id="prodCategory" class="form-input form-select"><option>Dress</option><option>Cardigan</option><option>Kemeja</option><option>Celana</option><option>Aksesoris</option></select></div>
      <div><label class="form-label">Harga (Rp)</label><input type="text" id="prodPrice" class="form-input" placeholder="0"/></div>
    </div>

    <div class="grid grid-cols-2 gap-3 mb-4">
      <div><label class="form-label">Harga Coret (opsional)</label><input type="text" id="prodOldPrice" class="form-input" placeholder="Contoh: 120000"/></div>
      <div><label class="form-label">Badge</label>
        <select id="prodBadge" class="form-input form-select">
          <option value="">Tanpa Badge</option>
          <option value="new">New</option>
          <option value="sale">Sale</option>
          <option value="branded">Branded</option>
        </select>
      </div>
    </div>

    <div class="grid grid-cols-2 gap-3 mb-4">
      <div><label class="form-label">Bahan</label><input type="text" id="prodBahan" class="form-input" placeholder="Contoh: Katun Premium"/></div>
      <div><label class="form-label">Warna</label><input type="text" id="prodWarna" class="form-input" placeholder="Contoh: Cream"/></div>
    </div>

    <div class="grid grid-cols-3 gap-3 mb-4">
      <div><label class="form-label">Kondisi</label>
        <select id="prodKondisi" class="form-input form-select">
          <option value="">Pilih</option>
          <option>Baru</option><option>Like New</option><option>Second</option>
        </select>
      </div>
      <div><label class="form-label">Lingkar Dada</label><input type="text" id="prodLingkarDada" class="form-input" placeholder="96 cm"/></div>
      <div><label class="form-label">Panjang Baju</label><input type="text" id="prodPanjangBaju" class="form-input" placeholder="72 cm"/></div>
    </div>

    <div class="grid grid-cols-2 gap-3 mb-4">
      <div><label class="form-label">Stok</label><input type="number" id="prodStock" class="form-input" placeholder="0"/></div>
      <div><label class="form-label">Ukuran (varian)</label>
        <div class="flex flex-wrap gap-2 mb-2" id="variantContainer">
          <span class="chip chip-terra">S<button class="chip-remove" onclick="this.closest('.chip').remove()">×</button></span>
          <span class="chip chip-terra">M<button class="chip-remove" onclick="this.closest('.chip').remove()">×</button></span>
        </div>
        <input type="text" id="variantInput" class="form-input" placeholder="Tambah ukuran lalu Enter" onkeydown="addVariant(event)"/>
      </div>
    </div>

    <div class="mb-4">
      <label class="form-label">Deskripsi</label>
      <textarea id="prodDesc" rows="3" class="form-input resize-none" placeholder="Deskripsi produk..."></textarea>
    </div>

    <div class="flex flex-col gap-3">
      <button id="saveProductBtn" class="flex-1 py-4 rounded-2xl font-bold text-white text-sm tracking-wide transition-all duration-200 hover:opacity-90 active:scale-[.98]" style="background:#C49A6C; box-shadow:0 4px 14px rgba(196,154,108,.35);">Simpan Produk</button>
      <button onclick="closeProductModal()" class="flex-1 py-4 rounded-2xl font-bold text-kashy-dark text-sm tracking-wide border-2 border-kashy-border transition-all duration-200 hover:bg-kashy-cream active:scale-[.98] bg-white">Batal</button>
    </div>
  </div>
</div>

<script>
  // ========= SIDEBAR TOGGLE =========
  const sidebar = document.getElementById('sidebar');
  const overlay = document.getElementById('overlay');
  const menuBtn = document.getElementById('global-menu-toggle');

  function openSidebar()  { sidebar.classList.add('sidebar-open'); overlay.classList.add('show'); document.body.style.overflow='hidden'; }
  function closeSidebar() { sidebar.classList.remove('sidebar-open'); overlay.classList.remove('show'); document.body.style.overflow=''; }
  function toggleSidebar() { sidebar.classList.contains('sidebar-open') ? closeSidebar() : openSidebar(); }

  if (menuBtn) menuBtn.addEventListener('click', e => { e.stopPropagation(); toggleSidebar(); });
  if (overlay) overlay.addEventListener('click', closeSidebar);
  document.addEventListener('keydown', e => { if (e.key==='Escape') closeSidebar(); });

  // ========= DATA PRODUK =========
  let products = [
    { id:1, name:"Artisan Linen Midi Dress", sku:"EG-001", category:"Dress", price:"1450000", oldPrice:"", badge:"", bahan:"Linen", warna:"Cream", kondisi:"Baru", lingkar_dada:"96 cm", panjang_baju:"110 cm", stock:142, desc:"Linen premium modern.", variants:["S","M","L"], img:"https://images.unsplash.com/photo-1572804013309-59a88b7e92f1?w=600&q=80" },
    { id:2, name:"Uniqlo Cardigan Pink", sku:"EG-002", category:"Cardigan", price:"890000", oldPrice:"", badge:"", bahan:"Rajut", warna:"Pink", kondisi:"Like New", lingkar_dada:"100 cm", panjang_baju:"60 cm", stock:22, desc:"Cardigan rajut pink.", variants:["M","L"], img:"https://images.unsplash.com/photo-1576566588028-4147f3842f27?w=600&q=80" },
    { id:3, name:"Organic Cotton Oxford", sku:"EG-003", category:"Kemeja", price:"780000", oldPrice:"", badge:"new", bahan:"Katun Organik", warna:"Putih", kondisi:"Baru", lingkar_dada:"104 cm", panjang_baju:"72 cm", stock:0, desc:"Kemeja katun organik.", variants:["S","M","L"], img:"https://images.unsplash.com/photo-1596755094514-f87e34085b2c?w=600&q=80" }
  ];

  let currentFilter = "semua";
  let searchKeyword = "";

  function updateCounters() {
    document.getElementById("countSemua").innerHTML = `(${products.length})`;
  }

  // RINGKASAN STOK DIPERKECIL UKURANNYA
  function renderCategoryStats() {
    const container = document.getElementById('categoryStatsGrid');
    if (!container) return;

    if (currentFilter === "semua") {
      const totalHabis = products.filter(p => p.stock === 0).length;
      const totalMenipis = products.filter(p => p.stock > 0 && p.stock <= 5).length;

      container.innerHTML = `
        <div class="bg-white rounded-xl p-1.5 shadow-card border border-kashy-border">
          <div class="grid grid-cols-2 gap-2">
            <div class="rounded-lg bg-red-50 border border-red-200 p-2 text-center">
              <p class="text-[10px] text-red-500 font-semibold">Stok Habis</p>
              <p class="text-xl font-extrabold text-red-600">${totalHabis}</p>
            </div>
            <div class="rounded-lg bg-orange-50 border border-orange-200 p-2 text-center">
              <p class="text-[10px] text-orange-500 font-semibold">Stok Menipis</p>
              <p class="text-xl font-extrabold text-orange-600">${totalMenipis}</p>
            </div>
          </div>
        </div>
      `;
      return;
    }

    // kategori tertentu
    const kategoriProduk = products.filter(p => p.category === currentFilter);
    const habis = kategoriProduk.filter(p => p.stock === 0).length;
    const menipis = kategoriProduk.filter(p => p.stock > 0 && p.stock <= 5).length;

    container.innerHTML = `
      <div class="bg-white rounded-xl p-1.5 shadow-card border border-kashy-border">
        <div class="grid grid-cols-2 gap-2">
          <div class="rounded-lg bg-red-50 border border-red-200 p-2 text-center">
            <p class="text-[10px] text-red-500 font-semibold">Stok Habis</p>
            <p class="text-xl font-extrabold text-red-600">${habis}</p>
          </div>
          <div class="rounded-lg bg-orange-50 border border-orange-200 p-2 text-center">
            <p class="text-[10px] text-orange-500 font-semibold">Stok Menipis</p>
            <p class="text-xl font-extrabold text-orange-600">${menipis}</p>
          </div>
        </div>
      </div>
    `;
  }

  function renderProducts() {
    let filtered = [...products];
    if (currentFilter !== "semua") {
      filtered = filtered.filter(p => p.category === currentFilter);
    }
    if (searchKeyword.trim()) {
      const kw = searchKeyword.toLowerCase();
      filtered = filtered.filter(p => p.name.toLowerCase().includes(kw) || (p.sku && p.sku.toLowerCase().includes(kw)));
    }
    const container = document.getElementById("productContainer");
    container.innerHTML = "";
    if (filtered.length === 0) {
      container.innerHTML = `<div class="bg-white rounded-2xl p-8 text-center shadow-card col-span-2"><p class="text-kashy-muted">Tidak ada produk ditemukan.</p></div>`;
      updateCounters();
      renderCategoryStats();
      return;
    }
    filtered.forEach(p => {
      const formattedPrice = `Rp ${parseInt(p.price).toLocaleString('id-ID')}`;
      let oldPriceHtml = p.oldPrice ? `<span class="text-xs text-muted line-through">Rp ${parseInt(p.oldPrice).toLocaleString('id-ID')}</span>` : '';
      let badgeHtml = '';
      if (p.badge === 'sale') badgeHtml = `<span class="badge-produk badge-sale">SALE</span>`;
      else if (p.badge === 'new') badgeHtml = `<span class="badge-produk badge-new">NEW</span>`;
      else if (p.badge === 'branded') badgeHtml = `<span class="badge-produk badge-branded">BRANDED</span>`;
      
      const card = document.createElement("div");
      card.className = "bg-white rounded-2xl p-3 shadow-card fade-up";
      card.innerHTML = `
        <div class="prod-img-wrap relative h-[220px]">
          <img src="${p.img}" loading="lazy">
          ${badgeHtml}
        </div>
        <p class="text-[10px] font-semibold text-kashy-muted uppercase mb-1">${p.category}</p>
        <h3 class="text-base font-bold text-kashy-dark line-clamp-1 mb-1">${p.name}</h3>
        <div class="flex items-center gap-2 mb-1">
          <p class="text-lg font-extrabold text-kashy-brown">${formattedPrice}</p>
          ${oldPriceHtml}
        </div>
        <p class="text-xs text-kashy-muted line-clamp-2 mb-3">${p.desc}</p>
        <div class="flex items-center justify-between mb-2">
          <div>
            <p class="text-xs text-kashy-muted">Stok: ${p.stock}</p>
            ${p.stock === 0 ? `<p class="text-[10px] font-bold text-red-600 mt-1">⚠ Stok Habis</p>` : (p.stock <= 5 ? `<p class="text-[10px] font-bold text-orange-500 mt-1">⚠ Stok Menipis</p>` : '')}
          </div>
          <div class="flex flex-wrap gap-1">
            ${p.variants.map(v => `<span class="chip text-xs py-0 px-2">${v}</span>`).join('')}
          </div>
        </div>
        <div class="flex items-center gap-3 pt-3 border-t border-kashy-border">
          <button class="flex items-center gap-1 text-xs font-semibold text-kashy-muted hover:text-kashy-dark" onclick="editProduct(${p.id})">Edit</button>
          <button class="flex items-center gap-1 text-xs font-semibold text-red-600 hover:text-red-700" onclick="deleteProduct(${p.id})">Hapus</button>
        </div>
      `;
      container.appendChild(card);
    });
    updateCounters();
    renderCategoryStats();
  }

  function filterTab(tab, btn) {
    currentFilter = tab;
    document.querySelectorAll(".tab-btn").forEach(b => b.classList.remove("active"));
    btn.classList.add("active");
    renderProducts();
  }

  document.getElementById("searchProduct")?.addEventListener("input", e => { searchKeyword = e.target.value; renderProducts(); });

  function addVariant(e) {
    if (e.key !== "Enter") return;
    const val = e.target.value.trim();
    if (!val) return;
    const chip = document.createElement("span");
    chip.className = "chip chip-terra";
    chip.innerHTML = `${val}<button class="chip-remove" onclick="this.closest('.chip').remove()">×</button>`;
    document.getElementById("variantContainer").appendChild(chip);
    e.target.value = "";
  }

  // ========= MODAL TAMBAH/EDIT =========
  let editMode = false;

  function openProductModal(id = null) {
    const modal = document.getElementById("productModal");
    modal.classList.remove("hidden");
    document.body.style.overflow = "hidden";
    
    if (id) {
      editMode = true;
      const product = products.find(p => p.id === id);
      if (product) {
        document.getElementById("modalTitle").innerText = "Edit Produk";
        document.getElementById("editId").value = product.id;
        document.getElementById("prodName").value = product.name;
        document.getElementById("prodCategory").value = product.category;
        document.getElementById("prodPrice").value = product.price;
        document.getElementById("prodOldPrice").value = product.oldPrice || "";
        document.getElementById("prodBadge").value = product.badge || "";
        document.getElementById("prodBahan").value = product.bahan || "";
        document.getElementById("prodWarna").value = product.warna || "";
        document.getElementById("prodKondisi").value = product.kondisi || "";
        document.getElementById("prodLingkarDada").value = product.lingkar_dada || "";
        document.getElementById("prodPanjangBaju").value = product.panjang_baju || "";
        document.getElementById("prodStock").value = product.stock;
        document.getElementById("prodDesc").value = product.desc;
        const variantContainer = document.getElementById("variantContainer");
        variantContainer.innerHTML = "";
        product.variants.forEach(v => {
          const chip = document.createElement("span");
          chip.className = "chip chip-terra";
          chip.innerHTML = `${v}<button class="chip-remove" onclick="this.closest('.chip').remove()">×</button>`;
          variantContainer.appendChild(chip);
        });
        document.getElementById("prodImage").value = "";
      }
    } else {
      editMode = false;
      document.getElementById("modalTitle").innerText = "Tambah Produk";
      document.getElementById("editId").value = "";
      document.getElementById("prodName").value = "";
      document.getElementById("prodCategory").value = "Dress";
      document.getElementById("prodPrice").value = "";
      document.getElementById("prodOldPrice").value = "";
      document.getElementById("prodBadge").value = "";
      document.getElementById("prodBahan").value = "";
      document.getElementById("prodWarna").value = "";
      document.getElementById("prodKondisi").value = "";
      document.getElementById("prodLingkarDada").value = "";
      document.getElementById("prodPanjangBaju").value = "";
      document.getElementById("prodStock").value = "";
      document.getElementById("prodDesc").value = "";
      document.getElementById("variantContainer").innerHTML = `<span class="chip chip-terra">S<button class="chip-remove" onclick="this.closest('.chip').remove()">×</button></span><span class="chip chip-terra">M<button class="chip-remove" onclick="this.closest('.chip').remove()">×</button></span>`;
      document.getElementById("prodImage").value = "";
    }
  }

  function closeProductModal() {
    document.getElementById("productModal").classList.add("hidden");
    document.body.style.overflow = "";
  }

  function getVariants() {
    const chips = document.querySelectorAll("#variantContainer .chip");
    return Array.from(chips).map(ch => ch.innerText.replace("×","").trim());
  }

  document.getElementById("saveProductBtn")?.addEventListener("click", () => {
    const name = document.getElementById("prodName").value.trim();
    if (!name) {
      alert("Nama produk wajib diisi.");
      return;
    }
    let image = "https://images.unsplash.com/photo-1594938298603-c8148c4b4057?w=600&q=80";
    const fileInput = document.getElementById("prodImage");
    if (fileInput.files[0]) {
      image = URL.createObjectURL(fileInput.files[0]);
    }

    const editId = document.getElementById("editId").value;
    const productData = {
      name: name,
      category: document.getElementById("prodCategory").value,
      price: document.getElementById("prodPrice").value.replace(/[^0-9]/g, '') || "0",
      oldPrice: document.getElementById("prodOldPrice").value.replace(/[^0-9]/g, '') || "",
      badge: document.getElementById("prodBadge").value,
      bahan: document.getElementById("prodBahan").value,
      warna: document.getElementById("prodWarna").value,
      kondisi: document.getElementById("prodKondisi").value,
      lingkar_dada: document.getElementById("prodLingkarDada").value,
      panjang_baju: document.getElementById("prodPanjangBaju").value,
      stock: parseInt(document.getElementById("prodStock").value) || 0,
      desc: document.getElementById("prodDesc").value || "Deskripsi produk",
      variants: getVariants(),
      img: image,
      sku: "SKU-" + Date.now()
    };

    if (editId) {
      const index = products.findIndex(p => p.id == editId);
      if (index !== -1) {
        productData.id = parseInt(editId);
        productData.sku = products[index].sku;
        products[index] = productData;
        alert(`Produk "${name}" berhasil diperbarui.`);
      }
    } else {
      const newId = Date.now();
      productData.id = newId;
      products.unshift(productData);
      alert(`Produk "${name}" berhasil ditambahkan.`);
    }
    renderProducts();
    closeProductModal();
  });

  function editProduct(id) {
    openProductModal(id);
  }

  function deleteProduct(id) {
    if (confirm("Hapus produk permanen?")) {
      products = products.filter(p => p.id !== id);
      renderProducts();
    }
  }

  // ========= INISIALISASI =========
  renderProducts();
</script>
</body>
</html>