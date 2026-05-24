<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover"/>
  <title>Kashy – Kustomisasi Template Struk</title>
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
    .d1{animation-delay:.05s} .d2{animation-delay:.10s}
    .d3{animation-delay:.15s} .d4{animation-delay:.20s}
    .d5{animation-delay:.25s} .d6{animation-delay:.30s}

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

    /* ── Form ── */
    .form-label {
      font-size:12px; font-weight:700; color:#1a1a1a;
      margin-bottom:6px; display:block;
    }
    .form-input {
      width:100%; padding:12px 14px; border:1.5px solid #E0D8CE;
      border-radius:12px; font-size:13px; font-family:'Poppins',sans-serif;
      color:#1a1a1a; background:#FAF6F2; outline:none; transition:border-color .2s;
      resize:none;
    }
    .form-input:focus { border-color:#C49A6C; background:#fff; }
    .form-input::placeholder { color:#BFB4AC; }

    /* ── Section header ── */
    .section-icon-title {
      display:flex; align-items:center; gap:8px;
      font-size:16px; font-weight:700; color:#1a1a1a; margin-bottom:16px;
    }

    /* ── Receipt preview ── */
    .receipt {
      background:#fff; border-radius:4px;
      font-family:'Courier New', monospace;
      padding:20px 18px; font-size:12px; color:#1a1a1a;
      line-height:1.6; position:relative;
    }
    .receipt-title {
      text-align:center; font-weight:700; font-size:14px;
      letter-spacing:.12em; margin-bottom:4px;
    }
    .receipt-addr {
      text-align:center; font-size:11px; color:#666; margin-bottom:14px; line-height:1.5;
    }
    .receipt-divider-dash {
      border:none; border-top:1.5px dashed #D0C8C0; margin:10px 0;
    }
    .receipt-divider-solid {
      border:none; border-top:1.5px solid #D0C8C0; margin:10px 0;
    }
    .receipt-row {
      display:flex; justify-content:space-between; align-items:baseline;
      margin:5px 0;
    }
    .receipt-item-name { font-weight:700; font-size:12px; }
    .receipt-total-row {
      display:flex; justify-content:space-between; align-items:baseline;
      margin:6px 0;
    }
    .receipt-total-label { font-weight:700; font-size:13px; }
    .receipt-total-value { font-weight:700; font-size:13px; color:#C49A6C; }
    .receipt-point-value { font-weight:700; font-size:13px; color:#C49A6C; }
    .receipt-footer-quote {
      text-align:center; font-size:10.5px; color:#666;
      font-style:italic; line-height:1.6; margin:12px 0 10px;
    }
    .receipt-social {
      display:flex; justify-content:space-between;
      font-size:10px; color:#888;
    }

    /* ── Preview bar ── */
    .preview-bar {
      display:flex; align-items:center; justify-content:space-between;
      padding:10px 4px; margin-bottom:8px;
    }
    .preview-bar-label {
      display:flex; align-items:center; gap:6px;
      font-size:13px; font-weight:600; color:#1a1a1a;
    }
    .preview-bar-actions { display:flex; gap:10px; }
    .preview-action-btn {
      width:32px; height:32px; border-radius:50%; border:none;
      background:#fff; cursor:pointer; display:flex; align-items:center; justify-content:center;
      box-shadow:0 2px 8px rgba(60,40,10,.10); transition:background .15s;
    }
    .preview-action-btn:hover { background:#F5F0EB; }

    /* ── Scrollbar ── */
    ::-webkit-scrollbar { width:4px; }
    ::-webkit-scrollbar-track { background:transparent; }
    ::-webkit-scrollbar-thumb { background:#C49A6C; border-radius:10px; }

    /* ── Mod btn (sidebar) ── */
    .mod-btn {
      display:flex; align-items:center; gap:12px; width:100%;
      background:rgba(255,255,255,.07); border:1px solid rgba(255,255,255,.12);
      border-radius:12px; padding:14px 16px; cursor:pointer;
      transition:background .18s,transform .12s;
      color:#fff; font-size:13.5px; font-weight:500;
    }
    .mod-btn:hover { background:rgba(255,255,255,.13); transform:translateX(3px); }

    /* live update */
    #previewNamaToko   { font-weight:700; letter-spacing:.12em; }
    #previewAlamatToko { font-size:11px; color:#666; text-align:center; line-height:1.5; }
  </style>
</head>

@include('owner.components.sidebar')

<body>
<main id="main" class="min-h-screen bg-kashy-cream">
  @include('owner.components.topbar')

  <div class="px-5 md:px-8 py-6 max-w-2xl mx-auto">

    <!-- ── Header ── -->
    <div class="fade-up d1 mb-6">
      <h1 class="text-3xl font-extrabold text-kashy-dark leading-tight">
        Kustomisasi<br/>Template Struk
      </h1>
      <p class="mt-2 text-sm text-kashy-muted leading-relaxed max-w-sm">
        Ciptakan pengalaman merek yang khas dengan pemformatan tanda terima yang disesuaikan.
        Personalisasikan setiap titik kontak perjalanan pelanggan Anda.
      </p>
    </div>

    <!-- ── Card: Detail Header ── -->
    <div class="fade-up d2 bg-white rounded-2xl p-5 mb-4" style="box-shadow:0 2px 18px 0 rgba(60,40,10,.07);">
      <div class="section-icon-title">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#C49A6C" stroke-width="2">
          <line x1="3" y1="6" x2="21" y2="6"/>
          <line x1="3" y1="12" x2="15" y2="12"/>
          <line x1="3" y1="18" x2="18" y2="18"/>
        </svg>
        Detail Header
      </div>

      <div class="mb-4">
        <label class="form-label">Nama Toko</label>
        <input
          type="text"
          id="inputNamaToko"
          class="form-input"
          value="SND Store"
          oninput="updatePreview()"
          placeholder="Nama toko..."
        />
      </div>

      <div>
        <label class="form-label">Alamat Toko</label>
        <textarea
          id="inputAlamatToko"
          class="form-input"
          rows="3"
          oninput="updatePreview()"
          placeholder="Alamat toko..."
        >Jl. Bromo No.171 C, Binjai, Kec. Medan Denai, Kota Medan, Sumatera Utara</textarea>
      </div>
    </div>

    <!-- ── Buttons ── -->
    <div class="fade-up d3 grid grid-cols-2 gap-3 mb-6">
      <button
        onclick="buangPerubahan()"
        class="py-4 rounded-2xl font-bold text-kashy-dark text-sm border-2 border-kashy-border bg-white transition-all hover:bg-kashy-cream active:scale-[.97]">
        Buang<br/>Perubahan
      </button>
      <button
        onclick="simpanTemplate()"
        class="py-4 rounded-2xl font-bold text-white text-sm transition-all hover:opacity-90 active:scale-[.97]"
        style="background:#C49A6C; box-shadow:0 4px 14px 0 rgba(196,154,108,.35);">
        Simpan<br/>Template
      </button>
    </div>

    <!-- ── Preview ── -->
    <div class="fade-up d4">
      <div class="preview-bar">
        <div class="preview-bar-label">
          <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#1a1a1a" stroke-width="2">
            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
            <circle cx="12" cy="12" r="3"/>
          </svg>
          Pratinjau Langsung
        </div>
        <div class="preview-bar-actions">
          <button class="preview-action-btn" title="Zoom">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#8A7968" stroke-width="2">
              <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
              <line x1="11" y1="8" x2="11" y2="14"/><line x1="8" y1="11" x2="14" y2="11"/>
            </svg>
          </button>
          <button class="preview-action-btn" title="Cetak" onclick="cetakStruk()">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#8A7968" stroke-width="2">
              <polyline points="6 9 6 2 18 2 18 9"/>
              <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/>
              <rect x="6" y="14" width="12" height="8"/>
            </svg>
          </button>
        </div>
      </div>

      <!-- Garis coklat atas preview -->
      <div style="height:3px; background:#7B4F2E; border-radius:2px; margin-bottom:0;"></div>

      <!-- Receipt -->
      <div class="receipt" id="receiptPreview">
        <p class="receipt-title" id="previewNamaToko">SND STORE</p>
        <p class="receipt-addr" id="previewAlamatToko">
          Jalan Bromo, Komplek Bromo Residence<br/>Nomor 171 C
        </p>

        <hr class="receipt-divider-dash"/>

        <div class="receipt-row" style="font-size:10px; color:#888;">
          <span>RECEIPT: #EG-8821</span>
          <span>24 Mei 2023 14:20</span>
        </div>

        <hr class="receipt-divider-dash"/>

        <div class="receipt-row">
          <span class="receipt-item-name">Kemeja Putih</span>
          <span>Rp 75.000</span>
        </div>
        <div class="receipt-row">
          <span class="receipt-item-name">Celana Kulot</span>
          <span>Rp 45.000</span>
        </div>

        <hr class="receipt-divider-solid"/>

        <div class="receipt-row" style="color:#555;">
          <span>Subtotal</span>
          <span>Rp 120.000</span>
        </div>

        <div class="receipt-total-row">
          <span class="receipt-total-label">TOTAL</span>
          <span class="receipt-total-value">Rp 120.000</span>
        </div>
        <div class="receipt-total-row">
          <span class="receipt-total-label">POINT</span>
          <span class="receipt-point-value">34</span>
        </div>

        <hr class="receipt-divider-dash"/>

        <p class="receipt-footer-quote">
          "Terimakasih atas dukungan Anda terhadap kerajinan tangan.<br/>
          Setiap karya dibuat dengan penuh perhatian dan kesungguhan.<br/>
          Kami berharap dapat bertemu Anda lagi segera."
        </p>

        <div class="receipt-social">
          <span>IG: @snd_store___</span>
          <span>WA: 0852-6124-6660</span>
        </div>
      </div>

      <!-- Garis bawah -->
      <div style="height:3px; background:#7B4F2E; border-radius:2px; margin-top:0;"></div>
    </div>

  </div><!-- /container -->
</main>

<script>
  /* ── Sidebar ── */
  const sidebar = document.getElementById('sidebar');
  const overlay = document.getElementById('overlay');
  const menuBtn = document.getElementById('global-menu-toggle');

  function openSidebar()  { sidebar.classList.add('sidebar-open'); overlay.classList.add('show'); document.body.style.overflow='hidden'; }
  function closeSidebar() { sidebar.classList.remove('sidebar-open'); overlay.classList.remove('show'); document.body.style.overflow=''; }
  function toggleSidebar() { sidebar.classList.contains('sidebar-open') ? closeSidebar() : openSidebar(); }

  if (menuBtn) menuBtn.addEventListener('click', e => { e.stopPropagation(); toggleSidebar(); });
  if (overlay)  overlay.addEventListener('click', closeSidebar);
  document.addEventListener('keydown', e => { if (e.key==='Escape') closeSidebar(); });

  /* ── Live preview update ── */
  function updatePreview() {
    const nama   = document.getElementById('inputNamaToko').value.toUpperCase() || 'NAMA TOKO';
    const alamat = document.getElementById('inputAlamatToko').value || 'Alamat toko...';

    document.getElementById('previewNamaToko').textContent = nama;
    // Ganti newline jadi <br>
    document.getElementById('previewAlamatToko').innerHTML = alamat.replace(/\n/g, '<br/>');
  }

  /* ── Buang perubahan ── */
  function buangPerubahan() {
    document.getElementById('inputNamaToko').value   = 'SND Store';
    document.getElementById('inputAlamatToko').value = 'Jl. Bromo No.171 C, Binjai, Kec. Medan Denai, Kota Medan, Sumatera Utara';
    updatePreview();
  }

  /* ── Simpan template (TODO: kirim ke controller) ── */
  function simpanTemplate() {
    // TODO: submit form ke route('owner.struk.simpan')
    alert('Template disimpan!');
  }

  /* ── Cetak ── */
  function cetakStruk() {
    const receipt = document.getElementById('receiptPreview').innerHTML;
    const w = window.open('', '_blank');
    w.document.write(`
      <html><head>
        <style>
          body { font-family:'Courier New',monospace; padding:20px; font-size:12px; }
          @media print { body { padding:0; } }
        </style>
      </head><body>${receipt}</body></html>
    `);
    w.document.close();
    w.print();
  }
</script>
</body>
</html>