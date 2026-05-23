<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Absensi – Kashy</title>
<script src="https://cdn.tailwindcss.com"></script>
<link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700;1,400;1,600&display=swap" rel="stylesheet">
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
          'poppins': ['Poppins', 'sans-serif'],
        },
        keyframes: {
          fadeUp: {
            from: { opacity: '0', transform: 'translateY(18px)' },
            to:   { opacity: '1', transform: 'translateY(0)' }
          },
          clockTickStep: {
            '0%,100%': { opacity: '1' },
            '50%':     { opacity: '0.4' }
          },
          ringPulse: {
            '0%':   { transform: 'scale(1)', opacity: '.55' },
            '70%':  { transform: 'scale(1.35)', opacity: '0' },
            '100%': { transform: 'scale(1.35)', opacity: '0' }
          },
          shimmer: {
            '0%':   { backgroundPosition: '-400px 0' },
            '100%': { backgroundPosition: '400px 0' }
          },
          drawFp: {
            from: { strokeDashoffset: '400', opacity: '0' },
            to:   { strokeDashoffset: '0',   opacity: '1' }
          },
          checkDraw: {
            from: { strokeDashoffset: '60' },
            to:   { strokeDashoffset: '0' }
          },
          successPop: {
            '0%':   { transform: 'scale(0.7)', opacity: '0' },
            '65%':  { transform: 'scale(1.12)' },
            '100%': { transform: 'scale(1)',   opacity: '1' }
          },
          scanLine: {
            '0%':   { top: '20%',   opacity: '1' },
            '45%':  { top: '78%',   opacity: '1' },
            '50%':  { top: '78%',   opacity: '0' },
            '51%':  { top: '20%',   opacity: '0' },
            '55%':  { top: '20%',   opacity: '1' },
            '100%': { top: '20%',   opacity: '1' }
          }
        },
        animation: {
          'fade-up-1': 'fadeUp 0.45s cubic-bezier(0.22,1,0.36,1) 0.05s both',
          'fade-up-2': 'fadeUp 0.45s cubic-bezier(0.22,1,0.36,1) 0.12s both',
          'fade-up-3': 'fadeUp 0.45s cubic-bezier(0.22,1,0.36,1) 0.19s both',
          'fade-up-4': 'fadeUp 0.45s cubic-bezier(0.22,1,0.36,1) 0.26s both',
          'clock-sep': 'clockTickStep 1s step-end infinite',
          'ring-1': 'ringPulse 2.2s ease-out infinite',
          'ring-2': 'ringPulse 2.2s ease-out 0.55s infinite',
          'ring-3': 'ringPulse 2.2s ease-out 1.1s infinite',
          'shimmer-slow': 'shimmer 4s linear infinite',
          'draw-fp': 'drawFp 1.8s ease-out forwards',
          'check-draw': 'checkDraw 0.4s 0.3s ease forwards',
          'success-pop': 'successPop 0.45s cubic-bezier(0.34,1.56,0.64,1) forwards',
          'scan-slide': 'scanLine 2.4s ease-in-out infinite'
        }
      }
    }
  }
