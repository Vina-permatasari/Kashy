<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
<title>Manajemen Toko | Kashy</title>

<script src="https://cdn.tailwindcss.com"></script>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

<script>
tailwind.config = {
  theme: {
    extend: {
      colors: {
        kashy: {
          dark: '#1a1a1a',
          brown: '#C49A6C',
          'brown-deep': '#7B4F2E',
          cream: '#F5F0EB',
          'cream-dark': '#EDE5DB',
          muted: '#8A7968',
          border: '#E0D8CE',
        }
      },
      fontFamily: {
        poppins: ['Poppins', 'sans-serif']
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
* {
  box-sizing: border-box;
  margin: 0;
  padding: 0;
  font-family: 'Poppins', sans-serif;
}

body {
  background: #F5F0EB;
}

/* Sidebar (konsisten dengan semua halaman) */
#sidebar {
  position: fixed;
  top: 0;
  left: 0;
  height: 100vh;
  width: 280px;
  background: #fff;
  box-shadow: 2px 0 24px rgba(60,40,10,.12);
  z-index: 60;
  transition: transform .3s cubic-bezier(0.2,0.9,0.4,1.1);
  display: flex;
  flex-direction: column;
  overflow-y: auto;
  transform: translateX(-100%);
}

#sidebar.sidebar-open {
  transform: translateX(0);
}

#overlay {
  display: none;
  position: fixed;
  inset: 0;
  background: rgba(0,0,0,.45);
  z-index: 55;
  backdrop-filter: blur(3px);
}

#overlay.show {
  display: block;
}

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

.nav-item {
  display: flex;
  align-items: center;
  gap: 12px;
  padding: 11px 18px;
  border-radius: 12px;
  cursor: pointer;
  transition: all .15s;
  font-size: 14px;
  font-weight: 500;
  color: #1a1a1a;
  text-decoration: none;
  width: 100%;
}

