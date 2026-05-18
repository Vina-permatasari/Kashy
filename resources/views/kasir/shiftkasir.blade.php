<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
<title>Kashy - Buka / Tutup Shift</title>
<script src="https://cdn.tailwindcss.com"></script>
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
  body { font-family: 'Poppins',sans-serif; background:#F5F0EB; }
  @keyframes fadeUp {
    from { opacity:0; transform:translateY(16px); }
    to   { opacity:1; transform:translateY(0); }
  }
  .fade-up { animation: fadeUp 0.4s cubic-bezier(0.2,0.9,0.4,1.1) both; }
  .card-hover { transition: transform 0.2s, box-shadow 0.2s; }
  .card-hover:hover { transform: translateY(-2px); box-shadow: 0 12px 24px rgba(0,0,0,0.08); }
  .pulse-dot { animation: pulse 1.4s infinite; }
  @keyframes pulse { 0%,100%{ opacity:1; transform:scale(1); } 50%{ opacity:0.7; transform:scale(1.2); } }
  input[type="text"]::-webkit-outer-spin-button,
  input[type="text"]::-webkit-inner-spin-button { -webkit-appearance: none; margin:0; }
  .bn-item.active .bn-icon { background:#F0D7C7; }
  .bn-item.active .bn-icon svg { stroke:#C8966C; }
  .bn-item.active .bn-label { color:#C8966C; font-weight:600; }
</style>
</head>
@include('kasir.components.navbar')

<body class="bg-bg min-h-screen flex flex-col">

<!-- TOPBAR -->
<nav class="sticky top-0 z-20 bg-gray-900 px-5 py-3 flex items-center justify-between shadow-md">
  <div class="w-8"></div>
  <span class="font-display text-xl font-bold text-white tracking-widest">Kashy</span>
  <div class="flex items-center gap-2">
    <button class="relative w-8 h-8 flex items-center justify-center rounded-full hover:bg-white/10 transition">
      <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#9C8B7E" stroke-width="2">
        <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/>
        <path d="M13.73 21a2 2 0 0 1-3.46 0"/>
      </svg>
      <span class="absolute top-1 right-1 w-2 h-2 bg-terra rounded-full border border-gray-900"></span>
    </button>
  </div>
</nav>

<main class="flex-1 max-w-2xl mx-auto w-full px-4 pt-6 pb-28">
  
  <!-- ======================= BUKA SHIFT SECTION ======================= -->
  <div id="openShiftSection" class="fade-up">
    <div class="flex items-center gap-2 mb-1">
      <div class="w-1 h-5 bg-terra rounded-full"></div>
      <p class="text-xs text-muted font-semibold uppercase tracking-wider">Sesi Aktif</p>
    </div>
    <h2 class="text-3xl font-extrabold text-gray-900 mb-6 tracking-tight">Buka Shift</h2>

    <div class="bg-white rounded-2xl shadow-sm border border-border p-6 card-hover">
      <p class="text-sm text-muted mb-5 leading-relaxed">
        Masukkan saldo kas awal untuk memulai sesi penjualan harianmu.
      </p>
      
      <div class="mb-6">
        <label class="block text-xs font-semibold text-muted uppercase tracking-wider mb-2">Saldo Kas Awal</label>
        <div class="relative">
          <input type="text" id="initialBalance" class="w-full border-2 border-border rounded-xl py-3.5 px-4 text-gray-900 font-semibold text-base focus:border-terra focus:ring-1 focus:ring-terra outline-none transition bg-white" placeholder="Rp 0.00" oninput="formatRupiah(this)">
        </div>
      </div>

      <button onclick="showBukaShiftModal()" class="w-full bg-gradient-to-r from-terra to-terra-l text-white font-bold py-3.5 rounded-xl flex items-center justify-center gap-2 shadow-md hover:shadow-lg transition-all card-hover">
        <span class="text-lg">▶</span>
        Mulai Shift
      </button>
    </div>
  </div>

  <!-- ======================= TUTUP SHIFT SECTION ======================= -->
  <div id="closeShiftSection" style="display: none;" class="fade-up">
    <div class="flex items-center gap-2 mb-1">
      <div class="w-1 h-5 bg-terra rounded-full"></div>
      <p class="text-xs text-muted font-semibold uppercase tracking-wider">Ringkasan Sesi</p>
    </div>
    <h2 class="text-3xl font-extrabold text-gray-900 mb-6 tracking-tight">Tutup Shift</h2>

    <!-- STATUS SHIFT AKTIF (Card Hijau) -->
    <div class="bg-green-50 border-l-4 border-green-500 rounded-xl p-4 mb-5 shadow-sm">
      <div class="flex items-center justify-between">
        <div>
          <p class="text-[10px] font-semibold text-green-600 uppercase tracking-wider mb-1">Status Saat Ini</p>
          <p class="text-lg font-bold text-green-700">Shift Aktif</p>
        </div>
      </div>
    </div>

    <!-- Ringkasan Transaksi -->
    <div class="bg-white rounded-2xl shadow-sm border border-border overflow-hidden mb-6">
      <div class="p-5 space-y-3">
        <div class="flex justify-between items-center p-3 bg-terra-xs rounded-xl">
          <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center shadow-sm">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#C8966C" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="2" y="6" width="20" height="12" rx="2" />
                <path d="M6 12h12" />
                <path d="M12 6v12" />
                <circle cx="12" cy="12" r="2" />
              </svg>
            </div>
            <div>
              <p class="font-semibold text-gray-800">Cash</p>
              <p class="text-xs text-muted">Tunai</p>
            </div>
          </div>
          <span class="font-extrabold text-gray-900 text-base" id="totalCash">Rp4.250.000</span>
        </div>
        <div class="flex justify-between items-center p-3 bg-terra-xs rounded-xl">
          <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center shadow-sm">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#C8966C" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="2" y="5" width="20" height="14" rx="2" />
                <path d="M2 10h20" />
                <circle cx="8.5" cy="15.5" r="1.5" fill="#C8966C" />
                <circle cx="8.5" cy="15.5" r="1.5" fill="none" />
              </svg>
            </div>
            <div>
              <p class="font-semibold text-gray-800">Non-Cash</p>
              <p class="text-xs text-muted">(Debit/QRIS)</p>
            </div>
          </div>
          <span class="font-extrabold text-gray-900 text-base" id="totalNonCash">Rp8.120.000</span>
        </div>
      </div>
    </div>

    <!-- Laporan Saldo Akhir -->
    <div class="bg-gradient-to-br from-gray-800 to-gray-900 text-white rounded-2xl p-6 shadow-md mb-6 relative overflow-hidden">
      <div class="absolute -right-6 -top-6 w-24 h-24 bg-terra/20 rounded-full blur-2xl"></div>
      <div class="relative">
        <div class="text-xs font-semibold uppercase tracking-wider text-terra-ll">Laporan Saldo Akhir</div>
        <div class="text-3xl font-extrabold mt-1" id="totalSaldoAkhir">Rp12.370.000</div>
        <div class="text-xs text-gray-300 border-t border-white/20 pt-2 mt-2">Saldo awal + total penjualan</div>
      </div>
    </div>

    <!-- Verifikasi Uang Tunai -->
    <div class="mb-6">
      <label class="block text-xs font-semibold text-muted uppercase tracking-wider mb-2">Jumlah Total Uang Tunai</label>
      <input type="text" id="finalCash" class="w-full border-2 border-dashed border-border rounded-xl py-3.5 px-4 text-gray-900 font-semibold text-base focus:border-terra focus:ring-1 focus:ring-terra outline-none transition bg-white" placeholder="Masukkan jumlah untuk verifikasi" oninput="formatRupiah(this)">
      <p class="text-[11px] text-muted mt-1 flex items-center gap-1">🔍 Masukkan nominal uang tunai yang ada di laci kas</p>
    </div>

    <!-- Tombol Tutup -->
<button onclick="showTutupShiftModal()" class="w-full bg-gray-800 hover:bg-gray-900 text-white font-bold py-3.5 rounded-xl flex items-center justify-center gap-2 shadow-md transition-all card-hover">
  <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
    <rect x="3" y="11" width="18" height="11" rx="2" ry="2" />
    <path d="M7 11V7a5 5 0 0 1 10 0v4" />
  </svg>
  Tutup Shift
</button>
  </div>
</main>

<!-- ========== MODAL KONFIRMASI BUKA SHIFT ========== -->
<div id="confirmModal" class="fixed inset-0 z-50 hidden items-center justify-center" style="background-color: rgba(0,0,0,0.5); backdrop-filter: blur(4px);">
  <div class="bg-white rounded-2xl max-w-sm w-full mx-4 shadow-2xl transform transition-all">
    <div class="p-6">
      <div class="flex items-center gap-3 mb-4">
        <div class="w-10 h-10 rounded-full bg-terra-xs flex items-center justify-center">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#C8966C" stroke-width="2">
            <circle cx="12" cy="12" r="10"/>
            <path d="M12 6v6l4 2"/>
          </svg>
        </div>
        <h3 class="text-lg font-bold text-gray-900">Konfirmasi Buka Shift</h3>
      </div>
      <p class="text-sm text-muted mb-4">Apakah Anda yakin ingin memulai shift dengan data berikut?</p>
      <div class="bg-green-50 border border-green-200 rounded-xl p-4 mb-5">
        <div class="flex justify-between text-sm">
          <span class="text-muted">Saldo Kas Awal</span>
          <span id="modalBalance" class="font-bold text-gray-900">Rp 0</span>
        </div>
        <div class="flex justify-between text-sm mt-2">
          <span class="text-muted">Waktu Mulai</span>
          <span id="modalStartTime" class="font-bold text-gray-900">--:--</span>
        </div>
      </div>
      <div class="flex gap-3">
        <button onclick="closeModal()" class="flex-1 py-2.5 rounded-xl border border-border bg-white text-gray-700 text-sm font-semibold hover:bg-gray-100 transition">Batal</button>
        <button onclick="confirmBukaShift()" class="flex-1 py-2.5 rounded-xl bg-green-500 text-white text-sm font-semibold hover:bg-green-600 transition">Ya, Mulai Shift</button>
      </div>
    </div>
  </div>
</div>

<!-- ========== MODAL KONFIRMASI TUTUP SHIFT ========== -->
<div id="confirmTutupModal" class="fixed inset-0 z-50 hidden items-center justify-center" style="background-color: rgba(0,0,0,0.5); backdrop-filter: blur(4px);">
  <div class="bg-white rounded-2xl max-w-sm w-full mx-4 shadow-2xl transform transition-all">
    <div class="p-6">
      <div class="flex items-center gap-3 mb-4">
        <div class="w-10 h-10 rounded-full bg-terra-xs flex items-center justify-center">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#C8966C" stroke-width="2">
            <circle cx="12" cy="12" r="10"/>
            <path d="M12 6v6l4 2"/>
          </svg>
        </div>
        <h3 class="text-lg font-bold text-gray-900">Konfirmasi Tutup Shift</h3>
      </div>
      <p class="text-sm text-muted mb-4">Periksa kembali data verifikasi tunai berikut:</p>
      <div id="verifikasiDetail" class="bg-gray-50 rounded-xl p-4 mb-5 space-y-2 text-sm">
        <!-- detail akan diisi js -->
      </div>
      <div class="flex gap-3">
        <button onclick="closeTutupModal()" class="flex-1 py-2.5 rounded-xl border border-border bg-white text-gray-700 text-sm font-semibold hover:bg-gray-100 transition">Batal</button>
        <button id="confirmTutupBtn" class="flex-1 py-2.5 rounded-xl text-white text-sm font-semibold transition">Ya, Tutup Shift</button>
      </div>
    </div>
  </div>
</div>

<!-- TOAST NOTIFICATION -->
<div id="toast" class="fixed bottom-24 left-1/2 -translate-x-1/2 z-30 bg-gray-900 text-white text-sm font-medium px-5 py-3 rounded-full shadow-xl flex items-center gap-2 pointer-events-none transition-all duration-300 opacity-0 translate-y-4">
  <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5"><path d="M20 6 9 17l-5-5"/></svg>
  <span id="toastMsg">—</span>
</div>

<script>
  // ---------- FORMAT RUPIAH ----------
  function formatRupiah(input) {
    let val = input.value.replace(/[^\d]/g, '');
    if (val) {
      let num = parseInt(val, 10);
      input.value = 'Rp ' + num.toLocaleString('id-ID');
    } else {
      input.value = '';
    }
  }

  function parseRupiah(str) {
    if (!str) return 0;
    let cleaned = str.replace(/[^\d]/g, '');
    return parseInt(cleaned, 10) || 0;
  }

  // ---------- DATA DUMMY TRANSAKSI ----------
  const totalCash = 4250000;      // Rp4.250.000
  const totalNonCash = 8120000;   // Rp8.120.000
  const totalPenjualan = totalCash + totalNonCash;

  // State shift
  let shiftActive = false;
  let initialBalance = 0;
  let shiftStartTime = null;

  const openSection = document.getElementById('openShiftSection');
  const closeSection = document.getElementById('closeShiftSection');
  const initialBalanceInput = document.getElementById('initialBalance');
  const finalCashInput = document.getElementById('finalCash');
  const totalCashSpan = document.getElementById('totalCash');
  const totalNonCashSpan = document.getElementById('totalNonCash');
  const totalSaldoAkhirSpan = document.getElementById('totalSaldoAkhir');

  totalCashSpan.innerText = 'Rp ' + totalCash.toLocaleString('id-ID');
  totalNonCashSpan.innerText = 'Rp ' + totalNonCash.toLocaleString('id-ID');
  
  function updateTotalSaldoAkhir() {
    let saldoAkhir = initialBalance + totalPenjualan;
    totalSaldoAkhirSpan.innerText = 'Rp ' + saldoAkhir.toLocaleString('id-ID');
  }

  // ---------- PERSISTENSI SHIFT ----------
  function loadShiftState() {
    const saved = localStorage.getItem('kashy_shift');
    if (saved) {
      try {
        const data = JSON.parse(saved);
        shiftActive = data.active || false;
        initialBalance = data.initialBalance || 0;
        if (data.startTime) shiftStartTime = new Date(data.startTime);
        if (shiftActive && shiftStartTime) {
          const now = new Date();
          const diffMinutes = (now - shiftStartTime) / 60000;
          if (diffMinutes >= 480) {
            shiftActive = false;
            shiftStartTime = null;
            initialBalance = 0;
            localStorage.removeItem('kashy_shift');
          }
        }
      } catch(e) { console.warn(e); }
    }
    updateUIBerdasarkanState();
  }

  function saveShiftState() {
    const data = {
      active: shiftActive,
      initialBalance: initialBalance,
      startTime: shiftStartTime ? shiftStartTime.toISOString() : null
    };
    localStorage.setItem('kashy_shift', JSON.stringify(data));
  }

  function updateUIBerdasarkanState() {
    if (shiftActive) {
      openSection.style.display = 'none';
      closeSection.style.display = 'block';
      updateTotalSaldoAkhir();
      if (finalCashInput) finalCashInput.value = '';
    } else {
      openSection.style.display = 'block';
      closeSection.style.display = 'none';
      if (initialBalanceInput) initialBalanceInput.value = '';
    }
  }

  // ---------- MODAL KONFIRMASI BUKA SHIFT ----------
  const bukaModal = document.getElementById('confirmModal');
  let pendingBalance = 0;

  function showBukaShiftModal() {
    const balanceStr = initialBalanceInput.value;
    const balanceNum = parseRupiah(balanceStr);
    if (balanceNum === 0) {
      showToast('Masukkan saldo kas awal yang valid!');
      return;
    }
    pendingBalance = balanceNum;
    document.getElementById('modalBalance').innerText = 'Rp ' + balanceNum.toLocaleString('id-ID');
    const now = new Date();
    const waktuMulai = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });
    document.getElementById('modalStartTime').innerText = waktuMulai;
    bukaModal.classList.remove('hidden');
    bukaModal.classList.add('flex');
  }

  function closeModal() {
    bukaModal.classList.add('hidden');
    bukaModal.classList.remove('flex');
  }

  function confirmBukaShift() {
    shiftActive = true;
    initialBalance = pendingBalance;
    shiftStartTime = new Date();
    saveShiftState();
    updateUIBerdasarkanState();
    closeModal();
    showToast('✅ Shift berhasil dibuka! Selamat bekerja.');
  }

  // ---------- MODAL KONFIRMASI TUTUP SHIFT (dengan warna tombol dinamis) ----------
  const tutupModal = document.getElementById('confirmTutupModal');
  const verifikasiDetail = document.getElementById('verifikasiDetail');
  const confirmTutupBtn = document.getElementById('confirmTutupBtn');
  let finalCashValue = 0;
  let expectedCash = 0;
  let selisih = 0;

  function showTutupShiftModal() {
    const finalCashStr = finalCashInput.value;
    const finalCashNum = parseRupiah(finalCashStr);
    if (finalCashNum === 0) {
      showToast('Masukkan jumlah uang tunai fisik untuk verifikasi!');
      return;
    }
    finalCashValue = finalCashNum;
    expectedCash = initialBalance + totalCash;
    selisih = finalCashValue - expectedCash;

    // Bangun detail verifikasi
    let detailHtml = `
      <div class="flex justify-between text-sm">
        <span class="text-muted">Saldo awal kas:</span>
        <span class="font-semibold">Rp ${initialBalance.toLocaleString('id-ID')}</span>
      </div>
      <div class="flex justify-between text-sm">
        <span class="text-muted">Penjualan tunai:</span>
        <span class="font-semibold">Rp ${totalCash.toLocaleString('id-ID')}</span>
      </div>
      <div class="flex justify-between text-sm border-t border-gray-200 pt-2 mt-1">
        <span class="text-muted">Ekspektasi uang tunai:</span>
        <span class="font-semibold">Rp ${expectedCash.toLocaleString('id-ID')}</span>
      </div>
      <div class="flex justify-between text-sm">
        <span class="text-muted">Uang tunai aktual:</span>
        <span class="font-semibold">Rp ${finalCashValue.toLocaleString('id-ID')}</span>
      </div>
    `;
    if (selisih > 0) {
      detailHtml += `<div class="flex justify-between text-sm text-green-600 bg-green-50 p-2 rounded-lg mt-2">
        <span>⚠️ Kelebihan tunai:</span>
        <span class="font-bold">Rp ${selisih.toLocaleString('id-ID')}</span>
      </div>`;
    } else if (selisih < 0) {
      detailHtml += `<div class="flex justify-between text-sm text-red-600 bg-red-50 p-2 rounded-lg mt-2">
        <span>⚠️ Kekurangan tunai:</span>
        <span class="font-bold">Rp ${Math.abs(selisih).toLocaleString('id-ID')}</span>
      </div>`;
    } else {
      detailHtml += `<div class="flex justify-between text-sm text-green-600 bg-green-50 p-2 rounded-lg mt-2">
        <span>✅ Pas! Kas sesuai.</span>
      </div>`;
    }
    verifikasiDetail.innerHTML = detailHtml;

    // Atur warna tombol berdasarkan selisih
    if (selisih >= 0) {
      confirmTutupBtn.className = "flex-1 py-2.5 rounded-xl bg-green-500 text-white text-sm font-semibold hover:bg-green-600 transition";
      confirmTutupBtn.innerText = "Ya, Tutup Shift";
    } else {
      confirmTutupBtn.className = "flex-1 py-2.5 rounded-xl bg-red-500 text-white text-sm font-semibold hover:bg-red-600 transition";
      confirmTutupBtn.innerText = "Ya, Tutup Shift";
    }

    tutupModal.classList.remove('hidden');
    tutupModal.classList.add('flex');
  }

  function closeTutupModal() {
    tutupModal.classList.add('hidden');
    tutupModal.classList.remove('flex');
  }

  function confirmTutupShift() {
    // Proses tutup shift
    shiftActive = false;
    initialBalance = 0;
    shiftStartTime = null;
    saveShiftState();
    updateUIBerdasarkanState();
    closeTutupModal();
    showToast('✅ Shift berhasil ditutup! Terima kasih.');
  }

  // Pasang event listener untuk tombol konfirmasi di modal tutup
  confirmTutupBtn.onclick = confirmTutupShift;

  // ---------- FUNGSI TUTUP SHIFT LAMA (digantikan modal, tapi kita pertahankan untuk referensi) ----------
  // Tidak digunakan lagi karena sudah pakai modal

  // ---------- NAVIGASI ----------
  function setNav(el) {
    document.querySelectorAll('.bn-item').forEach(b => b.classList.remove('active'));
    el.classList.add('active');
    const label = el.querySelector('.bn-label');
    if (label) {
      label.classList.add('text-terra');
      label.classList.remove('text-muted');
      const svg = el.querySelector('svg');
      if (svg) svg.setAttribute('stroke', '#C8966C');
    }
    document.querySelectorAll('.bn-item:not(.active)').forEach(b => {
      const lbl = b.querySelector('.bn-label');
      if (lbl) lbl.classList.remove('text-terra');
      const svg = b.querySelector('svg');
      if (svg) svg.setAttribute('stroke', '#9C8B7E');
    });
  }

  function goToPage(page) {
    if (page === 'beranda') {
      window.location.href = 'dashboard.html';
    } else if (page === 'shift') {
      showToast('Anda sudah di halaman Shift');
    } else {
      showToast(`Fitur ${page} sedang dalam pengembangan`);
    }
  }

  function showToast(msg) {
    const toast = document.getElementById('toast');
    document.getElementById('toastMsg').innerText = msg;
    toast.style.opacity = '1';
    toast.style.transform = 'translateX(-50%) translateY(0)';
    setTimeout(() => {
      toast.style.opacity = '0';
      toast.style.transform = 'translateX(-50%) translateY(16px)';
    }, 2600);
  }

  // Inisialisasi
  loadShiftState();

  // Set active nav ke Shift
  document.querySelectorAll('.bn-item').forEach((item, idx) => {
    if (idx === 3) {
      item.classList.add('active');
      const lbl = item.querySelector('.bn-label');
      if (lbl) lbl.classList.add('text-terra');
      const svg = item.querySelector('svg');
      if (svg) svg.setAttribute('stroke', '#C8966C');
    } else {
      item.classList.remove('active');
    }
  });
</script>
</body>
</html>