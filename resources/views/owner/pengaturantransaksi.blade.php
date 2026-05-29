<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover"/>
  <title>Kashy – Pengaturan Tambahan</title>
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

    /* Sidebar (sama persis dengan laporan keuangan) */
    #sidebar {
      position:fixed; top:0; left:0; height:100vh; width:280px;
      background:#fff; box-shadow:2px 0 24px rgba(60,40,10,.12);
      z-index:60; transition:transform .3s cubic-bezier(0.2, 0.9, 0.4, 1.1);
      display:flex; flex-direction:column; overflow-y:auto;
      transform:translateX(-100%);
    }
    #sidebar.sidebar-open { transform:translateX(0); }
    #overlay {
      display:none; position:fixed; inset:0; background:rgba(0,0,0,.45);
      z-index:55; backdrop-filter:blur(3px);
    }
    #overlay.show { display:block; }

    /* Animasi */
    @keyframes fadeUp {
      from { opacity:0; transform:translateY(18px); }
      to   { opacity:1; transform:translateY(0); }
    }
    .fade-up { animation:fadeUp .4s ease both; }
    .d1{animation-delay:.04s} .d2{animation-delay:.08s}
    .d3{animation-delay:.12s} .d4{animation-delay:.16s}
    .d5{animation-delay:.20s}

    /* Nav items */
    .nav-item {
      display:flex; align-items:center; gap:12px; padding:11px 18px;
      border-radius:12px; cursor:pointer; transition:all .15s;
      font-size:14px; font-weight:500; color:#1a1a1a;
      text-decoration:none; width:100%;
    }
    .nav-item:hover { background:#F5F0EB; }
    .nav-item.active { background:#F7EFE5; color:#7B4F2E; font-weight:600; }
    .nav-item.active svg { stroke:#7B4F2E; }

    /* Tab button (gaya seperti halaman lain) */
    .tab-btn {
      padding:10px 4px; font-size:13px; font-weight:600; color:#8A7968;
      border-bottom:2px solid transparent; cursor:pointer;
      transition:all .2s; background:none;
      border-top:none; border-left:none; border-right:none;
      font-family:'Poppins',sans-serif; white-space:nowrap;
      flex-shrink:0;
    }
    .tab-btn.active { color:#1a1a1a; border-bottom-color:#C49A6C; }

    /* Toggle switch (konsisten) */
    .toggle-input { display:none; }
    .toggle-label {
      display:inline-flex; align-items:center;
      width:46px; height:26px; border-radius:999px;
      background:#D1C4B8; cursor:pointer;
      transition:background .2s; position:relative; flex-shrink:0;
    }
    .toggle-label::after {
      content:''; position:absolute; left:3px;
      width:20px; height:20px; border-radius:50%;
      background:#fff; transition:transform .2s;
      box-shadow:0 1px 4px rgba(0,0,0,.18);
    }
    .toggle-input:checked + .toggle-label { background:#C49A6C; }
    .toggle-input:checked + .toggle-label::after { transform:translateX(20px); }

    /* Form elements */
    .form-label {
      font-size:11px; font-weight:700; color:#8A7968;
      text-transform:uppercase; letter-spacing:.07em; margin-bottom:6px; display:block;
    }
    .form-input {
      width:100%; padding:12px 14px; border:1.5px solid #E0D8CE;
      border-radius:12px; font-size:13px; font-family:'Poppins',sans-serif;
      color:#1a1a1a; background:#FAF6F2; outline:none;
      transition:border-color .2s;
    }
    .form-input:focus { border-color:#C49A6C; background:#fff; }
    .form-input::placeholder { color:#BFB4AC; }

    /* Receipt preview */
    .receipt {
      background:#fff; border-radius:12px;
      font-family:'Courier New', monospace;
      padding:20px 18px; font-size:12px; color:#1a1a1a;
      line-height:1.6; position:relative;
    }
    .receipt-title { text-align:center; font-weight:700; font-size:14px; letter-spacing:.12em; margin-bottom:4px; }
    .receipt-addr  { text-align:center; font-size:11px; color:#666; margin-bottom:14px; line-height:1.5; }
    .receipt-divider-dash  { border:none; border-top:1.5px dashed #D0C8C0; margin:10px 0; }
    .receipt-divider-solid { border:none; border-top:1.5px solid #D0C8C0; margin:10px 0; }
    .receipt-row       { display:flex; justify-content:space-between; align-items:baseline; margin:5px 0; }
    .receipt-item-name { font-weight:700; font-size:12px; }
    .receipt-total-row { display:flex; justify-content:space-between; align-items:baseline; margin:6px 0; }
    .receipt-total-label { font-weight:700; font-size:13px; }
    .receipt-total-value { font-weight:700; font-size:13px; color:#C49A6C; }

    /* Printer row */
    .printer-row {
      display:flex; align-items:center; gap:12px;
      padding:12px 16px; background:#fff;
      border:1.5px solid #E0D8CE; border-radius:12px;
      cursor:pointer; transition:all .2s;
    }
    .printer-row:hover { border-color:#C49A6C; background:#FAF6F2; }
    .printer-row.selected { border-color:#C49A6C; background:#FDF1E8; }

    .paper-chip {
      flex:1; padding:12px; border-radius:12px; text-align:center;
      font-size:14px; font-weight:600; cursor:pointer;
      border:1.5px solid #E0D8CE; background:#fff; color:#1a1a1a;
      transition:all .2s;
    }
    .paper-chip.active { border-color:#C49A6C; background:#FDF1E8; color:#C49A6C; }
    .paper-chip .check { display:none; margin-right:6px; }
    .paper-chip.active .check { display:inline; }

    /* Badge aktif/nonaktif */
    .badge-aktif {
      display:inline-flex; align-items:center; gap:5px;
      font-size:11px; font-weight:700; color:#2E7D32;
      background:#E8F5E9; padding:4px 10px; border-radius:20px;
    }
    .badge-dot { width:7px; height:7px; border-radius:50%; background:#2E7D32; }
    .badge-nonaktif {
      display:inline-flex; align-items:center; justify-content:center;
      font-size:12px; font-weight:700; color:#C49A6C;
      border:1.5px solid #C49A6C; padding:5px 14px; border-radius:10px;
      cursor:pointer; transition:background .15s; background:none;
      font-family:'Poppins',sans-serif;
    }
    .badge-nonaktif:hover { background:#FDF1E8; }

    .search-input {
      width:100%; padding:12px 14px 12px 38px;
      border:1.5px solid #E0D8CE; border-radius:12px;
      font-size:13px; font-family:'Poppins',sans-serif;
      background:#FAF6F2; outline:none;
    }
    .search-input:focus { border-color:#C49A6C; background:#fff; }

    .refresh-btn {
      width:46px; height:46px; border-radius:12px;
      background:#1a1a1a; border:none; cursor:pointer;
      display:flex; align-items:center; justify-content:center;
      transition:background .2s;
    }
    .refresh-btn:hover { background:#333; }
    @keyframes spin { from{transform:rotate(0deg)} to{transform:rotate(360deg)} }
    .refresh-btn.spinning svg { animation:spin .6s linear; }

    #toast {
      opacity:0; transform:translateX(-50%) translateY(12px);
      transition:opacity .25s ease, transform .3s cubic-bezier(0.34,1.56,.64,1);
      pointer-events:none;
    }
    #toast.show { opacity:1; transform:translateX(-50%) translateY(0); }

    .tab-panel { display:none; }
    .tab-panel.active { display:block; }
  </style>
</head>

@include('owner.components.sidebar')

<body>
<main id="main" class="min-h-screen bg-kashy-cream">
@include('owner.components.topbar')

  <div class="px-5 md:px-8 py-6 max-w-2xl mx-auto">

    <!-- Header -->
    <div class="fade-up d1 mb-5">
      <h1 class="text-2xl md:text-3xl font-extrabold text-kashy-dark leading-tight">Pengaturan Tambahan</h1>
      <p class="text-sm text-kashy-muted mt-1">Konfigurasi transaksi, template struk, dan printer</p>
    </div>

    <!-- TABS -->
    <div class="fade-up d2 flex gap-6 mb-5 overflow-x-auto whitespace-nowrap pb-0 border-b border-kashy-border">
      <button class="tab-btn active" onclick="switchTab('transaksi', this)">
        <span class="flex items-center gap-1.5">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><rect x="1" y="4" width="22" height="16" rx="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
          Transaksi
        </span>
      </button>
      <button class="tab-btn" onclick="switchTab('struk', this)">
        <span class="flex items-center gap-1.5">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
            <polyline points="14 2 14 8 20 8"/>
            <line x1="16" y1="13" x2="8" y2="13"/>
            <line x1="16" y1="17" x2="8" y2="17"/>
            <polyline points="10 9 9 9 8 9"/>
          </svg>
          Template Struk
        </span>
      </button>
      <button class="tab-btn" onclick="switchTab('printer', this)">
        <span class="flex items-center gap-1.5">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect x="6" y="14" width="12" height="8"/></svg>
          Printer
        </span>
      </button>
    </div>

    <!-- TAB 1: TRANSAKSI -->
    <div id="panel-transaksi" class="tab-panel active">
      <div class="fade-up d3 bg-white rounded-2xl shadow-card mb-4">
        <div class="flex items-center gap-3 p-5 border-b border-kashy-border">
          <div class="w-9 h-9 rounded-xl bg-kashy-cream flex items-center justify-center">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#C49A6C" stroke-width="2"><rect x="1" y="4" width="22" height="16" rx="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
          </div>
          <div><p class="text-sm font-semibold text-kashy-dark">Metode Pembayaran</p><p class="text-xs text-kashy-muted">Aktifkan metode yang tersedia di toko</p></div>
        </div>
        <div class="divide-y divide-kashy-border/60">
          <div class="flex items-center justify-between px-5 py-4">
            <div class="flex items-center gap-3"><div class="w-9 h-9 rounded-xl bg-kashy-cream flex items-center justify-center"><svg class="w-5 h-5 text-kashy-brown" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8"><rect x="2" y="6" width="20" height="12" rx="2"/><circle cx="12" cy="12" r="3"/><path d="M6 12h.01M18 12h.01"/></svg></div><div><p class="text-sm font-semibold text-kashy-dark">Tunai</p><p class="text-xs text-kashy-muted">Terima pembayaran uang tunai di kasir</p></div></div>
            <input type="checkbox" id="toggle-tunai" class="toggle-input" checked><label for="toggle-tunai" class="toggle-label"></label>
          </div>
          <div class="flex items-center justify-between px-5 py-4">
            <div class="flex items-center gap-3"><div class="w-9 h-9 rounded-xl bg-kashy-cream flex items-center justify-center"><svg class="w-5 h-5 text-kashy-brown" viewBox="0 0 24 24" fill="currentColor"><path d="M3 3h7v7H3V3zm1 1v5h5V4H4zm1 1h3v3H5V5zM14 3h7v7h-7V3zm1 1v5h5V4h-5zm1 1h3v3h-3V5zM3 14h7v7H3v-7zm1 1v5h5v-5H4zm1 1h3v3H5v-3zM14 14h2v2h-2v-2zm3 0h2v2h-2v-2zm-3 3h2v2h-2v-2zm3 0h2v2h-2v-2z"/></svg></div><div><p class="text-sm font-semibold text-kashy-dark">QRIS</p><p class="text-xs text-kashy-muted">Pembayaran digital via kode QR standar nasional</p></div></div>
            <input type="checkbox" id="toggle-qris" class="toggle-input" checked><label for="toggle-qris" class="toggle-label"></label>
          </div>
          <div class="flex items-center justify-between px-5 py-4">
            <div class="flex items-center gap-3"><div class="w-9 h-9 rounded-xl bg-kashy-cream flex items-center justify-center"><svg class="w-5 h-5 text-kashy-brown" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8"><rect x="2" y="5" width="20" height="14" rx="2"/><line x1="2" y1="10" x2="22" y2="10"/></svg></div><div><p class="text-sm font-semibold text-kashy-dark">Debit</p><p class="text-xs text-kashy-muted">Proses transaksi kartu debit melalui terminal EDC</p></div></div>
            <input type="checkbox" id="toggle-debit" class="toggle-input"><label for="toggle-debit" class="toggle-label"></label>
          </div>
        </div>
      </div>
      <div class="fade-up d4 bg-white rounded-2xl p-5 flex items-start gap-4 shadow-card">
        <div class="w-10 h-10 rounded-xl bg-kashy-cream flex items-center justify-center flex-shrink-0"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#C49A6C" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg></div>
        <div><p class="text-sm font-semibold text-kashy-dark mb-0.5">Butuh Bantuan?</p><p class="text-xs text-kashy-muted">Tim kurasi kami siap membantu konfigurasi sistem kasir butik Anda.</p><button class="mt-3 text-white text-xs font-semibold px-4 py-2 rounded-xl" style="background:#C49A6C;">Hubungi Dukungan</button></div>
      </div>
    </div>

    <!-- TAB 2: TEMPLATE STRUK -->
    <div id="panel-struk" class="tab-panel">
      <div class="fade-up d3 bg-white rounded-2xl p-5 mb-4 shadow-card">
        <div class="flex items-center gap-2 mb-4"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#C49A6C" stroke-width="2"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="15" y2="12"/><line x1="3" y1="18" x2="18" y2="18"/></svg><span class="text-base font-bold text-kashy-dark">Detail Header</span></div>
        <div class="mb-4"><label class="form-label">Nama Toko</label><input type="text" id="inputNamaToko" class="form-input" value="SND Store" oninput="updatePreviewStruk()" placeholder="Nama toko..."/></div>
        <div><label class="form-label">Alamat Toko</label><textarea id="inputAlamatToko" class="form-input" rows="3" oninput="updatePreviewStruk()" placeholder="Alamat toko...">Jl. Bromo No.171 C, Binjai, Kec. Medan Denai, Kota Medan, Sumatera Utara</textarea></div>
      </div>

      <div class="fade-up d4 grid grid-cols-2 gap-3 mb-5">
        <button onclick="buangPerubahanStruk()" class="py-4 rounded-2xl font-bold text-kashy-dark text-sm border-2 border-kashy-border bg-white hover:bg-kashy-cream active:scale-[.97] transition-all">Buang Perubahan</button>
        <button onclick="simpanTemplateStruk()" class="py-4 rounded-2xl font-bold text-white text-sm transition-all hover:opacity-90 active:scale-[.97]" style="background:#C49A6C; box-shadow:0 4px 14px 0 rgba(196,154,108,.35);">Simpan Template</button>
      </div>

      <div class="fade-up d5">
        <div class="flex items-center justify-between mb-2"><div class="flex items-center gap-2 text-sm font-semibold text-kashy-dark"><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg> Pratinjau Langsung</div><button class="w-8 h-8 rounded-full bg-white shadow flex items-center justify-center" onclick="cetakStrukPreview()"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#8A7968" stroke-width="2"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect x="6" y="14" width="12" height="8"/></svg></button></div>
        <div class="receipt" id="receiptPreviewStruk">
          <p class="receipt-title" id="previewNamaToko">SND STORE</p>
          <p class="receipt-addr" id="previewAlamatToko">Jalan Bromo, Komplek Bromo Residence<br/>Nomor 171 C</p>
          <hr class="receipt-divider-dash"/>
          <div class="receipt-row" style="font-size:10px; color:#888;"><span>RECEIPT: #EG-8821</span><span>24 Mei 2026 14:20</span></div>
          <div class="receipt-row" style="font-size:10px; color:#888;"><span>KASIR</span><span>Enjie</span></div>
          <hr class="receipt-divider-dash"/>
          <div class="receipt-row"><span class="receipt-item-name">Kemeja Putih</span><span>Rp 75.000</span></div>
          <div class="receipt-row"><span class="receipt-item-name">Celana Kulot</span><span>Rp 45.000</span></div>
          <hr class="receipt-divider-solid"/>
          <div class="receipt-row"><span>Subtotal</span><span>Rp 120.000</span></div>
          <div class="receipt-row"><span>Diskon</span><span>- Rp 20.000</span></div>
          <div class="receipt-total-row"><span class="receipt-total-label">TOTAL</span><span class="receipt-total-value">Rp 100.000</span></div>
          <div class="receipt-row"><span>Payment</span><span>QRIS</span></div>
          <hr class="receipt-divider-dash"/>
          <div class="receipt-row"><span>Pelanggan</span><span>Member Kashy</span></div>
          <div class="receipt-row"><span>Member Point</span><span>+10 Point</span></div>
          <div class="receipt-row"><span>Total Point</span><span>70 Point</span></div>
          <hr class="receipt-divider-dash"/>
          <p class="receipt-footer-quote flex justify-center">"Kumpulkan point dari setiap transaksi dan tukarkan dengan baju gratis!"</p>
          <div class="receipt-social flex justify-between text-[10px] text-kashy-muted"><span>IG: @snd_store___</span><span>WA: 0852-6124-6660</span></div>
        </div>
      </div>
    </div>

    <!-- TAB 3: PRINTER -->
    <div id="panel-printer" class="tab-panel">
      <div class="fade-up d3 bg-white rounded-2xl p-5 mb-4 shadow-card">
        <div class="flex items-start justify-between mb-1"><h2 class="text-base font-bold text-kashy-dark">Perangkat Terhubung</h2><span class="badge-aktif"><span class="badge-dot"></span>Aktif</span></div>
        <p class="text-sm text-kashy-muted mb-4">Kelola koneksi printer POS aktif Anda</p>
        <div class="flex items-center gap-4 p-4 bg-kashy-cream rounded-xl"><div class="w-10 h-10 rounded-xl bg-white flex items-center justify-center"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#C49A6C" stroke-width="1.8"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect x="6" y="14" width="12" height="8"/></svg></div><div><p class="text-sm font-bold">Epson TM-T82X</p><p class="text-xs text-kashy-muted">Bluetooth · Terhubung: 13:42:18</p></div><button class="badge-nonaktif ml-auto" onclick="nonaktifkanPrinter()">Nonaktif</button></div>
      </div>
      <div class="fade-up d3 bg-white rounded-2xl p-5 mb-4 shadow-card">
        <h2 class="text-base font-bold mb-4">Pindai Printer</h2>
        <div class="flex gap-3 mb-4"><div class="relative flex-1"><svg class="absolute left-3 top-1/2 -translate-y-1/2" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#8A7968"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg><input type="text" class="search-input pl-9" placeholder="Cari melalui Bluetooth atau Jaringan..." oninput="filterPrinter(this.value)"/></div><button class="refresh-btn" onclick="refreshScan()"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2.2"><polyline points="23 4 23 10 17 10"/><polyline points="1 20 1 14 7 14"/><path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"/></svg></button></div>
        <div id="printerList" class="flex flex-col gap-2"><div class="printer-row" onclick="pilihPrinter(this, 'Rongta RP326')"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#8A7968"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect x="6" y="14" width="12" height="8"/></svg><span class="text-sm font-medium">Rongta RP326</span></div><div class="printer-row" onclick="pilihPrinter(this, 'POS-58 Printer')"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#8A7968"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect x="6" y="14" width="12" height="8"/></svg><span class="text-sm font-medium">POS-58 Printer</span></div></div>
      </div>
      <div class="fade-up d4 bg-white rounded-2xl p-5 mb-4 shadow-card">
        <h2 class="text-base font-bold mb-4">Spesifikasi Kertas</h2>
        <p class="text-[10px] font-bold text-kashy-muted uppercase tracking-wide mb-2">Pengaturan Margin</p>
        <div class="flex gap-3 mb-6"><button class="paper-chip active" onclick="pilihKertas(this, '80mm')"><span class="check">✓</span>80mm</button><button class="paper-chip" onclick="pilihKertas(this, '58mm')"><span class="check">✓</span>58mm</button></div>
        <button onclick="jalankanTesPrint()" class="w-full py-4 rounded-2xl font-bold text-white text-sm tracking-wide mb-2 transition-all" style="background:#C49A6C;">Jalankan Tes Print</button>
        <p class="text-center text-xs text-kashy-muted">Memverifikasi koneksi dan penyelarasan</p>
      </div>
    </div>
  </div>
</main>

<div id="toast" class="fixed bottom-8 left-1/2 z-[80] text-white text-sm font-medium px-5 py-3 rounded-full shadow-xl flex items-center gap-2 bg-black/90 backdrop-blur-sm"><span id="toastMsg">✓ Perubahan disimpan</span></div>

<script>
  // ========= SIDEBAR =========
  const sidebar = document.getElementById('sidebar');
  const overlay = document.getElementById('overlay');
  const menuBtn = document.getElementById('global-menu-toggle');
  function openSidebar()  { sidebar.classList.add('sidebar-open'); overlay.classList.add('show'); document.body.style.overflow='hidden'; }
  function closeSidebar() { sidebar.classList.remove('sidebar-open'); overlay.classList.remove('show'); document.body.style.overflow=''; }
  if (menuBtn) menuBtn.addEventListener('click', e => { e.stopPropagation(); openSidebar(); });
  if (overlay) overlay.addEventListener('click', closeSidebar);
  document.addEventListener('keydown', e => { if (e.key==='Escape') closeSidebar(); });

  // ========= TAB SWITCH =========
  function switchTab(tab, btn) {
    document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    document.querySelectorAll('.tab-panel').forEach(p => p.classList.remove('active'));
    document.getElementById('panel-' + tab).classList.add('active');
    if (tab === 'struk') updatePreviewStruk();
  }

  // ========= TOAST =========
  function showToast(msg, success=true) {
    const t = document.getElementById('toast');
    document.getElementById('toastMsg').innerText = msg;
    t.style.background = success ? '#1c1c1c' : '#ef4444';
    t.classList.add('show');
    clearTimeout(t._t);
    t._t = setTimeout(() => t.classList.remove('show'), 2600);
  }

  // Toggle payment
  document.querySelectorAll('.toggle-input').forEach(toggle => {
    toggle.addEventListener('change', () => showToast('Pengaturan pembayaran disimpan'));
  });

  // ========= STRUK PREVIEW =========
  function updatePreviewStruk() {
    const namaToko = document.getElementById('inputNamaToko').value.toUpperCase() || "SND STORE";
    const alamatToko = document.getElementById('inputAlamatToko').value || "Alamat toko tidak diisi";
    document.getElementById('previewNamaToko').textContent = namaToko;
    document.getElementById('previewAlamatToko').innerHTML = alamatToko.replace(/\n/g, '<br/>');
  }

  function buangPerubahanStruk() {
    document.getElementById('inputNamaToko').value = "SND Store";
    document.getElementById('inputAlamatToko').value = "Jl. Bromo No.171 C, Binjai, Kec. Medan Denai, Kota Medan, Sumatera Utara";
    updatePreviewStruk();
    showToast("Perubahan dibuang ke default");
  }

  function simpanTemplateStruk() {
    localStorage.setItem('templateStruk', JSON.stringify({
      namaToko: document.getElementById('inputNamaToko').value,
      alamatToko: document.getElementById('inputAlamatToko').value
    }));
    showToast("Template struk disimpan");
  }

  function cetakStrukPreview() {
    const printContent = document.getElementById('receiptPreviewStruk').innerHTML;
    const win = window.open('', '_blank');
    win.document.write(`<html><head><title>Cetak Struk</title><style>body{font-family:'Courier New',monospace;margin:0;padding:20px;}.receipt{max-width:320px;margin:auto;}${document.querySelector('style').innerHTML}</style></head><body><div class="receipt">${printContent}</div></body></html>`);
    win.document.close(); win.print();
  }

  // ========= PRINTER =========
  function pilihPrinter(el, nama) {
    document.querySelectorAll('.printer-row').forEach(r => r.classList.remove('selected'));
    el.classList.add('selected');
    showToast('Printer "' + nama + '" dipilih');
  }
  function filterPrinter(q) {
    document.querySelectorAll('.printer-row').forEach(row => {
      row.style.display = row.querySelector('span').textContent.toLowerCase().includes(q.toLowerCase()) ? '' : 'none';
    });
  }
  function refreshScan() {
    const btn = document.querySelector('.refresh-btn');
    btn.classList.add('spinning');
    setTimeout(() => { btn.classList.remove('spinning'); showToast('Pemindaian selesai'); }, 700);
  }
  function pilihKertas(el, ukuran) {
    document.querySelectorAll('.paper-chip').forEach(c => c.classList.remove('active'));
    el.classList.add('active');
    showToast('Ukuran kertas ' + ukuran + ' dipilih');
  }
  function nonaktifkanPrinter() {
    if (confirm('Nonaktifkan printer ini?')) showToast('Printer dinonaktifkan', false);
  }
  function jalankanTesPrint() { showToast('Mengirim tes print...'); }

  // Load saved template
  const savedTemplate = localStorage.getItem('templateStruk');
  if (savedTemplate) {
    try {
      const { namaToko, alamatToko } = JSON.parse(savedTemplate);
      document.getElementById('inputNamaToko').value = namaToko;
      document.getElementById('inputAlamatToko').value = alamatToko;
      updatePreviewStruk();
    } catch(e) {}
  }
  updatePreviewStruk();
</script>
</body>
</html>