.nav-item:hover { background: #F5F0EB; }
.nav-item.active { background: #F7EFE5; color: #7B4F2E; font-weight: 600; }
.nav-item.active svg { stroke: #7B4F2E; }

/* Form elements – disamakan dengan Laporan Keuangan */
.form-label {
  font-size: 11px;
  font-weight: 700;
  color: #8A7968;
  text-transform: uppercase;
  letter-spacing: .07em;
  margin-bottom: 6px;
  display: block;
}

.form-input {
  width: 100%;
  padding: 12px 14px;
  border: 1.5px solid #E0D8CE;
  border-radius: 12px;
  font-size: 13px;
  font-family: 'Poppins', sans-serif;
  color: #1a1a1a;
  background: #fff;
  outline: none;
  transition: border-color .2s;
}

.form-input:focus {
  border-color: #C49A6C;
}

.form-input::placeholder {
  color: #BFB4AC;
}

select.form-input {
  appearance: none;
  background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%238A7968' stroke-width='2'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E");
  background-repeat: no-repeat;
  background-position: right 14px center;
  padding-right: 36px;
  cursor: pointer;
}

.section-title {
  font-size: 13px;
  font-weight: 700;
  color: #1a1a1a;
  margin-bottom: 12px;
  letter-spacing: -0.2px;
}

/* Card style (shadow-card, border, border-radius) */
.card {
  background: #fff;
  border: 1px solid #E0D8CE;
  border-radius: 16px;
  box-shadow: 0 2px 18px 0 rgba(60,40,10,.07);
  padding: 20px;
}

/* Toast */
#toast {
  position: fixed;
  bottom: 2rem;
  left: 50%;
  transform: translateX(-50%) translateY(12px);
  background: #1c1c1c;
  color: white;
  font-size: 0.875rem;
  font-weight: 500;
  padding: 0.75rem 1.25rem;
  border-radius: 9999px;
  display: flex;
  align-items: center;
  gap: 0.5rem;
  z-index: 9999;
  opacity: 0;
  transition: opacity 0.25s ease, transform 0.3s cubic-bezier(0.34,1.56,0.64,1);
  pointer-events: none;
}

#toast.show {
  opacity: 1;
  transform: translateX(-50%) translateY(0);
}

::-webkit-scrollbar { width: 4px; }
::-webkit-scrollbar-track { background: transparent; }
::-webkit-scrollbar-thumb { background: #C49A6C; border-radius: 10px; }
</style>
</head>

<body>

@include('owner.components.sidebar')

<main id="main" class="min-h-screen bg-kashy-cream">
  @include('owner.components.topbar')

  <!-- KONTEN UTAMA: ukuran & padding SAMA PERSIS dengan Laporan Keuangan -->
  <div class="px-5 md:px-8 py-6 max-w-2xl mx-auto">

    <!-- Header -->
    <div class="fade-up d1 mb-5">
      <h1 class="text-2xl md:text-3xl font-extrabold text-kashy-dark leading-tight">Manajemen Toko</h1>
      <p class="text-xs text-kashy-muted mt-1">Kelola identitas merek dan informasi operasional toko Anda.</p>
    </div>

    <form id="storeForm" onsubmit="simpanProfil(event)" class="flex flex-col gap-5">

      <!-- Nama Toko -->
      <div class="card fade-up d2">
        <label class="form-label">Nama Toko</label>
        <input type="text" id="namaToko" class="form-input" value="SND STORE" placeholder="Nama toko Anda"/>
      </div>

      <!-- Informasi Kontak -->
      <div class="card fade-up d3">
        <p class="section-title">Informasi Kontak</p>
        <div class="flex flex-col gap-3">
          <div>
            <label class="form-label">Alamat Email</label>
            <input type="email" id="email" class="form-input" value="contact@sndstore.com"/>
          </div>
          <div>
            <label class="form-label">Nomor Handphone</label>
            <input type="tel" id="phone" class="form-input" value="+62 812-3456-7890"/>
          </div>
        </div>
      </div>

      <!-- Alamat Fisik -->
      <div class="card fade-up d4">
        <p class="section-title">Alamat Fisik</p>
        <div class="flex flex-col gap-3">
          <div>
            <label class="form-label">Jalan</label>
            <input type="text" id="jalan" class="form-input" value="Jl. Gatot Subroto No.123"/>
          </div>
          <div class="grid grid-cols-2 gap-3">
            <div>
              <label class="form-label">Kota</label>
              <input type="text" id="kota" class="form-input" value="Medan"/>
            </div>
            <div>
              <label class="form-label">Kode Pos</label>
              <input type="text" id="kodePos" class="form-input" value="20112"/>
            </div>
          </div>
          <div>
            <label class="form-label">Negara</label>
            <select id="negara" class="form-input">
              <option selected>Indonesia</option>
              <option>Malaysia</option>
              <option>Singapura</option>
            </select>
          </div>
        </div>
      </div>

      <!-- Tombol Aksi -->
      <div class="fade-up d5 flex flex-col gap-3 mt-1">
        <button type="submit"
          class="w-full flex items-center justify-center gap-2 py-4 rounded-2xl font-bold text-sm tracking-widest text-white uppercase transition-all duration-200 hover:opacity-90 active:scale-[.98]"
          style="background:#C49A6C; box-shadow:0 4px 14px 0 rgba(196,154,108,.35);">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
            <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/>
            <polyline points="17 21 17 13 7 13 7 21"/>
            <polyline points="7 3 7 8 15 8"/>
          </svg>
          Simpan Profil
        </button>

        <button type="button" onclick="buangPerubahan()"
          class="w-full py-4 rounded-2xl font-bold text-kashy-dark text-sm tracking-widest uppercase border-2 border-kashy-border transition-all duration-200 hover:bg-kashy-cream active:scale-[.98] bg-white">
          Buang Perubahan
        </button>
      </div>

    </form>

  </div>
</main>

<!-- Toast Notification -->
<div id="toast">
  <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#C49A6C" stroke-width="2.5">
    <polyline points="20 6 9 17 4 12"/>
  </svg>
  <span id="toastMsg">Profil toko berhasil disimpan!</span>
</div>

<div id="overlay"></div>

<script>
  // Sidebar (sama seperti halaman lain)
  const sidebar = document.getElementById('sidebar');
  const overlay = document.getElementById('overlay');
  const menuBtn = document.getElementById('global-menu-toggle');

  function openSidebar() {
    if (!sidebar || !overlay) return;
    sidebar.classList.add('sidebar-open');
    overlay.classList.add('show');
    document.body.style.overflow = 'hidden';
  }

  function closeSidebar() {
    if (!sidebar || !overlay) return;
    sidebar.classList.remove('sidebar-open');
    overlay.classList.remove('show');
    document.body.style.overflow = '';
  }

  if (menuBtn) {
    menuBtn.addEventListener('click', e => {
      e.stopPropagation();
      openSidebar();
    });
  }

  if (overlay) {
    overlay.addEventListener('click', closeSidebar);
  }

  document.addEventListener('keydown', e => {
    if (e.key === 'Escape') closeSidebar();
  });

  // Toast
  let toastTimer;
  function showToast(msg, success = true) {
    const toast = document.getElementById('toast');
    const toastMsg = document.getElementById('toastMsg');
    toastMsg.textContent = msg;
    toast.style.background = success ? '#1c1c1c' : '#ef4444';
    toast.classList.add('show');
    clearTimeout(toastTimer);
    toastTimer = setTimeout(() => toast.classList.remove('show'), 2600);
  }

  // Simpan profil
  function simpanProfil(e) {
    e.preventDefault();
    // Simulasi penyimpanan (bisa diubah sesuai kebutuhan backend)
    showToast('Profil toko berhasil disimpan!');
  }

  // Buang perubahan (reset form ke nilai awal)
  function buangPerubahan() {
    if (confirm('Buang semua perubahan?')) {
      document.getElementById('namaToko').value = 'SND STORE';
      document.getElementById('email').value = 'contact@sndstore.com';
      document.getElementById('phone').value = '+62 812-3456-7890';
      document.getElementById('jalan').value = 'Jl. Gatot Subroto No.123';
      document.getElementById('kota').value = 'Medan';
      document.getElementById('kodePos').value = '20112';
      document.getElementById('negara').value = 'Indonesia';
      showToast('Perubahan dibuang.', true);
    }
  }
</script>
</body>
</html>