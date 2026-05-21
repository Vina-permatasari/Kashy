<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Profil Saya – Kashy</title>
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

  .info-row:hover, .menu-row:hover { background: #FAF2EC; }
  .menu-row:hover { transform: translateX(2px); }

  .bn-item.active .bn-icon { background: #F0D7C7; }
  .bn-item.active .bn-icon svg { stroke: #C8966C; }
  .bn-item.active .bn-label { color: #C8966C; font-weight: 600; }

  .avatar-ring {
    background: linear-gradient(135deg, #C8966C, #E5B18A, #F0D7C7, #C8966C);
    padding: 3px;
    border-radius: 9999px;
  }

  #toast {
    opacity: 0;
    transform: translateX(-50%) translateY(16px);
    transition: opacity .25s ease, transform .3s cubic-bezier(0.34,1.56,.64,1);
    pointer-events: none;
  }
  #toast.show {
    opacity: 1;
    transform: translateX(-50%) translateY(0);
  }

  #logoutOverlay {
    opacity: 0;
    pointer-events: none;
    transition: opacity .25s ease;
  }
  #logoutOverlay.open {
    opacity: 1;
    pointer-events: all;
  }
  #logoutDialog {
    transform: scale(.92) translateY(12px);
    transition: transform .3s cubic-bezier(0.34,1.56,.64,1);
  }
  #logoutOverlay.open #logoutDialog {
    transform: scale(1) translateY(0);
  }
</style>
</head>
<body class="bg-bg min-h-screen flex flex-col">

<!-- TOPBAR -->
<nav class="sticky top-0 z-50 bg-gray-900 flex items-center justify-center px-5 shadow-md h-[52px]">
  <span class="font-poppins text-xl font-bold text-white tracking-widest">Kashy</span>
</nav>

<main class="flex-1 overflow-y-auto hide-scroll">
  <div class="max-w-lg mx-auto px-4 pt-7 pb-28 space-y-5">

    <!-- Profile Hero -->
    <div class="anim-0 flex flex-col items-center text-center">
      <div class="avatar-anim relative mb-4">
        <div class="avatar-ring">
          <div class="w-24 h-24 sm:w-28 sm:h-28 rounded-full overflow-hidden bg-stone-200">
            <div class="w-full h-full flex items-center justify-center" style="background:linear-gradient(135deg,#d4c5b0,#b8a898,#c8b8a8);">
              <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="rgba(255,255,255,0.7)" stroke-width="1.2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
            </div>
          </div>
        </div>
        <button onclick="showToast('Fitur upload foto segera hadir ✨')" class="absolute bottom-0.5 right-0.5 w-7 h-7 rounded-full bg-terra shadow-md border-2 border-white flex items-center justify-center hover:bg-terra-l">
          <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
        </button>
      </div>
      <h1 class="font-display text-2xl sm:text-3xl font-bold text-gray-900">{{ Auth::user()->name }}</h1>
<span class="inline-flex items-center gap-1.5 px-3.5 py-1 rounded-full text-xs font-semibold bg-terra-xs text-terra border border-terra-ll">
  <span class="w-1.5 h-1.5 rounded-full bg-terra"></span> Kasir
