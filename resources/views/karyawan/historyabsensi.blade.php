<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>History Absensi – Kashy</title>
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
          poppins: ['Poppins', 'sans-serif'],
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
  .bn-item.active .bn-icon { background:#F0D7C7; }
  .bn-item.active .bn-icon svg { stroke:#C8966C; }
  .bn-item.active .bn-label { color:#C8966C; font-weight:600; }
  .calendar-grid {
    display: grid;
    grid-template-columns: repeat(7, 1fr);
    gap: 0.25rem;
    text-align: center;
  }
  .calendar-day {
    padding: 0.5rem 0;
    font-size: 0.75rem;
    font-weight: 500;
    border-radius: 0.5rem;
    cursor: pointer;
    transition: all 0.15s;
  }
  .calendar-day:hover {
    background-color: #F0D7C7;
    color: #C8966C;
  }
  .calendar-day.selected {
    background-color: #C8966C;
    color: white;
  }
</style>
</head>

<body class="bg-bg min-h-screen flex flex-col font-poppins">

<!-- TOPBAR with Back Button -->
<nav class="sticky top-0 z-20 bg-gray-900 px-4 py-3 flex items-center justify-between shadow-md">
  <button onclick="goBack()" class="w-9 h-9 flex items-center justify-center rounded-lg hover:bg-white/10 transition">
    <svg width="25" height="25" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5">
      <path d="M19 12H5M12 19l-7-7 7-7"/>
    </svg>
  </button>
  <span class="font-poppins text-xl font-bold text-white tracking-widest">Kashy</span>
  <div class="w-9"></div>
</nav>

<main class="flex-1 overflow-y-auto pb-28">
  <div class="max-w-md mx-auto w-full px-4 pt-5 space-y-5">
    <!-- GREETING -->
    <div class="fade-up delay-1">
      <p class="text-xs text-muted font-medium uppercase tracking-wide">Riwayat Absensi Karyawan</p>
      <h1 class="font-display text-2xl font-bold text-gray-900 mt-0.5">
        Selamat Pagi, <span class="text-terra" id="userName">{{ Auth::user()->name }}</span>
      </h1>
      <p class="text-xs text-muted mt-1 leading-relaxed">Berikut adalah riwayat absensi Anda.</p>
    </div>
    
    <!-- Summary Stats -->
    <div class="grid grid-cols-3 gap-2 fade-up delay-1">
      <div class="bg-white rounded-xl border border-border shadow-sm p-2 flex items-center gap-1.5">
        <div class="w-6 h-6 bg-green-50 rounded-lg flex items-center justify-center flex-shrink-0">
          <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#10b981" stroke-width="2.5">
            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
            <polyline points="22 4 12 14.01 9 11.01"/>
          </svg>
        </div>
        <div>
          <p class="text-base font-bold text-gray-900 leading-tight" id="totalHadir">0</p>
          <p class="text-[8px] text-muted font-medium uppercase tracking-wide">Hadir</p>
        </div>
      </div>
      <div class="bg-white rounded-xl border border-border shadow-sm p-2 flex items-center gap-1.5">
        <div class="w-6 h-6 bg-yellow-50 rounded-lg flex items-center justify-center flex-shrink-0">
          <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#f59e0b" stroke-width="2.5">
            <circle cx="12" cy="12" r="10"/>
            <polyline points="12 6 12 12 16 14"/>
          </svg>
        </div>
        <div>
          <p class="text-base font-bold text-gray-900 leading-tight" id="totalTerlambat">0</p>
          <p class="text-[8px] text-muted font-medium uppercase tracking-wide">Terlambat</p>
        </div>
      </div>
      <div class="bg-white rounded-xl border border-border shadow-sm p-2 flex items-center gap-1.5">
        <div class="w-6 h-6 bg-red-50 rounded-lg flex items-center justify-center flex-shrink-0">
          <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#ef4444" stroke-width="2.5">
            <circle cx="12" cy="12" r="10"/>
            <line x1="15" y1="9" x2="9" y2="15"/>
            <line x1="9" y1="9" x2="15" y2="15"/>
          </svg>
        </div>
        <div>
          <p class="text-base font-bold text-gray-900 leading-tight" id="totalTidakHadir">0</p>
          <p class="text-[8px] text-muted font-medium uppercase tracking-wide">Tidak Hadir</p>
        </div>
      </div>
    </div>

    <!-- Filter Section -->
    <div class="bg-white rounded-2xl border border-border shadow-sm p-4 space-y-3 fade-up delay-2">
      <!-- Filter Buttons (Status) -->
      <div class="flex items-center gap-2 overflow-x-auto pb-1">
        <button onclick="setFilter('semua')" id="filterSemua" class="filter-btn active px-4 py-2 rounded-lg text-xs font-semibold whitespace-nowrap transition bg-terra text-white hover:bg-terra-l">
          Semua
        </button>
        <button onclick="setFilter('hadir')" id="filterHadir" class="filter-btn px-4 py-2 rounded-lg text-xs font-semibold whitespace-nowrap transition bg-stone-100 text-muted hover:bg-terra-xs">
          Hadir
        </button>
        <button onclick="setFilter('terlambat')" id="filterTerlambat" class="filter-btn px-4 py-2 rounded-lg text-xs font-semibold whitespace-nowrap transition bg-stone-100 text-muted hover:bg-terra-xs">
          Terlambat
        </button>
        <button onclick="setFilter('tidak_hadir')" id="filterTidakHadir" class="filter-btn px-4 py-2 rounded-lg text-xs font-semibold whitespace-nowrap transition bg-stone-100 text-muted hover:bg-terra-xs">
          Tidak Hadir
        </button>
      </div>

      <div class="flex flex-wrap items-center gap-2 pt-2 border-t border-stone-100">
        <div class="relative flex-1 min-w-[150px]">
          <input type="text" id="filterPreviewInput" readonly 
            class="w-full pl-9 pr-3 py-2.5 border border-border rounded-xl text-sm font-medium text-gray-700 bg-stone-50 cursor-default"
            placeholder="Pilih Tanggal / Bulan & Tahun">
          <svg class="absolute left-3 top-1/2 -translate-y-1/2 text-muted" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <rect x="3" y="4" width="18" height="18" rx="2"/><path d="M8 2v4M16 2v4M3 10h18"/>
          </svg>
        </div>
        
        <button id="openCalendarBtn" class="flex-shrink-0 w-10 h-10 bg-terra text-white rounded-xl flex items-center justify-center hover:bg-terra-l transition shadow-sm">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2">
            <rect x="3" y="4" width="18" height="18" rx="2"/>
            <path d="M8 2v4M16 2v4M3 10h18"/>
          </svg>
        </button>
        
        <button id="resetCalendarFilter" class="flex-shrink-0 px-3 py-2.5 bg-stone-100 rounded-xl text-xs font-semibold text-muted hover:bg-stone-200 transition">Reset</button>
      </div>
    </div>

    <!-- History List -->
    <div class="space-y-3 fade-up delay-3" id="historyContainer">
      <div class="flex justify-center py-8" id="historyLoading">
        <svg class="animate-spin h-6 w-6 text-terra" viewBox="0 0 24 24" fill="none">
          <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
          <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
        </svg>
      </div>
      <div id="historyContent" class="hidden"></div>
    </div>

    <!-- Empty State -->
    <div id="emptyState" class="hidden bg-white rounded-2xl border border-border shadow-sm p-8 text-center">
      <div class="w-16 h-16 mx-auto mb-3 bg-stone-100 rounded-full flex items-center justify-center">
        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#9C8B7E" stroke-width="2">
          <rect x="3" y="4" width="18" height="18" rx="2"/>
          <path d="M16 2v4M8 2v4M3 10h18"/>
        </svg>
      </div>
      <p class="text-sm font-semibold text-gray-900 mb-1">Tidak ada data</p>
      <p class="text-xs text-muted">Tidak ada riwayat absensi yang sesuai filter</p>
    </div>
  </div>
</main>

<!-- Bottom Nav -->
<nav class="fixed bottom-0 left-0 right-0 z-50 bg-white border-t border-border flex justify-around py-2 pb-4 shadow-[0_-2px_12px_rgba(28,28,28,0.06)]">
  <button class="bn-item flex flex-col items-center gap-1 flex-1" onclick="window.location.href='{{ route('dashboard-karyawan') }}'">
    <div class="bn-icon w-10 h-10 rounded-xl flex items-center justify-center"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#9C8B7E" stroke-width="2"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg></div><span class="bn-label text-[10px] font-medium text-muted">Beranda</span>
  </button>
  <button class="bn-item flex flex-col items-center gap-1 flex-1" onclick="window.location.href='{{ route('absensi') }}'">
    <div class="bn-icon w-10 h-10 rounded-xl flex items-center justify-center"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#9C8B7E" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/><path d="m9 16 2 2 4-4"/></svg></div><span class="bn-label text-[10px] font-medium text-muted">Absensi</span>
  </button>
  <button class="bn-item flex flex-col items-center gap-1 flex-1" onclick="window.location.href='{{ route('stok-produk') }}'">
    <div class="bn-icon w-10 h-10 rounded-xl flex items-center justify-center"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#9C8B7E" stroke-width="2"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/></svg></div><span class="bn-label text-[10px] font-medium text-muted">Stok Produk</span>
  </button>
  <button class="bn-item flex flex-col items-center gap-1 flex-1" onclick="window.location.href='{{ route('karyawan.profile') }}'">
    <div class="bn-icon w-10 h-10 rounded-xl flex items-center justify-center"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#9C8B7E" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg></div><span class="bn-label text-[10px] font-medium text-muted">Profil</span>
  </button>
</nav>

<!-- MODAL KALENDER -->
<div id="calendarModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm hidden transition-all duration-300">
  <div class="bg-white rounded-2xl w-[90%] max-w-sm mx-4 shadow-2xl transform transition-all">
    <div class="p-5 pb-2 text-center">
      <h3 class="text-base font-bold text-gray-800 tracking-wide">PILIH TANGGAL</h3>
    </div>
    <div class="px-5 pb-2">
      <div class="bg-stone-50 rounded-xl p-2 text-center border border-stone-100">
        <span id="previewDate" class="text-sm font-semibold text-gray-700">-</span>
      </div>
    </div>
    <div class="px-5 flex gap-3 mb-3">
      <select id="monthSelect" class="flex-1 border border-border rounded-lg py-2 px-2 text-sm font-medium focus:border-terra">
        <option value="0">Januari</option><option value="1">Februari</option><option value="2">Maret</option>
        <option value="3">April</option><option value="4">Mei</option><option value="5">Juni</option>
        <option value="6">Juli</option><option value="7">Agustus</option><option value="8">September</option>
        <option value="9">Oktober</option><option value="10">November</option><option value="11">Desember</option>
      </select>
      <select id="yearSelect" class="flex-1 border border-border rounded-lg py-2 px-2 text-sm font-medium focus:border-terra"></select>
    </div>
    <div class="px-5">
      <div class="calendar-grid text-[11px] font-semibold text-muted mb-1">
        <span>M</span><span>S</span><span>S</span><span>R</span><span>K</span><span>J</span><span>S</span>
      </div>
      <div id="calendarDaysGrid" class="calendar-grid mb-4"></div>
    </div>
    <div class="flex border-t border-border">
      <button id="cancelCalendarBtn" class="flex-1 py-3 text-center text-sm font-semibold text-muted hover:bg-stone-50 transition rounded-bl-2xl">BATAL</button>
      <div class="w-px bg-border"></div>
      <button id="selectCalendarBtn" class="flex-1 py-3 text-center text-sm font-semibold text-terra hover:bg-terra-xs transition rounded-br-2xl">PILIH</button>
    </div>
  </div>
</div>

<!-- TOAST -->
<div id="toast" class="fixed bottom-24 left-1/2 -translate-x-1/2 z-30 bg-gray-900 text-white text-sm font-medium px-5 py-3 rounded-full shadow-xl flex items-center gap-2 pointer-events-none transition-all duration-300 opacity-0 translate-y-4">
  <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5"><path d="M20 6 9 17l-5-5"/></svg>
  <span id="toastMsg">—</span>
</div>

<script>
// ========== GLOBAL VARIABLES ==========
let currentStatus = 'semua';
let currentYear = null;
let currentMonth = null;
let currentDate = null;
let selectedYear = new Date().getFullYear();
let selectedMonth = new Date().getMonth();
let selectedDay = new Date().getDate();
const monthNames = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

// ========== LOAD DATA DARI SERVER ==========
async function loadData() {
    try {
        let url = '{{ route("shift.full-history") }}';
        let params = [];
        
        if (currentDate) {
            params.push(`date=${currentDate}`);
        } else if (currentYear !== null && currentMonth !== null) {
            params.push(`year=${currentYear}`);
            params.push(`month=${currentMonth + 1}`);
        }
        
        if (currentStatus !== 'semua') {
            params.push(`status=${currentStatus}`);
        }
        
        if (params.length > 0) {
            url += '?' + params.join('&');
        }
        
        const response = await fetch(url);
        const data = await response.json();
        
        document.getElementById('totalHadir').textContent = data.stats.hadir || 0;
        document.getElementById('totalTerlambat').textContent = data.stats.terlambat || 0;
        document.getElementById('totalTidakHadir').textContent = data.stats.tidak_hadir || 0;
        
        renderHistory(data.histories);
        
    } catch (error) {
        console.error('Gagal load data:', error);
        showToast('Gagal memuat riwayat absensi');
    }
}

function renderHistory(histories) {
    const container = document.getElementById('historyContent');
    const loadingEl = document.getElementById('historyLoading');
    const emptyState = document.getElementById('emptyState');
    
    loadingEl.classList.add('hidden');
    
    if (histories.length === 0) {
        container.innerHTML = '';
        container.classList.add('hidden');
        emptyState.classList.remove('hidden');
        return;
    }
    
    emptyState.classList.add('hidden');
    container.classList.remove('hidden');
    
    container.innerHTML = histories.map(history => {
        let statusConfig = getStatusConfig(history.status);
        return `
        <div class="bg-white rounded-xl border border-border shadow-sm p-3 card-hover">
          <div class="flex items-start justify-between gap-2">
            <div class="w-9 h-9 ${statusConfig.bgColor} rounded-lg flex items-center justify-center flex-shrink-0">
              ${statusConfig.icon}
            </div>
            <div class="flex-1 min-w-0">
              <p class="text-xs font-bold text-gray-900">${history.date}</p>
              <div class="flex items-center gap-2 mt-1.5">
                <div class="flex items-center gap-1">
                  <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="#10b981" stroke-width="2.5">
                    <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/>
                    <polyline points="10 17 15 12 10 7"/>
                    <line x1="15" y1="12" x2="3" y2="12"/>
                  </svg>
                  <span class="text-[10px] font-medium text-gray-800">${history.check_in}</span>
                </div>
                <span class="text-muted text-[8px]">→</span>
                <div class="flex items-center gap-1">
                  <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="#ef4444" stroke-width="2.5">
                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                    <polyline points="16 17 21 12 16 7"/>
                    <line x1="21" y1="12" x2="9" y2="12"/>
                  </svg>
                  <span class="text-[10px] font-medium text-gray-800">${history.check_out}</span>
                </div>
              </div>
              ${history.shift_type ? `<p class="text-[9px] text-muted mt-1">Shift ${history.shift_type === 'pagi' ? 'Pagi' : 'Malam'} (${history.shift_start} - ${history.shift_end})</p>` : ''}
            </div>
            <span class="px-2 py-0.5 rounded-full text-[9px] font-bold ${statusConfig.badgeClass}">${statusConfig.label}</span>
          </div>
        </div>`;
    }).join('');
}

function getStatusConfig(status) {
    const configs = {
        'Hadir': { label: 'Hadir', badgeClass: 'bg-green-100 text-green-700', bgColor: 'bg-green-50', 
            icon: '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#10b981" stroke-width="2.5"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>' },
        'Terlambat': { label: 'Terlambat', badgeClass: 'bg-yellow-100 text-yellow-700', bgColor: 'bg-yellow-50', 
            icon: '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#f59e0b" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>' },
        'Tidak Hadir': { label: 'Tidak Hadir', badgeClass: 'bg-red-100 text-red-700', bgColor: 'bg-red-50', 
            icon: '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#ef4444" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>' }
    };
    return configs[status] || configs['Hadir'];
}

// ========== FILTER FUNCTIONS ==========
function setFilter(status) {
    currentStatus = status;
    
    document.querySelectorAll('.filter-btn').forEach(btn => {
        btn.classList.remove('active', 'bg-terra', 'text-white');
        btn.classList.add('bg-stone-100', 'text-muted');
    });
    
    let activeBtn = document.getElementById(`filter${status.charAt(0).toUpperCase() + status.slice(1)}`);
    if (status === 'semua') activeBtn = document.getElementById('filterSemua');
    if (status === 'tidak_hadir') activeBtn = document.getElementById('filterTidakHadir');
    
    if (activeBtn) {
        activeBtn.classList.remove('bg-stone-100', 'text-muted');
        activeBtn.classList.add('active', 'bg-terra', 'text-white');
    }
    
    loadData();
}

// ========== CALENDAR FUNCTIONS ==========
function buildCalendar(year, month) {
    const firstDayOfMonth = new Date(year, month, 1);
    let startWeekday = firstDayOfMonth.getDay();
    let startOffset = (startWeekday + 6) % 7;
    const daysInMonth = new Date(year, month + 1, 0).getDate();
    const daysGrid = [];
    for (let i = 0; i < startOffset; i++) daysGrid.push(null);
    for (let d = 1; d <= daysInMonth; d++) daysGrid.push(d);
    return daysGrid;
}

function renderCalendarGrid(year, month) {
    const grid = buildCalendar(year, month);
    const container = document.getElementById('calendarDaysGrid');
    container.innerHTML = '';
    grid.forEach(day => {
        const div = document.createElement('div');
        div.className = 'calendar-day';
        if (day === null) {
            div.innerHTML = '';
            div.classList.add('opacity-0', 'cursor-default', 'hover:bg-transparent');
        } else {
            div.innerHTML = day;
            if (day === selectedDay && year === selectedYear && month === selectedMonth) div.classList.add('selected');
            div.addEventListener('click', () => {
                document.querySelectorAll('.calendar-day').forEach(d => d.classList.remove('selected'));
                div.classList.add('selected');
                selectedDay = day;
                selectedMonth = month;
                selectedYear = year;
                updatePreviewDate();
            });
        }
        container.appendChild(div);
    });
}

function updatePreviewDate() {
    const dateObj = new Date(selectedYear, selectedMonth, selectedDay);
    const formattedDate = `${selectedDay} ${monthNames[selectedMonth]} ${selectedYear}`;
    document.getElementById('previewDate').innerHTML = formattedDate;
}

function populateYearSelect() {
    const currentYear = new Date().getFullYear();
    const select = document.getElementById('yearSelect');
    select.innerHTML = '';
    for (let y = currentYear - 5; y <= currentYear + 5; y++) {
        const option = document.createElement('option');
        option.value = y;
        option.textContent = y;
        if (y === selectedYear) option.selected = true;
        select.appendChild(option);
    }
}

function openCalendarModal() {
    const modal = document.getElementById('calendarModal');
    modal.classList.remove('hidden');
    document.getElementById('monthSelect').value = selectedMonth;
    document.getElementById('yearSelect').value = selectedYear;
    renderCalendarGrid(selectedYear, selectedMonth);
    updatePreviewDate();
}

function closeCalendarModal() {
    document.getElementById('calendarModal').classList.add('hidden');
}

function applyCalendarSelection() {
    const month = parseInt(document.getElementById('monthSelect').value);
    const year = parseInt(document.getElementById('yearSelect').value);
    
    // Kirim sebagai filter tanggal (bukan bulan/tahun)
    const selectedDate = `${year}-${String(month + 1).padStart(2, '0')}-${String(selectedDay).padStart(2, '0')}`;
    
    currentDate = selectedDate;
    currentYear = null;
    currentMonth = null;
    
    document.getElementById('filterPreviewInput').value = `${selectedDay} ${monthNames[month]} ${year}`;
    
    loadData();
    closeCalendarModal();
    showToast(`Menampilkan data tanggal ${selectedDay} ${monthNames[month]} ${year}`);
}

function resetCalendarFilter() {
    currentYear = null;
    currentMonth = null;
    currentDate = null;
    selectedYear = new Date().getFullYear();
    selectedMonth = new Date().getMonth();
    selectedDay = new Date().getDate();
    document.getElementById('filterPreviewInput').value = '';
    loadData();
    showToast('Filter direset');
}

function initCalendar() {
    populateYearSelect();
    document.getElementById('openCalendarBtn').addEventListener('click', openCalendarModal);
    document.getElementById('resetCalendarFilter').addEventListener('click', resetCalendarFilter);
    document.getElementById('cancelCalendarBtn').addEventListener('click', closeCalendarModal);
    document.getElementById('selectCalendarBtn').addEventListener('click', applyCalendarSelection);
    
    document.getElementById('monthSelect').addEventListener('change', () => {
        const month = parseInt(document.getElementById('monthSelect').value);
        const year = parseInt(document.getElementById('yearSelect').value);
        renderCalendarGrid(year, month);
        updatePreviewDate();
    });
    
    document.getElementById('yearSelect').addEventListener('change', () => {
        const month = parseInt(document.getElementById('monthSelect').value);
        const year = parseInt(document.getElementById('yearSelect').value);
        renderCalendarGrid(year, month);
        updatePreviewDate();
    });
    
    document.getElementById('calendarModal').addEventListener('click', (e) => {
        if (e.target === document.getElementById('calendarModal')) closeCalendarModal();
    });
}

function goBack() {
    window.history.back();
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

// ========== GREETING ==========
(function() {
    const h = new Date().getHours();
    let greet = 'Selamat Pagi';
    if (h >= 11 && h < 15) greet = 'Selamat Siang';
    else if (h >= 15 && h < 18) greet = 'Selamat Sore';
    else if (h >= 18) greet = 'Selamat Malam';
    const greetingElement = document.querySelector('.font-display');
    if (greetingElement) {
        const userName = document.getElementById('userName')?.innerText || 'Karyawan';
        greetingElement.innerHTML = `${greet}, <span class="text-terra">${userName}</span>`;
    }
})();

// ========== INIT ==========
function init() {
    initCalendar();
    loadData();
}

init();
</script>
</body>
</html>