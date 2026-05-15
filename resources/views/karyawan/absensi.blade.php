<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
<title>Absensi – Kashy</title>
<script src="https://cdn.tailwindcss.com"></script>
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,600;0,700;1,400;1,600&family=DM+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
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
          display: ['Cormorant Garamond', 'serif'],
          body:    ['DM Sans', 'sans-serif'],
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
  .scanning .fp-path { animation: drawFp 1.8s ease-out forwards; }
  .check-draw { stroke-dasharray: 60; stroke-dashoffset: 60; }
  .ripple-el { animation: ripple 0.55s ease-out forwards; }
  @keyframes ripple {
    from { transform: scale(0.5); opacity: .6; }
    to   { transform: scale(2.2); opacity: 0; }
  }
</style>
</head>
<body class="bg-bg min-h-screen flex flex-col">

<!-- TOPBAR (Konsisten dengan dashboard) -->
<nav class="sticky top-0 z-50 bg-gray-900 flex items-center justify-between px-5 shadow-md h-[52px]">
  <a href="javascript:history.back()" class="flex items-center gap-1.5 text-xs text-gray-400 hover:text-white transition-colors no-underline">
    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M19 12H5m7-7-7 7 7 7"/></svg>
    Kembali
  </a>
  <span class="font-display text-xl font-bold text-white tracking-widest">Kashy</span>
  <button class="relative w-8 h-8 flex items-center justify-center rounded-full hover:bg-white/10 transition-colors">
    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="#9C8B7E" stroke-width="2"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
    <span class="absolute top-1 right-1 w-2 h-2 bg-terra rounded-full border-2 border-gray-900"></span>
  </button>
</nav>