</span>
</div>

    <!-- Info Card -->
    <div class="anim-1 bg-white rounded-2xl shadow-sm border border-border overflow-hidden">
      <div class="shimmer-bar h-1"></div>
      <div class="info-row flex items-center gap-4 px-5 py-4 border-b border-stone-100">
        <div class="w-9 h-9 rounded-xl bg-terra-xs flex items-center justify-center"><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#C8966C" stroke-width="2"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg></div>
        <div><p class="text-[10px] font-bold tracking-wide text-muted">Email Address</p><p class="text-sm font-medium text-gray-900">adinda.permata@example.com</p></div>
      </div>
      <div class="info-row flex items-center gap-4 px-5 py-4 border-b border-stone-100">
        <div class="w-9 h-9 rounded-xl bg-terra-xs flex items-center justify-center"><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#C8966C" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.15 13a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 3.06 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 21 16.92z"/></svg></div>
        <div><p class="text-[10px] font-bold tracking-wide text-muted">Phone Number</p><p class="text-sm font-medium text-gray-900">+62 812-3456-7890</p></div>
      </div>
      <div class="info-row flex items-center gap-4 px-5 py-4">
        <div class="w-9 h-9 rounded-xl bg-terra-xs flex items-center justify-center"><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#C8966C" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg></div>
        <div><p class="text-[10px] font-bold tracking-wide text-muted">Account Role</p><p class="text-sm font-medium text-gray-900">Kasir</p></div>
      </div>
    </div>

    <!-- Pengaturan Akun Heading -->
    <div class="anim-2 pt-1">
      <h2 class="font-display text-2xl sm:text-3xl font-bold text-gray-900">Pengaturan Akun</h2>
      <div class="w-8 h-0.5 bg-terra rounded-full mt-1.5"></div>
    </div>

    <!-- Edit Profil -->
    <div class="anim-3 bg-white rounded-2xl shadow-sm border border-border overflow-hidden">
      <div class="px-5 pt-5 pb-6">
        <div class="flex items-center gap-3 mb-5">
          <div class="w-9 h-9 rounded-xl bg-terra-xs flex items-center justify-center"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#C8966C" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg></div>
          <h3 class="text-base font-bold text-gray-900">Edit Profil</h3>
        </div>
        <div class="space-y-4">
          <div><label class="block text-[10px] font-bold tracking-wide text-muted mb-2">Nama Lengkap</label><input type="text" value="Adinda Permata" class="kashy-input w-full px-4 py-3 border border-border rounded-xl bg-bg text-sm text-gray-900"></div>
          <div><label class="block text-[10px] font-bold tracking-wide text-muted mb-2">Email</label><input type="email" value="adinda.permata@example.com" class="kashy-input w-full px-4 py-3 border border-border rounded-xl bg-bg text-sm"></div>
          <div><label class="block text-[10px] font-bold tracking-wide text-muted mb-2">Nomor Telepon</label><input type="tel" value="+62 812-3456-7890" class="kashy-input w-full px-4 py-3 border border-border rounded-xl bg-bg text-sm"></div>
          <button onclick="handleSimpan()" class="btn-dark w-full py-3.5 text-white font-semibold rounded-xl text-sm tracking-wide flex items-center justify-center gap-2"><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>Simpan Perubahan</button>
        </div>
      </div>
    </div>

    <!-- Ganti Password -->
    <div class="anim-4 bg-white rounded-2xl shadow-sm border border-border overflow-hidden">
      <div class="px-5 pt-5 pb-6">
        <div class="flex items-center gap-3 mb-5">
          <div class="w-9 h-9 rounded-xl bg-terra-xs flex items-center justify-center"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#C8966C" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg></div>
          <h3 class="text-base font-bold text-gray-900">Ganti Password</h3>
        </div>
        <div class="space-y-4">
          <div><label class="block text-[10px] font-bold tracking-wide text-muted mb-2">Password Lama</label><div class="relative"><input type="password" id="pwLama" class="kashy-input w-full px-4 py-3 pr-11 border border-border rounded-xl bg-bg text-sm"><button type="button" onclick="togglePw('pwLama','eyeL')" class="absolute right-3.5 top-1/2 -translate-y-1/2 text-stone-300 hover:text-terra" id="eyeL"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7z"/><circle cx="12" cy="12" r="3"/></svg></button></div></div>
          <div><label class="block text-[10px] font-bold tracking-wide text-muted mb-2">Password Baru</label><div class="relative"><input type="password" id="pwBaru" class="kashy-input w-full px-4 py-3 pr-11 border border-border rounded-xl bg-bg text-sm"><button type="button" onclick="togglePw('pwBaru','eyeB')" class="absolute right-3.5 top-1/2 -translate-y-1/2 text-stone-300 hover:text-terra" id="eyeB"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7z"/><circle cx="12" cy="12" r="3"/></svg></button></div></div>
          <div><label class="block text-[10px] font-bold tracking-wide text-muted mb-2">Konfirmasi Password</label><div class="relative"><input type="password" id="pwKonfirm" class="kashy-input w-full px-4 py-3 pr-11 border border-border rounded-xl bg-bg text-sm"><button type="button" onclick="togglePw('pwKonfirm','eyeK')" class="absolute right-3.5 top-1/2 -translate-y-1/2 text-stone-300 hover:text-terra" id="eyeK"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7z"/><circle cx="12" cy="12" r="3"/></svg></button></div></div>
          <div id="strengthWrap" class="hidden"><div class="flex gap-1 mb-1"><div class="flex-1 h-1 rounded-full bg-stone-100" id="s1"></div><div class="flex-1 h-1 rounded-full bg-stone-100" id="s2"></div><div class="flex-1 h-1 rounded-full bg-stone-100" id="s3"></div><div class="flex-1 h-1 rounded-full bg-stone-100" id="s4"></div></div><p class="text-[11px] text-muted" id="strengthLabel">Kekuatan password</p></div>
          <button onclick="handleUpdatePassword()" class="btn-terra w-full py-3.5 text-white font-semibold rounded-xl text-sm tracking-wide flex items-center justify-center gap-2"><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>Update Password</button>
        </div>
      </div>
    </div>

    <!-- Menu Lainnya -->
    <div class="anim-5 bg-white rounded-2xl shadow-sm border border-border overflow-hidden">
      <button onclick="openLogout()" class="menu-row w-full flex items-center gap-4 px-5 py-4 text-left">
        <div class="w-10 h-10 rounded-xl bg-red-50 flex items-center justify-center"><svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="#ef4444" stroke-width="2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg></div>
        <div class="flex-1 text-left"><p class="text-sm font-semibold text-red-500">Keluar dari Akun</p><p class="text-xs text-red-300">Sesi Anda akan berakhir dengan aman</p></div>
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#ef4444" stroke-width="2.5"><path d="m9 18 6-6-6-6"/></svg>
      </button>
    </div>

    <div class="anim-6 text-center pb-2"><p class="text-[11px] text-stone-300 tracking-widest">Kashy © 2026</p><p class="text-[10px] text-stone-200 mt-0.5">IMK Project · Adinda Permata</p></div>
  </div>
