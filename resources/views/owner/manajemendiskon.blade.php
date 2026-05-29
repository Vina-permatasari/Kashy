<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover"/>
  <title>Kashy – Manajemen Diskon</title>
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

    /* Sidebar */
    #sidebar { position:fixed; top:0; left:0; height:100vh; width:280px; background:#fff; box-shadow:2px 0 24px rgba(60,40,10,.12); z-index:60; transition:transform .3s cubic-bezier(0.2,0.9,0.4,1.1); display:flex; flex-direction:column; overflow-y:auto; transform:translateX(-100%); }
    #sidebar.sidebar-open { transform:translateX(0); }
    #overlay { display:none; position:fixed; inset:0; background:rgba(0,0,0,.45); z-index:55; backdrop-filter:blur(3px); }
    #overlay.show { display:block; }
    
    @keyframes fadeUp { from { opacity:0; transform:translateY(18px); } to { opacity:1; transform:translateY(0); } }
    .fade-up { animation:fadeUp .4s ease both; }
    .d1{animation-delay:.05s} .d2{animation-delay:.10s}
    .d3{animation-delay:.15s} .d4{animation-delay:.20s}
    .d5{animation-delay:.25s} .d6{animation-delay:.30s}
    
    .nav-item { display:flex; align-items:center; gap:12px; padding:11px 18px; border-radius:12px; cursor:pointer; transition:all .15s; font-size:14px; font-weight:500; color:#1a1a1a; text-decoration:none; width:100%; }
    .nav-item:hover { background:#F5F0EB; }
    .nav-item.active { background:#F7EFE5; color:#7B4F2E; font-weight:600; }
    .nav-item.active svg { stroke:#7B4F2E; }
    
    .tab-btn { padding:10px 4px; font-size:13px; font-weight:600; color:#8A7968; border-bottom:2px solid transparent; cursor:pointer; transition:all .2s; background:none; }
    .tab-btn.active { color:#1a1a1a; border-bottom-color:#C49A6C; }
    
    .promo-img-wrap { width:100%; height:160px; border-radius:14px; overflow:hidden; position:relative; margin-bottom:12px; }
    .promo-img-wrap img { width:100%; height:100%; object-fit:cover; }
    .promo-badge { position:absolute; top:10px; right:10px; font-size:10px; font-weight:700; letter-spacing:.05em; padding:3px 10px; border-radius:20px; }
    
    .chip { display:inline-flex; align-items:center; gap:5px; padding:5px 12px; border-radius:8px; font-size:12px; font-weight:600; background:#F5F0EB; color:#8A7968; border:1.5px solid #E0D8CE; }
    .chip-terra { background:#FDF1E8; color:#C49A6C; border-color:#C49A6C; }
    .chip-remove { background:none; border:none; cursor:pointer; color:#8A7968; font-size:14px; line-height:1; padding:0; margin-left:4px; }
    
    .form-input { width:100%; padding:12px 14px; border:1.5px solid #E0D8CE; border-radius:12px; font-size:13px; font-family:'Poppins',sans-serif; color:#1a1a1a; background:#FAF6F2; outline:none; transition:border-color .2s; }
    .form-input:focus { border-color:#C49A6C; background:#fff; }
    .form-select { appearance:none; background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%238A7968' stroke-width='2'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E"); background-repeat:no-repeat; background-position:right 12px center; padding-right:36px; cursor:pointer; }
    .form-label { font-size:11px; font-weight:700; color:#8A7968; text-transform:uppercase; letter-spacing:.07em; margin-bottom:6px; display:block; }
    
    .img-dropzone { width:100%; border:2px dashed #E0D8CE; border-radius:14px; padding:28px 20px; text-align:center; cursor:pointer; transition:border-color .2s, background .2s; background:#FAF6F2; position:relative; overflow:hidden; }
    .img-dropzone:hover { border-color:#C49A6C; background:#FDF9F5; }
    .img-dropzone.has-image { border-color:#C49A6C; padding:0; height:180px; }
    .img-dropzone.has-image img { width:100%; height:100%; object-fit:cover; border-radius:12px; display:block; }
    .img-dropzone.has-image .dropzone-overlay { position:absolute; inset:0; background:rgba(0,0,0,.35); display:flex; align-items:center; justify-content:center; border-radius:12px; opacity:0; transition:opacity .2s; }
    .img-dropzone.has-image:hover .dropzone-overlay { opacity:1; }
    
    .modal-fixed { position: fixed; top:0; left:0; width:100%; height:100%; background: rgba(0,0,0,0.5); backdrop-filter: blur(4px); z-index: 1000; display: flex; align-items: center; justify-content: center; visibility: hidden; opacity: 0; transition: visibility 0.2s, opacity 0.2s; }
    .modal-fixed.show { visibility: visible; opacity: 1; }
    .modal-card { background: white; max-width: 580px; width: 90%; max-height: 90vh; overflow-y: auto; border-radius: 28px; padding: 24px; transform: scale(0.95); transition: transform 0.2s; }
    .modal-fixed.show .modal-card { transform: scale(1); }
    
    .modal-confirm { position: fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); backdrop-filter:blur(4px); z-index:2000; display:flex; align-items:center; justify-content:center; visibility:hidden; opacity:0; transition:visibility 0.2s, opacity 0.2s; }
    .modal-confirm.show { visibility:visible; opacity:1; }
    .modal-confirm .modal-card { background:white; max-width:380px; width:90%; border-radius:28px; padding:24px; text-align:center; transform:scale(0.95); transition:transform 0.2s; }
    .modal-confirm.show .modal-card { transform:scale(1); }
    .modal-icon { width:64px; height:64px; border-radius:60px; display:flex; align-items:center; justify-content:center; margin:0 auto 16px; }
    .modal-icon-success { background:#E8F5EA; }
    .modal-icon-success svg { stroke:#3A9E6F; }
    .modal-icon-danger { background:#FEF2F2; }
    .modal-icon-danger svg { stroke:#D94F4F; }
    .modal-title { font-size:20px; font-weight:800; color:#1a1a1a; margin-bottom:12px; }
    .modal-message { font-size:14px; color:#6B5E52; margin-bottom:24px; line-height:1.5; }
    .modal-buttons { display:flex; gap:12px; }
    .modal-btn { flex:1; padding:12px; border-radius:40px; font-weight:700; font-size:14px; cursor:pointer; transition:all 0.2s; border:none; }
    .modal-btn-cancel { background:#F5F0EB; color:#1a1a1a; }
    .modal-btn-cancel:hover { background:#EDE5DB; transform:scale(0.97); }
    .modal-btn-confirm-success { background:#3A9E6F; color:white; box-shadow:0 4px 10px rgba(58,158,111,0.3); }
    .modal-btn-confirm-success:hover { background:#2e7d57; transform:scale(0.97); }
    .modal-btn-confirm-danger { background:#D94F4F; color:white; box-shadow:0 4px 10px rgba(217,79,79,0.3); }
    .modal-btn-confirm-danger:hover { background:#b53b3b; transform:scale(0.97); }
    
    #toast { position:fixed; bottom:2rem; left:50%; transform:translateX(-50%) translateY(12px); background:#1c1c1c; color:white; font-size:0.875rem; font-weight:500; padding:0.75rem 1.25rem; border-radius:9999px; display:flex; align-items:center; gap:0.5rem; z-index:9999; opacity:0; transition:opacity 0.25s, transform 0.3s; pointer-events:none; }
    #toast.show { opacity:1; transform:translateX(-50%) translateY(0); }
    
    ::-webkit-scrollbar { width:4px; }
    ::-webkit-scrollbar-track { background:transparent; }
    ::-webkit-scrollbar-thumb { background:#C49A6C; border-radius:10px; }
  </style>
</head>

@include('owner.components.sidebar')

<body>
<main id="main" class="min-h-screen bg-kashy-cream">
  @include('owner.components.topbar')

  <!-- Container utama: konsisten dengan Laporan Keuangan (max-w-2xl, px-5 md:px-8, py-6) -->
  <div class="px-5 md:px-8 py-6 max-w-2xl mx-auto">
    
    <div class="fade-up d1 mb-5">
      <h1 class="text-3xl font-extrabold text-kashy-dark">Manajemen Diskon</h1>
      <p class="text-sm text-kashy-muted mt-1">Kelola diskon produk koleksi anda.</p>
    </div>

    <div class="fade-up d2 mb-5">
      <button onclick="openDiskonModal()" class="w-full flex items-center justify-center gap-2 py-4 rounded-2xl font-bold text-sm tracking-widest text-white uppercase transition-all duration-200 hover:opacity-90 active:scale-[.98]" style="background:#C49A6C; box-shadow:0 4px 14px 0 rgba(196,154,108,.35);">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
        Tambah Diskon Baru
      </button>
    </div>

    <div class="fade-up d2 flex gap-6 border-b border-kashy-border mb-5">
      <button class="tab-btn active" onclick="switchTab('aktif', this)">Diskon Aktif <span id="badgeAktif">(3)</span></button>
      <button class="tab-btn" onclick="switchTab('nonaktif', this)">Diskon Tidak Aktif <span id="badgeNonaktif">(0)</span></button>
    </div>

    <div id="tab-aktif" class="flex flex-col gap-4"></div>
    <div id="tab-nonaktif" class="hidden flex flex-col gap-4"></div>

  </div>
</main>

<!-- MODAL TAMBAH/EDIT DISKON -->
<div id="diskonModal" class="modal-fixed">
  <div class="modal-card">
    <h2 id="modalTitle" class="text-xl font-bold text-kashy-dark mb-5">Tambah Diskon</h2>
    <input type="hidden" id="editId" value="">
    <div class="mb-4">
      <label class="form-label">Gambar Promosi <span class="normal-case font-normal">(opsional)</span></label>
      <div class="img-dropzone" id="modalImgDropzone" onclick="document.getElementById('modalImgInput').click()">
        <input type="file" id="modalImgInput" accept="image/*" class="hidden" onchange="previewModalImage(this)"/>
        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#C49A6C" stroke-width="1.6" class="mx-auto mb-2"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
        <p class="text-sm font-semibold text-kashy-muted">Pilih atau seret gambar</p>
        <p class="text-xs text-kashy-muted mt-1">JPG, PNG — maks 5MB</p>
      </div>
    </div>
    <div class="mb-4">
      <label class="form-label">Nama Promosi</label>
      <input type="text" id="modalNama" class="form-input" placeholder="nama promosi..."/>
    </div>
    <div class="grid grid-cols-2 gap-3 mb-4">
      <div><label class="form-label">Tipe</label><select id="modalTipe" class="form-input form-select"><option>Persentase</option><option>Nominal</option><option>Kategori</option></select></div>
      <div><label class="form-label">Nilai</label><input type="text" id="modalNilai" class="form-input" placeholder="20%"/></div>
    </div>
    <div class="mb-4">
      <div class="grid grid-cols-2 gap-3">
        <div><label class="form-label">Mulai dari</label><input type="date" id="modalMulai" class="form-input"/></div>
        <div><label class="form-label">Berakhir</label><input type="date" id="modalAkhir" class="form-input"/></div>
      </div>
    </div>
    <div class="mb-6">
      <label class="form-label">Berlaku Untuk</label>
      <div class="flex flex-wrap gap-2 mb-3" id="modalTagContainer">
        <span class="chip chip-terra">Semua Produk<button class="chip-remove" onclick="removeModalTag(this)">×</button></span>
      </div>
      <div style="position:relative;">
        <span style="position:absolute;left:12px;top:50%;transform:translateY(-50%);"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#8A7968" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg></span>
        <input type="text" id="modalTagInput" class="form-input" style="padding-left:36px;" placeholder="Cari & tambah kategori (Enter)..." onkeydown="addModalTag(event)"/>
      </div>
    </div>
    <div class="flex flex-col gap-2">
      <button type="button" onclick="saveDiskon()" class="w-full py-4 rounded-2xl font-bold text-sm text-white transition-all hover:opacity-90 active:scale-[.98]" style="background:#C49A6C; box-shadow:0 4px 14px 0 rgba(196,154,108,.35);">Simpan Diskon</button>
      <button type="button" onclick="closeDiskonModal()" class="w-full py-4 rounded-2xl font-bold text-sm text-kashy-muted border-2 border-kashy-border bg-white hover:bg-kashy-cream transition-all active:scale-[.98]">Batal</button>
    </div>
  </div>
</div>

<!-- MODAL KONFIRMASI DINAMIS -->
<div id="confirmModal" class="modal-confirm">
  <div class="modal-card">
    <div class="modal-icon" id="modalIcon"></div>
    <div class="modal-title" id="modalTitle">Konfirmasi Tindakan</div>
    <div class="modal-message" id="modalMessage"></div>
    <div class="modal-buttons">
      <button id="modalCancelBtn" class="modal-btn modal-btn-cancel">Batal</button>
      <button id="modalConfirmBtn" class="modal-btn">Ya, Lanjutkan</button>
    </div>
  </div>
</div>

<!-- Toast -->
<div id="toast"><span id="toastMsg"></span></div>

<script>
  /* ========= DATA DISKON ========= */
  let discounts = [
    { id:1, name:"Promo Cuci Gudang", type:"Persentase", value:"50%", start:"2025-06-01", end:"2025-06-30", tags:["Semua Produk"], image:"https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=600&q=80", active:true },
    { id:2, name:"Selamat Datang!", type:"Nominal", value:"75%", start:"2025-05-01", end:"2025-05-31", tags:["FirstBuy"], image:"", active:true },
    { id:3, name:"Kemeja Putih", type:"Kategori", value:"15%", start:"2025-06-10", end:"2025-06-20", tags:["Kemeja"], image:"", active:true },
    { id:4, name:"Diskon Lebaran", type:"Persentase", value:"30%", start:"2025-04-01", end:"2025-04-10", tags:["Semua Produk"], image:"", active:false },
    { id:5, name:"Hari Belanja Online", type:"Nominal", value:"Rp50.000", start:"2025-03-01", end:"2025-03-05", tags:["Online"], image:"", active:false }
  ];

  function renderActive() {
    const activeList = discounts.filter(d => d.active);
    const container = document.getElementById('tab-aktif');
    if (!container) return;
    container.innerHTML = '';
    activeList.forEach(d => {
      container.innerHTML += `
        <div class="fade-up d3 bg-white rounded-2xl overflow-hidden shadow-card" data-id="${d.id}">
          <div class="promo-img-wrap">
            <img src="${d.image || 'https://via.placeholder.com/400x160?text=No+Image'}" alt="${d.name}"/>
            <span class="promo-badge" style="background:#EBF5EF; color:#3A9E6F;">Aktif</span>
          </div>
          <div class="p-4">
            <h3 class="text-lg font-bold text-kashy-dark mb-1">${escapeHtml(d.name)}</h3>
            <p class="text-sm text-kashy-muted mb-3">${d.type} ${d.value} - berlaku untuk ${d.tags.join(', ')}</p>
            <div class="flex gap-6 mb-3">
              <div><p class="text-[10px] font-semibold text-kashy-muted uppercase">Diskon</p><p class="text-base font-bold text-kashy-brown">${d.value}</p></div>
              <div><p class="text-[10px] font-semibold text-kashy-muted uppercase">Berakhir</p><p class="text-base font-bold text-kashy-dark">${new Date(d.end).toLocaleDateString('id-ID')}</p></div>
            </div>
            <div class="flex items-center gap-4 pt-3 border-t border-kashy-border">
              <button class="flex items-center gap-1.5 text-sm font-semibold text-kashy-muted hover:text-kashy-dark transition-colors" onclick="editDiskon(${d.id})">Edit</button>
              <button class="flex items-center gap-1.5 text-sm font-semibold text-red-600 hover:text-red-700 transition-colors" onclick="akhiriPromo(${d.id})">Akhiri</button>
            </div>
          </div>
        </div>
      `;
    });
    document.getElementById('badgeAktif').innerText = `(${activeList.length})`;
  }

  function renderInactive() {
    const inactiveList = discounts.filter(d => !d.active);
    const container = document.getElementById('tab-nonaktif');
    if (!container) return;
    container.innerHTML = '';
    inactiveList.forEach(d => {
      container.innerHTML += `
        <div class="fade-up d3 bg-white rounded-2xl overflow-hidden shadow-card opacity-75" data-id="${d.id}">
          <div class="promo-img-wrap">
            <img src="${d.image || 'https://via.placeholder.com/400x160?text=No+Image'}" alt="${d.name}"/>
            <span class="promo-badge" style="background:#FEF2F2; color:#D94F4F;">Nonaktif</span>
          </div>
          <div class="p-4">
            <h3 class="text-lg font-bold text-kashy-dark mb-1">${escapeHtml(d.name)}</h3>
            <p class="text-sm text-kashy-muted mb-3">${d.type} ${d.value} - berlaku ${d.tags.join(', ')}</p>
            <div class="flex gap-6 mb-3">
              <div><p class="text-[10px] font-semibold text-kashy-muted uppercase">Diskon</p><p class="text-base font-bold">${d.value}</p></div>
              <div><p class="text-[10px] font-semibold text-kashy-muted uppercase">Berakhir</p><p class="text-base font-bold">${new Date(d.end).toLocaleDateString('id-ID')}</p></div>
            </div>
            <div class="flex items-center gap-4 pt-3 border-t border-kashy-border">
              <button class="flex items-center gap-1.5 text-sm font-semibold text-green-600 hover:text-green-700 transition-colors" onclick="aktifkanPromo(${d.id})">Aktifkan</button>
            </div>
          </div>
        </div>
      `;
    });
    document.getElementById('badgeNonaktif').innerText = `(${inactiveList.length})`;
  }

  function escapeHtml(str) { return str.replace(/[&<>]/g, function(m){if(m==='&') return '&amp;'; if(m==='<') return '&lt;'; if(m==='>') return '&gt;'; return m;}); }

  /* ========= MODAL KONFIRMASI ========= */
  function showConfirmDialog(message, type = 'success', confirmText = 'Ya, Lanjutkan') {
    return new Promise((resolve) => {
      const modal = document.getElementById("confirmModal");
      const modalIcon = document.getElementById("modalIcon");
      const modalTitle = document.getElementById("modalTitle");
      const modalMessage = document.getElementById("modalMessage");
      const confirmBtn = document.getElementById("modalConfirmBtn");

      modalMessage.innerText = message;
      modalTitle.innerText = 'Konfirmasi Tindakan';

      if (type === 'danger') {
        modalIcon.className = 'modal-icon modal-icon-danger';
        modalIcon.innerHTML = `<svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><circle cx="12" cy="12" r="10"/><path d="M12 7V13"/><path d="M12 17H12.01"/></svg>`;
        confirmBtn.className = 'modal-btn modal-btn-confirm-danger';
        confirmBtn.innerText = confirmText || 'Ya, Lanjutkan';
      } else {
        modalIcon.className = 'modal-icon modal-icon-success';
        modalIcon.innerHTML = `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M20 6L9 17l-5-5"/></svg>`;
        confirmBtn.className = 'modal-btn modal-btn-confirm-success';
        confirmBtn.innerText = confirmText || 'Ya, Simpan';
      }

      modal.classList.add("show");
      const onConfirm = () => { modal.classList.remove("show"); cleanup(); resolve(true); };
      const onCancel = () => { modal.classList.remove("show"); cleanup(); resolve(false); };
      const cleanup = () => {
        confirmBtn.removeEventListener("click", onConfirm);
        document.getElementById("modalCancelBtn").removeEventListener("click", onCancel);
      };
      confirmBtn.addEventListener("click", onConfirm);
      document.getElementById("modalCancelBtn").addEventListener("click", onCancel);
    });
  }

  function showToast(msg, success=true) {
    const toast = document.getElementById('toast');
    document.getElementById('toastMsg').innerText = msg;
    toast.style.background = success ? '#1c1c1c' : '#ef4444';
    toast.classList.add('show');
    clearTimeout(toast._t);
    toast._t = setTimeout(() => toast.classList.remove('show'), 2600);
  }

  /* ========= AKHIRI & AKTIFKAN ========= */
  async function akhiriPromo(id) {
    const diskon = discounts.find(d => d.id === id);
    if (!diskon) return;
    const message = `Anda yakin ingin mengakhiri promosi "${diskon.name}"? Diskon akan dipindahkan ke tab Tidak Aktif.`;
    const confirmed = await showConfirmDialog(message, 'danger', 'Ya, Akhiri');
    if (confirmed) {
      const index = discounts.findIndex(d => d.id === id);
      if (index !== -1) {
        discounts[index].active = false;
        renderActive();
        renderInactive();
        showToast(`Promosi "${diskon.name}" telah diakhiri.`, true);
      }
    }
  }

  async function aktifkanPromo(id) {
    const diskon = discounts.find(d => d.id === id);
    if (!diskon) return;
    const message = `Anda yakin ingin mengaktifkan kembali promosi "${diskon.name}"?`;
    const confirmed = await showConfirmDialog(message, 'success', 'Ya, Aktifkan');
    if (confirmed) {
      const index = discounts.findIndex(d => d.id === id);
      if (index !== -1) {
        discounts[index].active = true;
        renderActive();
        renderInactive();
        showToast(`Promosi "${diskon.name}" berhasil diaktifkan.`, true);
      }
    }
  }

  /* ========= TAB SWITCH ========= */
  function switchTab(tab, btn) {
    document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    document.getElementById('tab-aktif').classList.toggle('hidden', tab !== 'aktif');
    document.getElementById('tab-nonaktif').classList.toggle('hidden', tab !== 'nonaktif');
    if (tab === 'nonaktif') renderInactive();
  }

  /* ========= MODAL DISKON ========= */
  function openDiskonModal(id = null) {
    const modal = document.getElementById('diskonModal');
    modal.classList.add('show');
    document.body.style.overflow = 'hidden';
    if (id) {
      const d = discounts.find(x => x.id === id);
      if (d) {
        document.getElementById('modalTitle').innerText = 'Edit Diskon';
        document.getElementById('editId').value = d.id;
        document.getElementById('modalNama').value = d.name;
        document.getElementById('modalTipe').value = d.type;
        document.getElementById('modalNilai').value = d.value;
        document.getElementById('modalMulai').value = d.start;
        document.getElementById('modalAkhir').value = d.end;
        const tagContainer = document.getElementById('modalTagContainer');
        tagContainer.innerHTML = '';
        d.tags.forEach(tag => {
          const chip = document.createElement('span');
          chip.className = 'chip';
          chip.innerHTML = `${escapeHtml(tag)}<button class="chip-remove" onclick="removeModalTag(this)">×</button>`;
          tagContainer.appendChild(chip);
        });
        if (d.image) setModalPreview(d.image);
        else resetModalDropzone();
      }
    } else {
      document.getElementById('modalTitle').innerText = 'Tambah Diskon';
      document.getElementById('editId').value = '';
      document.getElementById('modalNama').value = '';
      document.getElementById('modalTipe').value = 'Persentase';
      document.getElementById('modalNilai').value = '';
      document.getElementById('modalMulai').value = '';
      document.getElementById('modalAkhir').value = '';
      document.getElementById('modalTagContainer').innerHTML = `<span class="chip chip-terra">Semua Produk<button class="chip-remove" onclick="removeModalTag(this)">×</button></span>`;
      resetModalDropzone();
    }
  }

  function closeDiskonModal() {
    document.getElementById('diskonModal').classList.remove('show');
    document.body.style.overflow = '';
  }

  function previewModalImage(input) {
    if (!input.files || !input.files[0]) return;
    const reader = new FileReader();
    reader.onload = e => {
      const dz = document.getElementById('modalImgDropzone');
      dz.innerHTML = `<img src="${e.target.result}" alt="preview"/><div class="dropzone-overlay"><span class="text-white text-xs font-semibold bg-black/50 px-3 py-1.5 rounded-lg">Ganti Gambar</span></div><input type="file" id="modalImgInput" accept="image/*" class="hidden" onchange="previewModalImage(this)"/>`;
      dz.classList.add('has-image');
      dz.onclick = () => document.getElementById('modalImgInput').click();
    };
    reader.readAsDataURL(input.files[0]);
  }

  function setModalPreview(url) {
    const dz = document.getElementById('modalImgDropzone');
    dz.innerHTML = `<img src="${url}" alt="preview"/><div class="dropzone-overlay"><span class="text-white text-xs font-semibold bg-black/50 px-3 py-1.5 rounded-lg">Ganti Gambar</span></div><input type="file" id="modalImgInput" accept="image/*" class="hidden" onchange="previewModalImage(this)"/>`;
    dz.classList.add('has-image');
    dz.onclick = () => document.getElementById('modalImgInput').click();
  }

  function resetModalDropzone() {
    const dz = document.getElementById('modalImgDropzone');
    dz.classList.remove('has-image');
    dz.innerHTML = `<input type="file" id="modalImgInput" accept="image/*" class="hidden" onchange="previewModalImage(this)"/><svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#C49A6C" stroke-width="1.6" class="mx-auto mb-2"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg><p class="text-sm font-semibold text-kashy-muted">Pilih atau seret gambar</p><p class="text-xs text-kashy-muted mt-1">JPG, PNG — maks 5MB</p>`;
    dz.onclick = () => document.getElementById('modalImgInput').click();
  }

  function addModalTag(e) {
    if (e.key !== 'Enter') return;
    const val = e.target.value.trim();
    if (!val) return;
    const container = document.getElementById('modalTagContainer');
    const chip = document.createElement('span');
    chip.className = 'chip';
    chip.innerHTML = `${escapeHtml(val)}<button class="chip-remove" onclick="removeModalTag(this)">×</button>`;
    container.appendChild(chip);
    e.target.value = '';
  }
  function removeModalTag(btn) { btn.closest('.chip').remove(); }
  function getModalTags() { return Array.from(document.querySelectorAll('#modalTagContainer .chip')).map(ch => ch.innerText.replace('×','').trim()); }

  function saveDiskon() {
    const nama = document.getElementById('modalNama').value.trim();
    if (!nama) { showToast('Nama promosi harus diisi', false); return; }
    const id = document.getElementById('editId').value;
    let image = '';
    const fileInput = document.getElementById('modalImgInput');
    if (fileInput.files && fileInput.files[0]) image = URL.createObjectURL(fileInput.files[0]);
    else if (id) { const existing = discounts.find(d => d.id == id); if (existing && existing.image) image = existing.image; }
    const diskonData = {
      name: nama,
      type: document.getElementById('modalTipe').value,
      value: document.getElementById('modalNilai').value,
      start: document.getElementById('modalMulai').value,
      end: document.getElementById('modalAkhir').value,
      tags: getModalTags(),
      image: image,
      active: id ? (discounts.find(d => d.id == id)?.active ?? true) : true
    };
    if (id) {
      const index = discounts.findIndex(d => d.id == id);
      if (index !== -1) { diskonData.id = parseInt(id); discounts[index] = diskonData; showToast(`Diskon "${nama}" berhasil diperbarui!`, true); }
    } else {
      const newId = Date.now(); diskonData.id = newId; discounts.push(diskonData); showToast(`Diskon "${nama}" berhasil ditambahkan!`, true);
    }
    renderActive(); renderInactive(); closeDiskonModal();
  }

  function editDiskon(id) { openDiskonModal(id); }

  /* ========= SIDEBAR ========= */
  const sidebar = document.getElementById('sidebar');
  const overlay = document.getElementById('overlay');
  const menuBtn = document.getElementById('global-menu-toggle');
  function openSidebar() { sidebar.classList.add('sidebar-open'); overlay.classList.add('show'); document.body.style.overflow='hidden'; }
  function closeSidebar() { sidebar.classList.remove('sidebar-open'); overlay.classList.remove('show'); document.body.style.overflow=''; }
  if (menuBtn) menuBtn.addEventListener('click', e => { e.stopPropagation(); openSidebar(); });
  if (overlay) overlay.addEventListener('click', closeSidebar);
  document.addEventListener('keydown', e => { if (e.key==='Escape') closeSidebar(); });

  renderActive(); 
  renderInactive();
</script>
</body>
</html>