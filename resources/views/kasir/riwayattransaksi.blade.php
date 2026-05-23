<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
<title>Riwayat Transaksi – Kashy</title>
<script src="https://cdn.tailwindcss.com"></script>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<script>
  tailwind.config = {
    theme: {
      extend: {
        colors: {
          terra:      '#C8966C',
          'terra-l':  '#E5B18A',
          'terra-ll': '#F0D7C7',
          'terra-xs': '#FAF2EC',
          muted:      '#9C8B7E',
          border:     '#EAE0D6',
          bg:         '#F5F0EB',
        },
        fontFamily: {
          display: ['Poppins', 'sans-serif'],
          body:    ['Poppins', 'sans-serif'],
        },
      }
    }
  }
</script>
<style>
  * { margin:0; padding:0; box-sizing:border-box; }
  body { font-family:'Poppins',sans-serif; background:#F5F0EB; }

  /* ── Search ── */
  .search-wrapper { position:relative; }
  .search-wrapper .search-icon {
    position:absolute; left:14px; top:50%;
    transform:translateY(-50%); pointer-events:none;
  }
  .search-input {
    width:100%; padding:13px 14px 13px 42px;
    background:#fff; border:1.5px solid #EAE0D6;
    border-radius:16px; font-size:14px; font-family:'Poppins',sans-serif;
    color:#1C1C1C; outline:none; transition:border-color .2s;
  }
  .search-input::placeholder { color:#BFB4AC; }
  .search-input:focus { border-color:#C8966C; }

  /* ── Quick filter chips ── */
  .qf-btn {
    padding:9px 18px; border-radius:30px; font-size:13px;
    font-weight:500; border:1.5px solid #EAE0D6;
    background:#fff; color:#1C1C1C; cursor:pointer;
    transition:all .2s; white-space:nowrap;
    font-family:'Poppins',sans-serif; flex-shrink:0;
  }
  .qf-btn.active {
    border-color:#C8966C; background:#FDF1E8; color:#C8966C; font-weight:600;
  }

  /* ── Date label ── */
  .date-label {
    font-size:11px; font-weight:600; color:#9C8B7E;
    letter-spacing:.07em; text-transform:uppercase;
  }

  /* ── Trx card ── */
  .trx-card {
    background:#fff; border-radius:16px;
    border:1.5px solid #EAE0D6; overflow:hidden; transition:box-shadow .2s;
  }
  .trx-card:hover { box-shadow:0 4px 20px rgba(200,150,108,.13); }
  .trx-card-header { padding:16px; cursor:pointer; user-select:none; }
  .trx-id   { font-size:11px; font-weight:600; color:#9C8B7E; letter-spacing:.04em; }
  .trx-name { font-size:15px; font-weight:700; color:#1C1C1C; margin-top:2px; }
  .trx-time { font-size:12px; color:#BFB4AC; display:flex; align-items:center; gap:4px; margin-top:4px; }
  .trx-amount { font-size:16px; font-weight:800; color:#1C1C1C; text-align:right; line-height:1.2; }

  .badge { display:inline-block; font-size:10px; font-weight:700; letter-spacing:.04em; padding:3px 10px; border-radius:20px; margin-top:5px; }
  .badge-success  { background:#E8F5E9; color:#2E7D32; }
  .badge-cancel   { background:#FDECEA; color:#C62828; }
  .badge-pending  { background:#FFF8E1; color:#F57F17; }

  /* ── Accordion ── */
  .trx-detail { max-height:0; overflow:hidden; transition:max-height .35s ease; }
  .trx-detail.open { max-height:400px; }
  .trx-detail-inner { padding:14px 16px 16px; border-top:1.5px dashed #EAE0D6; }
  .detail-section-label { font-size:10px; font-weight:700; color:#9C8B7E; text-transform:uppercase; letter-spacing:.08em; margin-bottom:10px; }
  .detail-row { display:flex; justify-content:space-between; align-items:center; font-size:13px; color:#1C1C1C; padding:4px 0; }
  .detail-row .item-name { color:#9C8B7E; }
  .detail-footer { display:flex; align-items:center; justify-content:space-between; margin-top:14px; padding-top:12px; border-top:1.5px dashed #EAE0D6; gap:8px; }
  .metode-tag { display:flex; align-items:center; gap:6px; font-size:12px; font-weight:600; color:#9C8B7E; background:#F5F0EC; padding:7px 13px; border-radius:10px; flex-shrink:0; }
  .cetak-btn { display:flex; align-items:center; gap:6px; font-size:13px; font-weight:600; color:#C8966C; background:#FDF1E8; border:none; padding:8px 14px; border-radius:10px; cursor:pointer; transition:background .2s; font-family:'Poppins',sans-serif; flex-shrink:0; }
  .cetak-btn:hover { background:#F5E3D0; }

  /* ── Filter Modal ── */
  .filter-overlay { display:none; position:fixed; inset:0; background:rgba(28,28,28,.5); z-index:200; align-items:center; justify-content:center; padding:20px; }
  .filter-overlay.show { display:flex; }
  .filter-modal { width:100%; max-width:420px; background:#fff; border-radius:20px; padding:24px 20px 20px; animation:popIn .25s cubic-bezier(.2,.9,.4,1.1); max-height:90vh; overflow-y:auto; }
  @keyframes popIn { from { transform:scale(.94); opacity:0; } to { transform:scale(1); opacity:1; } }
  .filter-modal-header { display:flex; align-items:center; justify-content:space-between; margin-bottom:20px; }
  .filter-modal-header h3 { font-size:16px; font-weight:700; color:#1C1C1C; }
  .reset-btn { font-size:12px; font-weight:600; color:#C8966C; background:none; border:none; cursor:pointer; font-family:'Poppins',sans-serif; padding:4px 8px; border-radius:8px; transition:background .15s; }
  .reset-btn:hover { background:#FDF1E8; }
  .filter-group { margin-bottom:18px; }
  .filter-group > p { font-size:10px; font-weight:700; color:#9C8B7E; text-transform:uppercase; letter-spacing:.08em; margin-bottom:10px; }
  .filter-chips-row { display:flex; flex-wrap:wrap; gap:8px; }
  .fchip { padding:8px 16px; border-radius:30px; font-size:13px; font-weight:500; border:1.5px solid #EAE0D6; background:#fff; color:#1C1C1C; cursor:pointer; transition:all .15s; font-family:'Poppins',sans-serif; user-select:none; }
  .fchip.selected { background:#FDF1E8; border-color:#C8966C; color:#C8966C; font-weight:600; }
  .filter-modal-footer { display:flex; gap:10px; margin-top:4px; }
  .apply-btn { flex:1; padding:13px; background:#C8966C; color:#fff; font-size:14px; font-weight:700; border:none; border-radius:12px; cursor:pointer; transition:background .2s; font-family:'Poppins',sans-serif; }
  .apply-btn:hover { background:#b5844f; }

  /* ── Scrollbar hide ── */
  .scrollbar-hide::-webkit-scrollbar { display:none; }
  .scrollbar-hide { -ms-overflow-style:none; scrollbar-width:none; }

  /* ── Fade animation ── */
  @keyframes fadeUp { from { opacity:0; transform:translateY(14px); } to { opacity:1; transform:translateY(0); } }
  .fade-up { animation:fadeUp .4s cubic-bezier(.2,.9,.4,1.1) both; }
  .delay-1 { animation-delay:.05s; }
  .delay-2 { animation-delay:.12s; }
  .delay-3 { animation-delay:.20s; }

  /* navbar active */
  .bn-item.active .bn-icon { background:#F0D7C7; }
  .bn-item.active .bn-icon svg { stroke:#C8966C; }
  .bn-item.active .bn-label { color:#C8966C; font-weight:600; }
</style>
</head>

@include('kasir.components.navbar')

<body class="bg-bg min-h-screen flex flex-col">

<!-- TOPBAR — fixed, tidak ikut scroll -->
<nav class="fixed top-0 left-0 right-0 z-40 bg-gray-900 px-5 py-3 flex items-center justify-between shadow-md">
  <div class="w-8"></div>
  <span class="font-display text-xl font-bold text-white tracking-widest">Kashy</span>
  <div class="w-8"></div>
</nav>

<main class="flex-1 overflow-y-auto pb-28 max-w-2xl mx-auto w-full">

  <!-- ── Sticky subheader (search + filter) — tepat di bawah topbar ── -->
  <!-- mt-[52px] = tinggi topbar biar konten tidak tertutup -->
  <div class="sticky top-[52px] z-30 bg-bg px-4 pt-3 pb-3 mt-[52px]">

    <h1 class="text-2xl font-bold text-gray-900 mb-3 fade-up delay-1">Riwayat Transaksi</h1>

    <!-- Search -->
    <div class="search-wrapper mb-3 fade-up delay-1">
      <span class="search-icon">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#9C8B7E" stroke-width="2">
          <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
        </svg>
      </span>
      <input type="text" id="searchInput" class="search-input" placeholder="Cari transaksi..." oninput="filterCards()">
    </div>

    <!-- Quick filter -->
    <div class="flex gap-2 overflow-x-auto scrollbar-hide fade-up delay-2">
      <button class="qf-btn active" onclick="setQuickFilter('hariini', this)">Hari Ini</button>
      <button class="qf-btn" onclick="setQuickFilter('minggu', this)">7 Hari</button>
      <button class="qf-btn" onclick="setQuickFilter('bulan', this)">Bulan Ini</button>
      <button class="qf-btn" onclick="openFilter()">
        <span style="display:flex;align-items:center;gap:6px;">
          <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <line x1="4" y1="6" x2="20" y2="6"/><line x1="8" y1="12" x2="16" y2="12"/><line x1="10" y1="18" x2="14" y2="18"/>
          </svg>
          Filter
        </span>
      </button>
    </div>
  </div>

  <!-- ── Transaction list ── -->
  <div class="px-4 pt-3 flex flex-col gap-5" id="trxList">

    <!-- Group: 27 Oktober 2023 -->
    <div class="trx-group fade-up delay-2" data-date="2023-10-27">
      <p class="date-label mb-3">27 Oktober 2023</p>
      <div class="flex flex-col gap-3">

        <div class="trx-card" data-status="berhasil" data-id="INV/20231027/001">
          <div class="trx-card-header" onclick="toggleDetail(this)">
            <div class="flex justify-between items-start gap-3">
              <div class="flex-1 min-w-0">
                <p class="trx-id">INV/20231027/001</p>
                <p class="trx-name">Andini Putri</p>
                <p class="trx-time"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#BFB4AC" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>14:20 · 27 Okt 2023</p>
              </div>
              <div class="text-right flex-shrink-0">
                <p class="trx-amount">Rp 1.250.000</p>
                <span class="badge badge-success">BERHASIL</span>
              </div>
            </div>
          </div>
          <div class="trx-detail">
            <div class="trx-detail-inner">
              <p class="detail-section-label">Detail Produk</p>
              <div class="detail-row"><span class="item-name">Silk Wrap Dress (S) × 1</span><span>Rp 850.000</span></div>
              <div class="detail-row"><span class="item-name">Leather Belt Tan × 1</span><span>Rp 400.000</span></div>
              <div class="detail-footer">
                <div class="metode-tag"><svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#9C8B7E" stroke-width="2"><rect x="2" y="5" width="20" height="14" rx="2"/><path d="M2 10h20"/></svg>Metode: QRIS</div>
                <button class="cetak-btn" onclick="cetakStruk('INV/20231027/001')"><svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect x="6" y="14" width="12" height="8"/></svg>Cetak Ulang</button>
              </div>
            </div>
          </div>
        </div>

        <div class="trx-card" data-status="berhasil" data-id="INV/20231027/002">
          <div class="trx-card-header" onclick="toggleDetail(this)">
            <div class="flex justify-between items-start gap-3">
              <div class="flex-1 min-w-0">
                <p class="trx-id">INV/20231027/002</p>
                <p class="trx-name">Budi Santoso</p>
                <p class="trx-time"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#BFB4AC" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>13:45 · 27 Okt 2023</p>
              </div>
              <div class="text-right flex-shrink-0">
                <p class="trx-amount">Rp 450.000</p>
                <span class="badge badge-success">BERHASIL</span>
              </div>
            </div>
          </div>
          <div class="trx-detail">
            <div class="trx-detail-inner">
              <p class="detail-section-label">Detail Produk</p>
              <div class="detail-row"><span class="item-name">Linen Shirt Blue × 1</span><span>Rp 450.000</span></div>
              <div class="detail-footer">
                <div class="metode-tag"><svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#9C8B7E" stroke-width="2"><rect x="2" y="5" width="20" height="14" rx="2"/><path d="M2 10h20"/></svg>Metode: Tunai</div>
                <button class="cetak-btn" onclick="cetakStruk('INV/20231027/002')"><svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect x="6" y="14" width="12" height="8"/></svg>Cetak Ulang</button>
              </div>
            </div>
          </div>
        </div>

        <div class="trx-card" data-status="dibatalkan" data-id="INV/20231027/003">
          <div class="trx-card-header" onclick="toggleDetail(this)">
            <div class="flex justify-between items-start gap-3">
              <div class="flex-1 min-w-0">
                <p class="trx-id">INV/20231027/003</p>
                <p class="trx-name">Citra Lestari</p>
                <p class="trx-time"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#BFB4AC" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>12:10 · 27 Okt 2023</p>
              </div>
              <div class="text-right flex-shrink-0">
                <p class="trx-amount">Rp 2.100.000</p>
                <span class="badge badge-cancel">DIBATALKAN</span>
              </div>
            </div>
          </div>
          <div class="trx-detail">
            <div class="trx-detail-inner">
              <p class="detail-section-label">Detail Produk</p>
              <div class="detail-row"><span class="item-name">Batik Premium × 2</span><span>Rp 1.600.000</span></div>
              <div class="detail-row"><span class="item-name">Scarf Sutera × 1</span><span>Rp 500.000</span></div>
              <div class="detail-footer">
                <div class="metode-tag"><svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#9C8B7E" stroke-width="2"><rect x="2" y="5" width="20" height="14" rx="2"/><path d="M2 10h20"/></svg>Metode: Transfer</div>
                <span style="font-size:11px;font-weight:600;color:#C62828;background:#FDECEA;padding:7px 13px;border-radius:10px;">Dibatalkan</span>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>

    <!-- Group: 26 Oktober 2023 -->
    <div class="trx-group fade-up delay-3" data-date="2023-10-26">
      <p class="date-label mb-3">26 Oktober 2023</p>
      <div class="flex flex-col gap-3">

        <div class="trx-card" data-status="berhasil" data-id="INV/20231026/089">
          <div class="trx-card-header" onclick="toggleDetail(this)">
            <div class="flex justify-between items-start gap-3">
              <div class="flex-1 min-w-0">
                <p class="trx-id">INV/20231026/089</p>
                <p class="trx-name">Guest #102</p>
                <p class="trx-time"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#BFB4AC" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>19:30 · 26 Okt 2023</p>
              </div>
              <div class="text-right flex-shrink-0">
                <p class="trx-amount">Rp 750.000</p>
                <span class="badge badge-success">BERHASIL</span>
              </div>
            </div>
          </div>
          <div class="trx-detail">
            <div class="trx-detail-inner">
              <p class="detail-section-label">Detail Produk</p>
              <div class="detail-row"><span class="item-name">Tas Rotan Natural × 1</span><span>Rp 750.000</span></div>
              <div class="detail-footer">
                <div class="metode-tag"><svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#9C8B7E" stroke-width="2"><rect x="2" y="5" width="20" height="14" rx="2"/><path d="M2 10h20"/></svg>Metode: QRIS</div>
                <button class="cetak-btn" onclick="cetakStruk('INV/20231026/089')"><svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect x="6" y="14" width="12" height="8"/></svg>Cetak Ulang</button>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>

  </div>
</main>

<!-- FILTER MODAL -->
<div class="filter-overlay" id="filterOverlay" onclick="closeFilterOutside(event)">
  <div class="filter-modal" onclick="event.stopPropagation()">
    <div class="filter-modal-header">
      <h3>Filter Transaksi</h3>
      <button class="reset-btn" onclick="resetFilter()">↺ Reset</button>
    </div>
    <div class="filter-group">
      <p>Status</p>
      <div class="filter-chips-row" data-group="status">
        <button class="fchip selected" onclick="selectChip(this)">Semua</button>
        <button class="fchip" onclick="selectChip(this)">Berhasil</button>
        <button class="fchip" onclick="selectChip(this)">Dibatalkan</button>
        <button class="fchip" onclick="selectChip(this)">Pending</button>
      </div>
    </div>
    <div class="filter-group">
      <p>Metode Pembayaran</p>
      <div class="filter-chips-row" data-group="metode">
        <button class="fchip selected" onclick="selectChip(this)">Semua</button>
        <button class="fchip" onclick="selectChip(this)">Tunai</button>
        <button class="fchip" onclick="selectChip(this)">QRIS</button>
        <button class="fchip" onclick="selectChip(this)">Transfer</button>
      </div>
    </div>
    <div class="filter-group">
      <p>Rentang Tanggal</p>
      <div class="filter-chips-row" data-group="tanggal">
        <button class="fchip selected" onclick="selectChip(this)">Hari Ini</button>
        <button class="fchip" onclick="selectChip(this)">7 Hari</button>
        <button class="fchip" onclick="selectChip(this)">Bulan Ini</button>
        <button class="fchip" onclick="selectChip(this)">Custom</button>
      </div>
    </div>
    <div class="filter-modal-footer">
      <button class="apply-btn" onclick="applyFilter()">Terapkan Filter</button>
    </div>
  </div>
</div>

<script>
  function toggleDetail(header) { header.nextElementSibling.classList.toggle('open'); }

  function filterCards() {
    const q = document.getElementById('searchInput').value.toLowerCase();
    document.querySelectorAll('.trx-card').forEach(card => {
      const id   = (card.dataset.id || '').toLowerCase();
      const name = card.querySelector('.trx-name')?.textContent.toLowerCase() || '';
      card.style.display = (!q || id.includes(q) || name.includes(q)) ? '' : 'none';
    });
    document.querySelectorAll('.trx-group').forEach(group => {
      const hasVisible = [...group.querySelectorAll('.trx-card')].some(c => c.style.display !== 'none');
      group.style.display = hasVisible ? '' : 'none';
    });
  }

  function setQuickFilter(key, btn) {
    document.querySelectorAll('.qf-btn').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
  }

  function openFilter()  { document.getElementById('filterOverlay').classList.add('show'); }
  function applyFilter() { document.getElementById('filterOverlay').classList.remove('show'); }
  function closeFilterOutside(e) { document.getElementById('filterOverlay').classList.remove('show'); }

  function selectChip(el) {
    el.parentElement.querySelectorAll('.fchip').forEach(c => c.classList.remove('selected'));
    el.classList.add('selected');
  }

  function resetFilter() {
    document.querySelectorAll('[data-group]').forEach(group => {
      group.querySelectorAll('.fchip').forEach((c, i) => c.classList.toggle('selected', i === 0));
    });
  }

  function cetakStruk(id) {
    alert('Mencetak struk: ' + id);
  }
</script>
</body>
</html>