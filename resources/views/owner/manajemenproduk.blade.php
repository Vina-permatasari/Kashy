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

    /* Sidebar tersembunyi (sama seperti manajemen diskon) */
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

    /* Desktop: sidebar selalu terlihat */
    /* @media(min-width:1024px) {
      #sidebar { transform:translateX(0)!important; }
      #main    { margin-left:280px; }
      #overlay { display:none!important; }
      #global-menu-toggle { display:none!important; }
    } */

    /* Animasi */
    @keyframes fadeUp {
      from { opacity:0; transform:translateY(18px); }
      to   { opacity:1; transform:translateY(0); }
    }
    .fade-up { animation:fadeUp .4s ease both; }
    .d1 { animation-delay:.05s; } .d2 { animation-delay:.10s; }
    .d3 { animation-delay:.15s; } .d4 { animation-delay:.20s; }
    .d5 { animation-delay:.25s; } .d6 { animation-delay:.30s; }

    /* Navigasi */
    .nav-item {
      display:flex; align-items:center; gap:12px; padding:11px 18px;
      border-radius:12px; cursor:pointer; transition:all .15s;
      font-size:14px; font-weight:500; color:#1a1a1a;
      text-decoration:none; width:100%;
    }
    .nav-item:hover { background:#F5F0EB; }
    .nav-item.active { background:#F7EFE5; color:#7B4F2E; font-weight:600; }
    .nav-item.active svg { stroke:#7B4F2E; }

    /* Tab */
    .tab-btn {
      padding:10px 4px; font-size:13px; font-weight:600; color:#8A7968;
      border-bottom:2px solid transparent; cursor:pointer;
      transition:all .2s; background:none;
    }
    .tab-btn.active { color:#1a1a1a; border-bottom-color:#C49A6C; }

    /* Product card */
    .prod-img-wrap {
      width:100%; height:160px; border-radius:14px; overflow:hidden;
      position:relative; margin-bottom:12px;
    }
    .prod-img-wrap img { width:100%; height:100%; object-fit:cover; }
    .badge-stok {
      position:absolute; top:10px; right:10px;
      font-size:10px; font-weight:700; letter-spacing:.05em;
      padding:3px 10px; border-radius:20px;
      background:#fff; color:#1a1a1a;
    }
    .badge-stok.tersedia { background:#C49A6C; color:#fff; }
    .badge-stok.rendah   { background:#F59E0B; color:#fff; }
    .badge-stok.habis    { background:#D94F4F; color:#fff; }

    /* Chip */
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
    ::-webkit-scrollbar { width:4px; }
    ::-webkit-scrollbar-track { background:transparent; }
    ::-webkit-scrollbar-thumb { background:#C49A6C; border-radius:10px; }
  </style>
</head>
@include('owner.components.sidebar')
<body>


<!-- ========== MAIN CONTENT ========== -->
<main id="main" class="min-h-screen bg-kashy-cream transition-all duration-300">
    @include('owner.components.topbar')
  <div class="px-5 md:px-8 py-6 max-w-2xl mx-auto">

    <!-- Header -->
    <div class="fade-up d1 mb-5">
      <h1 class="text-3xl font-extrabold text-kashy-dark">Manajemen Produk & Stok</h1>
      <p class="text-sm text-kashy-muted mt-1">Kelola dan pantau inventaris produk Anda.</p>
    </div>

    <!-- Tombol Tambah Produk -->
    <div class="fade-up d2 mb-5">
      <button onclick="document.getElementById('formSection').scrollIntoView({behavior:'smooth'})" class="w-full flex items-center justify-center gap-2 py-4 rounded-2xl font-bold text-sm tracking-widest text-white uppercase transition-all duration-200 hover:opacity-90 active:scale-[.98]" style="background:#C49A6C; box-shadow:0 4px 14px 0 rgba(196,154,108,.35);">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
        Tambah Produk
      </button>
    </div>

    <!-- Tabs Filter -->
    <div class="fade-up d2 flex gap-6 border-b border-kashy-border mb-5">
      <button class="tab-btn active" onclick="filterTab('semua', this)">SEMUA <span id="countSemua">(0)</span></button>
      <button class="tab-btn" onclick="filterTab('rendah', this)">STOK RENDAH <span id="countRendah">(0)</span></button>
      <button class="tab-btn" onclick="filterTab('habis', this)">STOK HABIS <span id="countHabis">(0)</span></button>
    </div>

    <!-- Search -->
    <div class="fade-up d2 mb-4">
      <div class="relative">
        <span class="absolute left-3 top-1/2 -translate-y-1/2 pointer-events-none"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#8A7968" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg></span>
        <input type="text" id="searchProduct" class="form-input" style="padding-left:36px;" placeholder="Cari nama produk atau SKU..."/>
      </div>
    </div>

    <!-- Daftar Produk (Card) -->
    <div id="productContainer" class="flex flex-col gap-4"></div>

    <!-- Form Tambah Produk -->
    <div id="formSection" class="fade-up d6 bg-white rounded-2xl p-5 mt-6 shadow-card">
      <h2 class="text-xl font-bold text-kashy-dark mb-5">Produk Baru</h2>
      <div class="mb-4"><label class="form-label">Nama Produk</label><input type="text" id="prodName" class="form-input" placeholder="nama produk..."/></div>
      <div class="grid grid-cols-2 gap-3 mb-4"><div><label class="form-label">SKU</label><input type="text" id="prodSku" class="form-input" placeholder="EG-XXX-000"/></div><div><label class="form-label">Kategori</label><select id="prodCategory" class="form-input form-select"><option>Dress</option><option>Cardigan</option><option>Kemeja</option><option>Celana</option><option>Aksesoris</option></select></div></div>
      <div class="grid grid-cols-2 gap-3 mb-4"><div><label class="form-label">Harga</label><input type="text" id="prodPrice" class="form-input" placeholder="Rp 0"/></div><div><label class="form-label">Stok</label><input type="number" id="prodStock" class="form-input" placeholder="0"/></div></div>
      <div class="mb-4"><label class="form-label">Batas Stok Rendah</label><input type="number" id="prodLowStock" class="form-input" placeholder="10"/></div>
      <div class="mb-4"><label class="form-label">Deskripsi</label><textarea id="prodDesc" rows="3" class="form-input resize-none" placeholder="Deskripsi produk..."></textarea></div>
      <div class="mb-5"><label class="form-label">Varian / Ukuran</label><div class="flex flex-wrap gap-2 mb-3" id="variantContainer"><span class="chip chip-terra">S<button class="chip-remove" onclick="this.closest('.chip').remove()">×</button></span><span class="chip chip-terra">M<button class="chip-remove" onclick="this.closest('.chip').remove()">×</button></span></div><input type="text" id="variantInput" class="form-input" placeholder="Tambah varian (tekan Enter)" onkeydown="addVariant(event)"/></div>
      <div class="mb-5"><label class="form-label">Status</label><select id="prodStatus" class="form-input form-select"><option>Tersedia</option><option>Stok Rendah</option><option>Tidak Tersedia</option></select></div>
      <button id="createProductBtn" class="w-full py-4 rounded-2xl font-bold text-white text-sm tracking-wide mb-3 transition-all duration-200 hover:opacity-90 active:scale-[.98]" style="background:#C49A6C; box-shadow:0 4px 14px 0 rgba(196,154,108,.35);">Simpan Produk</button>
    </div>

  </div>
</main>

<script>
  // ========== SIDEBAR TOGGLE (Hidden menu) ==========
  const sidebar = document.getElementById('sidebar');
  const overlay = document.getElementById('overlay');
  const menuBtn = document.getElementById('global-menu-toggle');

  function openSidebar()  { sidebar.classList.add('sidebar-open'); overlay.classList.add('show'); document.body.style.overflow='hidden'; }
  function closeSidebar() { sidebar.classList.remove('sidebar-open'); overlay.classList.remove('show'); document.body.style.overflow=''; }
  function toggleSidebar() { sidebar.classList.contains('sidebar-open') ? closeSidebar() : openSidebar(); }

  if (menuBtn) menuBtn.addEventListener('click', e => { e.stopPropagation(); toggleSidebar(); });
  if (overlay) overlay.addEventListener('click', closeSidebar);
  document.addEventListener('keydown', e => { if (e.key==='Escape') closeSidebar(); });

  // ========== DATA PRODUK ==========
  let products = [
    { id:1, name:"Artisan Linen Midi Dress", sku:"EG-DR-2024-001", category:"Dress", price:"Rp 1.450.000", stock:142, lowStockThreshold:10, desc:"Linen alam, bersumber dari peternakan berkelanjutan.", variants:["S","M","L"], status:"Tersedia", img:"https://images.unsplash.com/photo-1572804013309-59a88b7e92f1?w=600&q=80" },
    { id:2, name:"Uniqlo Cardigan Pink", sku:"EG-ACC-Cardigan-88", category:"Cardigan", price:"Rp 3.890.000", stock:8, lowStockThreshold:10, desc:"Cardigan rajut lembut dengan warna pink dusty.", variants:["M","L"], status:"Stok Rendah", img:"https://images.unsplash.com/photo-1576566588028-4147f3842f27?w=600&q=80" },
    { id:3, name:"Organic Cotton Oxford", sku:"EG-TSH-WHT-21", category:"Kemeja", price:"Rp 890.000", stock:56, lowStockThreshold:10, desc:"Kemeja Oxford berbahan katun organik.", variants:["S","M","L","XL"], status:"Tersedia", img:"https://images.unsplash.com/photo-1596755094514-f87e34085b2c?w=600&q=80" },
    { id:4, name:"Cashmere Blend Sweater", sku:"EG-KW-OOL-402", category:"Cardigan", price:"Rp 2.450.000", stock:0, lowStockThreshold:5, desc:"Sweater cashmere premium.", variants:["M","L"], status:"Tidak Tersedia", img:"https://images.unsplash.com/photo-1614676471928-2ed0ad1061a4?w=600&q=80" },
    { id:5, name:"Silk Evening Gown", sku:"EG-GWN-EVE-019", category:"Dress", price:"Rp 3.250.000", stock:24, lowStockThreshold:10, desc:"Gaun malam sutra premium.", variants:["S","M"], status:"Tersedia", img:"https://images.unsplash.com/photo-1566174053879-31528523f8ae?w=600&q=80" }
  ];

  let currentFilter = "semua";
  let searchKeyword = "";

  function updateCounters() {
    document.getElementById("countSemua").innerHTML = `(${products.length})`;
    const rendah = products.filter(p => p.stock > 0 && p.stock <= (p.lowStockThreshold||10)).length;
    const habis = products.filter(p => p.stock === 0).length;
    document.getElementById("countRendah").innerHTML = `(${rendah})`;
    document.getElementById("countHabis").innerHTML = `(${habis})`;
  }

  function getStockStatus(p) {
    if (p.stock === 0) return "habis";
    if (p.stock <= (p.lowStockThreshold||10)) return "rendah";
    return "tersedia";
  }

  function renderProducts() {
    let filtered = [...products];
    if (currentFilter === "rendah") filtered = filtered.filter(p => p.stock > 0 && p.stock <= (p.lowStockThreshold||10));
    if (currentFilter === "habis") filtered = filtered.filter(p => p.stock === 0);
    if (searchKeyword.trim()) {
      const kw = searchKeyword.toLowerCase();
      filtered = filtered.filter(p => p.name.toLowerCase().includes(kw) || p.sku.toLowerCase().includes(kw));
    }
    const container = document.getElementById("productContainer");
    if (!container) return;
    container.innerHTML = "";
    if (filtered.length === 0) {
      container.innerHTML = `<div class="bg-white rounded-2xl p-8 text-center shadow-card"><p class="text-kashy-muted">Tidak ada produk ditemukan.</p></div>`;
      return;
    }
    filtered.forEach(p => {
      const statusKey = getStockStatus(p);
      let badgeClass = "", badgeText = "";
      if (statusKey === "tersedia") { badgeClass = "tersedia"; badgeText = "Tersedia"; }
      else if (statusKey === "rendah") { badgeClass = "rendah"; badgeText = "Stok Rendah"; }
      else { badgeClass = "habis"; badgeText = "Stok Habis"; }
      const stockColor = p.stock === 0 ? "text-red-500" : (statusKey === "rendah" ? "text-amber-500" : "text-kashy-dark");
      const card = document.createElement("div");
      card.className = "bg-white rounded-2xl p-4 shadow-card fade-up";
      card.innerHTML = `
        <div class="prod-img-wrap"><img src="${p.img}" loading="lazy"><span class="badge-stok ${badgeClass}">${badgeText}</span></div>
        <p class="text-[10px] font-semibold text-kashy-muted uppercase mb-1">${p.sku}</p>
        <h3 class="text-lg font-bold text-kashy-dark mb-1">${p.name}</h3>
        <p class="text-sm text-kashy-muted mb-3">${p.desc.substring(0,80)}${p.desc.length>80?'…':''}</p>
        <div class="flex gap-6 mb-3"><div><p class="text-[10px] font-semibold text-kashy-muted uppercase mb-1">Stok</p><p class="text-base font-bold ${stockColor}">${p.stock} Unit</p></div><div><p class="text-[10px] font-semibold text-kashy-muted uppercase mb-1">Harga</p><p class="text-base font-bold text-kashy-brown">${p.price}</p></div></div>
        <div class="flex items-center gap-4 pt-3 border-t border-kashy-border">
          <button class="flex items-center gap-1.5 text-sm font-semibold text-kashy-muted hover:text-kashy-dark" onclick="editProduct(${p.id})"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>Edit</button>
          <button class="flex items-center gap-1.5 text-sm font-semibold text-red-600 hover:text-red-700" onclick="deleteProduct(${p.id})"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4h6v2"/></svg>Hapus</button>
        </div>
      `;
      container.appendChild(card);
    });
    updateCounters();
  }

  function filterTab(tab, btn) {
    currentFilter = tab;
    document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    renderProducts();
  }

  function editProduct(id) {
    const p = products.find(x => x.id === id);
    if (!p) return;
    let newName = prompt("Edit nama:", p.name);
    if (newName?.trim()) p.name = newName.trim();
    let newPrice = prompt("Edit harga:", p.price);
    if (newPrice?.trim()) p.price = newPrice.trim();
    let newStock = prompt("Edit stok:", p.stock);
    if (newStock !== null && !isNaN(parseInt(newStock))) p.stock = parseInt(newStock);
    renderProducts();
  }

  function deleteProduct(id) {
    if (confirm("Hapus produk permanen?")) {
      products = products.filter(p => p.id !== id);
      renderProducts();
    }
  }

  document.getElementById("searchProduct")?.addEventListener("input", e => { searchKeyword = e.target.value; renderProducts(); });

  function addVariant(e) {
    if (e.key !== 'Enter') return;
    const val = e.target.value.trim();
    if (!val) return;
    const container = document.getElementById("variantContainer");
    const chip = document.createElement("span");
    chip.className = "chip";
    chip.innerHTML = `${val}<button class="chip-remove" onclick="this.closest('.chip').remove()">×</button>`;
    container.appendChild(chip);
    e.target.value = "";
  }

  document.getElementById("createProductBtn")?.addEventListener("click", () => {
    const name = document.getElementById("prodName").value.trim();
    const sku = document.getElementById("prodSku").value.trim();
    if (!name || !sku) { alert("Nama dan SKU wajib diisi."); return; }
    const category = document.getElementById("prodCategory").value;
    let price = document.getElementById("prodPrice").value.trim();
    if (!price.startsWith("Rp")) price = `Rp ${price}`;
    const stock = parseInt(document.getElementById("prodStock").value) || 0;
    const lowStock = parseInt(document.getElementById("prodLowStock").value) || 10;
    const desc = document.getElementById("prodDesc").value.trim() || "Produk baru";
    const variants = Array.from(document.querySelectorAll("#variantContainer .chip")).map(ch => ch.innerText.replace('×', '').trim());
    const status = document.getElementById("prodStatus").value;
    const newId = Date.now();
    products.push({ id:newId, name, sku, category, price, stock, lowStockThreshold:lowStock, desc, variants, status, img:"https://images.unsplash.com/photo-1594938298603-c8148c4b4057?w=600&q=80" });
    renderProducts();
    // reset form
    document.getElementById("prodName").value = "";
    document.getElementById("prodSku").value = "";
    document.getElementById("prodPrice").value = "";
    document.getElementById("prodStock").value = "";
    document.getElementById("prodLowStock").value = "10";
    document.getElementById("prodDesc").value = "";
    document.getElementById("variantContainer").innerHTML = `<span class="chip chip-terra">S<button class="chip-remove" onclick="this.closest('.chip').remove()">×</button></span><span class="chip chip-terra">M<button class="chip-remove" onclick="this.closest('.chip').remove()">×</button></span>`;
    alert(`Produk "${name}" berhasil ditambahkan.`);
  });

  renderProducts();
</script>
</body>
</html>