<!-- MAIN CONTENT -->
<main class="flex-1 overflow-y-auto">
  <div class="max-w-md mx-auto px-4 pt-6 pb-28 space-y-5">

    <!-- Session Card (Visibility of System Status) -->
    <div class="bg-white rounded-2xl shadow-sm border border-border overflow-hidden animate-fade-up-1">
      <div class="shimmer-bar h-1 w-full bg-gradient-to-r from-terra via-terra-l via-terra-ll to-terra bg-[length:200%] animate-shimmer-slow"></div>
      <div class="px-5 py-5 text-center">
        <p class="text-[10px] font-bold tracking-[.18em] uppercase text-terra mb-1">Current Session</p>
        <div class="font-display text-5xl sm:text-6xl font-bold text-gray-900 leading-none mb-1" id="liveClock">
          --<span class="animate-clock-sep">:</span>-- <span class="text-2xl sm:text-3xl font-semibold text-muted">--</span>
        </div>
        <p class="text-sm text-muted mt-1" id="liveDate">--</p>
      </div>
    </div>

    <!-- Fingerprint Scanner Card (Affordance & Feedback) -->
    <div class="bg-white rounded-2xl shadow-sm border border-border overflow-hidden animate-fade-up-2">
      <div class="px-5 py-8 flex flex-col items-center">
        <div class="relative flex items-center justify-center mb-6 w-[200px] h-[200px]">
          <div class="absolute rounded-full border-2 border-terra/30 inset-0 animate-ring-1"></div>
          <div class="absolute rounded-full border-2 border-terra/20 animate-ring-2" style="inset:-8px;border-radius:9999px;"></div>
          <div class="absolute rounded-full border-2 border-terra/10 animate-ring-3" style="inset:-18px;border-radius:9999px;"></div>
          <div id="fpGlow" class="absolute inset-4 rounded-full transition-all duration-500" style="background:radial-gradient(circle,#E5B18A 0%,#C8966C 60%,#a07050 100%);"></div>
          <button id="fpBtn" class="relative z-10 w-36 h-36 rounded-full flex flex-col items-center justify-center gap-2 select-none focus:outline-none focus:ring-2 focus:ring-terra" style="background:transparent;" onmousedown="startScan()" ontouchstart="startScan()">
            <svg id="fpSvg" width="64" height="64" viewBox="0 0 64 64" fill="none" class="drop-shadow-sm">
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
              <p id="fpLabel" class="text-xs font-bold text-white tracking-widest uppercase">Tekan</p>
              <p id="fpSub" class="text-[10px] text-white/70 mt-0.5">untuk melakukan absensi</p>
            </div>
          </button>
          <div id="successCircle" class="absolute inset-4 rounded-full flex items-center justify-center hidden" style="background:radial-gradient(circle,#34d399 0%,#10b981 60%,#059669 100%);">
            <svg width="56" height="56" viewBox="0 0 56 56" fill="none"><path class="check-draw" d="M14 28 L24 38 L42 18" stroke="white" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/></svg>
          </div>
        </div>
        <div class="text-center space-y-1" id="scanStatus">
          <p class="text-sm font-semibold text-gray-700" id="statusTitle">Siap Absen</p>
          <p class="text-xs text-muted" id="statusSub">Tempelkan jari Anda pada sensor</p>
        </div>
        <div id="progressWrap" class="w-full mt-5 hidden">
          <div class="w-full h-1.5 bg-stone-100 rounded-full overflow-hidden"><div id="progressBar" class="h-full rounded-full transition-none" style="width:0%;background:linear-gradient(90deg,#C8966C,#E5B18A)"></div></div>
          <p class="text-center text-xs text-muted mt-2" id="progressLabel">Memindai...</p>
        </div>
      </div>
    </div>

    <!-- Shift Times & Today Status (sama seperti sebelumnya) -->
    <div class="grid grid-cols-2 gap-3 animate-fade-up-3">
      <div class="bg-white rounded-2xl border border-border shadow-sm p-4"><p class="text-[10px] font-bold tracking-[.14em] uppercase text-muted mb-2">Mulai Bekerja</p><div class="flex items-end gap-1"><span class="font-display text-3xl font-bold text-gray-900 italic leading-none">08:00</span><span class="text-xs text-muted mb-0.5">h</span></div><div class="mt-2 flex items-center gap-1.5"><span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span><span class="text-[11px] text-emerald-600 font-medium">Shift Pagi</span></div></div>
      <div class="bg-white rounded-2xl border border-border shadow-sm p-4"><p class="text-[10px] font-bold tracking-[.14em] uppercase text-muted mb-2">Selesai Bekerja</p><div class="flex items-end gap-1"><span class="font-display text-3xl font-bold text-gray-900 italic leading-none">16:00</span><span class="text-xs text-muted mb-0.5">h</span></div><div class="mt-2 flex items-center gap-1.5"><span class="w-1.5 h-1.5 rounded-full bg-terra"></span><span class="text-[11px] text-terra font-medium">Main Gallery</span></div></div>
    </div>

    <div class="bg-white rounded-2xl border border-border shadow-sm overflow-hidden animate-fade-up-4">
      <div class="px-5 py-4"><p class="text-[10px] font-bold tracking-[.14em] uppercase text-muted mb-3">Status Hari Ini</p><div class="grid grid-cols-2 gap-3"><div class="flex items-center gap-2.5 p-3 rounded-xl bg-stone-50 border border-stone-100"><div class="w-8 h-8 rounded-xl bg-emerald-50 flex items-center justify-center flex-shrink-0"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#10b981" stroke-width="2.5"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg></div><div><p class="text-[10px] text-muted font-medium uppercase tracking-wide">Masuk</p><p class="text-sm font-bold text-gray-900" id="todayMasuk">—</p></div></div><div class="flex items-center gap-2.5 p-3 rounded-xl bg-stone-50 border border-stone-100"><div class="w-8 h-8 rounded-xl bg-red-50 flex items-center justify-center flex-shrink-0"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#ef4444" stroke-width="2.5"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg></div><div><p class="text-[10px] text-muted font-medium uppercase tracking-wide">Pulang</p><p class="text-sm font-bold text-gray-900" id="todayPulang">—</p></div></div></div></div>
    </div>

    <!-- Recent History (sama) -->
    <div class="bg-white rounded-2xl shadow-sm border border-border overflow-hidden animate-fade-up-4 [animation-delay:0.33s]">
      <div class="px-5 pt-5 pb-2"><div class="flex items-center justify-between mb-4"><h3 class="font-semibold text-gray-900 text-base">Recent History</h3><button class="text-xs text-terra font-medium hover:underline">Lihat semua</button></div><div class="space-y-2.5" id="historyList">...</div></div>
      <div class="border-t border-stone-100 mx-5 mt-3 py-3.5 flex items-center justify-center gap-2 cursor-pointer hover:bg-terra-xs transition-colors rounded-b-2xl"><span class="text-xs text-muted font-medium">Tampilkan lebih banyak</span><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#9C8B7E" stroke-width="2.5"><path d="m6 9 6 6 6-6"/></svg></div>
    </div>
  </div>
