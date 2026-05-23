<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover"/>
  <title>Kashy – Stok Opname</title>
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
              red:          '#D94F4F',
              green:        '#3A9E6F',
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

    /* ── Sidebar hidden menu (seperti halaman manajemen diskon) ── */
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

    /* Animations */
    @keyframes fadeUp {
      from { opacity:0; transform:translateY(18px); }
      to   { opacity:1; transform:translateY(0); }
    }
    .fade-up { animation:fadeUp .4s ease both; }
    .d1{animation-delay:.04s}.d2{animation-delay:.08s}.d3{animation-delay:.12s}
    .d4{animation-delay:.16s}.d5{animation-delay:.20s}.d6{animation-delay:.24s}

    /* navigation items */
    .nav-item {
      display:flex; align-items:center; gap:12px; padding:11px 18px;
      border-radius:12px; cursor:pointer; transition:all .15s;
      font-size:14px; font-weight:500; color:#1a1a1a;
      text-decoration:none; width:100%;
    }
    .nav-item:hover { background:#F5F0EB; }
    .nav-item.active { background:#F7EFE5; color:#7B4F2E; font-weight:600; }
    .nav-item.active svg { stroke:#7B4F2E; }

    /* stat card accent */
    .stat-card { position:relative; overflow:hidden; }
    .stat-card::before {
      content:''; position:absolute; left:0; top:12px; bottom:12px; width:3px;
      background:#C49A6C; border-radius:0 3px 3px 0;
    }

    /* table / form styling */
    .prod-row:hover { background:#FDFAF7; }
    input:focus,select:focus { outline:none; border-color:#C49A6C; box-shadow:0 0 0 3px rgba(196,154,108,.15); }
    .pg-btn { 
      width:32px; height:32px; border-radius:8px; display:flex; align-items:center; justify-content:center;
      font-size:13px; font-weight:500; cursor:pointer; transition:background .15s; 
      border:1px solid #E0D8CE; background:#fff; 
    }
    .pg-btn:hover { background:#F5F0EB; }
    .pg-btn.active { background:#1a1a1a; color:#fff; border-color:#1a1a1a; }
    ::-webkit-scrollbar { width:4px; }
    ::-webkit-scrollbar-track { background:transparent; }
    ::-webkit-scrollbar-thumb { background:#C49A6C; border-radius:10px; }
  </style>
</head>
@include('owner.components.sidebar')
<body>

<!-- ========== MAIN CONTENT ========== -->
<main id="main" class="min-h-screen bg-kashy-cream">
  @include('owner.components.topbar')


  <div class="px-5 md:px-8 py-6 max-w-4xl mx-auto">
    
    <!-- HEADER + action buttons -->
    <div class="fade-up d1 mb-5">
      <h1 class="text-3xl font-extrabold text-kashy-dark">Stok Opname</h1>
      <p class="text-sm text-kashy-muted mt-0.5">Pusat Distribusi Utama · verifikasi dan rekonsiliasi stok fisik</p>
      <div class="flex flex-wrap gap-3 mt-4">
        <button id="exportCsvBtn" class="flex items-center gap-2 px-4 py-2.5 rounded-xl border-2 border-kashy-dark bg-white text-kashy-dark text-sm font-semibold hover:bg-kashy-cream active:scale-[.97] transition-all">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
          Ekspor CSV
        </button>
        <button id="syncTriggerBtn" class="flex items-center gap-2 px-4 py-2.5 rounded-xl bg-kashy-dark text-white text-sm font-semibold shadow-btn hover:bg-black active:scale-[.97] transition-all">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><polyline points="1 4 1 10 7 10"/><polyline points="23 20 23 14 17 14"/><path d="M20.49 9A9 9 0 0 0 5.64 5.64L1 10M23 14l-4.64 4.36A9 9 0 0 1 3.51 15"/></svg>
          Sinkronkan Stok
        </button>
      </div>
    </div>

    <!-- Stat cards -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
      <div class="fade-up d1 stat-card bg-white rounded-2xl p-4 shadow-card">
        <p class="text-[10px] font-semibold tracking-widest text-kashy-muted uppercase mb-2">Total SKU</p>
        <p class="text-2xl font-bold text-kashy-dark">1,248</p>
      </div>
      <div class="fade-up d2 stat-card bg-white rounded-2xl p-4 shadow-card">
        <p class="text-[10px] font-semibold tracking-widest text-kashy-muted uppercase mb-2">Item Diaudit</p>
        <p class="text-2xl font-bold text-kashy-brown">842<span class="text-sm font-medium text-kashy-muted"> / 1.2k</span></p>
      </div>
      <div class="fade-up d3 stat-card bg-white rounded-2xl p-4 shadow-card">
        <p class="text-[10px] font-semibold tracking-widest text-kashy-muted uppercase mb-2">Jumlah Selisih</p>
        <p class="text-2xl font-bold text-kashy-red" id="totalDiffCount">12</p>
      </div>
      <div class="fade-up d4 stat-card bg-white rounded-2xl p-4 shadow-card">
        <p class="text-[10px] font-semibold tracking-widest text-kashy-muted uppercase mb-2">Delta Nilai Bersih</p>
        <p class="text-2xl font-bold text-kashy-red" id="totalDeltaValue">-$420.50</p>
      </div>
    </div>

    <!-- Search & Filter -->
    <div class="fade-up d3 bg-white rounded-2xl p-4 shadow-card mb-4">
      <div class="flex flex-col sm:flex-row gap-3">
        <div class="relative flex-1">
          <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-kashy-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
          <input type="text" id="searchInput" placeholder="Cari berdasarkan Nama Produk atau SKU" class="w-full pl-9 pr-4 py-2.5 rounded-xl border border-kashy-border text-sm text-kashy-dark placeholder-kashy-muted transition-all duration-200 bg-kashy-cream"/>
        </div>
        <div class="flex items-center gap-2 flex-shrink-0">
          <span class="text-xs text-kashy-muted font-medium whitespace-nowrap">Saring Berdasarkan</span>
          <select id="categoryFilter" class="px-3 py-2.5 rounded-xl border border-kashy-border bg-kashy-cream text-sm text-kashy-dark transition-all duration-200 cursor-pointer">
            <option value="all">Semua Kategori</option>
            <option value="Blazer">Blazer</option>
            <option value="T-Shirt">T-Shirt</option>
            <option value="Trousers">Trousers</option>
            <option value="Accessories">Accessories</option>
          </select>
        </div>
      </div>
    </div>

    <!-- Product Table (Stok Opname) -->
    <div class="fade-up d4 bg-white rounded-2xl shadow-card mb-6 overflow-hidden">
      <div class="overflow-x-auto">
        <table class="w-full min-w-[600px]" id="stockTable">
          <thead>
            <tr class="border-b border-kashy-border bg-kashy-cream/50">
              <th class="text-left px-5 py-3.5 text-xs font-semibold text-kashy-muted uppercase tracking-wider">Informasi Produk</th>
              <th class="text-center px-4 py-3.5 text-xs font-semibold text-kashy-muted uppercase tracking-wider">Sistem</th>
              <th class="text-center px-4 py-3.5 text-xs font-semibold text-kashy-muted uppercase tracking-wider">Fisik</th>
              <th class="text-center px-4 py-3.5 text-xs font-semibold text-kashy-muted uppercase tracking-wider">Selisih</th>
              <th class="text-center px-4 py-3.5 text-xs font-semibold text-kashy-muted uppercase tracking-wider">Status</th>
            </tr>
          </thead>
          <tbody id="tableBody">
            <!-- data rows will be injected via JS for dynamic filter, but we build static plus JS manipulation -->
          </tbody>
        </table>
      </div>
      <!-- pagination dummy -->
      <div class="flex items-center justify-between px-5 py-4 border-t border-kashy-border">
        <p class="text-xs text-kashy-muted">Menampilkan 1–5 dari <span class="font-semibold text-kashy-dark">1,248 SKUs</span></p>
        <div class="flex items-center gap-1.5">
          <button class="pg-btn"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg></button>
          <button class="pg-btn active">1</button>
          <button class="pg-btn">2</button>
          <button class="pg-btn">3</button>
          <span class="text-kashy-muted text-sm px-1">…</span>
          <button class="pg-btn">84</button>
          <button class="pg-btn"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg></button>
        </div>
      </div>
    </div>

    <!-- Catatan Audit -->
    <div class="fade-up d5 bg-white rounded-2xl p-5 shadow-card mb-4">
      <h3 class="font-bold text-kashy-dark text-base mb-3">Catatan Audit</h3>
      <textarea id="auditNotes" rows="3" placeholder="Tambahkan pengamatan mengenai ketidaksesuaian atau kondisi penyimpanan..." class="w-full px-4 py-3 rounded-xl border border-kashy-border bg-kashy-cream text-sm text-kashy-dark placeholder-kashy-muted resize-none transition-all duration-200 focus:outline-none focus:border-kashy-brown"></textarea>
    </div>
  </div>
</main>

<script>
  // ========== SIDEBAR HIDDEN (like discount management) ==========
  const sidebar = document.getElementById('sidebar');
  const overlay = document.getElementById('overlay');
  const menuBtn = document.getElementById('global-menu-toggle');

  function openSidebar()  { sidebar.classList.add('sidebar-open'); overlay.classList.add('show'); document.body.style.overflow='hidden'; }
  function closeSidebar() { sidebar.classList.remove('sidebar-open'); overlay.classList.remove('show'); document.body.style.overflow=''; }
  function toggleSidebar() { sidebar.classList.contains('sidebar-open') ? closeSidebar() : openSidebar(); }

  if (menuBtn) menuBtn.addEventListener('click', e => { e.stopPropagation(); toggleSidebar(); });
  if (overlay)  overlay.addEventListener('click', closeSidebar);
  document.addEventListener('keydown', e => { if (e.key==='Escape') closeSidebar(); });

  // ========== DATA PRODUK STOK OPNAME ==========
  const productsData = [
    { id:1, name:"Linen Structured Blazer", sku:"EG-BLZ-001", variant:"Oatmeal / M", category:"Blazer", img:"https://images.unsplash.com/photo-1594938298603-c8148c4b4057?w=80&q=80", system:42, physical:42, diff:0, status:"Sesuai", statusType:"match" },
    { id:2, name:"Essential Crewneck", sku:"EG-TEE-104", variant:"Clay / L", category:"T-Shirt", img:"https://images.unsplash.com/photo-1556821840-3a63f15732ce?w=80&q=80", system:124, physical:120, diff:-4, status:"Selisih", statusType:"short" },
    { id:3, name:"Silk Wide-Leg Trousers", sku:"EG-TRS-022", variant:"Charcoal / S", category:"Trousers", img:"https://images.unsplash.com/photo-1624378441864-6eda7786a814?w=80&q=80", system:15, physical:null, diff:"—", status:"Belum", statusType:"pending" },
    { id:4, name:"Silk Scarf Premium", sku:"EG-SCF-007", variant:"Ivory / One Size", category:"Accessories", img:"https://images.unsplash.com/photo-1601924994987-69e26d50dc26?w=80&q=80", system:33, physical:35, diff:+2, status:"Lebih", statusType:"excess" },
    { id:5, name:"Leather Tote Bag", sku:"EG-BAG-015", variant:"Tan / Standard", category:"Accessories", img:"https://images.unsplash.com/photo-1548036328-c9fa89d128fa?w=80&q=80", system:28, physical:28, diff:0, status:"Sesuai", statusType:"match" }
  ];

  function renderTable(filterText = "", category = "all") {
    const tbody = document.getElementById("tableBody");
    if (!tbody) return;
    let filtered = [...productsData];
    if (filterText.trim() !== "") {
      filtered = filtered.filter(p => p.name.toLowerCase().includes(filterText.toLowerCase()) || p.sku.toLowerCase().includes(filterText.toLowerCase()));
    }
    if (category !== "all") {
      filtered = filtered.filter(p => p.category === category);
    }
    tbody.innerHTML = "";
    filtered.forEach(p => {
      const physicalVal = (p.physical !== null && p.physical !== undefined) ? p.physical : "";
      const diffDisplay = p.diff === "—" ? "—" : (p.diff > 0 ? `+${p.diff}` : p.diff);
      let statusHtml = "", inputBorder = "", diffClass = "";
      if (p.statusType === "match") {
        statusHtml = `<span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-green-50 text-green-700 text-[11px] font-semibold">Sesuai</span>`;
        inputBorder = "border-kashy-border text-kashy-dark bg-kashy-cream";
        diffClass = "text-kashy-green";
      } else if (p.statusType === "short") {
        statusHtml = `<span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-red-50 text-red-600 text-[11px] font-semibold">Selisih</span>`;
        inputBorder = "border-red-300 text-red-600 bg-red-50";
        diffClass = "text-red-500";
      } else if (p.statusType === "excess") {
        statusHtml = `<span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-blue-50 text-blue-600 text-[11px] font-semibold">Lebih</span>`;
        inputBorder = "border-green-300 text-green-700 bg-green-50";
        diffClass = "text-kashy-green";
      } else {
        statusHtml = `<span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-amber-50 text-amber-600 text-[11px] font-semibold">Belum</span>`;
        inputBorder = "border-kashy-border text-kashy-muted bg-kashy-cream";
        diffClass = "text-kashy-muted";
      }
      const row = document.createElement("tr");
      row.className = "prod-row border-b border-kashy-border/60 transition-colors";
      row.innerHTML = `
        <td class="px-5 py-4">
          <div class="flex items-center gap-3">
            <img src="${p.img}" alt="${p.name}" class="w-12 h-12 rounded-xl object-cover flex-shrink-0 bg-kashy-cream-dark" loading="lazy">
            <div><p class="font-semibold text-kashy-dark text-sm leading-tight">${p.name}</p><p class="text-[11px] text-kashy-muted mt-0.5">${p.sku} • ${p.variant}</p></div>
          </div>
        </td>
        <td class="text-center px-4 py-4 text-sm font-medium text-kashy-dark">${p.system}</td>
        <td class="text-center px-4 py-4"><input type="number" value="${physicalVal !== "" ? physicalVal : ""}" placeholder="—" class="phys-count w-20 text-center ${inputBorder} rounded-lg py-1.5 text-sm font-medium transition-all duration-200 border" data-id="${p.id}" data-system="${p.system}"></td>
        <td class="text-center px-4 py-4 text-sm font-semibold ${diffClass} diff-cell">${diffDisplay}</td>
        <td class="text-center px-4 py-4 status-cell">${statusHtml}</td>
      `;
      tbody.appendChild(row);
    });
    attachInputEvents();
    updateTotalStats();
  }

  function updateRowDiff(row, inputEl, systemVal, physicalVal) {
    const diffCell = row.querySelector(".diff-cell");
    const statusCell = row.querySelector(".status-cell");
    const physicalNum = physicalVal === "" || isNaN(parseInt(physicalVal)) ? null : parseInt(physicalVal);
    let diff = null;
    if (physicalNum === null) {
      diffCell.textContent = "—";
      diffCell.className = "text-center px-4 py-4 text-sm font-medium text-kashy-muted diff-cell";
      statusCell.innerHTML = `<span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-amber-50 text-amber-600 text-[11px] font-semibold"><svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>Belum</span>`;
      inputEl.className = "phys-count w-20 text-center border border-kashy-border rounded-lg py-1.5 text-sm font-medium text-kashy-muted bg-kashy-cream transition-all duration-200";
      return;
    }
    diff = physicalNum - systemVal;
    if (diff === 0) {
      diffCell.textContent = "0";
      diffCell.className = "text-center px-4 py-4 text-sm font-semibold text-kashy-green diff-cell";
      statusCell.innerHTML = `<span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-green-50 text-green-700 text-[11px] font-semibold"><svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>Sesuai</span>`;
      inputEl.className = "phys-count w-20 text-center border border-kashy-border rounded-lg py-1.5 text-sm font-medium text-kashy-dark bg-kashy-cream transition-all duration-200";
    } else if (diff < 0) {
      diffCell.textContent = diff;
      diffCell.className = "text-center px-4 py-4 text-sm font-semibold text-red-500 diff-cell";
      statusCell.innerHTML = `<span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-red-50 text-red-600 text-[11px] font-semibold"><svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>Selisih</span>`;
      inputEl.className = "phys-count w-20 text-center border border-red-300 rounded-lg py-1.5 text-sm font-medium text-red-600 bg-red-50 transition-all duration-200";
    } else {
      diffCell.textContent = `+${diff}`;
      diffCell.className = "text-center px-4 py-4 text-sm font-semibold text-kashy-green diff-cell";
      statusCell.innerHTML = `<span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-blue-50 text-blue-600 text-[11px] font-semibold"><svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="18 15 12 9 6 15"/></svg>Lebih</span>`;
      inputEl.className = "phys-count w-20 text-center border border-green-300 rounded-lg py-1.5 text-sm font-medium text-green-700 bg-green-50 transition-all duration-200";
    }
  }

  function attachInputEvents() {
    document.querySelectorAll(".phys-count").forEach(input => {
      input.removeEventListener("input", input._listener);
      const handler = function(e) {
        const row = this.closest("tr");
        const systemVal = parseInt(this.getAttribute("data-system"));
        let physicalVal = this.value.trim() === "" ? "" : parseInt(this.value);
        if (this.value.trim() !== "" && isNaN(parseInt(this.value))) physicalVal = null;
        updateRowDiff(row, this, systemVal, (physicalVal === null || physicalVal === "") ? null : physicalVal);
        updateTotalStats();
      };
      input.addEventListener("input", handler);
      input._listener = handler;
    });
  }

  function updateTotalStats() {
    let diffRows = 0;
    let totalDelta = 0;
    document.querySelectorAll(".phys-count").forEach(input => {
      const row = input.closest("tr");
      const systemVal = parseInt(input.getAttribute("data-system"));
      let physicalVal = input.value.trim() === "" ? null : parseInt(input.value);
      if (physicalVal !== null && !isNaN(physicalVal)) {
        const diff = physicalVal - systemVal;
        if (diff !== 0) diffRows++;
        totalDelta += diff;
      }
    });
    const diffCountElem = document.getElementById("totalDiffCount");
    const deltaElem = document.getElementById("totalDeltaValue");
    if (diffCountElem) diffCountElem.innerText = diffRows;
    if (deltaElem) deltaElem.innerText = (totalDelta >= 0 ? `+$${totalDelta.toFixed(2)}` : `-$${Math.abs(totalDelta).toFixed(2)}`);
  }

  // filter listeners
  const searchInput = document.getElementById("searchInput");
  const categoryFilter = document.getElementById("categoryFilter");
  function refreshFilter() {
    const search = searchInput ? searchInput.value : "";
    const cat = categoryFilter ? categoryFilter.value : "all";
    renderTable(search, cat);
  }
  if (searchInput) searchInput.addEventListener("input", refreshFilter);
  if (categoryFilter) categoryFilter.addEventListener("change", refreshFilter);
  
  // initial render
  renderTable();

  // export CSV dummy
  document.getElementById("exportCsvBtn")?.addEventListener("click", () => alert("📁 Ekspor CSV: file stok_opname_2026.csv (simulasi)"));
  // sync button demo
  document.getElementById("syncTriggerBtn")?.addEventListener("click", () => alert("🔄 Sinkronisasi permintaan dikirim. Periksa ketersediaan data."));
  document.getElementById("confirmSyncBtn")?.addEventListener("click", () => {
    let notes = document.getElementById("auditNotes")?.value || "-";
    alert(`✅ Stok berhasil disinkronisasi. Catatan: ${notes.substring(0,60)}`); 
  });
</script>
</body>
</html>