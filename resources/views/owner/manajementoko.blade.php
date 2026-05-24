<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Manajemen Toko | Kashy</title>
<script src="https://cdn.tailwindcss.com"></script>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<script>
  tailwind.config = {
    theme: {
      extend: {
        colors: {
          kashy: {
            dark:         '#1a1a1a',
            brown:        '#C49A6C',
            'brown-deep': '#7B4F2E',
            cream:        '#F5F0EB',
            'cream-dark': '#EDE5DB',
            muted:        '#8A7968',
            border:       '#E0D8CE',
          }
        },
        fontFamily: { poppins: ['Poppins','sans-serif'] },
      }
    }
  }
</script>
<style>
  * { box-sizing:border-box; margin:0; padding:0; }
  body { font-family:'Poppins',sans-serif; background:#F5F0EB; }

  /* ── Sidebar ── */
  #sidebar {
    position:fixed; top:0; left:0; height:100vh; width:280px;
    background:#fff; box-shadow:2px 0 24px rgba(60,40,10,.12);
    z-index:60; transition:transform .3s cubic-bezier(0.2,0.9,0.4,1.1);
    display:flex; flex-direction:column; overflow-y:auto;
    transform:translateX(-100%);
  }
  #sidebar.sidebar-open { transform:translateX(0); }
  #overlay {
    display:none; position:fixed; inset:0;
    background:rgba(0,0,0,.45); z-index:55; backdrop-filter:blur(3px);
  }
  #overlay.show { display:block; }

  /* ── Animations ── */
  @keyframes fadeUp {
    from { opacity:0; transform:translateY(18px); }
    to   { opacity:1; transform:translateY(0); }
  }
  .fade-up { animation:fadeUp .4s ease both; }
  .d1{animation-delay:.05s} .d2{animation-delay:.10s}
  .d3{animation-delay:.15s} .d4{animation-delay:.20s}
  .d5{animation-delay:.25s}

  /* ── Nav items ── */
  .nav-item {
    display:flex; align-items:center; gap:12px; padding:11px 18px;
    border-radius:12px; cursor:pointer; transition:all .15s;
    font-size:14px; font-weight:500; color:#1a1a1a;
    text-decoration:none; width:100%;
  }
  .nav-item:hover { background:#F5F0EB; }
  .nav-item.active { background:#F7EFE5; color:#7B4F2E; font-weight:600; }
  .nav-item.active svg { stroke:#7B4F2E; }

  /* ── Form ── */
  .form-label {
    font-size:11px; font-weight:700; color:#8A7968;
    text-transform:uppercase; letter-spacing:.07em;
    margin-bottom:6px; display:block;
  }
  .form-input {
    width:100%; padding:12px 14px; border:1.5px solid #E0D8CE;
    border-radius:12px; font-size:13px; font-family:'Poppins',sans-serif;
    color:#1a1a1a; background:#FAF6F2; outline:none;
    transition:border-color .2s;
  }
  .form-input:focus { border-color:#C49A6C; background:#fff; }
  .form-input::placeholder { color:#BFB4AC; }

  .form-input-icon { position:relative; }
  .form-input-icon svg { position:absolute; left:13px; top:50%; transform:translateY(-50%); pointer-events:none; }
  .form-input-icon input { padding-left:38px; }

  select.form-input {
    appearance:none;
    background-image:url("data:image/svg+xml,%3Csvg width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%238A7968' stroke-width='2.5' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='m6 9 6 6 6-6'/%3E%3C/svg%3E");
    background-repeat:no-repeat; background-position:right 14px center;
    padding-right:36px; cursor:pointer;
  }

  /* ── Info card ── */
  .info-card {
    display:flex; align-items:flex-start; gap:12px;
    background:#fff; border:1.5px solid #E0D8CE;
    border-radius:14px; padding:14px 16px;
  }
  .info-card-icon {
    width:32px; height:32px; border-radius:50%;
    border:1.5px solid #E0D8CE; flex-shrink:0;
    display:flex; align-items:center; justify-content:center;
    background:#FAF6F2;
  }

  /* ── Section title ── */
  .section-title {
    font-size:13px; font-weight:700; color:#1a1a1a; margin-bottom:12px;
  }

  /* ── Toast ── */
  #toast {
    position:fixed; bottom:24px; left:50%;
    transform:translateX(-50%) translateY(0);
    background:#1a1a1a; color:#fff;
    font-size:12px; font-weight:500;
    padding:12px 20px; border-radius:12px;
    display:flex; align-items:center; gap:8px;
    opacity:0; pointer-events:none;
    transition:opacity .3s, transform .3s; z-index:300;
  }
  #toast.show { opacity:1; transform:translateX(-50%) translateY(-8px); }

  /* ── Scrollbar ── */
  ::-webkit-scrollbar { width:4px; }
  ::-webkit-scrollbar-track { background:transparent; }
  ::-webkit-scrollbar-thumb { background:#C49A6C; border-radius:10px; }
</style>
</head>

@include('owner.components.sidebar')

<body>
<main id="main" class="min-h-screen bg-kashy-cream">
  @include('owner.components.topbar')

  <div class="px-5 md:px-8 py-6 max-w-2xl mx-auto">

    <!-- ── Header ── -->
    <div class="fade-up d1 mb-6">
      <h1 class="text-3xl font-extrabold text-kashy-dark">Manajemen Toko</h1>
      <p class="text-sm text-kashy-muted mt-1">Kelola identitas merek dan pengaturan toko Anda di seluruh platform.</p>
    </div>

    <form onsubmit="simpanProfil(event)" class="flex flex-col gap-5">

      <!-- Nama Toko -->
      <div class="fade-up d2">
        <label class="form-label">Nama Toko</label>
        <input type="text" class="form-input" value="SND STORE" placeholder="Nama toko Anda"/>
      </div>

      <!-- Pegangan Merk -->
      <div class="fade-up d2">
        <label class="form-label">Pegangan Merk</label>
        <div class="form-input-icon">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#8A7968" stroke-width="2">
            <circle cx="12" cy="12" r="10"/>
            <path d="M8.56 2.75c4.37 6.03 6.02 9.42 8.03 17.72m2.54-15.38c-3.72 4.35-8.94 5.66-16.88 5.85m19.5 1.9c-3.5-.93-6.63-.82-8.94 0-2.58.92-5.01 2.86-7.44 6.32"/>
          </svg>
          <input type="text" class="form-input" value="earthandgrace" placeholder="@username"/>
        </div>
      </div>

      <!-- Informasi Kontak -->
      <div class="fade-up d3">
        <p class="section-title">Informasi Kontak</p>
        <div class="flex flex-col gap-3">
          <div>
            <label class="form-label">Alamat Email</label>
            <input type="email" class="form-input" value="contact@earthandgrace.com" placeholder="email@toko.com"/>
          </div>
          <div>
            <label class="form-label">Nomor Handphone</label>
            <input type="tel" class="form-input" value="+62 000-0000" placeholder="+62 xxx-xxxx-xxxx"/>
          </div>
        </div>
      </div>

      <!-- Alamat Fisik -->
      <div class="fade-up d4">
        <p class="section-title">Alamat Fisik</p>
        <div class="flex flex-col gap-3">
          <div>
            <label class="form-label">Jalan</label>
            <input type="text" class="form-input" value="123 Elegance Boulevard" placeholder="Nama jalan & nomor"/>
          </div>
          <div class="grid grid-cols-2 gap-3">
            <div>
              <label class="form-label">Kota</label>
              <input type="text" class="form-input" value="Medan" placeholder="Kota"/>
            </div>
            <div>
              <label class="form-label">Kode Pos</label>
              <input type="text" class="form-input" value="EC1A 1BB" placeholder="Kode pos"/>
            </div>
          </div>
          <div>
            <label class="form-label">Negara</label>
            <select class="form-input">
              <option selected>Indonesia</option>
              <option>Malaysia</option>
              <option>Singapura</option>
            </select>
          </div>
        </div>
      </div>

      <!-- Tombol -->
      <div class="fade-up d5 grid grid-cols-2 gap-3 mt-1">
        <button
          type="button"
          onclick="buangPerubahan()"
          class="py-4 rounded-2xl font-bold text-sm text-kashy-muted border-2 border-kashy-border bg-white hover:bg-kashy-cream transition-colors">
          Buang Perubahan
        </button>
        <button
          type="submit"
          class="py-4 rounded-2xl font-bold text-sm text-white transition-all hover:opacity-90 active:scale-[.98]"
          style="background:#C49A6C; box-shadow:0 4px 14px 0 rgba(196,154,108,.35);">
          Simpan Profil
        </button>
      </div>

    </form>

    <!-- ── Info Cards ── -->
    <div class="flex flex-col gap-3 mt-6 fade-up d5">

      <div class="info-card">
        <div class="info-card-icon">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#C49A6C" stroke-width="2">
            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
          </svg>
        </div>
        <div>
          <p class="text-xs font-bold text-kashy-dark">Identitas Diverifikasi</p>
          <p class="text-xs text-kashy-muted mt-0.5 leading-relaxed">
            Profil toko Anda telah diverifikasi dan aktif untuk perdagangan global.
          </p>
        </div>
      </div>

      <div class="info-card">
        <div class="info-card-icon">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#C49A6C" stroke-width="2">
            <circle cx="12" cy="12" r="10"/>
            <polyline points="12 6 12 12 16 14"/>
          </svg>
        </div>
        <div>
          <p class="text-xs font-bold text-kashy-dark">Terakhir Diperbarui</p>
          <p class="text-xs text-kashy-muted mt-0.5 leading-relaxed">
            Profil toko Anda telah diperbarui 24 Oktober 2023 pukul 14:32 oleh Kantor Pusat.
          </p>
        </div>
      </div>

    </div>

  </div>
</main>

<!-- ── Toast ── -->
<div id="toast">
  <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#C49A6C" stroke-width="2.5">
    <polyline points="20 6 9 17 4 12"/>
  </svg>
  <span id="toastMsg">Profil toko berhasil disimpan!</span>
</div>

<script>
  /* ── Sidebar ── */
  const sidebar = document.getElementById('sidebar');
  const overlay = document.getElementById('overlay');
  const menuBtn = document.getElementById('global-menu-toggle');

  function openSidebar()  { sidebar.classList.add('sidebar-open'); overlay.classList.add('show'); document.body.style.overflow='hidden'; }
  function closeSidebar() { sidebar.classList.remove('sidebar-open'); overlay.classList.remove('show'); document.body.style.overflow=''; }

  if (menuBtn) menuBtn.addEventListener('click', e => { e.stopPropagation(); openSidebar(); });
  if (overlay) overlay.addEventListener('click', closeSidebar);
  document.addEventListener('keydown', e => { if (e.key==='Escape') closeSidebar(); });

  /* ── Toast ── */
  let toastTimer;
  function showToast(msg) {
    const toast = document.getElementById('toast');
    document.getElementById('toastMsg').textContent = msg;
    toast.classList.add('show');
    clearTimeout(toastTimer);
    toastTimer = setTimeout(() => toast.classList.remove('show'), 2500);
  }

  /* ── Simpan ── */
  function simpanProfil(e) {
    e.preventDefault();
    showToast('Profil toko berhasil disimpan!');
    // TODO: submit ke route('owner.toko.simpan')
  }

  /* ── Buang perubahan ── */
  function buangPerubahan() {
    if (confirm('Buang semua perubahan?')) {
      document.querySelector('form').reset();
      showToast('Perubahan dibuang.');
    }
  }
</script>
</body>
</html>