</main>

<!-- BOTTOM NAV (Konsisten) -->
<nav class="fixed bottom-0 left-0 right-0 z-50 bg-white border-t border-border flex justify-around py-2.5 pb-4 shadow-[0_-2px_12px_rgba(28,28,28,0.06)]">
  <button class="bn-item flex flex-col items-center gap-1 flex-1" onclick="window.location.href='{{ route('dashboard-karyawan') }}'"><div class="bn-icon w-10 h-10 rounded-xl flex items-center justify-center transition-all hover:bg-terra-xs hover:-translate-y-0.5"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#9C8B7E" stroke-width="2"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg></div><span class="bn-label text-[10px] font-medium text-muted">Beranda</span></button>
  <button class="bn-item active flex flex-col items-center gap-1 flex-1" onclick="setNav(this)"><div class="bn-icon w-10 h-10 rounded-xl flex items-center justify-center transition-all hover:bg-terra-xs hover:-translate-y-0.5"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#9C8B7E" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/><path d="m9 16 2 2 4-4"/></svg></div><span class="bn-label text-[10px] font-medium text-muted">Absensi</span></button>
  <button class="bn-item flex flex-col items-center gap-1 flex-1" onclick="window.location.href='/karyawan/stok-produk'"><div class="bn-icon w-10 h-10 rounded-xl flex items-center justify-center transition-all hover:bg-terra-xs hover:-translate-y-0.5"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#9C8B7E" stroke-width="2"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/></svg></div><span class="bn-label text-[10px] font-medium text-muted">Stok Produk</span></button>
  <button class="bn-item flex flex-col items-center gap-1 flex-1" onclick="setNav(this)"><div class="bn-icon w-10 h-10 rounded-xl flex items-center justify-center transition-all hover:bg-terra-xs hover:-translate-y-0.5"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#9C8B7E" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg></div><span class="bn-label text-[10px] font-medium text-muted">Profil</span></button>
</nav>

<!-- TOAST -->
<div id="toast" class="fixed bottom-24 left-1/2 -translate-x-1/2 z-[60] px-5 py-3 rounded-full shadow-xl flex items-center gap-2 pointer-events-none transition-all duration-300 opacity-0 translate-y-4 bg-gray-900 text-white text-sm font-medium"><span id="toastMsg">—</span></div>

<script>
// ======================= IMK PRINCIPLES IMPLEMENTED =======================
// 1. Visibility of system status: live clock, progress bar, status badge.
// 2. Match between system and real world: fingerprint icon, familiar language.
// 3. User control and freedom: back button, disabled scan if shift inactive.
// 4. Consistency and standards: same colors, nav bar, fonts as dashboard.
// 5. Error prevention: cannot scan if shift not active or already checked.
// 6. Recognition rather than recall: clear labels and instructions.
// 7. Flexibility and efficiency: one-tap fingerprint scanning.
// 8. Aesthetic and minimalist design: clean layout, no clutter.
// 9. Help users recognize, diagnose, recover: toast messages for errors.

// Live Clock
function updateClock() {
  const now = new Date();
  let h = now.getHours();
  const m = String(now.getMinutes()).padStart(2,'0');
  const ampm = h >= 12 ? 'PM' : 'AM';
  h = h % 12 || 12;
  document.getElementById('liveClock').innerHTML = `${String(h).padStart(2,'0')}<span class="animate-clock-sep">:</span>${m} <span class="text-2xl sm:text-3xl font-semibold text-muted">${ampm}</span>`;
  document.getElementById('liveDate').textContent = now.toLocaleDateString('id-ID', { weekday:'long', day:'numeric', month:'long', year:'numeric' });
}
updateClock();
setInterval(updateClock, 1000);

