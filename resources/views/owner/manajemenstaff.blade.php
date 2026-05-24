<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover"/>
  <title>Kashy – Manajemen Staff</title>
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

    /* ── Sidebar (sama persis dengan manajemen diskon) ── */
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
    .d1 { animation-delay:.05s; } .d2 { animation-delay:.10s; }
    .d3 { animation-delay:.15s; } .d4 { animation-delay:.20s; }
    .d5 { animation-delay:.25s; } .d6 { animation-delay:.30s; }

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

    /* ── Tab underline ── */
    .tab-btn {
      padding:10px 4px; font-size:13px; font-weight:600; color:#8A7968;
      border-bottom:2px solid transparent; cursor:pointer;
      transition:all .2s; background:none; border-top:none; border-left:none; border-right:none;
      font-family:'Poppins',sans-serif;
    }
    .tab-btn.active { color:#1a1a1a; border-bottom-color:#C49A6C; }

    /* ── Staff card (mirip promo card) ── */
    .staff-avatar {
      width: 48px; height: 48px; border-radius: 60px;
      background: #F5F0EB; display: flex; align-items: center; justify-content: center;
      font-weight: 700; font-size: 18px; color: #C49A6C;
      flex-shrink: 0;
    }
    .role-badge {
      display: inline-flex; align-items: center;
      padding: 3px 12px; border-radius: 20px;
      font-size: 10px; font-weight: 700; letter-spacing: .04em;
    }
    .badge-owner   { background:#1a1a1a; color:#fff; }
    .badge-kasir   { background:#C49A6C; color:#fff; }
    .badge-gudang  { background:#7B4F2E; color:#fff; }
    .badge-manajer { background:#2C5F2D; color:#fff; }
    .status-badge {
      display: inline-flex; align-items: center; gap: 4px;
      padding: 3px 10px; border-radius: 20px;
      font-size: 10px; font-weight: 700;
    }
    .status-aktif   { background:#E8F5EA; color:#3A9E6F; }
    .status-nonaktif{ background:#FEF2F2; color:#D94F4F; }

    /* ── Form input (sama) ── */
    .form-input {
      width:100%; padding:12px 14px; border:1.5px solid #E0D8CE;
      border-radius:12px; font-size:13px; font-family:'Poppins',sans-serif;
      color:#1a1a1a; background:#fff; outline:none;
      transition:border-color .2s;
    }
    .form-input:focus { border-color:#C49A6C; }
    .form-input::placeholder { color:#BFB4AC; }
    .form-select {
      appearance:none; background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%238A7968' stroke-width='2'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E");
      background-repeat:no-repeat; background-position:right 12px center;
      padding-right:36px; cursor:pointer;
    }
    .form-label {
      font-size:11px; font-weight:700; color:#8A7968;
      text-transform:uppercase; letter-spacing:.07em; margin-bottom:6px;
      display:block;
    }

    /* ── Search wrapper ── */
    .search-icon {
      position: absolute; left: 14px; top: 50%; transform: translateY(-50%);
      pointer-events: none;
    }
    ::-webkit-scrollbar { width:4px; }
    ::-webkit-scrollbar-track { background:transparent; }
    ::-webkit-scrollbar-thumb { background:#C49A6C; border-radius:10px; }
  </style>
</head>

@include('owner.components.sidebar')

<body>

<main id="main" class="min-h-screen bg-kashy-cream">
  @include('owner.components.topbar')

  <div class="px-5 md:px-8 py-6 max-w-2xl mx-auto">

    <!-- ── Header ── -->
    <div class="fade-up d1 mb-5">
      <h1 class="text-3xl font-extrabold text-kashy-dark">Manajemen Staff</h1>
      <p class="text-sm text-kashy-muted mt-1">Kelola akses, peran, dan status karyawan toko Anda.</p>
    </div>

    <!-- ── Tambah Staff Button (sama seperti Create Promotion) ── -->
    <div class="fade-up d2 mb-5">
      <button
        onclick="document.getElementById('formSection').scrollIntoView({behavior:'smooth'})"
        class="w-full flex items-center justify-center gap-2 py-4 rounded-2xl font-bold text-sm tracking-widest text-white uppercase transition-all duration-200 hover:opacity-90 active:scale-[.98]"
        style="background:#C49A6C; box-shadow:0 4px 14px 0 rgba(196,154,108,.35);">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
          <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
        </svg>
        Tambah Staff Baru
      </button>
    </div>

    <!-- ── Tabs (Semua / Aktif / Nonaktif) ── -->
    <div class="fade-up d2 flex gap-6 border-b border-kashy-border mb-5">
      <button class="tab-btn active" data-tab="semua" onclick="filterTab('semua', this)">
        SEMUA <span id="countSemua" class="text-kashy-brown">(0)</span>
      </button>
      <button class="tab-btn" data-tab="aktif" onclick="filterTab('aktif', this)">
        AKTIF <span id="countAktif" class="text-kashy-muted">(0)</span>
      </button>
      <button class="tab-btn" data-tab="nonaktif" onclick="filterTab('nonaktif', this)">
        NONAKTIF <span id="countNonaktif" class="text-kashy-muted">(0)</span>
      </button>
    </div>

    <!-- ── Search & Filter (seperti pada diskon ada input cari, tapi kita tambah filter role) ── -->
    <div class="fade-up d2 mb-5">
      <div class="flex flex-col sm:flex-row gap-3">
        <div class="relative flex-1">
          <span class="search-icon">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#8A7968" stroke-width="2">
              <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
            </svg>
          </span>
          <input type="text" id="searchStaff" class="form-input" style="padding-left: 38px;" placeholder="Cari nama, email, atau peran...">
        </div>
        <div class="relative">
          <select id="roleFilter" class="form-input form-select w-full sm:w-40">
            <option value="all">Semua Peran</option>
            <option value="Owner">Owner</option>
            <option value="Kasir">Kasir</option>
            <option value="Gudang">Gudang</option>
            <option value="Manajer">Manajer</option>
          </select>
        </div>
      </div>
    </div>

    <!-- ══════════════════════════════
         DAFTAR STAFF (CARD LAYOUT, mirip promo card)
         ══════════════════════════════ -->
    <div id="staffContainer" class="flex flex-col gap-4">
      <!-- staff cards akan diisi javascript -->
    </div>

    <!-- ── Log Keamanan (mirip dengan diskon namun sebagai card tambahan) ── -->
    <div class="fade-up d5 bg-white rounded-2xl p-5 mt-6" style="box-shadow:0 2px 18px 0 rgba(60,40,10,.07);">
      <h2 class="text-xl font-bold text-kashy-dark mb-4">Log Keamanan Terbaru</h2>
      <div class="space-y-3">
        <div class="flex items-start gap-3">
          <div class="w-8 h-8 rounded-xl bg-green-50 flex items-center justify-center"><svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg></div>
          <div><p class="text-sm font-semibold text-kashy-dark">Julianne Deakin login</p><p class="text-xs text-kashy-muted">Hari ini 08:42 • IP 192.168.1.45</p></div>
        </div>
        <div class="flex items-start gap-3">
          <div class="w-8 h-8 rounded-xl bg-orange-50 flex items-center justify-center"><svg class="w-4 h-4 text-kashy-brown" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg></div>
          <div><p class="text-sm font-semibold text-kashy-dark">Izin Marcus Knight diperbarui</p><p class="text-xs text-kashy-muted">Kemarin 16:15 • Diperbarui oleh Julianne D.</p></div>
        </div>
        <div class="flex items-start gap-3">
          <div class="w-8 h-8 rounded-xl bg-red-50 flex items-center justify-center"><svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="4.93" y1="4.93" x2="19.07" y2="19.07"/></svg></div>
          <div><p class="text-sm font-semibold text-kashy-dark">Akun Sienna Lowe dinonaktifkan</p><p class="text-xs text-kashy-muted">24 Okt 2024 • Tindakan administratif</p></div>
        </div>
      </div>
    </div>

    <!-- ══════════════════════════════
         FORM — Tambah Staff Baru (sama persis gaya form diskon)
         ══════════════════════════════ -->
    <div id="formSection" class="fade-up d6 bg-white rounded-2xl p-5 mt-6" style="box-shadow:0 2px 18px 0 rgba(60,40,10,.07);">
      <h2 class="text-xl font-bold text-kashy-dark mb-5">Tambah Staff Baru</h2>

      <div class="mb-4">
        <label class="form-label">Nama Lengkap</label>
        <input type="text" id="newName" class="form-input" placeholder="Masukkan nama..."/>
      </div>

      <div class="mb-4">
        <label class="form-label">Email</label>
        <input type="email" id="newEmail" class="form-input" placeholder="contoh@kashy.id"/>
      </div>

      <div class="grid grid-cols-2 gap-3 mb-4">
        <div>
          <label class="form-label">Peran</label>
          <select id="newRole" class="form-input form-select">
            <option>Kasir</option><option>Gudang</option><option>Manajer</option><option>Owner</option>
          </select>
        </div>
        <div>
          <label class="form-label">Status</label>
          <select id="newStatus" class="form-input form-select">
            <option>Aktif</option><option>Nonaktif</option>
          </select>
        </div>
      </div>

      <div class="mb-5">
        <label class="form-label">Kata Sandi Sementara</label>
        <input type="password" class="form-input" placeholder="********" value="kasih123"/>
      </div>

      <button id="createStaffBtn" class="w-full py-4 rounded-2xl font-bold text-white text-sm tracking-wide mb-3 transition-all duration-200 hover:opacity-90 active:scale-[.98]" style="background:#C49A6C; box-shadow:0 4px 14px 0 rgba(196,154,108,.35);">
        Buat Akun
      </button>
      <button class="w-full py-4 rounded-2xl font-bold text-kashy-dark text-sm tracking-wide border-2 border-kashy-border transition-all duration-200 hover:bg-kashy-cream active:scale-[.98] bg-white">
        Batal
      </button>
    </div>

  </div>
</main>

<script>
  // ========== DATA STAFF ==========
  let staffData = [
    { id:1, name:"Julianne Deakin", role:"Owner", email:"julianne@kashy.id", status:"Aktif" },
    { id:2, name:"Marcus Knight", role:"Kasir", email:"m.knight@kashy.id", status:"Aktif" },
    { id:3, name:"Sienna Lowe", role:"Gudang", email:"s.lowe@kashy.id", status:"Nonaktif" },
    { id:4, name:"Ryan Hartwell", role:"Kasir", email:"r.hartwell@kashy.id", status:"Nonaktif" },
    { id:5, name:"Clara Bennett", role:"Manajer", email:"c.bennett@kashy.id", status:"Aktif" },
    { id:6, name:"Dylan Santoso", role:"Gudang", email:"d.santoso@kashy.id", status:"Aktif" },
    { id:7, name:"Vera Tan", role:"Kasir", email:"vera.tan@kashy.id", status:"Aktif" },
    { id:8, name:"Gilang Pratama", role:"Owner", email:"gilang@kashy.id", status:"Aktif" }
  ];

  let currentTab = "semua";   // semua, aktif, nonaktif
  let searchKeyword = "";
  let roleFilterValue = "all";

  // Helper: update angka pada tab
  function updateTabCounts() {
    const total = staffData.length;
    const aktif = staffData.filter(s => s.status === "Aktif").length;
    const nonaktif = staffData.filter(s => s.status === "Nonaktif").length;
    document.getElementById("countSemua").innerHTML = `(${total})`;
    document.getElementById("countAktif").innerHTML = `(${aktif})`;
    document.getElementById("countNonaktif").innerHTML = `(${nonaktif})`;
  }

  // Render staff cards berdasarkan filter
  function renderStaffCards() {
    let filtered = [...staffData];
    // Filter by tab status
    if (currentTab === "aktif") filtered = filtered.filter(s => s.status === "Aktif");
    else if (currentTab === "nonaktif") filtered = filtered.filter(s => s.status === "Nonaktif");
    // Search filter
    if (searchKeyword.trim() !== "") {
      const kw = searchKeyword.toLowerCase();
      filtered = filtered.filter(s => s.name.toLowerCase().includes(kw) || s.email.toLowerCase().includes(kw) || s.role.toLowerCase().includes(kw));
    }
    // Role filter
    if (roleFilterValue !== "all") filtered = filtered.filter(s => s.role === roleFilterValue);

    const container = document.getElementById("staffContainer");
    if (!container) return;
    container.innerHTML = "";
    if (filtered.length === 0) {
      container.innerHTML = `<div class="bg-white rounded-2xl p-8 text-center" style="box-shadow:0 2px 18px 0 rgba(60,40,10,.07);">
        <svg class="w-12 h-12 mx-auto mb-3 text-kashy-muted" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
        <p class="text-kashy-muted text-sm">Tidak ada staff ditemukan.</p>
      </div>`;
      return;
    }

    filtered.forEach(staff => {
      const roleBadgeClass = staff.role === "Owner" ? "badge-owner" : (staff.role === "Kasir" ? "badge-kasir" : (staff.role === "Gudang" ? "badge-gudang" : "badge-manajer"));
      const statusClass = staff.status === "Aktif" ? "status-aktif" : "status-nonaktif";
      const statusText = staff.status === "Aktif" ? "Aktif" : "Nonaktif";
      const avatarInitial = staff.name.charAt(0).toUpperCase();

      // Membuat card yang mirip dengan promo card (tanpa gambar, tapi dengan avatar bulat)
      const card = document.createElement("div");
      card.className = "fade-up d3 bg-white rounded-2xl p-4";
      card.style.boxShadow = "0 2px 18px 0 rgba(60,40,10,.07)";
      card.innerHTML = `
        <div class="flex items-start gap-4">
          <div class="staff-avatar">${avatarInitial}</div>
          <div class="flex-1">
            <div class="flex flex-wrap items-center justify-between gap-2 mb-1">
              <h3 class="text-lg font-bold text-kashy-dark">${staff.name}</h3>
              <span class="role-badge ${roleBadgeClass}">${staff.role}</span>
            </div>
            <p class="text-sm text-kashy-muted mb-3">${staff.email}</p>
            <div class="flex items-center justify-between flex-wrap gap-2">
              <span class="status-badge ${statusClass}">
                <span class="w-1.5 h-1.5 rounded-full ${staff.status === "Aktif" ? "bg-green-600" : "bg-red-500"} inline-block mr-1"></span>
                ${statusText}
              </span>
              <div class="flex items-center gap-3">
                <button onclick="editStaff(${staff.id})" class="flex items-center gap-1 text-sm font-semibold text-kashy-muted hover:text-kashy-dark transition-colors">
                  <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                  Edit
                </button>
                <button onclick="toggleStaffStatus(${staff.id})" class="flex items-center gap-1 text-sm font-semibold ${staff.status === "Aktif" ? "text-red-600 hover:text-red-700" : "text-green-600 hover:text-green-700"} transition-colors">
                  <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    ${staff.status === "Aktif" ? '<polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6M14 11v6"/>' : '<polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 1 0 .49-3"/>'}
                  </svg>
                  ${staff.status === "Aktif" ? "Nonaktifkan" : "Aktifkan"}
                </button>
              </div>
            </div>
          </div>
        </div>
      `;
      container.appendChild(card);
    });
  }

  // Fungsi toggle status
  function toggleStaffStatus(id) {
    const staff = staffData.find(s => s.id === id);
    if (staff) {
      staff.status = staff.status === "Aktif" ? "Nonaktif" : "Aktif";
      renderStaffCards();
      updateTabCounts();
      // jika tab sedang filter yang berubah, tetap konsisten
      filterTab(currentTab, document.querySelector(`.tab-btn[data-tab="${currentTab}"]`));
    }
  }

  // Edit staff (sederhana dengan prompt)
  function editStaff(id) {
    const staff = staffData.find(s => s.id === id);
    if (staff) {
      const newName = prompt("Edit nama:", staff.name);
      if (newName && newName.trim()) staff.name = newName.trim();
      const newRole = prompt("Edit peran (Owner/Kasir/Gudang/Manajer):", staff.role);
      if (newRole && ["Owner","Kasir","Gudang","Manajer"].includes(newRole)) staff.role = newRole;
      renderStaffCards();
      updateTabCounts();
      filterTab(currentTab, document.querySelector(`.tab-btn[data-tab="${currentTab}"]`));
    }
  }

  // Filter tab
  function filterTab(tab, btn) {
    currentTab = tab;
    document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    renderStaffCards();
  }

  // Event listeners untuk search & filter role
  document.getElementById("searchStaff")?.addEventListener("input", function(e) {
    searchKeyword = e.target.value;
    renderStaffCards();
  });
  document.getElementById("roleFilter")?.addEventListener("change", function(e) {
    roleFilterValue = e.target.value;
    renderStaffCards();
  });

  // Tambah staff baru
  document.getElementById("createStaffBtn")?.addEventListener("click", () => {
    const name = document.getElementById("newName").value.trim();
    const email = document.getElementById("newEmail").value.trim();
    const role = document.getElementById("newRole").value;
    const status = document.getElementById("newStatus").value;
    if (!name || !email) {
      alert("Nama dan email harus diisi.");
      return;
    }
    const newId = Date.now();
    staffData.push({ id: newId, name, role, email, status });
    renderStaffCards();
    updateTabCounts();
    // reset form
    document.getElementById("newName").value = "";
    document.getElementById("newEmail").value = "";
    // tetap di tab yang aktif
    filterTab(currentTab, document.querySelector(`.tab-btn[data-tab="${currentTab}"]`));
    alert(`Staff ${name} berhasil ditambahkan.`);
  });

  // Sidebar toggle (sama persis dengan manajemen diskon)
  const sidebar = document.getElementById('sidebar');
  const overlay = document.getElementById('overlay');
  const menuBtn = document.getElementById('global-menu-toggle');

  function openSidebar()  { sidebar.classList.add('sidebar-open'); overlay.classList.add('show'); document.body.style.overflow='hidden'; }
  function closeSidebar() { sidebar.classList.remove('sidebar-open'); overlay.classList.remove('show'); document.body.style.overflow=''; }
  function toggleSidebar() { sidebar.classList.contains('sidebar-open') ? closeSidebar() : openSidebar(); }

  if (menuBtn) menuBtn.addEventListener('click', e => { e.stopPropagation(); toggleSidebar(); });
  if (overlay)  overlay.addEventListener('click', closeSidebar);
  document.addEventListener('keydown', e => { if (e.key==='Escape') closeSidebar(); });

  // Inisialisasi awal
  updateTabCounts();
  renderStaffCards();
</script>
</body>
</html>