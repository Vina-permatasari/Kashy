<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Dashboard Karyawan – Kashy</title>
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
  input[type="checkbox"] { accent-color: #C8966C; width:1rem; height:1rem; }
  .bn-item.active .bn-icon { background:#F0D7C7; }
  .bn-item.active .bn-icon svg { stroke:#C8966C; }
  .bn-item.active .bn-label { color:#C8966C; font-weight:600; }
</style>
</head>
<body class="bg-bg min-h-screen flex flex-col">

<!-- TOPBAR (judul di tengah) -->
<nav class="sticky top-0 z-50 bg-gray-900 flex items-center justify-center px-5 shadow-md h-[52px]">
  <span class="font-poppins text-xl font-bold text-white tracking-widest">Kashy</span>
</nav>

<main class="flex-1 overflow-y-auto pb-28">
  <div class="max-w-md mx-auto px-4 pt-5 space-y-5">

    <!-- GREETING -->
    <div class="fade-up delay-1">
      <p class="text-xs text-muted font-medium uppercase tracking-wide">Dashboard Karyawan</p>
      <h1 class="font-display text-3xl font-bold text-gray-900 mt-0.5" id="greetTime">
        Selamat Pagi, <span class="text-terra">{{ Auth::user()->name }}</span>
      </h1>
      <p class="text-xs text-muted mt-1 leading-relaxed">Berikut ringkasan hari ini.</p>
    </div>

    <!-- SHIFT CARD (tanpa timeline) -->
    <div class="bg-white rounded-2xl border border-border shadow-sm overflow-hidden fade-up delay-2 card-hover">
      <div class="shimmer-bar h-1 w-full"></div>
      <div class="p-4">
        <div class="flex flex-wrap justify-between items-start gap-2 mb-3">
          <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-terra-xs flex items-center justify-center flex-shrink-0">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#C8966C" stroke-width="2">
                <circle cx="12" cy="12" r="10"/>
                <path d="M12 6v6l4 2"/>
              </svg>
            </div>
            <div>
              <h2 class="font-semibold text-gray-900 text-base">Shift Saat Ini</h2>
              <p class="text-[10px] text-muted" id="shiftHariTanggal"></p>
            </div>
          </div>
          <!-- Badge Status -->
          <div id="shiftBadge" class="flex items-center gap-1.5 px-3 py-1.5 rounded-full border">
            <span id="badgeDot" class="w-2 h-2 rounded-full"></span>
            <span id="badgeText" class="text-[10px] font-semibold">Memuat...</span>
          </div>
        </div>

        <!-- Waktu Mulai dan Berakhir -->
        <div class="grid grid-cols-2 gap-3 mb-3">
          <div>
            <p class="text-[9px] text-muted uppercase tracking-wide">Mulai</p>
            <p class="text-sm font-semibold text-gray-900" id="shiftMulai">08:00</p>
          </div>
          <div>
            <p class="text-[9px] text-muted uppercase tracking-wide">Berakhir</p>
            <p class="text-sm font-semibold text-gray-900" id="shiftBerakhir">16:00</p>
          </div>
        </div>

        <!-- Informasi Nama, Posisi -->
        <div class="flex flex-col gap-2 text-xs text-muted border-t border-border pt-3 mt-1">
          <div class="flex flex-wrap gap-3">
            <div class="flex items-center gap-1.5">
              <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                <circle cx="12" cy="7" r="4"/>
              </svg>
              <span>Nama: <strong class="text-gray-800">{{ Auth::user()->name }}</strong></span>
            </div>
            <div class="flex items-center gap-1.5">
              <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <rect x="3" y="4" width="18" height="16" rx="2"/>
                <path d="M3 10h18"/>
              </svg>
              <span>Posisi: <strong class="text-gray-800">{{ Auth::user()->role ?? 'Karyawan' }}</strong></span>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- TO-DO LIST (konsisten ukuran card) -->
    <div class="bg-white rounded-2xl border border-border shadow-sm overflow-hidden fade-up delay-3 card-hover">
      <div class="p-4">
        <div class="flex items-center justify-between mb-4 flex-wrap gap-2">
          <div class="flex items-center gap-2.5">
            <div class="w-8 h-8 rounded-xl bg-terra-xs flex items-center justify-center">
              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#C8966C" stroke-width="2"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
            </div>
            <div>
              <h3 class="font-semibold text-gray-900 text-sm">To-Do List Hari Ini</h3>
              <p class="text-[10px] text-muted">Tambah tugas yang harus diselesaikan</p>
            </div>
          </div>
          <div class="flex gap-2">
            <button id="showTodoFormBtn" class="px-3 py-1.5 bg-terra text-white rounded-lg text-xs font-semibold hover:bg-terra-l transition flex items-center gap-1">
              <svg width="12" height="12" fill="none" stroke="white" stroke-width="2" viewBox="0 0 24 24"><path d="M12 5v14M5 12h14"/></svg>
              Tambah
            </button>
            <button id="deleteAllBtn" class="px-3 py-1.5 bg-red-50 text-red-500 rounded-lg text-xs font-medium hover:bg-red-100 transition flex items-center gap-1">
              <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 6h18M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
              Hapus
            </button>
          </div>
        </div>

        <!-- Form tambah tugas (hidden) -->
        <div id="todoForm" class="hidden mb-4 p-3 bg-stone-50 rounded-xl border border-stone-200">
          <div class="flex flex-col gap-2">
            <textarea id="todoInput" rows="2" placeholder="Tulis tugas baru..." class="w-full px-3 py-2 border border-border rounded-xl text-sm focus:outline-none focus:border-terra focus:ring-1 focus:ring-terra bg-white resize-none"></textarea>
            <div class="flex justify-between gap-2">
              <button onclick="hideTodoForm()" class="px-3 py-2 bg-gray-200 text-gray-700 rounded-lg text-xs font-semibold hover:bg-gray-300 transition flex-1">Batal</button>
              <button onclick="tambahTugas()" class="px-3 py-2 bg-terra text-white rounded-lg text-xs font-semibold hover:bg-terra-l transition flex-1">Simpan</button>
            </div>
          </div>
        </div>

        <!-- Daftar tugas -->
        <div id="todoListContainer" class="space-y-2 max-h-64 overflow-y-auto"></div>
        <p id="todoEmpty" class="text-center text-muted text-xs py-4 hidden">Belum ada tugas. Klik "Tambah" untuk membuat daftar.</p>
      </div>
    </div>

    <!-- QUOTE BANNER -->
    <div class="rounded-2xl overflow-hidden relative min-h-[130px] shadow-sm fade-up delay-4" style="background-image:url('https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=800&q=80'); background-size:cover; background-position:center 30%;">
      <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-black/20"></div>
      <div class="relative z-10 flex flex-col justify-end h-full p-4 min-h-[130px]">
        <div class="w-8 h-0.5 bg-terra rounded-full mb-2"></div>
        <blockquote class="font-display text-lg italic font-semibold text-white leading-snug">"Kesederhanaan adalah kecanggihan tertinggi."</blockquote>
        <p class="text-[10px] text-white/60 mt-1">— Leonardo da Vinci</p>
      </div>
    </div>
  </div>
</main>

<!-- Bottom Nav -->
<nav class="fixed bottom-0 left-0 right-0 z-50 bg-white border-t border-border flex justify-around py-2 pb-4 shadow-[0_-2px_12px_rgba(28,28,28,0.06)]">
  <button class="bn-item active flex flex-col items-center gap-1 flex-1" onclick="window.location.href='{{ route('dashboard-karyawan') }}'">
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

<!-- TOAST NOTIF -->
<div id="toast" class="fixed bottom-24 left-1/2 -translate-x-1/2 z-30 bg-gray-900 text-white text-sm font-medium px-5 py-3 rounded-full shadow-xl flex items-center gap-2 pointer-events-none transition-all duration-300 opacity-0 translate-y-4">
  <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5"><path d="M20 6 9 17l-5-5"/></svg>
  <span id="toastMsg">—</span>
</div>

<!-- Modal Konfirmasi Hapus Semua -->
<div id="confirmDeleteAllModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm hidden transition-all duration-300">
  <div class="bg-white rounded-2xl max-w-sm w-full mx-4 p-5 shadow-2xl transform transition-all scale-95">
    <div class="text-center">
      <div class="w-12 h-12 rounded-full bg-red-100 flex items-center justify-center mx-auto mb-3">
        <svg width="22" height="22" fill="none" stroke="#ef4444" stroke-width="2" viewBox="0 0 24 24"><path d="M3 6h18M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
      </div>
      <h3 class="text-md font-semibold text-gray-900 mb-2">Hapus Semua Tugas?</h3>
      <p class="text-xs text-muted mb-5">Tindakan ini tidak dapat dibatalkan.</p>
      <div class="flex gap-3">
        <button id="cancelDeleteAllBtn" class="flex-1 px-4 py-2 bg-gray-100 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-200 transition">Batal</button>
        <button id="confirmDeleteAllBtn" class="flex-1 px-4 py-2 bg-red-500 text-white rounded-lg text-sm font-medium hover:bg-red-600 transition">Ya, Hapus</button>
      </div>
    </div>
  </div>
</div>

<script>
  // ========== SHIFT (tanpa timeline) ==========
  const SHIFT_STORAGE_KEY = 'kashy_shift';
  const SHIFT_DURATION_MIN = 480;
  const DEFAULT_START = "08:00";
  const DEFAULT_END = "16:00";

  let shiftOpen = false;
  let shiftStartTime = null;

  const shiftBadge = document.getElementById('shiftBadge');
  const badgeDot = document.getElementById('badgeDot');
  const badgeText = document.getElementById('badgeText');
  const shiftHariTanggal = document.getElementById('shiftHariTanggal');

  const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
  shiftHariTanggal.innerText = new Date().toLocaleDateString('id-ID', options);

  function loadShiftFromStorage() {
    const saved = localStorage.getItem(SHIFT_STORAGE_KEY);
    if (saved) {
      try {
        const data = JSON.parse(saved);
        shiftOpen = data.active || false;
        if (data.startTime) {
          shiftStartTime = new Date(data.startTime);
          if (shiftOpen && shiftStartTime) {
            const now = new Date();
            const diffMinutes = (now - shiftStartTime) / 60000;
            if (diffMinutes >= SHIFT_DURATION_MIN) {
              shiftOpen = false;
              shiftStartTime = null;
              localStorage.removeItem(SHIFT_STORAGE_KEY);
            }
          }
        } else {
          shiftStartTime = null;
        }
      } catch(e) { console.warn(e); }
    } else {
      shiftOpen = false;
      shiftStartTime = null;
    }
    updateShiftUI();
  }

  function updateShiftUI() {
    if (shiftOpen && shiftStartTime) {
      badgeDot.className = "w-2 h-2 rounded-full bg-green-500 pulse-dot";
      badgeText.innerText = "Aktif";
      shiftBadge.className = "flex items-center gap-1.5 px-3 py-1.5 rounded-full border border-green-300 text-green-500 bg-green-100";
      
      const startH = shiftStartTime.getHours().toString().padStart(2,'0');
      const startM = shiftStartTime.getMinutes().toString().padStart(2,'0');
      const endDate = new Date(shiftStartTime.getTime() + SHIFT_DURATION_MIN * 60000);
      const endH = endDate.getHours().toString().padStart(2,'0');
      const endM = endDate.getMinutes().toString().padStart(2,'0');
      
      document.getElementById('shiftMulai') && (document.getElementById('shiftMulai').innerText = `${startH}:${startM}`);
      document.getElementById('shiftBerakhir') && (document.getElementById('shiftBerakhir').innerText = `${endH}:${endM}`);
    } else {
      badgeDot.className = "w-2 h-2 rounded-full bg-red-500";
      badgeText.innerText = "Tidak Aktif";
      shiftBadge.className = "flex items-center gap-1.5 px-3 py-1.5 rounded-full border border-red-300 text-red-500 bg-red-100";
      
      document.getElementById('shiftMulai') && (document.getElementById('shiftMulai').innerText = DEFAULT_START);
      document.getElementById('shiftBerakhir') && (document.getElementById('shiftBerakhir').innerText = DEFAULT_END);
    }
  }

  window.addEventListener('storage', (event) => {
    if (event.key === SHIFT_STORAGE_KEY) {
      loadShiftFromStorage();
    }
  });

  loadShiftFromStorage();

  // ========== TO-DO LIST ==========
  let todos = [];

  function loadTodos() {
    const stored = localStorage.getItem('kashy_todos');
    if (stored) {
      try {
        todos = JSON.parse(stored);
      } catch(e) { todos = []; }
    } else {
      todos = [];
    }
    renderTodos();
  }

  function saveTodos() {
    localStorage.setItem('kashy_todos', JSON.stringify(todos));
  }

  function renderTodos() {
    const container = document.getElementById('todoListContainer');
    const emptyMsg = document.getElementById('todoEmpty');
    if (!container) return;
    
    if (todos.length === 0) {
      container.innerHTML = '';
      emptyMsg.classList.remove('hidden');
      return;
    }
    emptyMsg.classList.add('hidden');
    
    container.innerHTML = todos.map(todo => `
      <div class="flex items-start justify-between gap-2 p-2 rounded-lg bg-stone-50 border border-stone-100 hover:bg-terra-xs transition">
        <div class="flex gap-2 flex-1 min-w-0">
          <input type="checkbox" ${todo.completed ? 'checked' : ''} onchange="toggleTodo(${todo.id})" class="w-4 h-4 mt-0.5 rounded text-terra focus:ring-terra flex-shrink-0">
          <span class="text-xs text-gray-800 break-words whitespace-normal ${todo.completed ? 'line-through text-muted' : ''}" style="word-break: break-word;">${escapeHtml(todo.text)}</span>
        </div>
        <button onclick="deleteTodo(${todo.id})" class="flex-shrink-0 text-red-400 hover:text-red-600 transition">
          <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 6h18M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/><line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/></svg>
        </button>
      </div>
    `).join('');
  }

  function showTodoForm() {
    document.getElementById('todoForm').classList.remove('hidden');
    document.getElementById('showTodoFormBtn').classList.add('hidden');
    document.getElementById('todoInput').focus();
  }

  function hideTodoForm() {
    document.getElementById('todoForm').classList.add('hidden');
    document.getElementById('showTodoFormBtn').classList.remove('hidden');
    document.getElementById('todoInput').value = '';
  }

  function tambahTugas() {
    const input = document.getElementById('todoInput');
    const text = input.value.trim();
    if (text === '') {
      showToast('Tugas tidak boleh kosong!');
      return;
    }
    todos.push({
      id: Date.now(),
      text: text,
      completed: false
    });
    saveTodos();
    renderTodos();
    hideTodoForm();
    showToast('Tugas berhasil ditambahkan');
  }

  function toggleTodo(id) {
    const todo = todos.find(t => t.id === id);
    if (todo) {
      todo.completed = !todo.completed;
      saveTodos();
      renderTodos();
    }
  }

  function deleteTodo(id) {
    todos = todos.filter(t => t.id !== id);
    saveTodos();
    renderTodos();
    showToast('Tugas dihapus');
  }

  function deleteAllTodos() {
    if (todos.length === 0) {
      showToast('Tidak ada tugas untuk dihapus');
      return;
    }
    const modal = document.getElementById('confirmDeleteAllModal');
    modal.classList.remove('hidden');
    const confirmBtn = document.getElementById('confirmDeleteAllBtn');
    const cancelBtn = document.getElementById('cancelDeleteAllBtn');
    
    const handleConfirm = () => {
      todos = [];
      saveTodos();
      renderTodos();
      showToast('Semua tugas dihapus');
      modal.classList.add('hidden');
      cleanup();
    };
    const handleCancel = () => {
      modal.classList.add('hidden');
      cleanup();
    };
    const cleanup = () => {
      confirmBtn.removeEventListener('click', handleConfirm);
      cancelBtn.removeEventListener('click', handleCancel);
    };
    confirmBtn.addEventListener('click', handleConfirm);
    cancelBtn.addEventListener('click', handleCancel);
  }

  function escapeHtml(str) {
    return str.replace(/[&<>]/g, function(m) {
      if (m === '&') return '&amp;';
      if (m === '<') return '&lt;';
      if (m === '>') return '&gt;';
      return m;
    });
  }

  document.addEventListener('DOMContentLoaded', function() {
    const showBtn = document.getElementById('showTodoFormBtn');
    if (showBtn) showBtn.onclick = showTodoForm;
    const deleteAllBtn = document.getElementById('deleteAllBtn');
    if (deleteAllBtn) deleteAllBtn.onclick = deleteAllTodos;
    loadTodos();
  });

  function showToast(msg) {
    const toast = document.getElementById('toast');
    document.getElementById('toastMsg').innerText = msg;
    toast.style.opacity = '1';
    toast.style.transform = 'translateX(-50%) translateY(0)';
    clearTimeout(window.toastTimeout);
    window.toastTimeout = setTimeout(() => {
      toast.style.opacity = '0';
      toast.style.transform = 'translateX(-50%) translateY(16px)';
    }, 2600);
  }

  // GREETING DINAMIS
  (function() {
    const h = new Date().getHours();
    let greet = 'Selamat Pagi';
    if (h >= 11 && h < 15) greet = 'Selamat Siang';
    else if (h >= 15 && h < 18) greet = 'Selamat Sore';
    else if (h >= 18) greet = 'Selamat Malam';
    document.getElementById('greetTime').innerHTML = `${greet}, <span class="text-terra">{{ Auth::user()->name }}</span>`;
  })();

  loadTodos();
</script>
</body>
</html>