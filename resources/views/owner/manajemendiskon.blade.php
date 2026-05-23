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

    /* ── Sidebar ── */
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

    /* ── Promo card image ── */
    .promo-img-wrap {
      width:100%; height:160px; border-radius:14px; overflow:hidden;
      position:relative; margin-bottom:12px;
    }
    .promo-img-wrap img { width:100%; height:100%; object-fit:cover; }
    .promo-badge-aktif {
      position:absolute; top:10px; right:10px;
      background:#C49A6C; color:#fff;
      font-size:10px; font-weight:700; letter-spacing:.05em;
      padding:3px 10px; border-radius:20px;
    }

    /* ── Chip tags ── */
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
      padding:0; font-family:'Poppins',sans-serif;
    }

    /* ── Form input ── */
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

    /* ── Scrollbar ── */
    ::-webkit-scrollbar { width:4px; }
    ::-webkit-scrollbar-track { background:transparent; }
    ::-webkit-scrollbar-thumb { background:#C49A6C; border-radius:10px; }

    /* ── Module buttons ── */
    .mod-btn {
      display:flex; align-items:center; gap:12px; width:100%;
      background:rgba(255,255,255,.07); border:1px solid rgba(255,255,255,.12);
      border-radius:12px; padding:14px 16px; cursor:pointer;
      transition:background .18s,transform .12s;
      color:#fff; font-size:13.5px; font-weight:500;
    }
    .mod-btn:hover { background:rgba(255,255,255,.13); transform:translateX(3px); }
  </style>
</head>

@include('owner.components.sidebar')

<body>

<main id="main" class="min-h-screen bg-kashy-cream">
  @include('owner.components.topbar')

  <div class="px-5 md:px-8 py-6 max-w-2xl mx-auto">

    <!-- ── Header ── -->
    <div class="fade-up d1 mb-5">
      <h1 class="text-3xl font-extrabold text-kashy-dark">Manajemen Diskon</h1>
    </div>

    <!-- ── Create Promotion Button ── -->
    <div class="fade-up d2 mb-5">
      <button
        onclick="document.getElementById('formSection').scrollIntoView({behavior:'smooth'})"
        class="w-full flex items-center justify-center gap-2 py-4 rounded-2xl font-bold text-sm tracking-widest text-white uppercase transition-all duration-200 hover:opacity-90 active:scale-[.98]"
        style="background:#C49A6C; box-shadow:0 4px 14px 0 rgba(196,154,108,.35);">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
          <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
        </svg>
        Create Promotion
      </button>
    </div>

    <!-- ── Tabs Aktif / Terjadwal ── -->
    <div class="fade-up d2 flex gap-6 border-b border-kashy-border mb-5">
      <button class="tab-btn active" onclick="switchTab('aktif', this)">
        AKTIF <span class="text-kashy-brown">(12)</span>
      </button>
      <button class="tab-btn" onclick="switchTab('terjadwal', this)">
        Terjadwal <span class="text-kashy-muted">(4)</span>
      </button>
    </div>

    <!-- ══════════════════════════════
         TAB: AKTIF
         ══════════════════════════════ -->
    <div id="tab-aktif" class="flex flex-col gap-4">

      <!-- Promo Card 1 — dengan gambar -->
      <div class="fade-up d3 bg-white rounded-2xl p-4" style="box-shadow:0 2px 18px 0 rgba(60,40,10,.07);">
        <div class="promo-img-wrap">
          <!-- Placeholder gambar — ganti src dengan {{ asset('...') }} -->
          <img src="https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=600&q=80" alt="Promo Cuci Gudang"/>
          <span class="promo-badge-aktif">Aktif</span>
        </div>
        <h3 class="text-lg font-bold text-kashy-dark mb-1">Promo Cuci Gudang</h3>
        <p class="text-sm text-kashy-muted mb-3 leading-relaxed">
          Diskon universal 50% berlaku untuk seluruh koleksi kaos di SND Store
        </p>
        <div class="flex gap-6 mb-3">
          <div>
            <p class="text-[10px] font-semibold text-kashy-muted uppercase tracking-wider mb-1">Diskon</p>
            <p class="text-base font-bold text-kashy-brown">50% OFF</p>
          </div>
          <div>
            <p class="text-[10px] font-semibold text-kashy-muted uppercase tracking-wider mb-1">Berakhir</p>
            <p class="text-base font-bold text-kashy-dark">5 Hari</p>
          </div>
        </div>
        <div class="flex items-center gap-4 pt-3 border-t border-kashy-border">
          <button class="flex items-center gap-1.5 text-sm font-semibold text-kashy-muted hover:text-kashy-dark transition-colors">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
              <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
            </svg>
            Edit
          </button>
          <button class="flex items-center gap-1.5 text-sm font-semibold text-red-600 hover:text-red-700 transition-colors">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/>
              <path d="M10 11v6M14 11v6"/><path d="M9 6V4h6v2"/>
            </svg>
            Akhiri
          </button>
        </div>
      </div>

      <!-- Promo Card 2 — Nominal (tanpa gambar) -->
      <div class="fade-up d4 bg-white rounded-2xl p-4" style="box-shadow:0 2px 18px 0 rgba(60,40,10,.07);">
        <p class="text-[10px] font-semibold text-kashy-muted uppercase tracking-widest mb-1">Nominal</p>
        <h3 class="text-lg font-bold text-kashy-dark mb-1">Selamat Datang !</h3>
        <p class="text-sm text-kashy-muted mb-4 leading-relaxed">
          Diskon 75% untuk pelanggan yang pertama kali melakukan pembelian
        </p>
        <div class="flex items-center justify-between">
          <span class="chip">FirstBuy</span>
          <span class="text-base font-bold text-kashy-dark">1,240 Pelanggan</span>
        </div>
      </div>

      <!-- Promo Card 3 — Kategori (tanpa gambar) -->
      <div class="fade-up d5 bg-white rounded-2xl p-4" style="box-shadow:0 2px 18px 0 rgba(60,40,10,.07);">
        <p class="text-[10px] font-semibold text-kashy-muted uppercase tracking-widest mb-1">Kategori</p>
        <h3 class="text-lg font-bold text-kashy-dark mb-1">Kemeja Putih</h3>
        <p class="text-sm text-kashy-muted mb-4 leading-relaxed">
          Diskon 15% untuk semua pakaian kemeja putih
        </p>
        <div class="flex items-center justify-between">
          <span class="chip chip-terra">15% Persen</span>
          <span class="text-base font-bold text-kashy-dark">Active</span>
        </div>
      </div>

    </div><!-- /tab-aktif -->

    <!-- ══════════════════════════════
         TAB: TERJADWAL (hidden default)
         ══════════════════════════════ -->
    <div id="tab-terjadwal" class="flex flex-col gap-4 hidden">
      <div class="bg-white rounded-2xl p-6 text-center" style="box-shadow:0 2px 18px 0 rgba(60,40,10,.07);">
        <svg class="w-10 h-10 mx-auto mb-3 text-kashy-muted" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
          <rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/>
        </svg>
        <p class="text-kashy-muted text-sm">Belum ada promosi terjadwal</p>
      </div>
    </div>

    <!-- ══════════════════════════════
         FORM — Promosi Baru
         ══════════════════════════════ -->
    <div id="formSection" class="fade-up d6 bg-white rounded-2xl p-5 mt-6" style="box-shadow:0 2px 18px 0 rgba(60,40,10,.07);">

      <h2 class="text-xl font-bold text-kashy-dark mb-5">Promosi Baru</h2>

      <!-- Nama Promosi -->
      <div class="mb-4">
        <label class="form-label">Nama Promosi</label>
        <input type="text" class="form-input" placeholder="nama promosi..."/>
      </div>

      <!-- Tipe + Nilai -->
      <div class="grid grid-cols-2 gap-3 mb-4">
        <div>
          <label class="form-label">Tipe</label>
          <select class="form-input form-select">
            <option>Persentase</option>
            <option>Nominal</option>
          </select>
        </div>
        <div>
          <label class="form-label">Nilai</label>
          <input type="text" class="form-input" placeholder="20%"/>
        </div>
      </div>

      <!-- Tenggat Waktu -->
      <div class="mb-4">
        <label class="form-label">Tenggat Waktu</label>
        <div class="flex items-center gap-2">
          <input type="text" class="form-input" placeholder="dd/mm/yy"/>
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#8A7968" stroke-width="2" style="flex-shrink:0;">
            <polyline points="9 18 15 12 9 6"/>
          </svg>
          <input type="text" class="form-input" placeholder="dd/mm/yy"/>
        </div>
      </div>

      <!-- Berlaku Untuk -->
      <div class="mb-5">
        <label class="form-label">Berlaku Untuk</label>
        <div class="flex flex-wrap gap-2 mb-3" id="tagContainer">
          <span class="chip chip-terra">
            Semua Produk
            <button class="chip-remove" onclick="removeTag(this)">×</button>
          </span>
          <span class="chip">
            Celana
            <button class="chip-remove" onclick="removeTag(this)">×</button>
          </span>
          <span class="chip">
            Cardigan
            <button class="chip-remove" onclick="removeTag(this)">×</button>
          </span>
        </div>
        <div style="position:relative;">
          <span style="position:absolute;left:12px;top:50%;transform:translateY(-50%);pointer-events:none;">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#8A7968" stroke-width="2">
              <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
            </svg>
          </span>
          <input type="text" class="form-input" style="padding-left:36px;" placeholder="Cari kategori.."/>
        </div>
      </div>

      <!-- Buttons -->
      <button
        class="w-full py-4 rounded-2xl font-bold text-white text-sm tracking-wide mb-3 transition-all duration-200 hover:opacity-90 active:scale-[.98]"
        style="background:#C49A6C; box-shadow:0 4px 14px 0 rgba(196,154,108,.35);">
        Simpan Promosi
      </button>
      <button
        class="w-full py-4 rounded-2xl font-bold text-kashy-dark text-sm tracking-wide border-2 border-kashy-border transition-all duration-200 hover:bg-kashy-cream active:scale-[.98] bg-white">
        Simpan Sebagai Draft
      </button>

    </div>

  </div>
</main>

<script>
  /* ── Sidebar toggle ── */
  const sidebar = document.getElementById('sidebar');
  const overlay = document.getElementById('overlay');
  const menuBtn = document.getElementById('global-menu-toggle');

  function openSidebar()  { sidebar.classList.add('sidebar-open'); overlay.classList.add('show'); document.body.style.overflow='hidden'; }
  function closeSidebar() { sidebar.classList.remove('sidebar-open'); overlay.classList.remove('show'); document.body.style.overflow=''; }
  function toggleSidebar() { sidebar.classList.contains('sidebar-open') ? closeSidebar() : openSidebar(); }

  if (menuBtn) menuBtn.addEventListener('click', e => { e.stopPropagation(); toggleSidebar(); });
  if (overlay)  overlay.addEventListener('click', closeSidebar);
  document.addEventListener('keydown', e => { if (e.key==='Escape') closeSidebar(); });

  /* ── Tab switch ── */
  function switchTab(tab, btn) {
    document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    document.getElementById('tab-aktif').classList.toggle('hidden', tab !== 'aktif');
    document.getElementById('tab-terjadwal').classList.toggle('hidden', tab !== 'terjadwal');
  }

  /* ── Remove tag chip ── */
  function removeTag(btn) {
    btn.closest('.chip').remove();
  }
</script>
</body>
</html>