// --- Load shift & absensi status from localStorage (integrated with dashboard) ---
let shiftActive = localStorage.getItem('shiftActive') === 'true';
let masukTime = localStorage.getItem('masukTime');
let pulangTime = localStorage.getItem('pulangTime');

if (masukTime) document.getElementById('todayMasuk').textContent = masukTime + ' WIB';
if (pulangTime) document.getElementById('todayPulang').textContent = pulangTime + ' WIB';

// Update UI based on shift & attendance status
let absenType = null;
const statusTitle = document.getElementById('statusTitle');
const statusSub = document.getElementById('statusSub');
const fpBtn = document.getElementById('fpBtn');

if (!shiftActive && !masukTime) {
    statusTitle.textContent = 'Shift Belum Aktif';
    statusSub.textContent = 'Harap aktifkan shift dari dashboard terlebih dahulu';
    fpBtn.disabled = true;
    fpBtn.style.opacity = '0.5';
} else if (shiftActive && !masukTime) {
    absenType = 'masuk';
    statusTitle.textContent = 'Siap Absen Masuk';
    statusSub.textContent = 'Tempelkan jari untuk memulai shift';
    fpBtn.disabled = false;
    fpBtn.style.opacity = '1';
} else if (shiftActive && masukTime && !pulangTime) {
    absenType = 'pulang';
    statusTitle.textContent = 'Siap Absen Pulang';
    statusSub.textContent = 'Tempelkan jari untuk mengakhiri shift';
    fpBtn.disabled = false;
    fpBtn.style.opacity = '1';
} else {
    statusTitle.textContent = 'Absensi Selesai';
    statusSub.textContent = 'Terima kasih, Anda sudah absen hari ini';
    fpBtn.disabled = true;
    fpBtn.style.opacity = '0.5';
}

let scanState = 'idle';
let scanTimer = null;

function startScan() {
    if (scanState === 'scanning' || scanState === 'done') return;
    if (!shiftActive && !masukTime) {
        showToast('⚠️ Shift belum aktif. Aktifkan dari dashboard.');
        return;
    }
    if (masukTime && pulangTime) {
        showToast('✅ Anda sudah absen masuk dan pulang hari ini.');
        return;
    }
    if (!masukTime && shiftActive) absenType = 'masuk';
    else if (masukTime && !pulangTime) absenType = 'pulang';
    
    scanState = 'scanning';
    // Visual feedback: hide rings, show scan line, progress bar
    document.querySelectorAll('#ring1, #ring2, #ring3').forEach(r => r.style.opacity = '0');
    document.getElementById('scanLine').classList.remove('hidden');
    document.getElementById('progressWrap').classList.remove('hidden');
    document.getElementById('fpLabel').textContent = 'Memindai...';
    document.getElementById('fpSub').textContent = 'Jangan angkat jari';
    document.getElementById('statusTitle').textContent = 'Memindai Sidik Jari';
    document.getElementById('statusSub').textContent = 'Harap tunggu sebentar...';
    document.getElementById('fpGlow').style.boxShadow = '0 0 40px rgba(200,150,108,.5)';

    let pct = 0;
    const progInterval = setInterval(() => {
        pct += Math.random() * 12 + 4;
        if (pct >= 100) { pct = 100; clearInterval(progInterval); }
        document.getElementById('progressBar').style.width = pct + '%';
        document.getElementById('progressLabel').textContent = pct < 100 ? `Memindai... ${Math.round(pct)}%` : 'Verifikasi berhasil!';
    }, 120);
    scanTimer = setTimeout(() => completeScan(progInterval), 1900);
}

