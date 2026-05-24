<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Manajemen Kategori | Kashy</title>
<script src="https://cdn.tailwindcss.com"></script>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<script>
  tailwind.config = {
    theme: {
      extend: {
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
        fontFamily: { poppins: ['Poppins','sans-serif'] },
        boxShadow: {
          card: '0 2px 18px 0 rgba(60,40,10,.07)',
          btn:  '0 4px 14px 0 rgba(196,154,108,.35)',
        }
      }
    }
  }
</script>
<style>
  * { box-sizing:border-box; margin:0; padding:0; }
  body { font-family:'Poppins',sans-serif; background:#F5F0EB; }

  /* ── Sidebar ── */
  #sidebar {
    position:fixed; top:0; left:0; height:100vh; width:280px;
    background:#fff; box-shadow:2px 0 24px rgba(60,40,10,.12);
    z-index:60; transition:transform .3s cubic-bezier(0.2,0.9,0.4,1.1);
    display:flex; flex-direction:column; overflow-y:auto;
    transform:translateX(-100%);
  }
  #sidebar.sidebar-open { transform:translateX(0); }
  #overlay {
    display:none; position:fixed; inset:0;
    background:rgba(0,0,0,.45); z-index:55; backdrop-filter:blur(3px);
  }
  #overlay.show { display:block; }

  /* ── Animations ── */
  @keyframes fadeUp {
    from { opacity:0; transform:translateY(18px); }
    to   { opacity:1; transform:translateY(0); }
  }
  .fade-up { animation:fadeUp .4s ease both; }
  .d1{animation-delay:.05s} .d2{animation-delay:.10s}
  .d3{animation-delay:.15s} .d4{animation-delay:.20s}
  .d5{animation-delay:.25s}

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

  /* ── Category card image ── */
  .cat-img {
    width:100%; height:160px; object-fit:cover;
    display:block;
  }
  .cat-img-placeholder {
    width:100%; height:160px; background:#F5F0EB;
    display:flex; align-items:center; justify-content:center;
  }

  /* ── Dashed add card ── */
  .add-card {
    border:2px dashed #E0D8CE; border-radius:16px;
    padding:36px 20px; display:flex; flex-direction:column;
    align-items:center; gap:8px; cursor:pointer;
    transition:border-color .2s, background .2s;
  }
  .add-card:hover { border-color:#C49A6C; background:#fff; }

  /* ── Modal bottom sheet ── */
  .modal-overlay {
    display:none; position:fixed; inset:0; z-index:200;
    align-items:flex-end; justify-content:center;
  }
  .modal-overlay.show { display:flex; }
  .modal-backdrop {
    position:absolute; inset:0; background:rgba(0,0,0,.45);
    backdrop-filter:blur(3px);
  }
  .modal-sheet {
    position:relative; background:#fff; border-radius:24px 24px 0 0;
    width:100%; max-width:480px; padding:24px 24px 36px; z-index:10;
    animation:slideUp .3s cubic-bezier(0.2,0.9,0.4,1.1);
  }
  @keyframes slideUp {
    from { transform:translateY(100%); }
    to   { transform:translateY(0); }
  }
  .modal-handle {
    width:40px; height:4px; background:#E0D8CE;
    border-radius:99px; margin:0 auto 20px;
  }

  /* ── Form ── */
  .form-label {
    font-size:11px; font-weight:700; color:#8A7968;
    text-transform:uppercase; letter-spacing:.07em;
    margin-bottom:6px; display:block;
  }
  .form-input {
    width:100%; padding:12px 14px; border:1.5px solid #E0D8CE;
    border-radius:12px; font-size:13px; font-family:'Poppins',sans-serif;
    color:#1a1a1a; background:#FAF6F2; outline:none;
    transition:border-color .2s;
  }
  .form-input:focus { border-color:#C49A6C; background:#fff; }
  .form-input::placeholder { color:#BFB4AC; }

  /* ── Toast ── */
  #toast {
    position:fixed; bottom:24px; left:50%; transform:translateX(-50%) translateY(0);
    background:#1a1a1a; color:#fff; font-size:12px; font-weight:500;
    padding:12px 20px; border-radius:12px;
    display:flex; align-items:center; gap:8px;
    opacity:0; pointer-events:none;
    transition:opacity .3s, transform .3s; z-index:300;
  }
  #toast.show { opacity:1; transform:translateX(-50%) translateY(-8px); }

  /* ── Table ── */
  .log-table { width:100%; border-collapse:collapse; }
  .log-table thead th {
    font-size:11px; font-weight:700; color:#8A7968;
    padding:10px 16px; text-align:left;
    border-bottom:1.5px solid #E0D8CE;
  }
  .log-table tbody tr { border-bottom:1px solid #E0D8CE; }
  .log-table tbody tr:last-child { border-bottom:none; }
  .log-table tbody td {
    padding:12px 16px; font-size:12px; color:#1a1a1a;
  }

  /* ── Scrollbar ── */
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
      <h1 class="text-3xl font-extrabold text-kashy-dark">Manajemen Kategori</h1>
      <p class="text-sm text-kashy-muted mt-1">Susun dan tata katalog produk koleksi Anda dengan tepat dan elegan.</p>
    </div>

    <!-- ── Tombol Tambah ── -->
    <div class="fade-up d2 mb-5">
      <button
        onclick="openModal()"
        class="w-full flex items-center justify-center gap-2 py-4 rounded-2xl font-bold text-sm tracking-widest text-white uppercase transition-all hover:opacity-90 active:scale-[.98]"
        style="background:#C49A6C; box-shadow:0 4px 14px 0 rgba(196,154,108,.35);">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
          <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
        </svg>
        Tambah Kategori
      </button>
    </div>

    <!-- ── Daftar Kategori ── -->
    <div class="flex flex-col gap-4 fade-up d3" id="kategoriList">

      <!-- Card: Hoodie -->
      <div class="bg-white rounded-2xl overflow-hidden" style="box-shadow:0 2px 18px 0 rgba(60,40,10,.07);">
        <img src="https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=600&q=80" class="cat-img" alt="Hoodie"/>
        <div class="flex items-center justify-between px-4 py-3">
          <div>
            <p class="text-sm font-bold text-kashy-dark">Hoodie</p>
            <p class="text-xs text-kashy-muted">42 Item Premium</p>
          </div>
          <div class="flex items-center gap-3">
            <button onclick="openEditModal(this)" class="text-kashy-muted hover:text-kashy-dark transition-colors">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
            </button>
            <button onclick="hapusKategori(this)" class="text-kashy-muted hover:text-red-500 transition-colors">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4h6v2"/></svg>
            </button>
          </div>
        </div>
      </div>

      <!-- Card: Jeans Pria -->
      <div class="bg-white rounded-2xl overflow-hidden" style="box-shadow:0 2px 18px 0 rgba(60,40,10,.07);">
        <img src="https://images.unsplash.com/photo-1541099649105-f69ad21f3246?w=600&q=80" class="cat-img" alt="Jeans Pria"/>
        <div class="flex items-center justify-between px-4 py-3">
          <div>
            <p class="text-sm font-bold text-kashy-dark">Jeans Pria</p>
            <p class="text-xs text-kashy-muted">128 Item Dikurasi</p>
          </div>
          <div class="flex items-center gap-3">
            <button onclick="openEditModal(this)" class="text-kashy-muted hover:text-kashy-dark transition-colors">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
            </button>
            <button onclick="hapusKategori(this)" class="text-kashy-muted hover:text-red-500 transition-colors">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4h6v2"/></svg>
            </button>
          </div>
        </div>
      </div>

      <!-- Card: Rok Wanita -->
      <div class="bg-white rounded-2xl overflow-hidden" style="box-shadow:0 2px 18px 0 rgba(60,40,10,.07);">
        <img src="https://images.unsplash.com/photo-1583496661160-fb5218afa9a3?w=600&q=80" class="cat-img" alt="Rok Wanita"/>
        <div class="flex items-center justify-between px-4 py-3">
          <div>
            <p class="text-sm font-bold text-kashy-dark">Rok Wanita</p>
            <p class="text-xs text-kashy-muted">24 Gaya Muslimah</p>
          </div>
          <div class="flex items-center gap-3">
            <button onclick="openEditModal(this)" class="text-kashy-muted hover:text-kashy-dark transition-colors">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
            </button>
            <button onclick="hapusKategori(this)" class="text-kashy-muted hover:text-red-500 transition-colors">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4h6v2"/></svg>
            </button>
          </div>
        </div>
      </div>

    </div>

    <!-- ── Add card (dashed) ── -->
    <div class="add-card mt-4 fade-up d4" onclick="openModal()">
      <div class="w-10 h-10 rounded-full border-2 border-kashy-border flex items-center justify-center">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#8A7968" stroke-width="2.5">
          <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
        </svg>
      </div>
      <p class="text-sm font-semibold text-kashy-brown">Kategori Baru</p>
      <p class="text-xs text-kashy-muted">Klik untuk menambah katalog</p>
    </div>

    <!-- ── Log Aktivitas ── -->
    <div class="fade-up d5 mt-8 mb-6">
      <h2 class="text-base font-bold text-kashy-dark mb-3">Log Aktivitas Terbaru</h2>
      <div class="bg-white rounded-2xl overflow-hidden" style="box-shadow:0 2px 18px 0 rgba(60,40,10,.07);">
        <table class="log-table">
          <thead>
            <tr>
              <th>Aktivitas</th>
              <th>Kategori</th>
              <th>Waktu</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="font-semibold">Kategori Diperbarui</td>
              <td class="text-kashy-muted">Hoodie</td>
              <td class="text-kashy-muted">April 24, 2026<br/>10:45 AM</td>
            </tr>
            <tr>
              <td class="font-semibold">Kategori Baru Ditambahkan</td>
              <td class="text-kashy-muted">Jeans Pria</td>
              <td class="text-kashy-muted">Mei 11, 2026<br/>10:59 AM</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

  </div>
</main>

<!-- ══ MODAL TAMBAH / EDIT KATEGORI ══ -->
<div class="modal-overlay" id="modalTambah">
  <div class="modal-backdrop" onclick="closeModal()"></div>
  <div class="modal-sheet">
    <div class="modal-handle"></div>
    <h3 class="text-base font-bold text-kashy-dark mb-4" id="modalTitle">Tambah Kategori</h3>
    <input type="hidden" id="editTarget"/>
    <div class="flex flex-col gap-3">
      <div>
        <label class="form-label">Nama Kategori</label>
        <input type="text" id="inputNama" class="form-input" placeholder="cth: Kemeja Batik"/>
      </div>
      <div>
        <label class="form-label">Deskripsi</label>
        <input type="text" id="inputDesc" class="form-input" placeholder="cth: 12 Item Premium"/>
      </div>
    </div>
    <div class="flex gap-3 mt-5">
      <button
        onclick="closeModal()"
        class="flex-1 py-3 rounded-xl font-semibold text-sm text-kashy-muted border-2 border-kashy-border hover:bg-kashy-cream transition-colors">
        Batal
      </button>
      <button
        onclick="simpanKategori()"
        class="flex-1 py-3 rounded-xl font-bold text-sm text-white transition-all hover:opacity-90"
        style="background:#C49A6C;">
        Simpan
      </button>
    </div>
  </div>
</div>

<!-- ══ TOAST ══ -->
<div id="toast">
  <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#C49A6C" stroke-width="2.5">
    <polyline points="20 6 9 17 4 12"/>
  </svg>
  <span id="toastMsg">Berhasil!</span>
</div>

<script>
  /* ── Sidebar ── */
  const sidebar = document.getElementById('sidebar');
  const overlay = document.getElementById('overlay');
  const menuBtn = document.getElementById('global-menu-toggle');

  function openSidebar()  { sidebar.classList.add('sidebar-open'); overlay.classList.add('show'); document.body.style.overflow='hidden'; }
  function closeSidebar() { sidebar.classList.remove('sidebar-open'); overlay.classList.remove('show'); document.body.style.overflow=''; }

  if (menuBtn) menuBtn.addEventListener('click', e => { e.stopPropagation(); openSidebar(); });
  if (overlay) overlay.addEventListener('click', closeSidebar);
  document.addEventListener('keydown', e => { if (e.key==='Escape') { closeSidebar(); closeModal(); } });

  /* ── Modal state ── */
  let editCardEl = null; // simpan referensi card yang diedit

  function openModal() {
    editCardEl = null;
    document.getElementById('modalTitle').textContent = 'Tambah Kategori';
    document.getElementById('inputNama').value = '';
    document.getElementById('inputDesc').value = '';
    document.getElementById('modalTambah').classList.add('show');
  }

  function openEditModal(btn) {
    const card = btn.closest('.bg-white.rounded-2xl');
    editCardEl = card;
    const nama = card.querySelector('.text-sm.font-bold').textContent;
    const desc = card.querySelector('.text-xs.text-kashy-muted').textContent;
    document.getElementById('modalTitle').textContent = 'Edit Kategori';
    document.getElementById('inputNama').value = nama;
    document.getElementById('inputDesc').value = desc;
    document.getElementById('modalTambah').classList.add('show');
  }

  function closeModal() {
    document.getElementById('modalTambah').classList.remove('show');
    editCardEl = null;
  }

  function simpanKategori() {
    const nama = document.getElementById('inputNama').value.trim();
    const desc = document.getElementById('inputDesc').value.trim();
    if (!nama) { document.getElementById('inputNama').focus(); return; }

    if (editCardEl) {
      // Mode edit — update teks di card yang ada
      editCardEl.querySelector('.text-sm.font-bold').textContent = nama;
      editCardEl.querySelector('.text-xs.text-kashy-muted').textContent = desc || '0 Item';
      closeModal();
      showToast('Kategori berhasil diperbarui!');
    } else {
      // Mode tambah — buat card baru
      const card = document.createElement('div');
      card.className = 'bg-white rounded-2xl overflow-hidden';
      card.style.boxShadow = '0 2px 18px 0 rgba(60,40,10,.07)';
      card.innerHTML = `
        <div class="cat-img-placeholder">
          <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="#E0D8CE" stroke-width="1.5">
            <rect x="3" y="3" width="18" height="18" rx="2"/>
            <path d="m3 9 4-4 4 4 4-4 4 4"/><path d="M3 14h18"/>
          </svg>
        </div>
        <div class="flex items-center justify-between px-4 py-3">
          <div>
            <p class="text-sm font-bold text-kashy-dark">${nama}</p>
            <p class="text-xs text-kashy-muted">${desc || '0 Item'}</p>
          </div>
          <div class="flex items-center gap-3">
            <button onclick="openEditModal(this)" class="text-kashy-muted hover:text-kashy-dark transition-colors">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
            </button>
            <button onclick="hapusKategori(this)" class="text-kashy-muted hover:text-red-500 transition-colors">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4h6v2"/></svg>
            </button>
          </div>
        </div>`;
      document.getElementById('kategoriList').appendChild(card);
      closeModal();
      showToast('Kategori berhasil ditambahkan!');
    }
  }

  function hapusKategori(btn) {
    if (!confirm('Hapus kategori ini?')) return;
    btn.closest('.bg-white.rounded-2xl').remove();
    showToast('Kategori dihapus.');
  }

  /* ── Toast ── */
  let toastTimer;
  function showToast(msg) {
    const toast = document.getElementById('toast');
    document.getElementById('toastMsg').textContent = msg;
    toast.classList.add('show');
    clearTimeout(toastTimer);
    toastTimer = setTimeout(() => toast.classList.remove('show'), 2500);
  }
</script>
</body>
</html>