</script>
<style>
  body {
    font-family: 'Poppins', sans-serif;
  }
  .scanning .fp-path { animation: drawFp 1.8s ease-out forwards; }
  .check-draw { stroke-dasharray: 60; stroke-dashoffset: 60; }
  .ripple-el { animation: ripple 0.55s ease-out forwards; }
  @keyframes ripple {
    from { transform: scale(0.5); opacity: .6; }
    to   { transform: scale(2.2); opacity: 0; }
  }
  .font-display {
    font-family: 'Poppins', sans-serif;
  }
  .card-hover { transition: transform 0.2s, box-shadow 0.2s; }
  .card-hover:hover { transform: translateY(-2px); box-shadow: 0 12px 28px rgba(0,0,0,0.08); }
  .bn-item.active .bn-icon { background:#F0D7C7; }
  .bn-item.active .bn-icon svg { stroke:#C8966C; }
  .bn-item.active .bn-label { color:#C8966C; font-weight:600; }
</style>
</head>
<body class="bg-bg min-h-screen flex flex-col font-poppins">

<!-- TOPBAR (sama dengan stok produk & dashboard: judul di tengah) -->
<nav class="sticky top-0 z-50 bg-gray-900 flex items-center justify-center px-5 shadow-md h-[52px]">
  <span class="font-poppins text-xl font-bold text-white tracking-widest">Kashy</span>
</nav>

<!-- MAIN CONTENT -->
<main class="flex-1 overflow-y-auto pb-28">
  <div class="max-w-md mx-auto px-4 pt-5 space-y-5">

    <!-- Session Card (jam & tanggal) -->
    <div class="bg-white rounded-2xl border border-border shadow-sm overflow-hidden fade-up-1 card-hover">
      <div class="shimmer-bar h-1 w-full bg-gradient-to-r from-terra via-terra-l via-terra-ll to-terra bg-[length:200%] animate-shimmer-slow"></div>
      <div class="px-4 py-4 text-center">
        <div class="font-poppins text-3xl sm:text-4xl font-bold text-gray-900 leading-none mb-1" id="liveClock">
          --<span class="animate-clock-sep">:</span>-- <span class="text-xl sm:text-2xl font-semibold text-muted">--</span>
        </div>
        <p class="text-xs text-muted mt-1" id="liveDate" style="font-family: 'Poppins', sans-serif;">--</p>
      </div>
    </div>

    <!-- Fingerprint Scanner Card -->
    <div class="bg-white rounded-2xl border border-border shadow-sm overflow-hidden fade-up-2 card-hover">
      <div class="px-4 py-5 flex flex-col items-center">
        <div class="relative flex items-center justify-center mb-5 w-[180px] h-[180px]">
          <div class="absolute rounded-full border-2 border-terra/30 inset-0 animate-ring-1"></div>
          <div class="absolute rounded-full border-2 border-terra/20 animate-ring-2" style="inset:-8px;border-radius:9999px;"></div>
          <div class="absolute rounded-full border-2 border-terra/10 animate-ring-3" style="inset:-18px;border-radius:9999px;"></div>
          <div id="fpGlow" class="absolute inset-4 rounded-full transition-all duration-500" style="background:radial-gradient(circle,#E5B18A 0%,#C8966C 60%,#a07050 100%);"></div>
          <button id="fpBtn" class="relative z-10 w-32 h-32 rounded-full flex flex-col items-center justify-center gap-2 select-none focus:outline-none focus:ring-2 focus:ring-terra" style="background:transparent;" onmousedown="startScan()" ontouchstart="startScan()">
            <svg id="fpSvg" width="56" height="56" viewBox="0 0 64 64" fill="none" class="drop-shadow-sm">
              <path class="fp-path" d="M10 40 C8 18, 56 18, 54 40" stroke="white" stroke-width="2.2" stroke-linecap="round" fill="none"/>
              <path class="fp-path" d="M14 44 C12 24, 52 24, 50 44" stroke="white" stroke-width="2" stroke-linecap="round" fill="none" stroke-dasharray="3 1"/>
              <path class="fp-path" d="M18 47 C16 30, 48 30, 46 47" stroke="white" stroke-width="2" stroke-linecap="round" fill="none"/>
              <path class="fp-path" d="M22 49 C20 36, 44 36, 42 49" stroke="white" stroke-width="2" stroke-linecap="round" fill="none" stroke-dasharray="2 1"/>
              <path class="fp-path" d="M26 50.5 C24 40, 40 40, 38 50.5" stroke="white" stroke-width="1.8" stroke-linecap="round" fill="none"/>
              <path class="fp-path" d="M30 52 C29 44, 35 44, 34 52" stroke="white" stroke-width="1.8" stroke-linecap="round" fill="none"/>
              <path class="fp-path" d="M10 40 C10 50, 14 56, 18 58" stroke="white" stroke-width="2" stroke-linecap="round" fill="none"/>
              <path class="fp-path" d="M54 40 C54 50, 50 56, 46 58" stroke="white" stroke-width="2" stroke-linecap="round" fill="none"/>
              <path class="fp-path" d="M26 16 Q32 8 38 16" stroke="white" stroke-width="2.2" stroke-linecap="round" fill="none"/>
            </svg>
            <div id="scanLine" class="absolute left-1/2 -translate-x-1/2 rounded-full hidden" style="width:70%;height:2px;background:rgba(255,255,255,0.85);filter:blur(1px);"></div>
            <div class="text-center leading-tight -mt-1">
              <p id="fpLabel" class="text-[10px] font-bold text-white tracking-widest uppercase" style="font-family: 'Poppins', sans-serif;">Tekan</p>
              <p id="fpSub" class="text-[9px] text-white/70 mt-0.5" style="font-family: 'Poppins', sans-serif;">untuk melakukan absensi</p>
            </div>
          </button>
          <div id="successCircle" class="absolute inset-4 rounded-full flex items-center justify-center hidden" style="background:radial-gradient(circle,#34d399 0%,#10b981 60%,#059669 100%);">
            <svg width="48" height="48" viewBox="0 0 56 56" fill="none"><path class="check-draw" d="M14 28 L24 38 L42 18" stroke="white" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/></svg>
          </div>
        </div>
        <div class="text-center space-y-1" id="scanStatus">
          <p class="text-sm font-semibold text-gray-700" id="statusTitle" style="font-family: 'Poppins', sans-serif;">Memuat data...</p>
          <p class="text-xs text-muted" id="statusSub" style="font-family: 'Poppins', sans-serif;">Mohon tunggu</p>
        </div>
        <div id="progressWrap" class="w-full mt-4 hidden">
          <div class="w-full h-1.5 bg-stone-100 rounded-full overflow-hidden"><div id="progressBar" class="h-full rounded-full transition-none" style="width:0%;background:linear-gradient(90deg,#C8966C,#E5B18A)"></div></div>
          <p class="text-center text-[10px] text-muted mt-1" id="progressLabel" style="font-family: 'Poppins', sans-serif;">Memindai...</p>
        </div>
      </div>
    </div>

    <!-- Status Hari Ini -->
    <div class="bg-white rounded-2xl border border-border shadow-sm overflow-hidden fade-up-3 card-hover">
      <div class="px-4 py-4">
        <p class="text-[10px] font-bold tracking-[.14em] uppercase text-muted mb-3">Status Hari Ini</p>
        <div class="grid grid-cols-2 gap-3">
          <div class="flex items-center gap-2.5 p-2.5 rounded-xl bg-stone-50 border border-stone-100">
            <div class="w-8 h-8 rounded-xl bg-emerald-50 flex items-center justify-center flex-shrink-0"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#10b981" stroke-width="2.5"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg></div>
            <div><p class="text-[10px] text-muted font-medium uppercase tracking-wide">Masuk</p><p class="text-sm font-bold text-gray-900" id="todayMasuk">—</p></div>
          </div>
          <div class="flex items-center gap-2.5 p-2.5 rounded-xl bg-stone-50 border border-stone-100">
            <div class="w-8 h-8 rounded-xl bg-red-50 flex items-center justify-center flex-shrink-0"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#ef4444" stroke-width="2.5"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg></div>
            <div><p class="text-[10px] text-muted font-medium uppercase tracking-wide">Pulang</p><p class="text-sm font-bold text-gray-900" id="todayPulang">—</p></div>
          </div>
        </div>
      </div>
    </div>

    <!-- Recent History -->
    <div class="bg-white rounded-2xl border border-border shadow-sm overflow-hidden fade-up-4 card-hover">
      <div class="px-4 pt-4 pb-2">
        <div class="flex items-center justify-between mb-3">
          <h3 class="font-semibold text-gray-900 text-sm">Recent History</h3>
          <button onclick="window.location.href='{{ route('historyabsensi') }}'" class="text-[10px] text-terra font-medium hover:underline">Lihat semua</button>
        </div>
        <div class="space-y-2" id="historyList">
          <div class="flex justify-center py-6" id="historyLoading">
            <svg class="animate-spin h-5 w-5 text-terra" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
              <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
              <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
          </div>
          <div id="historyContent" class="hidden"></div>
        </div>
      </div>
    </div>
  </div>
</main>

<!-- Bottom Nav (sama persis dengan halaman lain) -->
<nav class="fixed bottom-0 left-0 right-0 z-50 bg-white border-t border-border flex justify-around py-2 pb-4 shadow-[0_-2px_12px_rgba(28,28,28,0.06)]">
  <button class="bn-item flex flex-col items-center gap-1 flex-1" onclick="window.location.href='{{ route('dashboard-karyawan') }}'">
    <div class="bn-icon w-10 h-10 rounded-xl flex items-center justify-center"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#9C8B7E" stroke-width="2"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg></div><span class="bn-label text-[10px] font-medium text-muted">Beranda</span>
  </button>
  <button class="bn-item active flex flex-col items-center gap-1 flex-1">
    <div class="bn-icon w-10 h-10 rounded-xl flex items-center justify-center"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#9C8B7E" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/><path d="m9 16 2 2 4-4"/></svg></div><span class="bn-label text-[10px] font-medium text-terra">Absensi</span>
  </button>
  <button class="bn-item flex flex-col items-center gap-1 flex-1" onclick="window.location.href='{{ route('stok-produk') }}'">
    <div class="bn-icon w-10 h-10 rounded-xl flex items-center justify-center"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#9C8B7E" stroke-width="2"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/></svg></div><span class="bn-label text-[10px] font-medium text-muted">Stok Produk</span>
  </button>
  <button class="bn-item flex flex-col items-center gap-1 flex-1" onclick="window.location.href='{{ route('karyawan.profile') }}'">
    <div class="bn-icon w-10 h-10 rounded-xl flex items-center justify-center"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#9C8B7E" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg></div><span class="bn-label text-[10px] font-medium text-muted">Profil</span>
  </button>
</nav>

<!-- TOAST -->
<div id="toast" class="fixed bottom-24 left-1/2 -translate-x-1/2 z-[60] px-4 py-2.5 rounded-full shadow-xl flex items-center gap-2 pointer-events-none transition-all duration-300 opacity-0 translate-y-4 bg-gray-900 text-white text-xs font-medium" style="font-family: 'Poppins', sans-serif;"><span id="toastMsg">—</span></div>

<script>
// Live Clock
function updateClock() {
  const now = new Date();
  let h = now.getHours();
  const m = String(now.getMinutes()).padStart(2,'0');
  const ampm = h >= 12 ? 'PM' : 'AM';
  h = h % 12 || 12;
  document.getElementById('liveClock').innerHTML = `${String(h).padStart(2,'0')}<span class="animate-clock-sep">:</span>${m} <span class="text-lg sm:text-xl font-semibold text-muted">${ampm}</span>`;
  document.getElementById('liveDate').textContent = now.toLocaleDateString('id-ID', { weekday:'long', day:'numeric', month:'long', year:'numeric' });
}
updateClock();
setInterval(updateClock, 1000);

// Variabel global
let shiftStatus = 'tidak_aktif';
let checkInTime = null;
let checkOutTime = null;
let scanState = 'idle';
let scanTimer = null;
let absenType = null;

// Load history dari server
async function loadHistory() {
    try {
        const response = await fetch('{{ route("shift.history") }}');
        const histories = await response.json();
        
        const historyContainer = document.getElementById('historyContent');
        const loadingEl = document.getElementById('historyLoading');
        
        if (histories.length === 0) {
            historyContainer.innerHTML = '<p class="text-center text-muted text-xs py-4">Belum ada riwayat absensi</p>';
        } else {
            historyContainer.innerHTML = histories.map(history => `
                <div class="flex items-center justify-between p-2.5 rounded-xl bg-stone-50 border border-stone-100">
                    <div class="flex items-center gap-2.5">
                        <div class="w-7 h-7 rounded-full bg-terra-xs flex items-center justify-center">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#C8966C" stroke-width="2">
                                <rect x="3" y="4" width="18" height="18" rx="2"/>
                                <path d="M16 2v4M8 2v4M3 10h18"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs font-medium text-gray-800">${history.date}</p>
                            <p class="text-[9px] text-muted">${history.check_in} - ${history.check_out}</p>
                        </div>
                    </div>
                    <span class="text-[9px] px-2 py-0.5 rounded-full bg-green-100 text-green-700 font-medium">${history.status === 'hadir' ? 'Hadir' : history.status}</span>
                </div>
            `).join('');
        }
        
        loadingEl.classList.add('hidden');
        historyContainer.classList.remove('hidden');
        
    } catch (error) {
        console.error('Gagal load history:', error);
        const loadingEl = document.getElementById('historyLoading');
        loadingEl.innerHTML = '<p class="text-center text-muted text-xs py-4">Gagal memuat riwayat</p>';
    }
}

// Ambil data dari server saat halaman dimuat
async function loadData() {
    try {
        const response = await fetch('{{ route("shift.status") }}');
        const data = await response.json();
        
        shiftStatus = data.shift_status;
        checkInTime = data.check_in;
        checkOutTime = data.check_out;
        
        if (checkInTime) document.getElementById('todayMasuk').textContent = checkInTime + ' WIB';
        if (checkOutTime) document.getElementById('todayPulang').textContent = checkOutTime + ' WIB';
        
        updateUIByServerStatus();
        await loadHistory();
    } catch (error) {
        console.error('Gagal load data:', error);
        showToast('Gagal memuat data absensi');
    }
}

function updateUIByServerStatus() {
    const statusTitle = document.getElementById('statusTitle');
    const statusSub = document.getElementById('statusSub');
    const fpBtn = document.getElementById('fpBtn');
    
    if (shiftStatus === 'tidak_aktif') {
        statusTitle.textContent = 'Shift Belum Aktif';
        statusSub.textContent = 'Harap aktifkan shift dari dashboard';
        fpBtn.disabled = true;
        fpBtn.style.opacity = '0.5';
        absenType = null;
    } 
    else if (shiftStatus === 'selesai') {
        statusTitle.textContent = 'Absensi Selesai';
        statusSub.textContent = 'Terima kasih, Anda sudah absen hari ini';
        fpBtn.disabled = true;
        fpBtn.style.opacity = '0.5';
        absenType = null;
    }
    else if (shiftStatus === 'aktif') {
        if (checkInTime && !checkOutTime) {
            statusTitle.textContent = 'Siap Absen Pulang';
            statusSub.textContent = 'Tempelkan jari untuk mengakhiri shift';
            fpBtn.disabled = false;
            fpBtn.style.opacity = '1';
            absenType = 'pulang';
        } 
        else if (!checkInTime) {
            statusTitle.textContent = 'Siap Absen Masuk';
            statusSub.textContent = 'Tempelkan jari untuk memulai shift';
            fpBtn.disabled = false;
            fpBtn.style.opacity = '1';
            absenType = 'masuk';
        }
        else {
            fpBtn.disabled = true;
            fpBtn.style.opacity = '0.5';
        }
    }
}

function showToast(msg) {
    const t = document.getElementById('toast');
    document.getElementById('toastMsg').textContent = msg;
    t.style.opacity = '1';
    t.style.transform = 'translateX(-50%) translateY(0)';
    clearTimeout(t._t);
    t._t = setTimeout(() => {
        t.style.opacity = '0';
        t.style.transform = 'translateX(-50%) translateY(16px)';
    }, 2600);
}

async function startScan() {
    if (scanState === 'scanning' || scanState === 'done') return;
    if (shiftStatus !== 'aktif') {
        showToast('⚠️ Shift belum aktif. Aktifkan dari dashboard.');
        return;
    }
    if (checkInTime && checkOutTime) {
        showToast('✅ Anda sudah absen masuk dan pulang hari ini.');
        return;
    }
    
    if (!checkInTime) absenType = 'masuk';
    else if (checkInTime && !checkOutTime) absenType = 'pulang';
    else return;
    
    scanState = 'scanning';
    
    document.getElementById('scanLine').classList.remove('hidden');
    document.getElementById('progressWrap').classList.remove('hidden');
    document.getElementById('fpLabel').textContent = 'Memindai...';
    document.getElementById('fpSub').textContent = 'Jangan angkat jari';
    document.getElementById('statusTitle').textContent = 'Memindai Sidik Jari';
    document.getElementById('statusSub').textContent = 'Harap tunggu...';
    document.getElementById('fpGlow').style.boxShadow = '0 0 40px rgba(200,150,108,.5)';
    document.getElementById('fpBtn').style.pointerEvents = 'none';
    
    let pct = 0;
    const progInterval = setInterval(() => {
        pct += Math.random() * 12 + 4;
        if (pct >= 100) { pct = 100; clearInterval(progInterval); }
        document.getElementById('progressBar').style.width = pct + '%';
        document.getElementById('progressLabel').textContent = pct < 100 ? `Memindai... ${Math.round(pct)}%` : 'Verifikasi berhasil!';
    }, 120);
    
    scanTimer = setTimeout(() => completeScan(progInterval), 1900);
}

async function completeScan(progInterval) {
    clearInterval(progInterval);
    const now = new Date();
    const time = now.toLocaleTimeString('id-ID', { hour:'2-digit', minute:'2-digit' });
    
    try {
        const response = await fetch('{{ route("shift.handle") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ action: absenType })
        });
        const result = await response.json();
        
        if (result.success) {
            document.getElementById('fpGlow').style.opacity = '0';
            const sc = document.getElementById('successCircle');
            sc.classList.remove('hidden');
            sc.classList.add('animate-success-pop');
            document.getElementById('scanLine').classList.add('hidden');
            document.getElementById('progressLabel').textContent = 'Selesai ✓';
            
            if (absenType === 'masuk') {
                document.getElementById('statusTitle').textContent = '✓ Absen Masuk Berhasil';
                document.getElementById('statusSub').textContent = `Tercatat pukul ${time} WIB`;
                document.getElementById('fpLabel').textContent = '✓ Terverifikasi';
                document.getElementById('todayMasuk').textContent = time + ' WIB';
                checkInTime = time;
                showToast('✓ Absen masuk: ' + time);
                absenType = 'pulang';
                setTimeout(() => {
                    resetAfterSuccess('Siap Absen Pulang', 'Tempelkan jari untuk mengakhiri shift', 'Tekan', 'untuk melakukan absensi');
                }, 2000);
            } 
            else if (absenType === 'pulang') {
                document.getElementById('statusTitle').textContent = '✓ Absen Pulang Berhasil';
                document.getElementById('statusSub').textContent = `Tercatat pukul ${time} WIB`;
                document.getElementById('fpLabel').textContent = '✓ Terverifikasi';
                document.getElementById('todayPulang').textContent = time + ' WIB';
                checkOutTime = time;
                showToast('✓ Absen pulang: ' + time);
                await loadHistory();
                setTimeout(() => {
                    document.getElementById('statusTitle').textContent = 'Absensi Selesai';
                    document.getElementById('statusSub').textContent = 'Terima kasih, Anda sudah absen hari ini';
                    document.getElementById('fpLabel').textContent = 'Selesai';
                    document.getElementById('fpSub').textContent = '';
                    document.getElementById('fpBtn').disabled = true;
                    document.getElementById('fpBtn').style.opacity = '0.5';
                }, 2000);
            }
        } else {
            showToast(result.message || 'Terjadi kesalahan');
            resetScanner();
        }
    } catch (error) {
        console.error('Error:', error);
        showToast('Gagal melakukan absensi');
        resetScanner();
    }
    
    scanState = 'done';
    document.getElementById('fpBtn').style.pointerEvents = '';
    document.getElementById('fpGlow').style.boxShadow = '';
    
    setTimeout(() => {
        document.getElementById('progressWrap').classList.add('hidden');
        document.getElementById('progressBar').style.width = '0%';
        document.getElementById('successCircle').classList.add('hidden');
        document.getElementById('successCircle').classList.remove('animate-success-pop');
        document.getElementById('fpGlow').style.opacity = '1';
        scanState = 'idle';
    }, 2500);
}

function resetAfterSuccess(title, sub, label, sublabel) {
    scanState = 'idle';
    document.getElementById('fpGlow').style.opacity = '1';
    document.getElementById('successCircle').classList.add('hidden');
    document.getElementById('successCircle').classList.remove('animate-success-pop');
    document.getElementById('statusTitle').textContent = title;
    document.getElementById('statusSub').textContent = sub;
    document.getElementById('fpLabel').textContent = label;
    document.getElementById('fpSub').textContent = sublabel;
    document.getElementById('progressWrap').classList.add('hidden');
    document.getElementById('progressBar').style.width = '0%';
    document.getElementById('fpBtn').disabled = false;
    document.getElementById('fpBtn').style.opacity = '1';
    document.getElementById('fpGlow').style.boxShadow = '';
}

function resetScanner() {
    scanState = 'idle';
    document.getElementById('fpGlow').style.opacity = '1';
    document.getElementById('successCircle').classList.add('hidden');
    document.getElementById('progressWrap').classList.add('hidden');
    document.getElementById('progressBar').style.width = '0%';
    document.getElementById('fpBtn').disabled = false;
    document.getElementById('fpBtn').style.opacity = '1';
    document.getElementById('fpGlow').style.boxShadow = '';
    updateUIByServerStatus();
}

loadData();
</script>
</body>
</html>