<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Dashboard Kasir – Kashy</title>
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
  .fade-up { animation: fadeUp 0.45s cubic-bezier(0.2,0.9,0.4,1.1) both; }
  .delay-1 { animation-delay:0.05s; }
  .delay-2 { animation-delay:0.12s; }
  .delay-3 { animation-delay:0.2s; }
  .delay-4 { animation-delay:0.28s; }
  @keyframes pulse { 0%,100%{ opacity:1; transform:scale(1); } 50%{ opacity:0.7; transform:scale(1.2); } }
  .pulse-dot { animation: pulse 1.4s infinite; }
  .shimmer-bar {
    background: linear-gradient(90deg, #C8966C, #E5B18A, #F0D7C7, #E5B18A, #C8966C);
    background-size: 200%;
    animation: shimmer 3s infinite;
  }
  @keyframes shimmer { 0%{background-position:100%} 100%{background-position:-100%} }
  .card-hover { transition: transform 0.2s, box-shadow 0.2s; }
  .card-hover:hover { transform: translateY(-2px); box-shadow: 0 12px 28px rgba(0,0,0,0.08); }
</style>
</head>
<body class="bg-bg min-h-screen flex flex-col">

@include('kasir.components.navbar')

<main class="flex-1 overflow-y-auto px-4 pt-5 pb-28 max-w-2xl mx-auto w-full">
  
  <div class="mb-6 fade-up delay-1">
    <p class="text-xs text-muted font-medium uppercase tracking-wide">Dashboard Kasir</p>
    <h1 class="font-display text-3xl sm:text-4xl font-bold text-gray-900 mt-0.5" id="greetingText">
      Selamat Pagi, <span class="text-terra">{{ Auth::user()->name }}</span>
    </h1>
    <p class="text-sm text-muted mt-2 leading-relaxed">Ringkasan aktivitas dan performa toko hari ini.</p>
  </div>

  <div class="grid grid-cols-2 gap-3 mb-6 fade-up delay-2">
    <button id="transaksiBtn" onclick="goTransaksi()"
      class="bg-gray-900 hover:bg-gray-800 text-white rounded-xl px-4 py-4 flex items-center gap-3 shadow-md transition-all card-hover">
      <div class="w-8 h-8 rounded-lg bg-white/10 flex items-center justify-center">
        <svg width="18" height="18" fill="none" stroke="white" stroke-width="2" viewBox="0 0 24 24">
          <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
        </svg>
      </div>
      <span class="text-sm font-semibold leading-tight">Transaksi<br>Baru</span>
    </button>

    <button onclick="window.location.href='{{ route('kasir.shiftkasir') }}'"
      class="bg-white hover:bg-terra-xs border border-border text-gray-900 rounded-xl px-4 py-4 flex items-center gap-3 shadow-sm transition-all card-hover">
      <div class="w-8 h-8 rounded-lg bg-terra-xs flex items-center justify-center">
        <svg width="18" height="18" fill="none" stroke="#C8966C" stroke-width="2" viewBox="0 0 24 24">
          <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
          <polyline points="16 17 21 12 16 7"/>
          <line x1="21" y1="12" x2="9" y2="12"/>
        </svg>
      </div>
      <span id="shiftBtnLabel" class="text-sm font-semibold leading-tight text-gray-900">Buka Shift</span>
    </button>
  </div>

  <div class="bg-white rounded-2xl shadow-sm border border-border overflow-hidden mb-6 fade-up delay-3">
    <div class="shimmer-bar h-1 w-full"></div>
    <div class="p-5">
      <div class="flex flex-wrap justify-between items-start gap-2 mb-4">
        <div class="flex items-center gap-3">
          <div class="w-11 h-11 rounded-xl bg-terra-xs flex items-center justify-center">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#C8966C" stroke-width="2">
              <circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/>
            </svg>
          </div>
          <div>
            <h2 class="font-semibold text-gray-900 text-lg">Shift Saat Ini</h2>
            <p class="text-xs text-muted" id="shiftHariTanggal"></p>
          </div>
        </div>
        <div id="shiftBadge" class="flex items-center gap-1.5 px-3 py-1.5 rounded-full border">
          <span id="badgeDot" class="w-2 h-2 rounded-full"></span>
          <span id="badgeText" class="text-[11px] font-semibold">Memuat...</span>
        </div>
      </div>

      <div class="grid grid-cols-2 gap-4 mb-4">
        <div>
          <p class="text-[10px] text-muted uppercase tracking-wide">Mulai</p>
          <p class="text-base font-semibold text-gray-900" id="shiftMulai">--:--</p>
        </div>
        <div>
          <p class="text-[10px] text-muted uppercase tracking-wide">Berakhir</p>
          <p class="text-base font-semibold text-gray-900" id="shiftBerakhir">--:--</p>
        </div>
      </div>

      <div class="flex flex-col sm:flex-row sm:flex-wrap sm:items-center gap-3 text-xs text-muted border-t border-border pt-4">
        <div class="flex items-center gap-1.5">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>
          </svg>
          <span>Kasir: <strong class="text-gray-800">{{ Auth::user()->name }}</strong></span>
        </div>
        <div class="flex items-center gap-1.5">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <rect x="3" y="4" width="18" height="16" rx="2"/><path d="M3 10h18"/>
          </svg>
          <span>Posisi: <strong class="text-gray-800">Kasir</strong></span>
        </div>
      </div>
    </div>
  </div>

  <div class="bg-white rounded-2xl shadow-sm border border-border overflow-hidden mb-6 fade-up delay-3">
    <div class="p-5">
      <div class="flex items-center gap-2.5 mb-3">
        <div class="w-8 h-8 rounded-xl bg-terra-xs flex items-center justify-center">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#C8966C" stroke-width="2"><rect x="2" y="5" width="20" height="14" rx="2"/><circle cx="12" cy="12" r="3"/></svg>
        </div>
        <h3 class="font-semibold text-gray-900">Penjualan Hari Ini</h3>
      </div>
      <p id="penjualanValue" class="text-3xl sm:text-4xl font-extrabold text-gray-900 mb-2">Rp 0</p>
      <div class="flex items-center gap-3 mt-1">
        <div class="flex-1 h-1.5 bg-stone-100 rounded-full overflow-hidden">
          <div id="penjualanProgress" class="h-full bg-terra rounded-full" style="width:0%"></div>
        </div>
        <span id="penjualanPercent" class="text-[10px] text-muted">0% dari target</span>
      </div>

      <div class="flex gap-2 mt-4 flex-wrap">
        <span class="flex items-center gap-1.5 text-[10px] font-medium px-2.5 py-1 rounded-full bg-terra-xs text-terra">
          <svg class="w-3.5 h-3.5 text-terra" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8">
            <rect x="2" y="6" width="20" height="12" rx="2"/><circle cx="12" cy="12" r="3"/>
          </svg>
          Tunai: Rp <span id="tunaiNominal">0</span>
        </span>
        <span class="flex items-center gap-1.5 text-[10px] font-medium px-2.5 py-1 rounded-full bg-terra-xs text-terra">
          <svg class="w-3.5 h-3.5 text-terra" viewBox="0 0 24 24" fill="currentColor">
            <path d="M3 3h7v7H3V3zm1 1v5h5V4H4zm1 1h3v3H5V5zM14 3h7v7h-7V3zm1 1v5h5V4h-5zm1 1h3v3h-3V5zM3 14h7v7H3v-7zm1 1v5h5v-5H4zm1 1h3v3H5v-3zM14 14h2v2h-2v-2zm3 0h2v2h-2v-2zm-3 3h2v2h-2v-2zm3 0h2v2h-2v-2z"/>
          </svg>
          QRIS: Rp <span id="qrisNominal">0</span>
        </span>
        <span class="flex items-center gap-1.5 text-[10px] font-medium px-2.5 py-1 rounded-full bg-terra-xs text-terra">
          <svg class="w-3.5 h-3.5 text-terra" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8">
            <rect x="2" y="5" width="20" height="14" rx="2"/><line x1="2" y1="10" x2="22" y2="10"/>
          </svg>
          Debit: Rp <span id="debitNominal">0</span>
        </span>
      </div>
    </div>
  </div>

  <div class="grid grid-cols-2 gap-3 mb-6 fade-up delay-3">
    <div class="bg-white rounded-2xl px-4 py-3 shadow-sm border border-border card-hover">
      <div class="flex items-center justify-between">
        <div class="flex items-center gap-3">
          <div class="w-10 h-10 rounded-xl bg-terra-xs flex items-center justify-center">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#C8966C" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
          </div>
          <div>
            <p class="text-xs text-muted font-medium">Transaksi</p>
            <h3 id="transaksiCount" class="text-lg font-bold text-gray-900">0</h3>
          </div>
        </div>
      </div>
    </div>
    <div class="bg-white rounded-2xl px-4 py-3 shadow-sm border border-border card-hover">
      <div class="flex items-center justify-between">
        <div class="flex items-center gap-3">
          <div class="w-10 h-10 rounded-xl bg-terra-xs flex items-center justify-center">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#C8966C" stroke-width="2"><path d="M20 6 9 17l-5-5"/></svg>
          </div>
          <div>
            <p class="text-xs text-muted font-medium">Item Terjual</p>
            <h3 id="itemCount" class="text-lg font-bold text-gray-900">0</h3>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="bg-white rounded-2xl shadow-sm border border-border overflow-hidden fade-up delay-4">
    <div class="px-5 pt-5 pb-4">
      <div class="flex items-center justify-between mb-4">
        <div class="flex items-center gap-2.5">
          <div class="w-8 h-8 rounded-xl bg-terra-xs flex items-center justify-center">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#C8966C" stroke-width="2"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
          </div>
          <div>
            <h3 class="font-semibold text-gray-900">Transaksi Terbaru</h3>
            <p class="text-[11px] text-muted">Hari ini</p>
          </div>
        </div>
        <span class="text-[10px] font-semibold text-terra cursor-pointer" onclick="goRiwayat()">Lihat semua →</span>
      </div>
      <ul class="space-y-2" id="recentTransactionsList">
        <li class="text-center text-muted text-xs py-4">Memuat transaksi...</li>
      </ul>
    </div>
  </div>
</main>

<div id="toast" class="fixed bottom-24 left-1/2 -translate-x-1/2 z-30 bg-gray-900 text-white text-sm font-medium px-5 py-3 rounded-full shadow-xl flex items-center gap-2 pointer-events-none transition-all duration-300 opacity-0 translate-y-4">
  <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5"><path d="M20 6 9 17l-5-5"/></svg>
  <span id="toastMsg">—</span>
</div>

<script>
(function() {
    const h = new Date().getHours();
    let greet = 'Selamat Pagi';
    if (h >= 11 && h < 15) greet = 'Selamat Siang';
    else if (h >= 15 && h < 18) greet = 'Selamat Sore';
    else if (h >= 18) greet = 'Selamat Malam';
    document.getElementById('greetingText').innerHTML = `${greet}, <span class="text-terra">{{ Auth::user()->name }}</span>`;
})();

const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
document.getElementById('shiftHariTanggal').innerText = new Date().toLocaleDateString('id-ID', options);

let isShiftActive = false;

async function loadShiftStatus() {
    try {
        const response = await fetch('{{ route("kasir.shift.status") }}');
        const data = await response.json();
        
        const shiftBadge = document.getElementById('shiftBadge');
        const badgeDot = document.getElementById('badgeDot');
        const badgeText = document.getElementById('badgeText');
        const shiftMulaiElem = document.getElementById('shiftMulai');
        const shiftBerakhirElem = document.getElementById('shiftBerakhir');
        const shiftBtnLabel = document.getElementById('shiftBtnLabel');
        
        if (data.shift_active && data.shift) {
            isShiftActive = true;
            badgeDot.className = "w-2 h-2 rounded-full bg-green-500 pulse-dot";
            badgeText.innerText = "Aktif";
            shiftBadge.className = "flex items-center gap-1.5 px-3 py-1.5 rounded-full border border-green-300 bg-green-100";
            
            shiftMulaiElem.innerText = data.shift.waktu_buka || '--:--';
            shiftBerakhirElem.innerText = '23:59';
            shiftBtnLabel.innerText = "Tutup Shift";
            
            const totalPenjualan = data.shift.total_penjualan || 0;
            const penjualanTunai = data.shift.penjualan_tunai || 0;
            const penjualanQris = data.shift.penjualan_qris || 0;
            const penjualanDebit = data.shift.penjualan_debit || 0;
            
            document.getElementById('penjualanValue').innerText = `Rp ${totalPenjualan.toLocaleString('id-ID')}`;
            document.getElementById('tunaiNominal').innerText = penjualanTunai.toLocaleString('id-ID');
            document.getElementById('qrisNominal').innerText = penjualanQris.toLocaleString('id-ID');
            document.getElementById('debitNominal').innerText = penjualanDebit.toLocaleString('id-ID');
            
            const percent = Math.min(Math.round((totalPenjualan / 15000000) * 100), 100);
            document.getElementById('penjualanProgress').style.width = `${percent}%`;
            document.getElementById('penjualanPercent').innerText = `${percent}% dari target`;
            
            await loadTransactionStats();
        } else {
            isShiftActive = false;
            badgeDot.className = "w-2 h-2 rounded-full bg-red-500";
            badgeText.innerText = "Tidak Aktif";
            shiftBadge.className = "flex items-center gap-1.5 px-3 py-1.5 rounded-full border border-red-300 bg-red-100";
            
            shiftMulaiElem.innerText = "--:--";
            shiftBerakhirElem.innerText = "--:--";
            shiftBtnLabel.innerText = "Buka Shift";
            
            document.getElementById('penjualanValue').innerText = "Rp 0";
            document.getElementById('tunaiNominal').innerText = "0";
            document.getElementById('qrisNominal').innerText = "0";
            document.getElementById('debitNominal').innerText = "0";
            document.getElementById('penjualanProgress').style.width = "0%";
            document.getElementById('penjualanPercent').innerText = "0% dari target";
            document.getElementById('transaksiCount').innerText = "0";
            document.getElementById('itemCount').innerText = "0";
        }
    } catch (error) {
        console.error('Gagal load shift status:', error);
        showToast('Gagal memuat status shift');
    }
}

async function loadTransactionStats() {
    try {
        const response = await fetch('{{ route("kasir.transaksi.recent") }}');
        const transactions = await response.json();
        document.getElementById('transaksiCount').innerText = transactions.length;
        
        // Hitung total item terjual
        let totalItems = 0;
        transactions.forEach(trx => {
            totalItems += trx.total_items || 0;
        });
        document.getElementById('itemCount').innerText = totalItems;
    } catch (error) {
        console.error('Gagal load statistik:', error);
    }
}

async function loadRecentTransactions() {
    try {
        const response = await fetch('{{ route("kasir.transaksi.recent") }}');
        const transactions = await response.json();
        const container = document.getElementById('recentTransactionsList');
        
        if (transactions.length === 0) {
            container.innerHTML = '<li class="text-center text-muted text-xs py-4">Belum ada transaksi hari ini</li>';
        } else {
            container.innerHTML = transactions.map(trx => `
                <li class="flex items-center justify-between p-2 rounded-xl hover:bg-terra-xs transition">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-emerald-50 flex items-center justify-center">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#10b981" stroke-width="2.5">
                                <path d="M20 6 9 17l-5-5"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs font-semibold">${trx.invoice_number}</p>
                            <p class="text-[9px] text-muted">${trx.time} · ${trx.metode_pembayaran}</p>
                        </div>
                    </div>
                    <span class="text-xs font-bold">Rp ${trx.grand_total.toLocaleString('id-ID')}</span>
                </li>
            `).join('');
        }
    } catch (error) {
        console.error('Gagal load recent transactions:', error);
        document.getElementById('recentTransactionsList').innerHTML = '<li class="text-center text-muted text-xs py-4">Gagal memuat transaksi</li>';
    }
}

function goTransaksi() {
    if (isShiftActive) {
        window.location.href = '{{ route("kasir.transaksi") }}';
    } else {
        showToast('⚠️ Silakan buka shift terlebih dahulu!');
    }
}

function goRiwayat() {
    window.location.href = '{{ route("kasir.riwayattransaksi") }}';
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

window.addEventListener('storage', (event) => {
    if (event.key === 'kasir_shift_updated') {
        loadShiftStatus();
        loadRecentTransactions();
    }
});

setInterval(() => {
    loadShiftStatus();
    loadRecentTransactions();
}, 30000);

loadShiftStatus();
loadRecentTransactions();
</script>
</body>
</html>