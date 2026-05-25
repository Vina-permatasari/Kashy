<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Profil Owner – Kashy</title>
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
  * { box-sizing: border-box; margin: 0; padding: 0; }
  body { font-family: 'Poppins', sans-serif; background: #F5F0EB; }
  .hide-scroll::-webkit-scrollbar { display: none; }
  .hide-scroll { scrollbar-width: none; }

  @keyframes fadeUp {
    from { opacity: 0; transform: translateY(16px); }
    to   { opacity: 1; transform: translateY(0); }
  }
  @keyframes shimmer {
    0%   { background-position: -400px 0; }
    100% { background-position:  400px 0; }
  }
  @keyframes avatarPop {
    0%   { transform: scale(0.85); opacity: 0; }
    70%  { transform: scale(1.04); }
    100% { transform: scale(1);    opacity: 1; }
  }

  .anim-0 { animation: fadeUp .42s cubic-bezier(0.22,1,.36,1) .00s both; }
  .anim-1 { animation: fadeUp .42s cubic-bezier(0.22,1,.36,1) .07s both; }
  .anim-2 { animation: fadeUp .42s cubic-bezier(0.22,1,.36,1) .14s both; }
  .anim-3 { animation: fadeUp .42s cubic-bezier(0.22,1,.36,1) .21s both; }
  .anim-4 { animation: fadeUp .42s cubic-bezier(0.22,1,.36,1) .28s both; }
  .anim-5 { animation: fadeUp .42s cubic-bezier(0.22,1,.36,1) .35s both; }
  .anim-6 { animation: fadeUp .42s cubic-bezier(0.22,1,.36,1) .42s both; }
  .anim-7 { animation: fadeUp .42s cubic-bezier(0.22,1,.36,1) .49s both; }
  .anim-8 { animation: fadeUp .42s cubic-bezier(0.22,1,.36,1) .56s both; }

  .avatar-anim { animation: avatarPop .55s cubic-bezier(0.34,1.56,.64,1) .08s both; }

  .shimmer-bar {
    background: linear-gradient(90deg,#C8966C,#E5B18A,#F0D7C7,#E5B18A,#C8966C);
    background-size: 200%;
    animation: shimmer 4s linear infinite;
  }

  .kashy-input {
    transition: border-color .2s ease, box-shadow .2s ease, background .2s ease;
  }
  .kashy-input:focus {
    border-color: #C8966C;
    box-shadow: 0 0 0 3px rgba(200,150,108,.14);
    background: #fff;
    outline: none;
  }

  .btn-dark {
    background: #1c1c1c;
    transition: background .22s ease, transform .15s ease, box-shadow .22s ease;
  }
  .btn-dark:hover {
    background: #333;
    transform: translateY(-1px);
    box-shadow: 0 6px 20px rgba(28,28,28,.2);
  }

  .btn-terra {
    background: #C8966C;
    transition: background .22s ease, transform .15s ease, box-shadow .22s ease;
  }
  .btn-terra:hover {
    background: #b8845a;
    transform: translateY(-1px);
    box-shadow: 0 6px 20px rgba(200,150,108,.35);
  }

  .info-row { transition: background .15s; }
  .info-row:hover { background: #FAF2EC; }
  .menu-row { transition: background .15s, transform .15s; }
  .menu-row:hover { background: #FAF2EC; transform: translateX(2px); }

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
      display:none; position:fixed; inset:0; background:rgba(0,0,0,.45);
      z-index:55; backdrop-filter:blur(3px);
    }
    #overlay.show { display:block; }

    header.sticky.top-0.z-50 {
    background-color: #1a1a1a !important;
    box-shadow: 0 4px 14px 0 rgba(0,0,0,0.1) !important;
    }

  /* Avatar ring gradient */
  .avatar-ring {
    background: linear-gradient(135deg, #C8966C, #E5B18A, #F0D7C7, #C8966C);
    padding: 3px;
    border-radius: 9999px;
  }

  /* Owner crown badge on avatar */
  .crown-badge {
    background: linear-gradient(135deg, #1c1c1c, #3d3d3d);
  }

  /* Toggle switch */
  .toggle-track {
    width: 44px; height: 24px; border-radius: 12px;
    background: #E0D8CE; position: relative;
    transition: background .25s ease; cursor: pointer; flex-shrink: 0;
  }
  .toggle-track.on { background: #C8966C; }
  .toggle-thumb {
    position: absolute; top: 3px; left: 3px;
    width: 18px; height: 18px; border-radius: 50%;
    background: #fff; box-shadow: 0 1px 4px rgba(0,0,0,.18);
    transition: transform .25s cubic-bezier(0.34,1.56,.64,1);
  }
  .toggle-track.on .toggle-thumb { transform: translateX(20px); }

  /* Nav items */
  .nav-item {
    display:flex; align-items:center; gap:12px; padding:11px 18px;
    border-radius:12px; cursor:pointer; transition:all .15s;
    font-size:14px; font-weight:500; color:#1a1a1a;
    text-decoration:none; width:100%;
  }
  .nav-item:hover { background:#F5F0EB; }
  .nav-item.active { background:#F7EFE5; color:#7B4F2E; font-weight:600; }
  .nav-item.active svg { stroke:#7B4F2E; }

  /* Toast */
  #toast {
    opacity: 0; transform: translateX(-50%) translateY(16px);
    transition: opacity .25s ease, transform .3s cubic-bezier(0.34,1.56,.64,1);
    pointer-events: none;
  }
  #toast.show { opacity: 1; transform: translateX(-50%) translateY(0); }

  /* Logout overlay */
  #logoutOverlay {
    opacity: 0; pointer-events: none;
    transition: opacity .25s ease;
  }
  #logoutOverlay.open { opacity: 1; pointer-events: all; }
  #logoutDialog {
    transform: scale(.92) translateY(12px);
    transition: transform .3s cubic-bezier(0.34,1.56,.64,1);
  }
  #logoutOverlay.open #logoutDialog { transform: scale(1) translateY(0); }

  ::-webkit-scrollbar { width:4px; }
  ::-webkit-scrollbar-thumb { background:#C8966C; border-radius:10px; }
</style>
</head>
@include('owner.components.sidebar')
<body class="bg-bg min-h-screen">

<!-- ════════ MAIN WRAP ════════ -->
<main id="main" class="min-h-screen bg-kashy-cream">
    @include('owner.components.topbar')
    <div class="max-w-lg mx-auto lg:max-w-2xl px-4 pt-7 pb-20 space-y-5">

      <!-- ── HERO ── -->
      <div class="anim-0 flex flex-col items-center text-center">
        <div class="avatar-anim relative mb-4">
          <div class="avatar-ring">
            <div class="w-24 h-24 sm:w-28 sm:h-28 rounded-full overflow-hidden bg-stone-200">
              <div class="w-full h-full flex items-center justify-center" style="background:linear-gradient(135deg,#c4a882,#9d7e5e,#b8966c);">
                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="rgba(255,255,255,0.75)" stroke-width="1.2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
              </div>
            </div>
          </div>
          <!-- Edit button -->
          <button onclick="showToast('Fitur upload foto segera hadir ✨')" class="absolute bottom-0.5 right-0.5 w-7 h-7 rounded-full bg-terra shadow-md border-2 border-white flex items-center justify-center hover:bg-terra-l transition-colors">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
          </button>
        </div>

        <h1 class="font-display text-2xl sm:text-3xl font-bold text-gray-900 mb-2">Julianne Deakin</h1>

        <!-- Owner badge — dark premium style -->
        <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full text-xs font-bold tracking-wider text-white" style="background:linear-gradient(135deg,#1c1c1c,#3d3d3d); box-shadow:0 4px 14px rgba(0,0,0,.25);">
          <!-- Crown icon -->
          <svg width="11" height="11" viewBox="0 0 24 24" fill="currentColor" stroke="none" class="text-terra-l opacity-90"><path d="M2 19l3.553-10.658A1 1 0 0 1 7.28 8.184l4.72 5.316 4.72-5.316a1 1 0 0 1 1.727.158L22 19H2z"/><rect x="2" y="19" width="20" height="2" rx="1"/></svg>
          OWNER
        </span>
      </div>

      <!-- ── CARD 1: Informasi Akun ── -->
      <div class="anim-1 bg-white rounded-2xl shadow-sm border border-border overflow-hidden">
        <div class="shimmer-bar h-1"></div>
        <div class="px-5 pt-4 pb-1 flex items-center gap-3">
          <div class="w-8 h-8 rounded-xl bg-terra-xs flex items-center justify-center">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#C8966C" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
          </div>
          <h3 class="text-sm font-bold text-gray-900">Informasi Akun</h3>
        </div>
        <!-- Email -->
        <div class="info-row flex items-center gap-4 px-5 py-4 border-b border-stone-100 transition-colors">
          <div class="w-9 h-9 rounded-xl bg-terra-xs flex items-center justify-center flex-shrink-0">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#C8966C" stroke-width="2"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
          </div>
          <div class="flex-1 min-w-0">
            <p class="text-[10px] font-bold tracking-wide text-muted">Email Address</p>
            <p class="text-sm font-medium text-gray-900 truncate">julianne.deakin@kashy.id</p>
          </div>
        </div>
        <!-- Phone -->
        <div class="info-row flex items-center gap-4 px-5 py-4 border-b border-stone-100 transition-colors">
          <div class="w-9 h-9 rounded-xl bg-terra-xs flex items-center justify-center flex-shrink-0">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#C8966C" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.15 13a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 3.06 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L7.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 21 16.92z"/></svg>
          </div>
          <div class="flex-1 min-w-0">
            <p class="text-[10px] font-bold tracking-wide text-muted">Phone Number</p>
            <p class="text-sm font-medium text-gray-900">+62 878-1234-5678</p>
          </div>
        </div>
        <!-- Role -->
        <div class="info-row flex items-center gap-4 px-5 py-4 transition-colors">
          <div class="w-9 h-9 rounded-xl bg-terra-xs flex items-center justify-center flex-shrink-0">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#C8966C" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
          </div>
          <div class="flex-1">
            <p class="text-[10px] font-bold tracking-wide text-muted">Account Role</p>
            <div class="flex items-center gap-2 mt-0.5">
              <p class="text-sm font-medium text-gray-900">Owner</p>
              <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold text-white" style="background:#1c1c1c;">AKSES PENUH</span>
            </div>
          </div>
        </div>
      </div>

      <!-- ── CARD 2: Informasi Toko ── -->
      <div class="anim-2 bg-white rounded-2xl shadow-sm border border-border overflow-hidden">
        <div class="shimmer-bar h-1"></div>
        <div class="px-5 pt-4 pb-1 flex items-center justify-between">
          <div class="flex items-center gap-3">
            <div class="w-8 h-8 rounded-xl bg-terra-xs flex items-center justify-center">
              <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#C8966C" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
            </div>
            <h3 class="text-sm font-bold text-gray-900">Informasi Toko</h3>
          </div>
          <button onclick="window.location.href='{{ route('manajemen.toko') }}'" class="text-[11px] font-semibold text-terra hover:underline">Edit</button>
        </div>
        <!-- Nama Toko -->
        <div class="info-row flex items-center gap-4 px-5 py-4 border-b border-stone-100 transition-colors">
          <div class="w-9 h-9 rounded-xl bg-terra-xs flex items-center justify-center flex-shrink-0">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#C8966C" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22 6 12 13 2 6"/></svg>
          </div>
          <div class="flex-1">
            <p class="text-[10px] font-bold tracking-wide text-muted">Nama Toko</p>
            <p class="text-sm font-medium text-gray-900">SND STORE</p>
          </div>
        </div>
        <!-- Alamat toko -->
        <div class="info-row flex items-center gap-4 px-5 py-4 border-b border-stone-100 transition-colors">
          <div class="w-9 h-9 rounded-xl bg-terra-xs flex items-center justify-center flex-shrink-0">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#C8966C" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
          </div>
          <div class="flex-1">
            <p class="text-[10px] font-bold tracking-wide text-muted">Alamat Toko</p>
            <div class="flex flex-wrap gap-1.5 mt-1">
              <span class="px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-terra-xs text-terra border border-terra-ll">Pusat – Jakarta</span>
              <span class="px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-stone-50 text-muted border border-border">Bandung</span>
              <span class="px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-stone-50 text-muted border border-border">Surabaya</span>
            </div>
          </div>
        </div>
        <!-- Kontak Bisnis -->
         <a href="https://www.instagram.com/snd_store___?igsh=cmloaGdna3ptbnp5" target="_blank">
        <div class="info-row flex items-center gap-4 px-5 py-4 border-b border-stone-100 transition-colors">
              
              <div class="w-9 h-9 rounded-xl bg-terra-xs flex items-center justify-center flex-shrink-0">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#C8966C" stroke-width="2"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
          </div>
          <div class="flex-1">
            
            <p class="text-[10px] font-bold tracking-wide text-muted">Instagram</p>
            <p class="text-sm font-medium text-gray-900">@snd_store___</p>
          </div>
        </div>

        <!-- Website -->
          <a href="https://wa.me/6285261246660" target="_blank">
        <div class="info-row flex items-center gap-4 px-5 py-4 transition-colors">
          <div class="w-9 h-9 rounded-xl bg-terra-xs flex items-center justify-center flex-shrink-0">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#C8966C" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>
          </div>
          <div class="flex-1">
            <p class="text-[10px] font-bold tracking-wide text-muted">WhatsApp</p>
            <p class="text-sm font-medium text-terra">0852-6124-6660</p>
          </div>
        </div> </a>
      </div>

      <!-- ── HEADING Pengaturan Akun ── -->
      <div class="anim-3 pt-1">
        <h2 class="font-display text-2xl sm:text-3xl font-bold text-gray-900">Pengaturan Akun</h2>
        <div class="w-8 h-0.5 bg-terra rounded-full mt-1.5"></div>
      </div>

      <!-- ── CARD 3: Edit Profil ── -->
      <div class="anim-3 bg-white rounded-2xl shadow-sm border border-border overflow-hidden">
        <div class="px-5 pt-5 pb-6">
          <div class="flex items-center gap-3 mb-5">
            <div class="w-9 h-9 rounded-xl bg-terra-xs flex items-center justify-center">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#C8966C" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
            </div>
            <h3 class="text-base font-bold text-gray-900">Edit Profil</h3>
          </div>
          <div class="space-y-4">
            <div>
              <label class="block text-[10px] font-bold tracking-wide text-muted mb-2">Nama Lengkap</label>
              <input type="text" value="Julianne Deakin" class="kashy-input w-full px-4 py-3 border border-border rounded-xl bg-bg text-sm text-gray-900"/>
            </div>
            <div>
              <label class="block text-[10px] font-bold tracking-wide text-muted mb-2">Email</label>
              <input type="email" value="julianne.deakin@kashy.id" class="kashy-input w-full px-4 py-3 border border-border rounded-xl bg-bg text-sm"/>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
              <div>
                <label class="block text-[10px] font-bold tracking-wide text-muted mb-2">Nomor Telepon</label>
                <input type="tel" value="+62 878-1234-5678" class="kashy-input w-full px-4 py-3 border border-border rounded-xl bg-bg text-sm"/>
              </div>
              <div>
                <label class="block text-[10px] font-bold tracking-wide text-muted mb-2">Nama Toko</label>
                <input type="text" value="Earth & Grace Studio" class="kashy-input w-full px-4 py-3 border border-border rounded-xl bg-bg text-sm"/>
              </div>
            </div>
            <button onclick="handleSimpan()" class="btn-dark w-full py-3.5 text-white font-semibold rounded-xl text-sm tracking-wide flex items-center justify-center gap-2">
              <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
              Simpan Perubahan
            </button>
          </div>
        </div>
      </div>

      <!-- ── CARD 4: Ganti Password ── -->
      <div class="anim-4 bg-white rounded-2xl shadow-sm border border-border overflow-hidden">
        <div class="px-5 pt-5 pb-6">
          <div class="flex items-center gap-3 mb-5">
            <div class="w-9 h-9 rounded-xl bg-terra-xs flex items-center justify-center">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#C8966C" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
            </div>
            <h3 class="text-base font-bold text-gray-900">Ganti Password</h3>
          </div>
          <div class="space-y-4">
            <div>
              <label class="block text-[10px] font-bold tracking-wide text-muted mb-2">Password Lama</label>
              <div class="relative">
                <input type="password" id="pwLama" class="kashy-input w-full px-4 py-3 pr-11 border border-border rounded-xl bg-bg text-sm"/>
                <button type="button" onclick="togglePw('pwLama','eyeL')" id="eyeL" class="absolute right-3.5 top-1/2 -translate-y-1/2 text-stone-300 hover:text-terra transition-colors">
                  <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7z"/><circle cx="12" cy="12" r="3"/></svg>
                </button>
              </div>
            </div>
            <div>
              <label class="block text-[10px] font-bold tracking-wide text-muted mb-2">Password Baru</label>
              <div class="relative">
                <input type="password" id="pwBaru" class="kashy-input w-full px-4 py-3 pr-11 border border-border rounded-xl bg-bg text-sm"/>
                <button type="button" onclick="togglePw('pwBaru','eyeB')" id="eyeB" class="absolute right-3.5 top-1/2 -translate-y-1/2 text-stone-300 hover:text-terra transition-colors">
                  <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7z"/><circle cx="12" cy="12" r="3"/></svg>
                </button>
              </div>
            </div>
            <div>
              <label class="block text-[10px] font-bold tracking-wide text-muted mb-2">Konfirmasi Password</label>
              <div class="relative">
                <input type="password" id="pwKonfirm" class="kashy-input w-full px-4 py-3 pr-11 border border-border rounded-xl bg-bg text-sm"/>
                <button type="button" onclick="togglePw('pwKonfirm','eyeK')" id="eyeK" class="absolute right-3.5 top-1/2 -translate-y-1/2 text-stone-300 hover:text-terra transition-colors">
                  <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7z"/><circle cx="12" cy="12" r="3"/></svg>
                </button>
              </div>
            </div>
            <!-- Strength meter -->
            <div id="strengthWrap" class="hidden">
              <div class="flex gap-1 mb-1">
                <div class="flex-1 h-1 rounded-full bg-stone-100" id="s1"></div>
                <div class="flex-1 h-1 rounded-full bg-stone-100" id="s2"></div>
                <div class="flex-1 h-1 rounded-full bg-stone-100" id="s3"></div>
                <div class="flex-1 h-1 rounded-full bg-stone-100" id="s4"></div>
              </div>
              <p class="text-[11px] text-muted" id="strengthLabel">Kekuatan password</p>
            </div>
            <button onclick="handleUpdatePassword()" class="btn-terra w-full py-3.5 text-white font-semibold rounded-xl text-sm tracking-wide flex items-center justify-center gap-2">
              <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
              Update Password
            </button>
          </div>
        </div>
      </div>

      <!-- ── CARD 5: Preferensi Sistem ── -->
      <div class="anim-5 bg-white rounded-2xl shadow-sm border border-border overflow-hidden">
        <div class="shimmer-bar h-1"></div>
        <div class="px-5 pt-4 pb-1 flex items-center gap-3">
          <div class="w-8 h-8 rounded-xl bg-terra-xs flex items-center justify-center">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#C8966C" stroke-width="2"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83-2.83l.06-.06A1.65 1.65 0 0 0 4.68 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 2.83-2.83l.06.06A1.65 1.65 0 0 0 9 4.68a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 2.83l-.06.06A1.65 1.65 0 0 0 19.4 9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg>
          </div>
          <h3 class="text-sm font-bold text-gray-900">Preferensi Sistem</h3>
        </div>

        <!-- Toggle rows -->
        <!-- 1 -->
        <div class="info-row flex items-center gap-4 px-5 py-4 border-b border-stone-100 transition-colors">
          <div class="w-9 h-9 rounded-xl bg-terra-xs flex items-center justify-center flex-shrink-0">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#C8966C" stroke-width="2"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
          </div>
          <div class="flex-1">
            <p class="text-sm font-semibold text-gray-900">Notifikasi Email</p>
            <p class="text-[11px] text-muted">Laporan harian & ringkasan penjualan</p>
          </div>
          <div class="toggle-track on" onclick="toggleSwitch(this)"><div class="toggle-thumb"></div></div>
        </div>
        <!-- 3 -->
        <div class="info-row flex items-center gap-4 px-5 py-4 border-b border-stone-100 transition-colors">
          <div class="w-9 h-9 rounded-xl bg-terra-xs flex items-center justify-center flex-shrink-0">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#C8966C" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
          </div>
          <div class="flex-1">
            <p class="text-sm font-semibold text-gray-900">Autentikasi 2 Langkah</p>
            <p class="text-[11px] text-muted">Keamanan ekstra saat login</p>
          </div>
          <div class="toggle-track on" onclick="toggleSwitch(this)"><div class="toggle-thumb"></div></div>
        </div>
        <!-- 4 -->
        <div class="info-row flex items-center gap-4 px-5 py-4 border-b border-stone-100 transition-colors">
          <div class="w-9 h-9 rounded-xl bg-terra-xs flex items-center justify-center flex-shrink-0">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#C8966C" stroke-width="2"><polyline points="1 4 1 10 7 10"/><polyline points="23 20 23 14 17 14"/><path d="M20.49 9A9 9 0 0 0 5.64 5.64L1 10M23 14l-4.64 4.36A9 9 0 0 1 3.51 15"/></svg>
          </div>
          <div class="flex-1">
            <p class="text-sm font-semibold text-gray-900">Auto-Sinkron Stok</p>
            <p class="text-[11px] text-muted">Sinkronisasi otomatis setiap hari</p>
          </div>
          <div class="toggle-track on" onclick="toggleSwitch(this)"><div class="toggle-thumb"></div></div>
        </div>
        <!-- 5 -->
        <div class="info-row flex items-center gap-4 px-5 py-4 transition-colors">
          <div class="w-9 h-9 rounded-xl bg-terra-xs flex items-center justify-center flex-shrink-0">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#C8966C" stroke-width="2"><line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/><line x1="3" y1="6" x2="3.01" y2="6"/><line x1="3" y1="12" x2="3.01" y2="12"/><line x1="3" y1="18" x2="3.01" y2="18"/></svg>
          </div>
          <div class="flex-1">
            <p class="text-sm font-semibold text-gray-900">Log Aktivitas</p>
            <p class="text-[11px] text-muted">Rekam semua aksi dalam sistem</p>
          </div>
          <div class="toggle-track" onclick="toggleSwitch(this)"><div class="toggle-thumb"></div></div>
        </div>
      </div>

      <!-- ── CARD 6: Logout ── -->
      <div class="anim-6 bg-white rounded-2xl shadow-sm border border-border overflow-hidden">
        <button onclick="openLogout()" class="menu-row w-full flex items-center gap-4 px-5 py-4 text-left transition-all duration-150">
          <div class="w-10 h-10 rounded-xl bg-red-50 flex items-center justify-center">
            <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="#ef4444" stroke-width="2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
          </div>
          <div class="flex-1 text-left">
            <p class="text-sm font-semibold text-red-500">Keluar dari Akun</p>
            <p class="text-xs text-red-300">Sesi Anda akan berakhir dengan aman</p>
          </div>
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#ef4444" stroke-width="2.5"><path d="m9 18 6-6-6-6"/></svg>
        </button>
      </div>

      <!-- Footer -->
      <div class="anim-7 text-center pb-2">
        <p class="text-[11px] text-stone-300 tracking-widest">Kashy © 2026</p>
        <p class="text-[10px] text-stone-200 mt-0.5">IMK Project · Julianne Deakin</p>
      </div>

    </div>

</main><!-- /main-wrap -->

<!-- ── Logout Modal ── -->
<div id="logoutOverlay" class="fixed inset-0 z-[60] bg-black/50 backdrop-blur-sm flex items-end sm:items-center justify-center p-4">
  <div id="logoutDialog" class="w-full max-w-sm bg-white rounded-3xl shadow-2xl overflow-hidden">
    <div class="shimmer-bar h-1"></div>
    <div class="px-6 pt-6 pb-7 text-center">
      <div class="w-14 h-14 rounded-2xl bg-red-50 flex items-center justify-center mx-auto mb-4">
        <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#ef4444" stroke-width="2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
      </div>
      <h3 class="font-display text-xl font-bold text-gray-900 mb-1">Keluar dari Akun?</h3>
      <p class="text-sm text-muted">Sesi Anda akan berakhir dan Anda perlu login kembali.</p>
      <div class="flex gap-3 mt-6">
        <button onclick="closeLogout()" class="flex-1 py-3 rounded-xl border-2 border-border text-sm font-semibold text-muted hover:bg-stone-50 transition-colors">Batal</button>
        <button onclick="performLogout()" class="flex-1 py-3 rounded-xl bg-red-500 text-white text-sm font-semibold hover:bg-red-600 transition-colors">Ya, Keluar</button>
      </div>
    </div>
  </div>
</div>

<!-- Toast -->
<div id="toast" class="fixed bottom-8 left-1/2 z-[70] bg-gray-900 text-white text-sm font-medium px-5 py-3 rounded-full shadow-xl flex items-center gap-2">
  <span id="toastMsg"></span>
</div>

<script>
   // Sidebar logic (tetap)
  const sidebar = document.getElementById('sidebar');
  const overlay = document.getElementById('overlay');
  const menuBtn = document.getElementById('global-menu-toggle');

  function openSidebar()  { sidebar.classList.add('sidebar-open'); overlay.classList.add('show'); document.body.style.overflow='hidden'; }
  function closeSidebar() { sidebar.classList.remove('sidebar-open'); overlay.classList.remove('show'); document.body.style.overflow=''; }
  function toggleSidebar(){ sidebar.classList.contains('sidebar-open') ? closeSidebar() : openSidebar(); }

  if (menuBtn) menuBtn.addEventListener('click', e => { e.stopPropagation(); toggleSidebar(); });
  document.addEventListener('keydown', e => { if(e.key==='Escape') closeSidebar(); });



  /* Password toggle */
  function togglePw(inputId, btnId) {
    let i = document.getElementById(inputId), b = document.getElementById(btnId);
    let hide = i.type === 'password';
    i.type = hide ? 'text' : 'password';
    b.innerHTML = hide
      ? `<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/></svg>`
      : `<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7z"/><circle cx="12" cy="12" r="3"/></svg>`;
    b.style.color = hide ? '#C8966C' : '';
  }

  /* Strength meter */
  document.getElementById('pwBaru').addEventListener('input', function() {
    let v = this.value;
    let w = document.getElementById('strengthWrap');
    let bars = ['s1','s2','s3','s4'].map(id => document.getElementById(id));
    let l = document.getElementById('strengthLabel');
    if (!v) { w.classList.add('hidden'); return; }
    w.classList.remove('hidden');
    let s = (v.length>=8?1:0) + (/[A-Z]/.test(v)?1:0) + (/[0-9]/.test(v)?1:0) + (/[^A-Za-z0-9]/.test(v)?1:0);
    let c = ['#ef4444','#f97316','#eab308','#22c55e'];
    let t = ['Lemah','Cukup','Kuat','Sangat Kuat'];
    bars.forEach((b,i) => { b.style.background = i < s ? c[s-1] : '#e7e5e4'; });
    l.textContent = t[s-1] || 'Lemah';
    l.style.color = c[s-1] || '#ef4444';
  });

  function handleSimpan() { showToast('✓ Perubahan profil berhasil disimpan'); }
  function handleUpdatePassword() {
    let l = document.getElementById('pwLama').value;
    let b = document.getElementById('pwBaru').value;
    let k = document.getElementById('pwKonfirm').value;
    if (!l||!b||!k) return showToast('⚠ Isi semua kolom password', false);
    if (b !== k) return showToast('⚠ Password baru tidak cocok', false);
    if (b.length < 8) return showToast('⚠ Password minimal 8 karakter', false);
    showToast('✓ Password berhasil diperbarui');
    document.getElementById('pwLama').value = document.getElementById('pwBaru').value = document.getElementById('pwKonfirm').value = '';
    document.getElementById('strengthWrap').classList.add('hidden');
  }

  function openLogout()  { document.getElementById('logoutOverlay').classList.add('open'); document.body.style.overflow='hidden'; }
  function closeLogout() { document.getElementById('logoutOverlay').classList.remove('open'); document.body.style.overflow=''; }
 
// Fungsi untuk benar-benar logout dengan mengirim form POST ke route logout Laravel
function performLogout() {
    // Tampilkan toast
    showToast('Sampai jumpa! 👋');
    // Tutup modal
    closeLogout();
    // Buat form dinamis untuk POST ke route logout
    var form = document.createElement('form');
    form.method = 'POST';
    form.action = '{{ route("logout") }}';
    // Tambahkan CSRF token
    var csrfInput = document.createElement('input');
    csrfInput.type = 'hidden';
    csrfInput.name = '_token';
    csrfInput.value = '{{ csrf_token() }}';
    form.appendChild(csrfInput);
    document.body.appendChild(form);
    form.submit();
}
  document.getElementById('logoutOverlay').addEventListener('click', function(e) { if (e.target===this) closeLogout(); });

  function showToast(msg, success=true) {
    let t = document.getElementById('toast'), tm = document.getElementById('toastMsg');
    tm.textContent = msg;
    t.style.background = success ? '#1c1c1c' : '#ef4444';
    t.classList.add('show');
    clearTimeout(t._t);
    t._t = setTimeout(() => t.classList.remove('show'), 2800);
  }
</script>
</body>
</html>