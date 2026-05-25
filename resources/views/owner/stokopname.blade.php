<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
  <title>Kashy – Stok Opname</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          fontFamily: { poppins: ['Poppins', 'sans-serif'] },
          colors: {
            kashy: {
              dark: '#1a1a1a',
              brown: '#C49A6C',
              'brown-deep': '#7B4F2E',
              cream: '#F5F0EB',
              'cream-dark': '#EDE5DB',
              muted: '#8A7968',
              border: '#E0D8CE',
              red: '#D94F4F',
              green: '#3A9E6F',
            }
          },
          boxShadow: {
            card: '0 2px 18px 0 rgba(60,40,10,.07)',
            btn: '0 4px 14px 0 rgba(196,154,108,.35)',
          }
        }
      }
    }
  </script>
  <style>
    * { font-family: 'Poppins', sans-serif; box-sizing: border-box; }
    body { background: #F5F0EB; margin: 0; }

    /* Sidebar */
    #sidebar {
      position: fixed; top: 0; left: 0; height: 100vh; width: 280px;
      background: #fff; box-shadow: 2px 0 24px rgba(60,40,10,.12);
      z-index: 60; transition: transform .3s cubic-bezier(0.2,0.9,0.4,1.1);
      display: flex; flex-direction: column; overflow-y: auto;
      transform: translateX(-100%);
    }
    #sidebar.sidebar-open { transform: translateX(0); }
    #overlay {
      display: none; position: fixed; inset: 0; background: rgba(0,0,0,.45);
      z-index: 55; backdrop-filter: blur(3px);
    }
    #overlay.show { display: block; }

    /* Animations */
    @keyframes fadeUp {
      from { opacity: 0; transform: translateY(18px); }
      to   { opacity: 1; transform: translateY(0); }
    }
    .fade-up { animation: fadeUp .4s ease both; }
    .d1 { animation-delay: .05s; }
    .d2 { animation-delay: .10s; }
    .d3 { animation-delay: .15s; }
    .d4 { animation-delay: .20s; }
    .d5 { animation-delay: .25s; }

    /* Nav items */
    .nav-item {
      display: flex; align-items: center; gap: 12px; padding: 11px 18px;
      border-radius: 12px; cursor: pointer; transition: all .15s;
      font-size: 14px; font-weight: 500; color: #1a1a1a;
      text-decoration: none; width: 100%;
    }
    .nav-item:hover { background: #F5F0EB; }
    .nav-item.active { background: #F7EFE5; color: #7B4F2E; font-weight: 600; }
    .nav-item.active svg { stroke: #7B4F2E; }

    /* Shimmer bar */
    @keyframes shimmer {
      0%   { background-position: -400px 0; }
      100% { background-position: 400px 0; }
    }
    .shimmer-bar {
      background: linear-gradient(90deg, #C49A6C, #E5B18A, #F0D7C7, #E5B18A, #C49A6C);
      background-size: 200%; animation: shimmer 4s linear infinite;
    }

    /* Form inputs */
    .form-input {
      width: 100%; padding: 12px 14px; border: 1.5px solid #E0D8CE;
      border-radius: 12px; font-size: 13px; font-family: 'Poppins', sans-serif;
      color: #1a1a1a; background: #fff; outline: none;
      transition: border-color .2s, box-shadow .2s;
    }
    .form-input:focus { border-color: #C49A6C; box-shadow: 0 0 0 3px rgba(196,154,108,.12); }
    .form-input::placeholder { color: #BFB4AC; }
    .form-select {
      appearance: none;
      background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%238A7968' stroke-width='2'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E");
      background-repeat: no-repeat; background-position: right 14px center;
      padding-right: 36px; cursor: pointer;
    }
    .form-label {
      font-size: 11px; font-weight: 700; color: #8A7968;
      text-transform: uppercase; letter-spacing: .07em; margin-bottom: 6px; display: block;
    }

    /* Modal */
    #modal-overlay {
      opacity: 0; pointer-events: none;
      transition: opacity .25s ease;
    }
    #modal-overlay.open { opacity: 1; pointer-events: all; }
    #modal-dialog {
      transform: scale(.93) translateY(16px);
      transition: transform .32s cubic-bezier(0.34,1.56,.64,1);
    }
    #modal-overlay.open #modal-dialog { transform: scale(1) translateY(0); }

    /* Toast */
    #toast {
      opacity: 0; transform: translateX(-50%) translateY(12px);
      transition: opacity .25s ease, transform .3s cubic-bezier(0.34,1.56,.64,1);
      pointer-events: none;
    }
    #toast.show { opacity: 1; transform: translateX(-50%) translateY(0); }

    /* Entry card */
    .entry-card { transition: all .18s; }
    .entry-card:hover { background: #FDFAF7; }

    /* Scrollbar */
    ::-webkit-scrollbar { width: 4px; }
    ::-webkit-scrollbar-thumb { background: #C49A6C; border-radius: 10px; }
  </style>
</head>
@include('owner.components.sidebar')
<body>

<main id="main" class="min-h-screen bg-kashy-cream">
  @include('owner.components.topbar')

  <!-- KONTEN UTAMA: disamakan dengan Manajemen Staff (max-w-2xl, tanpa lg:max-w-3xl) -->
  <div class="px-5 md:px-8 py-6 max-w-2xl mx-auto">

    <div class="fade-up d1 mb-6">
      <h1 class="text-3xl font-extrabold text-kashy-dark">Stok Opname</h1>
      <p class="text-sm text-kashy-muted mt-1">Pilih tanggal untuk melihat atau mencatat data stok opname.</p>
    </div>

    <div class="fade-up d2 mb-6">
      <button onclick="openModal()"
        class="w-full flex items-center justify-center gap-2 py-4 rounded-2xl font-bold text-sm tracking-widest text-white uppercase transition-all duration-200 hover:opacity-90 active:scale-[.98]"
        style="background:#C49A6C; box-shadow:0 4px 14px 0 rgba(196,154,108,.35);">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
          <line x1="12" y1="5" x2="12" y2="19"/>
          <line x1="5" y1="12" x2="19" y2="12"/>
        </svg>
        Tambah Stok Opname
      </button>
    </div>

    <div class="bg-white rounded-2xl p-5 shadow-card mb-6">
      <label class="text-[11px] font-bold uppercase tracking-wider text-kashy-muted mb-1.5 block">
        Pilih Tanggal
      </label>
      <input
        type="date"
        id="simpleDate"
        class="w-full border-[1.5px] border-kashy-border rounded-xl px-3 py-3 text-sm text-kashy-dark outline-none transition-colors"
        style="font-family:'Poppins',sans-serif;"
        onchange="changeDate(this.value)"
        onfocus="this.style.borderColor='#C49A6C'"
        onblur="this.style.borderColor='#E0D8CE'"
      >
    </div>

    <div id="entrySection" class="fade-up d4 bg-white rounded-2xl shadow-card overflow-hidden mb-6 hidden">
      <div class="shimmer-bar h-1"></div>
      <div class="px-5 py-4 border-b border-kashy-border flex items-center justify-between">
        <div>
          <p class="font-bold text-kashy-dark text-base" id="entrySectionTitle">Entri Stok Opname</p>
          <p class="text-[11px] text-kashy-muted" id="entrySectionDate"></p>
        </div>
        <span id="entryCount" class="px-3 py-1 rounded-full bg-kashy-cream text-kashy-brown text-xs font-bold border border-kashy-border">0 entri</span>
      </div>
      <div id="entryList" class="divide-y divide-kashy-border/60"></div>
      <div id="entryEmpty" class="hidden flex flex-col items-center justify-center py-10 px-6 text-center">
        <svg class="w-10 h-10 text-kashy-border mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
          <path d="M9 5H7a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-2"/>
          <rect x="9" y="3" width="6" height="4" rx="1"/>
          <line x1="9" y1="12" x2="15" y2="12"/>
          <line x1="9" y1="16" x2="12" y2="16"/>
        </svg>
        <p class="text-kashy-muted text-sm font-medium">Belum ada entri pada tanggal ini</p>
        <button onclick="openModal()" class="mt-3 px-5 py-2 rounded-xl bg-kashy-brown text-white text-xs font-semibold hover:bg-kashy-brown-deep transition-colors">+ Tambah Sekarang</button>
      </div>
    </div>

  </div>
</main>

<!-- MODAL – ukuran tetap max-w-lg (cocok untuk tablet) -->
<div id="modal-overlay" class="fixed inset-0 z-[70] bg-black/50 backdrop-blur-sm flex items-end sm:items-center justify-center p-4">
  <div id="modal-dialog" class="w-full max-w-lg bg-white rounded-3xl shadow-2xl overflow-hidden max-h-[90vh] overflow-y-auto">
    <div class="shimmer-bar h-1"></div>
    <div class="flex items-center justify-between px-6 pt-5 pb-4 border-b border-kashy-border">
      <div>
        <h2 class="text-lg font-bold text-kashy-dark">Tambah Stok Opname</h2>
        <p class="text-[11px] text-kashy-muted mt-0.5" id="modalDateLabel">Senin, 26 Mei 2026</p>
      </div>
      <button onclick="closeModal()" class="w-9 h-9 rounded-xl border border-kashy-border flex items-center justify-center text-kashy-muted hover:bg-kashy-cream hover:border-kashy-brown transition-all">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
          <line x1="18" y1="6" x2="6" y2="18"/>
          <line x1="6" y1="6" x2="18" y2="18"/>
        </svg>
      </button>
    </div>
    <div class="px-6 py-5 space-y-4">
      <div>
        <label class="form-label">Tanggal Opname</label>
        <input type="date" id="formDate" class="form-input">
      </div>
      <div>
        <label class="form-label">Nama Produk</label>
        <input type="text" id="formProduct" class="form-input" placeholder="Cari atau ketik nama produk...">
      </div>
      <div class="grid grid-cols-2 gap-3">
        <div>
          <label class="form-label">Kategori</label>
          <select id="formCategory" class="form-input form-select">
            <option value="">Pilih kategori</option>
            <option>Dress</option>
            <option>Blazer</option>
            <option>Cardigan</option>
            <option>T-Shirt</option>
            <option>Trousers</option>
            <option>Kemeja</option>
            <option>Celana</option>
            <option>Aksesoris</option>
            <option>Tas</option>
          </select>
        </div>
        <div>
          <label class="form-label">Stok Sistem</label>
          <input type="number" id="formStokSistem" class="form-input" placeholder="0" min="0">
        </div>
      </div>
      <div>
        <label class="form-label">Harga Barang</label>
        <div class="relative">
          <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-kashy-muted text-sm font-medium">Rp</span>
          <input type="text" id="formHarga" class="form-input" style="padding-left:42px;" placeholder="0" oninput="formatRupiah(this)">
        </div>
      </div>
      <div class="grid grid-cols-2 gap-3">
        <div>
          <label class="form-label">Stok Fisik (Aktual)</label>
          <input type="number" id="formStokFisik" class="form-input" placeholder="0" min="0" oninput="calcSelisih()">
        </div>
        <div>
          <label class="form-label">Selisih</label>
          <div class="relative">
            <input type="text" id="formSelisih" class="form-input" placeholder="—" readonly style="background:#F5F0EB; cursor:default;">
            <span id="selisihIcon" class="absolute right-3 top-1/2 -translate-y-1/2 text-lg"></span>
          </div>
        </div>
      </div>
      <div id="statusPreview" class="hidden">
        <label class="form-label">Status</label>
        <div id="statusBadge" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-bold"></div>
      </div>
      <div>
        <label class="form-label">Deskripsi / Catatan</label>
        <textarea id="formDesc" rows="3" class="form-input resize-none" placeholder="Tambahkan catatan mengenai kondisi stok, penyebab selisih, dll..."></textarea>
      </div>
    </div>
    <div class="px-6 pb-6 flex flex-col gap-3">
      <button onclick="submitForm()"
        class="w-full py-4 rounded-2xl font-bold text-white text-sm tracking-wide transition-all duration-200 hover:opacity-90 active:scale-[.98]"
        style="background:#C49A6C; box-shadow:0 4px 14px 0 rgba(196,154,108,.35);">
        Simpan Stok Opname
      </button>
      <button onclick="closeModal()"
        class="w-full py-4 rounded-2xl font-bold text-kashy-dark text-sm tracking-wide border-2 border-kashy-border transition-all duration-200 hover:bg-kashy-cream active:scale-[.98] bg-white">
        Batal
      </button>
    </div>
  </div>
</div>

<div id="toast" class="fixed bottom-8 left-1/2 z-[80] text-white text-sm font-medium px-5 py-3 rounded-full shadow-xl flex items-center gap-2">
  <span id="toastMsg"></span>
</div>
<div id="overlay" onclick="closeSidebar()"></div>

<script>
  // ── Sidebar ──
  const sidebar = document.getElementById('sidebar');
  const overlay = document.getElementById('overlay');
  const menuBtn = document.getElementById('global-menu-toggle');

  function openSidebar()  { sidebar.classList.add('sidebar-open'); overlay.classList.add('show'); document.body.style.overflow='hidden'; }
  function closeSidebar() { sidebar.classList.remove('sidebar-open'); overlay.classList.remove('show'); document.body.style.overflow=''; }
  function toggleSidebar(){ sidebar.classList.contains('sidebar-open') ? closeSidebar() : openSidebar(); }

  if (menuBtn) menuBtn.addEventListener('click', e => { e.stopPropagation(); toggleSidebar(); });
  document.addEventListener('keydown', e => { if(e.key==='Escape') closeSidebar(); });

  function changeDate(dateVal) {
    if(!dateVal) return;
    selectedDate = dateVal;
    const d = new Date(dateVal + 'T00:00:00');
    const label = `${DAYS_ID[d.getDay()]}, ${d.getDate()} ${MONTHS_ID[d.getMonth()]} ${d.getFullYear()}`;
    showEntries(dateVal, label);
  }

  function fmt(y, m, d) {
    return `${y}-${String(m).padStart(2,'0')}-${String(d).padStart(2,'0')}`;
  }

  function showEntries(dateKey, label) {
    const sec  = document.getElementById('entrySection');
    const list = document.getElementById('entryList');
    const empty= document.getElementById('entryEmpty');
    const count= document.getElementById('entryCount');
    document.getElementById('entrySectionDate').textContent = label;
    const entries = entriesDB[dateKey] || [];
    count.textContent = `${entries.length} entri`;
    list.innerHTML = '';
    sec.classList.remove('hidden');
    if(entries.length === 0){
      empty.classList.remove('hidden');
      empty.style.display='flex';
    } else {
      empty.classList.add('hidden');
      empty.style.display='none';
      entries.forEach((e,i) => {
        const div = document.createElement('div');
        div.className = 'entry-card flex items-start gap-4 px-5 py-4 transition-colors';
        let badgeHtml='', diffColor='text-kashy-muted';
        if(e.status==='match')  { badgeHtml=`<span class="px-2.5 py-0.5 rounded-full bg-green-50 text-green-700 text-[10px] font-bold">Sesuai</span>`; diffColor='text-green-600'; }
        if(e.status==='short')  { badgeHtml=`<span class="px-2.5 py-0.5 rounded-full bg-red-50 text-red-600 text-[10px] font-bold">Selisih</span>`;   diffColor='text-red-500'; }
        if(e.status==='excess') { badgeHtml=`<span class="px-2.5 py-0.5 rounded-full bg-blue-50 text-blue-600 text-[10px] font-bold">Lebih</span>`;    diffColor='text-blue-600'; }
        const diffDisplay = e.selisih > 0 ? `+${e.selisih}` : e.selisih;
        div.innerHTML = `
          <div class="w-10 h-10 rounded-xl flex-shrink-0 flex items-center justify-center" style="background:#F7EFE5;">
            <svg class="w-5 h-5" fill="none" stroke="#C49A6C" viewBox="0 0 24 24" stroke-width="1.8"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/></svg>
          </div>
          <div class="flex-1 min-w-0">
            <div class="flex items-center gap-2 flex-wrap mb-0.5">
              <p class="text-sm font-semibold text-kashy-dark truncate">${e.product}</p>
              ${badgeHtml}
            </div>
            <p class="text-[11px] text-kashy-muted mb-1">${e.category} · ${e.harga}</p>
            <div class="flex gap-4 text-[11px]">
              <span class="text-kashy-muted">Sistem: <b class="text-kashy-dark">${e.sistem}</b></span>
              <span class="text-kashy-muted">Fisik: <b class="text-kashy-dark">${e.fisik}</b></span>
              <span class="text-kashy-muted">Selisih: <b class="${diffColor}">${diffDisplay}</b></span>
            </div>
            ${e.desc ? `<p class="text-[11px] text-kashy-muted mt-1 italic">"${e.desc}"</p>` : ''}
          </div>
          <button onclick="deleteEntry('${dateKey}',${i})" class="text-kashy-border hover:text-red-400 transition-colors flex-shrink-0 mt-0.5">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4h6v2"/></svg>
          </button>
        `;
        list.appendChild(div);
      });
    }
  }

  function deleteEntry(dateKey, idx) {
    if(!entriesDB[dateKey]) return;
    entriesDB[dateKey].splice(idx,1);
    if(entriesDB[dateKey].length === 0) delete entriesDB[dateKey];
    renderCalendar();
    showEntries(dateKey, document.getElementById('entrySectionDate').textContent);
    showToast('Entri dihapus');
  }

  function prevMonth() { viewMonth--; if(viewMonth<0){ viewMonth=11; viewYear--; } renderCalendar(); }
  function nextMonth() { viewMonth++; if(viewMonth>11){ viewMonth=0; viewYear++; } renderCalendar(); }

  function openModal() {
    const overlay = document.getElementById('modal-overlay');
    overlay.classList.add('open');
    document.body.style.overflow = 'hidden';
    const d = selectedDate || fmt(today.getFullYear(), today.getMonth()+1, today.getDate());
    document.getElementById('formDate').value = d;
    const dObj = new Date(d + 'T00:00:00');
    document.getElementById('modalDateLabel').textContent = `${DAYS_ID[dObj.getDay()]}, ${dObj.getDate()} ${MONTHS_ID[dObj.getMonth()]} ${dObj.getFullYear()}`;
    document.getElementById('formDate').onchange = function() {
      const dd = new Date(this.value + 'T00:00:00');
      document.getElementById('modalDateLabel').textContent = `${DAYS_ID[dd.getDay()]}, ${dd.getDate()} ${MONTHS_ID[dd.getMonth()]} ${dd.getFullYear()}`;
    };
  }

  function closeModal() {
    document.getElementById('modal-overlay').classList.remove('open');
    document.body.style.overflow = '';
    resetForm();
  }

  function resetForm() {
    ['formProduct','formHarga','formStokFisik','formSelisih','formDesc'].forEach(id => document.getElementById(id).value='');
    document.getElementById('formCategory').value = '';
    document.getElementById('formStokSistem').value = '';
    document.getElementById('formSelisih').value = '—';
    document.getElementById('formSelisih').className = 'form-input';
    document.getElementById('formSelisih').style = '';
    document.getElementById('selisihIcon').textContent = '';
    document.getElementById('statusPreview').classList.add('hidden');
  }

  function calcSelisih() {
    const sistem  = parseInt(document.getElementById('formStokSistem').value) || 0;
    const fisikEl = document.getElementById('formStokFisik');
    const selEl   = document.getElementById('formSelisih');
    const iconEl  = document.getElementById('selisihIcon');
    const prevEl  = document.getElementById('statusPreview');
    const badgeEl = document.getElementById('statusBadge');
    const fisik = parseInt(fisikEl.value);
    if(isNaN(fisik) || fisikEl.value.trim()===''){
      selEl.value = '—';
      selEl.style.color = '';
      iconEl.textContent = '';
      prevEl.classList.add('hidden');
      return;
    }
    const diff = fisik - sistem;
    selEl.value = diff > 0 ? `+${diff}` : diff === 0 ? '0' : diff;
    prevEl.classList.remove('hidden');
    if(diff === 0){
      selEl.style.color='#3A9E6F';
      iconEl.textContent='✓';
      iconEl.style.color='#3A9E6F';
      badgeEl.className='inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-bold bg-green-50 text-green-700';
      badgeEl.textContent='Sesuai';
    } else if(diff < 0){
      selEl.style.color='#D94F4F';
      iconEl.textContent='↓';
      iconEl.style.color='#D94F4F';
      badgeEl.className='inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-bold bg-red-50 text-red-600';
      badgeEl.textContent='Selisih (Kurang)';
    } else {
      selEl.style.color='#3B82F6';
      iconEl.textContent='↑';
      iconEl.style.color='#3B82F6';
      badgeEl.className='inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-bold bg-blue-50 text-blue-600';
      badgeEl.textContent='Lebih';
    }
  }

  function formatRupiah(el) {
    let val = el.value.replace(/[^0-9]/g,'');
    el.value = val ? parseInt(val).toLocaleString('id-ID') : '';
  }

  function submitForm() {
    const dateVal   = document.getElementById('formDate').value;
    const product   = document.getElementById('formProduct').value.trim();
    const category  = document.getElementById('formCategory').value;
    const harga     = 'Rp ' + (document.getElementById('formHarga').value || '0');
    const sistem    = parseInt(document.getElementById('formStokSistem').value) || 0;
    const fisikEl   = document.getElementById('formStokFisik');
    const fisik     = parseInt(fisikEl.value) || 0;
    const selisih   = fisik - sistem;
    const desc      = document.getElementById('formDesc').value.trim();
    if(!dateVal)    return showToast('⚠ Pilih tanggal terlebih dahulu', false);
    if(!product)    return showToast('⚠ Nama produk wajib diisi', false);
    if(!category)   return showToast('⚠ Pilih kategori terlebih dahulu', false);
    let status = 'match';
    if(selisih < 0) status = 'short';
    if(selisih > 0) status = 'excess';
    if(!entriesDB[dateVal]) entriesDB[dateVal] = [];
    entriesDB[dateVal].push({ product, category, harga, sistem, fisik, selisih, desc, status });
    closeModal();
    renderCalendar();
    if(selectedDate === dateVal) {
      showEntries(dateVal, document.getElementById('entrySectionDate').textContent);
    } else {
      const d = new Date(dateVal + 'T00:00:00');
      const label = `${DAYS_ID[d.getDay()]}, ${d.getDate()} ${MONTHS_ID[d.getMonth()]} ${d.getFullYear()}`;
      selectedDate = dateVal;
      viewYear  = d.getFullYear();
      viewMonth = d.getMonth();
      document.getElementById('selectedLabel').textContent = label;
      renderCalendar();
      showEntries(dateVal, label);
    }
    showToast('✓ Stok opname berhasil disimpan');
  }

  function showToast(msg, success=true) {
    const t = document.getElementById('toast');
    document.getElementById('toastMsg').textContent = msg;
    t.style.background = success ? '#1c1c1c' : '#ef4444';
    t.classList.add('show');
    clearTimeout(t._t);
    t._t = setTimeout(() => t.classList.remove('show'), 2600);
  }

  // Inisialisasi data dan variabel global
  const DAYS_ID = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
  const MONTHS_ID = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
  let entriesDB = {};
  let selectedDate = '';
  let viewYear, viewMonth;
  const today = new Date();
  const todayKey = fmt(today.getFullYear(), today.getMonth()+1, today.getDate());
  document.getElementById('simpleDate').value = todayKey;
  changeDate(todayKey);
</script>
</body>
</html>