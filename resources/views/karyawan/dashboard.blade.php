<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
<title>Dashboard Karyawan – Kashy</title>
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
      }
    }
  }
</script>
<style>
  * { margin:0; padding:0; box-sizing:border-box; }
  body { font-family: 'DM Sans', sans-serif; background:#F5F0EB; }
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
  input[type="checkbox"] { accent-color: #C8966C; width:1rem; height:1rem; }
  .bn-item.active .bn-icon { background:#F0D7C7; }
  .bn-item.active .bn-icon svg { stroke:#C8966C; }
  .bn-item.active .bn-label { color:#C8966C; font-weight:600; }
</style>
</head>
<body class="bg-bg min-h-screen flex flex-col">

<!-- TOPBAR -->
<nav class="sticky top-0 z-20 bg-gray-900 px-5 py-3 flex items-center justify-between shadow-md">
  
  <div class="w-8"></div>

  <span class="font-display text-xl font-bold text-white tracking-widest">
    Kashy
  </span>

  <!-- Right Actions -->
  <div class="flex items-center gap-2">

    <!-- Notification -->
    <button class="relative w-8 h-8 flex items-center justify-center rounded-full hover:bg-white/10 transition">
      <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#9C8B7E" stroke-width="2">
        <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/>
        <path d="M13.73 21a2 2 0 0 1-3.46 0"/>
      </svg>
      <span class="absolute top-1 right-1 w-2 h-2 bg-terra rounded-full border border-gray-900"></span>
    </button>

    <!-- Logout -->
    <form method="POST" action="{{ route('logout') }}">
      @csrf

      <button 
        type="submit"
        class="w-8 h-8 flex items-center justify-center rounded-full 
               bg-terra-xs border border-terra-ll 
               hover:bg-terra transition-all duration-300 group"
      >
        <svg 
          width="16" 
          height="16" 
          viewBox="0 0 24 24" 
          fill="none" 
          stroke="#C8966C" 
          stroke-width="2.2"
          class="group-hover:stroke-white transition"
        >
          <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/>
          <polyline points="10 17 15 12 10 7"/>
          <line x1="15" y1="12" x2="3" y2="12"/>
        </svg>
      </button>
    </form>

  </div>

</nav>

<main class="flex-1 overflow-y-auto px-4 pt-5 pb-28 max-w-2xl mx-auto w-full">
  
  <!-- GREETING -->
  <div class="mb-6 fade-up delay-1">
    <p class="text-xs text-muted font-medium uppercase tracking-wide" id="greetTime">Selamat Pagi</p>
    <h1 class="font-display text-3xl sm:text-4xl font-bold italic text-gray-900 mt-0.5">
      Selamat Pagi, <span class="text-terra">Aris</span>
    </h1>
    <p class="text-sm text-muted mt-2 leading-relaxed">Senang melihatmu kembali. Berikut ringkasan hari ini.</p>
  </div>

  <!-- STAT ROW -->
  <div class="grid grid-cols-2 gap-3 mb-6 fade-up delay-2">
    <div class="bg-white rounded-2xl px-4 py-3 shadow-sm border border-border card-hover">
      <div class="flex items-center justify-between">
        <div class="flex items-center gap-3">
          <div class="w-10 h-10 rounded-xl bg-terra-xs flex items-center justify-center">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#C8966C" stroke-width="2">
              <rect x="3" y="4" width="18" height="18" rx="2"/>
              <path d="M16 2v4M8 2v4M3 10h18"/>
            </svg>
          </div>
          <div>
            <p class="text-xs text-muted font-medium">Hari Kehadiran</p>
            <h3 class="text-lg font-bold text-gray-900">3 Hari</h3>
          </div>
        </div>
      </div>
    </div>
    <div class="bg-white rounded-2xl px-4 py-3 shadow-sm border border-border card-hover">
      <div class="flex items-center justify-between">
        <div class="flex items-center gap-3">
          <div class="w-10 h-10 rounded-xl bg-emerald-50 flex items-center justify-center">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#10b981" stroke-width="2">
              <path d="M20 6 9 17l-5-5"/>
            </svg>
          </div>
          <div>
            <p class="text-xs text-muted font-medium">Jumlah Tugas</p>
            <h3 class="text-lg font-bold text-gray-900">
              <span id="completedTaskCount">0</span>/<span id="totalTaskCount">4</span>
            </h3>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- SHIFT CARD -->
  <div class="bg-white rounded-2xl shadow-sm border border-border overflow-hidden mb-6 fade-up delay-3">
    <div class="shimmer-bar h-1 w-full"></div>
    <div class="p-5">
      <div class="flex flex-wrap justify-between items-start gap-2 mb-4">
        <div class="flex items-center gap-3">
          <div class="w-11 h-11 rounded-xl bg-terra-xs flex items-center justify-center">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#C8966C" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
          </div>
          <div>
            <h2 class="font-semibold text-gray-900 text-lg">Shift Pagi</h2>
            <p class="text-xs text-muted">08:00 – 16:00 WIB</p>
          </div>
        </div>
        <!-- Status badge (dinamis) -->
        <div id="shiftBadge" class="flex items-center gap-1.5 bg-red-100 px-3 py-1.5 rounded-full border border-red-300">
          <span id="badgeDot" class="w-2 h-2 rounded-full bg-red-500"></span>
          <span id="badgeText" class="text-[11px] font-semibold text-red-600">Tidak Aktif</span>
        </div>
      </div>
      
      <!-- Timeline Shift (awal tersembunyi) -->
      <div id="shiftTimeline" class="mb-4 hidden">
        <div class="flex justify-between text-[10px] text-muted mb-1">
          <span>08:00</span>
          <span class="text-terra font-semibold" id="currentTimeLabel">--:--</span>
          <span>16:00</span>
        </div>
        <div class="h-1.5 bg-stone-100 rounded-full overflow-hidden">
          <div class="h-full bg-terra rounded-full" id="shiftProgressBar" style="width:0%"></div>
        </div>
      </div>

      <!-- Lokasi & Supervisor -->
      <div class="flex flex-col sm:flex-row sm:items-center gap-2 text-xs text-muted mb-4">
        <div class="flex items-center gap-1.5">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
          <span>Main Gallery, Jakarta</span>
        </div>
        <div class="flex items-center gap-1.5">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
          <span>Supervisor: Budi S.</span>
        </div>
      </div>

      <!-- Tombol Shift (dinamis) -->
      <button id="shiftButton" onclick="handleShiftAction()" class="w-full sm:w-auto px-5 py-2.5 bg-emerald-500 hover:bg-emerald-600 text-white text-sm font-semibold rounded-xl transition-all flex items-center justify-center gap-2 shadow-sm hover:shadow-md">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg>
        <span id="shiftButtonText">Aktifkan Shift Hari Ini</span>
      </button>
    </div>
  </div>

  <!-- TUGAS HARI INI (sama seperti sebelumnya) -->
  <div class="bg-white rounded-2xl shadow-sm border border-border overflow-hidden mb-6 fade-up delay-3">
    <div class="px-5 pt-5 pb-4">
      <div class="flex items-center justify-between mb-4">
        <div class="flex items-center gap-2.5">
          <div class="w-8 h-8 rounded-xl bg-terra-xs flex items-center justify-center">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#C8966C" stroke-width="2"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
          </div>
          <div>
            <h3 class="font-semibold text-gray-900">Tugas Hari Ini</h3>
            <p class="text-[11px] text-muted" id="taskProgress">0 dari 4 selesai</p>
          </div>
        </div>
        <button class="w-8 h-8 rounded-lg bg-terra flex items-center justify-center hover:bg-terra-l transition">
          <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
        </button>
      </div>
      <div class="w-full h-1.5 bg-stone-100 rounded-full mb-5">
        <div id="taskBar" class="h-full bg-terra rounded-full transition-all duration-500" style="width:0%"></div>
      </div>
      <ul class="space-y-3" id="taskList">
        <li class="task-item flex flex-wrap sm:flex-nowrap items-center gap-3 p-3 rounded-xl bg-stone-50 border border-stone-100 hover:border-terra-l transition cursor-pointer" onclick="toggleTask(this)">
          <input type="checkbox" class="w-4 h-4 rounded flex-shrink-0" onclick="event.stopPropagation()">
          <div class="flex-1 min-w-0">
            <span class="text-sm text-gray-800 font-medium">Cek inventory masuk</span>
            <div class="flex items-center gap-1 mt-0.5">
              <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="#9C8B7E" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
              <span class="text-[10px] text-muted">09:00</span>
            </div>
          </div>
          <span class="badge text-[10px] px-2 py-0.5 rounded-full bg-amber-50 text-amber-600 border border-amber-100 font-medium">Pending</span>
        </li>
        <li class="task-item flex flex-wrap sm:flex-nowrap items-center gap-3 p-3 rounded-xl bg-stone-50 border border-stone-100 hover:border-terra-l transition cursor-pointer" onclick="toggleTask(this)">
          <input type="checkbox" class="w-4 h-4 rounded flex-shrink-0" onclick="event.stopPropagation()">
          <div class="flex-1 min-w-0">
            <span class="text-sm text-gray-800 font-medium">Update label harga</span>
            <div class="flex items-center gap-1 mt-0.5">
              <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="#9C8B7E" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
              <span class="text-[10px] text-muted">10:00</span>
            </div>
          </div>
          <span class="badge text-[10px] px-2 py-0.5 rounded-full bg-amber-50 text-amber-600 border border-amber-100 font-medium">Pending</span>
        </li>
        <li class="task-item flex flex-wrap sm:flex-nowrap items-center gap-3 p-3 rounded-xl bg-stone-50 border border-stone-100 hover:border-terra-l transition cursor-pointer" onclick="toggleTask(this)">
          <input type="checkbox" class="w-4 h-4 rounded flex-shrink-0" onclick="event.stopPropagation()">
          <div class="flex-1 min-w-0">
            <span class="text-sm text-gray-800 font-medium">Rapikan display baju baru</span>
            <div class="flex items-center gap-1 mt-0.5">
              <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="#9C8B7E" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
              <span class="text-[10px] text-muted">13:00</span>
            </div>
          </div>
          <span class="badge text-[10px] px-2 py-0.5 rounded-full bg-amber-50 text-amber-600 border border-amber-100 font-medium">Pending</span>
        </li>
      </ul>
    </div>
  </div>

  <!-- QUOTE BANNER -->
  <div class="rounded-2xl overflow-hidden relative min-h-[150px] shadow-md fade-up delay-4" style="background-image:url('https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=800&q=80'); background-size:cover; background-position:center 30%;">
    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-black/20"></div>
    <div class="relative z-10 flex flex-col justify-end h-full p-5 min-h-[150px]">
      <div class="w-8 h-0.5 bg-terra rounded-full mb-3"></div>
      <blockquote class="font-display text-xl sm:text-2xl italic font-semibold text-white leading-snug">"Kesederhanaan adalah kecanggihan tertinggi."</blockquote>
      <p class="text-xs text-white/60 mt-2">— Leonardo da Vinci</p>
    </div>
  </div>
</main>

<!-- BOTTOM NAV -->
<nav class="fixed bottom-0 left-0 right-0 z-20 bg-white border-t border-border flex justify-around py-2 pb-4 shadow-[0_-2px_12px_rgba(0,0,0,0.05)]">
  <button class="bn-item active flex flex-col items-center gap-1 flex-1" onclick="setNav(this)">
    <div class="bn-icon w-10 h-10 rounded-xl flex items-center justify-center transition"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#9C8B7E" stroke-width="2"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg></div>
    <span class="bn-label text-[10px] font-medium text-muted">Beranda</span>
  </button>
  <button class="bn-item flex flex-col items-center gap-1 flex-1" onclick="window.location.href='{{ route('absensi') }}'">
    <div class="bn-icon w-10 h-10 rounded-xl flex items-center justify-center transition"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#9C8B7E" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/><path d="m9 16 2 2 4-4"/></svg></div>
    <span class="bn-label text-[10px] font-medium text-muted">Absensi</span>
  </button>
  <button class="bn-item flex flex-col items-center gap-1 flex-1" onclick="setNav(this)">
    <div class="bn-icon w-10 h-10 rounded-xl flex items-center justify-center transition"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#9C8B7E" stroke-width="2"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/></svg></div>
    <span class="bn-label text-[10px] font-medium text-muted">Stok Produk</span>
  </button>
  <button class="bn-item flex flex-col items-center gap-1 flex-1" onclick="setNav(this)">
    <div class="bn-icon w-10 h-10 rounded-xl flex items-center justify-center transition"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#9C8B7E" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg></div>
    <span class="bn-label text-[10px] font-medium text-muted">Profil</span>
  </button>
</nav>

<!-- TOAST NOTIF -->
<div id="toast" class="fixed bottom-24 left-1/2 -translate-x-1/2 z-30 bg-gray-900 text-white text-sm font-medium px-5 py-3 rounded-full shadow-xl flex items-center gap-2 pointer-events-none transition-all duration-300 opacity-0 translate-y-4">
  <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5"><path d="M20 6 9 17l-5-5"/></svg>
  <span id="toastMsg">—</span>
</div>

<script>
  // ======================= GREETING =======================
  (function() {
    const h = new Date().getHours();
    let greet = 'Selamat Pagi';
    if (h >= 11 && h < 15) greet = 'Selamat Siang';
    else if (h >= 15 && h < 18) greet = 'Selamat Sore';
    else if (h >= 18) greet = 'Selamat Malam';
    document.getElementById('greetTime').innerText = greet;
    const heading = document.querySelector('h1');
    if(heading) heading.innerHTML = `${greet}, <span class="text-terra">Aris</span>`;
  })();

  // ======================= SHIFT STATUS (localStorage) =======================
  function loadShiftStatus() {
    const shiftActive = localStorage.getItem('shiftActive') === 'true';
    const shiftStartTime = localStorage.getItem('shiftStartTime');
    if (shiftActive && shiftStartTime) {
      // Shift aktif: tampilkan timeline, ubah badge, tombol disabled
      document.getElementById('shiftTimeline').classList.remove('hidden');
      // Ubah badge
      const badge = document.getElementById('shiftBadge');
      badge.classList.remove('bg-red-100', 'border-red-300');
      badge.classList.add('bg-emerald-100', 'border-emerald-300');
      document.getElementById('badgeDot').className = 'w-2 h-2 rounded-full bg-emerald-500 pulse-dot';
      document.getElementById('badgeText').innerText = 'Aktif';
      // Ubah tombol
      const btn = document.getElementById('shiftButton');
      btn.disabled = true;
      btn.classList.remove('bg-emerald-500', 'hover:bg-emerald-600');
      btn.classList.add('bg-gray-400', 'cursor-not-allowed', 'hover:bg-gray-400');
      document.getElementById('shiftButtonText').innerHTML = 'Shift Sedang Berjalan';
      // Update timeline setiap menit
      updateCurrentTime();
      setInterval(updateCurrentTime, 60000);
    } else {
      // Shift tidak aktif: timeline tetap tersembunyi, badge merah, tombol aktif
      document.getElementById('shiftTimeline').classList.add('hidden');
      // Badge sudah default (Tidak Aktif)
      // Tombol aktif
      const btn = document.getElementById('shiftButton');
      btn.disabled = false;
      btn.classList.add('bg-emerald-500', 'hover:bg-emerald-600');
      btn.classList.remove('bg-gray-400', 'cursor-not-allowed', 'hover:bg-gray-400');
      document.getElementById('shiftButtonText').innerHTML = 'Aktifkan Shift Hari Ini';
    }
  }

  function updateCurrentTime() {
    const now = new Date();
    const hours = now.getHours().toString().padStart(2,'0');
    const minutes = now.getMinutes().toString().padStart(2,'0');
    document.getElementById('currentTimeLabel').innerText = `${hours}:${minutes}`;
    // Hitung progress shift (08:00 - 16:00)
    const startHour = 8, endHour = 16;
    let currentHour = now.getHours() + now.getMinutes()/60;
    let progress = ((currentHour - startHour) / (endHour - startHour)) * 100;
    progress = Math.min(100, Math.max(0, progress));
    document.getElementById('shiftProgressBar').style.width = progress + '%';
  }

  // ======================= TOMBOL SHIFT =======================
  function handleShiftAction() {
    // Cek apakah shift sudah aktif (tombol mungkin di-disable, tapi safety)
    if (localStorage.getItem('shiftActive') === 'true') {
      showToast('Shift sudah aktif!');
      return;
    }
    // Arahkan ke halaman absensi dengan parameter ?from=dashboard
    window.location.href = '{{ route("absensi") }}?from=dashboard&action=startShift';
  }

  // ======================= TASK MANAGEMENT =======================
  function toggleTask(li) {
    const cb = li.querySelector('input[type="checkbox"]');
    const badge = li.querySelector('.badge');
    cb.checked = !cb.checked;
    const labelSpan = li.querySelector('span.text-sm');
    if (cb.checked) {
      labelSpan.classList.add('line-through', 'text-muted');
      li.classList.add('opacity-60');
      if (badge) { badge.innerText = 'Selesai'; badge.className = badge.className.replace(/amber|blue/g, 'emerald'); }
    } else {
      labelSpan.classList.remove('line-through', 'text-muted');
      li.classList.remove('opacity-60');
      if (badge) { badge.innerText = 'Pending'; badge.className = badge.className.replace('emerald', 'amber'); }
    }
    updateTaskProgress();
  }

  function updateTaskProgress() {
    const total = document.querySelectorAll('.task-item').length;
    const done = document.querySelectorAll('.task-item input:checked').length;
    const percent = Math.round((done / total) * 100);
    document.getElementById('taskProgress').innerText = `${done} dari ${total} selesai`;
    document.getElementById('taskBar').style.width = percent + '%';
    document.getElementById('completedTaskCount').innerText = done;
    document.getElementById('totalTaskCount').innerText = total;
  }

  // ======================= BOTTOM NAV =======================
  function setNav(el) {
    document.querySelectorAll('.bn-item').forEach(b => b.classList.remove('active'));
    el.classList.add('active');
  }

  // ======================= TOAST =======================
  let toastTimeout;
  function showToast(msg) {
    const toast = document.getElementById('toast');
    document.getElementById('toastMsg').innerText = msg;
    toast.style.opacity = '1';
    toast.style.transform = 'translateX(-50%) translateY(0)';
    clearTimeout(toastTimeout);
    toastTimeout = setTimeout(() => {
      toast.style.opacity = '0';
      toast.style.transform = 'translateX(-50%) translateY(16px)';
    }, 2600);
  }

  // ======================= INIT =======================
  loadShiftStatus();
  updateTaskProgress(); // hitung progress awal
</script>
</body>
</html>