</main>

<!-- Bottom Nav -->
@include('kasir.components.navbar')

<!-- Logout Modal -->
<div id="logoutOverlay" class="fixed inset-0 z-[60] bg-black/50 backdrop-blur-sm flex items-end sm:items-center justify-center p-4">
  <div id="logoutDialog" class="w-full max-w-sm bg-white rounded-3xl shadow-2xl overflow-hidden">
    <div class="shimmer-bar h-1"></div>
    <div class="px-6 pt-6 pb-7 text-center">
      <div class="w-14 h-14 rounded-2xl bg-red-50 flex items-center justify-center mx-auto mb-4"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#ef4444" stroke-width="2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg></div>
      <h3 class="font-display text-xl font-bold text-gray-900 mb-1">Keluar dari Akun?</h3>
      <p class="text-sm text-muted">Sesi Anda akan berakhir dan Anda perlu login kembali.</p>
      <div class="flex gap-3 mt-6"><button onclick="closeLogout()" class="flex-1 py-3 rounded-xl border-2 border-border text-sm font-semibold text-muted hover:bg-stone-50">Batal</button><button onclick="performLogout()" class="flex-1 py-3 rounded-xl bg-red-500 text-white text-sm font-semibold hover:bg-red-600">Ya, Keluar</button></div>
    </div>
  </div>
</div>

<!-- Toast -->
<div id="toast" class="fixed bottom-24 left-1/2 z-[70] bg-gray-900 text-white text-sm font-medium px-5 py-3 rounded-full shadow-xl flex items-center gap-2"><span id="toastMsg"></span></div>

<script>
function setNav(el){document.querySelectorAll('.bn-item').forEach(b=>b.classList.remove('active'));el.classList.add('active');}

function togglePw(inputId,btnId){let i=document.getElementById(inputId),b=document.getElementById(btnId),hide=i.type==='password';i.type=hide?'text':'password';b.innerHTML=hide?`<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/>`:`<path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7z"/><circle cx="12" cy="12" r="3"/>`;b.style.color=hide?'#C8966C':'';}

document.getElementById('pwBaru').addEventListener('input',function(){let v=this.value,w=document.getElementById('strengthWrap'),bars=[...'s1,s2,s3,s4'.split(',').map(id=>document.getElementById(id))],l=document.getElementById('strengthLabel');if(!v){w.classList.add('hidden');return;}w.classList.remove('hidden');let s=(v.length>=8?1:0)+(/[A-Z]/.test(v)?1:0)+(/[0-9]/.test(v)?1:0)+(/[^A-Za-z0-9]/.test(v)?1:0);let c=['#ef4444','#f97316','#eab308','#22c55e'],t=['Lemah','Cukup','Kuat','Sangat Kuat'];bars.forEach((b,i)=>{b.style.background=i<s?c[s-1]:'#e7e5e4'});l.textContent=t[s-1]||'Lemah';l.style.color=c[s-1]||'#ef4444';});

function handleSimpan(){showToast('✓ Perubahan profil berhasil disimpan');}
function handleUpdatePassword(){let l=document.getElementById('pwLama').value,b=document.getElementById('pwBaru').value,k=document.getElementById('pwKonfirm').value;if(!l||!b||!k)return showToast('⚠ Isi semua kolom password',false);if(b!==k)return showToast('⚠ Password baru tidak cocok',false);if(b.length<8)return showToast('⚠ Password minimal 8 karakter',false);showToast('✓ Password berhasil diperbarui');document.getElementById('pwLama').value=document.getElementById('pwBaru').value=document.getElementById('pwKonfirm').value='';document.getElementById('strengthWrap').classList.add('hidden');}

function openLogout(){document.getElementById('logoutOverlay').classList.add('open');document.body.style.overflow='hidden';}
function closeLogout(){document.getElementById('logoutOverlay').classList.remove('open');document.body.style.overflow='';}

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

document.getElementById('logoutOverlay').addEventListener('click',function(e){if(e.target===this)closeLogout();});

function showToast(msg,success=true){let t=document.getElementById('toast'),tm=document.getElementById('toastMsg');tm.textContent=msg;t.style.background=success?'#1c1c1c':'#ef4444';t.classList.add('show');clearTimeout(t._t);t._t=setTimeout(()=>t.classList.remove('show'),2800);}
</script>
</body>
</html>