function completeScan(progInterval) {
    clearInterval(progInterval);
    scanState = 'success';
    const now = new Date();
    const time = now.toLocaleTimeString('id-ID', { hour:'2-digit', minute:'2-digit' });

    // Success animation
    document.getElementById('fpBtn').style.pointerEvents = 'none';
    document.getElementById('fpGlow').style.opacity = '0';
    const sc = document.getElementById('successCircle');
    sc.classList.remove('hidden');
    sc.classList.add('animate-success-pop');

    document.getElementById('statusTitle').textContent = absenType === 'masuk' ? '✓ Absen Masuk Berhasil' : '✓ Absen Pulang Berhasil';
    document.getElementById('statusSub').textContent = `Tercatat pukul ${time} WIB`;
    document.getElementById('fpLabel').textContent = '✓ Terverifikasi';
    document.getElementById('fpSub').textContent = '';
    document.getElementById('scanLine').classList.add('hidden');
    document.getElementById('progressLabel').textContent = 'Selesai ✓';

    if (absenType === 'masuk') {
        masukTime = time;
        document.getElementById('todayMasuk').textContent = time + ' WIB';
        addHistoryRow(now, time, null);
        showToast('✓ Absen masuk: ' + time);
        localStorage.setItem('masukTime', time);
        localStorage.setItem('shiftActive', 'true');
        localStorage.setItem('shiftStartTime', now.toISOString());
        // Redirect to dashboard after short delay
        setTimeout(() => {
            window.location.href = '/karyawan/dashboard'; // adjust route as needed
        }, 1500);
    } else {
        pulangTime = time;
        document.getElementById('todayPulang').textContent = time + ' WIB';
        updateHistoryPulang(time);
        showToast('✓ Absen pulang: ' + time);
        localStorage.setItem('pulangTime', time);
        setTimeout(() => {
            window.location.href = '/karyawan/dashboard';
        }, 1500);
    }
}

function resetScanner(title, sub, label, sublabel) {
    scanState = 'idle';
    document.getElementById('fpGlow').style.opacity = '1';
    document.getElementById('fpGlow').style.boxShadow = '';
    document.getElementById('successCircle').classList.add('hidden');
    document.getElementById('successCircle').classList.remove('animate-success-pop');
    document.getElementById('fpBtn').style.pointerEvents = '';
    document.querySelectorAll('#ring1, #ring2, #ring3').forEach(r => r.style.opacity = '');
    document.getElementById('statusTitle').textContent = title;
    document.getElementById('statusSub').textContent = sub;
    document.getElementById('fpLabel').textContent = label;
    document.getElementById('fpSub').textContent = sublabel;
    document.getElementById('progressWrap').classList.add('hidden');
    document.getElementById('progressBar').style.width = '0%';
}

function setNav(el) {
    document.querySelectorAll('.bn-item').forEach(b => b.classList.remove('active'));
    el.classList.add('active');
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

function addHistoryRow(date, masuk, pulang) {
    const list = document.getElementById('historyList');
    const dateStr = date.toLocaleDateString('en-US', { month:'short', day:'numeric', year:'numeric' });
    const row = document.createElement('div');
    row.id = 'todayRow';
    row.className = 'hist-row flex items-center gap-3 p-3 rounded-xl border-2 border-terra-l bg-terra-xs cursor-pointer hover:bg-terra-xs hover:translate-x-1 transition-all';
    row.innerHTML = `<div class="w-9 h-9 rounded-xl bg-white flex items-center justify-center flex-shrink-0 shadow-sm"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#C8966C" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg></div><div class="flex-1 min-w-0"><p class="text-sm font-semibold text-gray-900">${dateStr} <span class="text-[10px] text-terra font-bold ml-1">HARI INI</span></p><p class="text-xs text-muted mt-0.5" id="todayTimeRange">${masuk} – –</p></div><span class="text-[10px] font-bold px-2.5 py-1 rounded-full bg-green-100 text-green-700 border border-green-200">ON TIME</span>`;
    list.insertBefore(row, list.firstChild);
}

function updateHistoryPulang(pulang) {
    const range = document.getElementById('todayTimeRange');
    if (range) range.textContent = range.textContent.replace('– –', '– ' + pulang);
}
</script>
</body>
</html>