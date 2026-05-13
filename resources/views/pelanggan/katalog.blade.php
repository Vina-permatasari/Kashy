<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Katalog | SND STORE</title>
<script src="https://cdn.tailwindcss.com"></script>
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,600;0,700;1,400&family=DM+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<script>
  tailwind.config = {
    theme: {
      extend: {
        colors: {
          terra:   '#C8966C',
          'terra-l':  '#E5B18A',
          'terra-ll': '#F0D7C7',
          'terra-xs': '#FAF2EC',
          muted:   '#9C8B7E',
          border:  '#EAE0D6',
          bg:      '#F5F0EB',
        },
        fontFamily: {
          display: ['Cormorant Garamond', 'serif'],
          body:    ['DM Sans', 'sans-serif'],
        },
        keyframes: {
          fadeUp: {
            '0%':   { opacity: '0', transform: 'translateY(14px)' },
            '100%': { opacity: '1', transform: 'translateY(0)' },
          },
        },
        animation: {
          'fade-up': 'fadeUp 0.35s ease both',
        }
      }
    }
  }
</script>
<style>
  * { box-sizing: border-box; margin: 0; padding: 0; }
  body { font-family: 'DM Sans', sans-serif; background-color: #F5F0EB; }
  .hide-scroll::-webkit-scrollbar { display: none; }
  .hide-scroll { scrollbar-width: none; -webkit-overflow-scrolling: touch; }
  @keyframes fadeUp {
    from { opacity: 0; transform: translateY(14px); }
    to   { opacity: 1; transform: translateY(0); }
  }
  .cat-btn.active .cat-icon { border-color: #C8966C; background: #F0D7C7; transform: translateY(-3px); box-shadow: 0 6px 18px rgba(200,150,108,.28); }
  .cat-btn.active .cat-icon svg { stroke: #C8966C; }
  .cat-btn.active .cat-label { color: #C8966C; font-weight: 600; }
  .card.selected { border-color: #C8966C !important; box-shadow: 0 0 0 4px rgba(200,150,108,.18), 0 12px 40px rgba(28,28,28,.18) !important; transform: translateY(-4px) !important; }
  .card.selected::after { content:''; position:absolute; inset:0; background:linear-gradient(180deg,rgba(200,150,108,.06) 0%,transparent 50%); pointer-events:none; }
  .bn-item.active .bn-icon { background: #F0D7C7; }
  .bn-item.active .bn-icon svg { stroke: #C8966C; }
  .bn-item.active .bn-label { color: #C8966C; font-weight: 600; }
</style>
</head>
<body class="bg-bg min-h-screen flex flex-col">

<!-- ════ TOPBAR ════ -->
<nav class="sticky top-0 z-50 bg-gray-900 px-5 py-3.5 flex items-center justify-center shadow-md">
  <a href="javascript:history.back()"  class="absolute left-5 flex items-center gap-1.5 text-xs text-gray-500 hover:text-white transition-colors no-underline">
    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M19 12H5m7-7-7 7 7 7"/></svg>
    Kembali
  </a>
  <span class="font-sans text-xl font-bold text-white tracking-normal">SND STORE</span>
</nav>

<!-- ════ HERO ════ -->
<div class="mx-4 mt-3 mb-5 rounded-2xl overflow-hidden h-56 relative bg-amber-900 shadow-lg">
  <div class="absolute inset-0 bg-cover bg-center opacity-60" style="background-image:url('https://images.unsplash.com/photo-1490481651871-ab68de25d43d?w=900&q=80')"></div>
  <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>
  <div class="relative z-10 flex flex-col justify-end h-full p-5">
    <span class="inline-block bg-terra text-white text-xs font-bold tracking-wider px-3 py-1 rounded-full mb-2 w-fit uppercase">New Arrival!!</span>
    <div class="text-xl font-semibold text-white mb-1">Promo koleksi kemeja terbaru</div>
    <div class="text-sm text-white/70">Buruan dibeli sebelum habis!!!</div>
  </div>
</div>

<!-- ════ KATEGORI ════ -->
<div class="flex items-center justify-between px-5 pb-3">
  <span class="text-base font-bold text-gray-900">Kategori</span>
</div>

<div class="overflow-x-auto hide-scroll pt-2 pb-6">
  <div class="inline-flex gap-10 px-5 min-w-full justify-center items-start">
    <button class="cat-btn active flex flex-col items-center gap-2 bg-transparent border-0 p-0 cursor-pointer font-body" onclick="window.location.href='{{ route('daftar-produk') }}?cat=semua'">
      <div class="cat-icon w-15 h-15 rounded-full bg-white border-2 border-border flex items-center justify-center transition-all duration-200 hover:border-terra hover:bg-terra-xs hover:-translate-y-1 hover:shadow-lg" style="width:60px;height:60px;">
        <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#9C8B7E" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
          <rect x="3" y="3" width="7" height="7" rx="1.5"/><rect x="14" y="3" width="7" height="7" rx="1.5"/>
          <rect x="3" y="14" width="7" height="7" rx="1.5"/><rect x="14" y="14" width="7" height="7" rx="1.5"/>
        </svg>
      </div>
      <span class="cat-label text-xs font-medium text-muted whitespace-nowrap">Beranda</span>
    </button>
    <button class="cat-btn flex flex-col items-center gap-2 bg-transparent border-0 p-0 cursor-pointer font-body" onclick="window.location.href='{{ route('daftar-produk') }}?cat=kemeja'">
      <div class="cat-icon w-15 h-15 rounded-full bg-white border-2 border-border flex items-center justify-center transition-all duration-200 hover:border-terra hover:bg-terra-xs hover:-translate-y-1 hover:shadow-lg" style="width:60px;height:60px;">
        <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#9C8B7E" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
          <path d="M20.38 3.46 16 2a4 4 0 0 1-8 0L3.62 3.46a2 2 0 0 0-1.34 2.23l.58 3.57a1 1 0 0 0 .99.84H6v10c0 1.1.9 2 2 2h8a2 2 0 0 0 2-2V10h2.15a1 1 0 0 0 .99-.84l.58-3.57a2 2 0 0 0-1.34-2.23z"/>
        </svg>
      </div>
      <span class="cat-label text-xs font-medium text-muted whitespace-nowrap">Kemeja</span>
    </button>
    <button class="cat-btn flex flex-col items-center gap-2 bg-transparent border-0 p-0 cursor-pointer font-body" onclick="window.location.href='{{ route('daftar-produk') }}?cat=rok'">
      <div class="cat-icon w-15 h-15 rounded-full bg-white border-2 border-border flex items-center justify-center transition-all duration-200 hover:border-terra hover:bg-terra-xs hover:-translate-y-1 hover:shadow-lg" style="width:60px;height:60px;">
        <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#9C8B7E" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
          <rect x="7" y="2" width="10" height="4" rx="1"/>
          <path d="M7 6 4 20h16L17 6"/>
        </svg>
      </div>
      <span class="cat-label text-xs font-medium text-muted whitespace-nowrap">Rok</span>
    </button>
    <button class="cat-btn flex flex-col items-center gap-2 bg-transparent border-0 p-0 cursor-pointer font-body" onclick="window.location.href='{{ route('daftar-produk') }}?cat=cardigan'">
      <div class="cat-icon w-15 h-15 rounded-full bg-white border-2 border-border flex items-center justify-center transition-all duration-200 hover:border-terra hover:bg-terra-xs hover:-translate-y-1 hover:shadow-lg" style="width:60px;height:60px;">
        <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#9C8B7E" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
          <path d="M3 6.5 7.5 3h3L12 5l1.5-2h3L21 6.5l-3 2.5v11a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V9L3 6.5z"/>
          <path d="M12 5v15"/>
        </svg>
      </div>
      <span class="cat-label text-xs font-medium text-muted whitespace-nowrap">Cardigan</span>
    </button>
    <button class="cat-btn flex flex-col items-center gap-2 bg-transparent border-0 p-0 cursor-pointer font-body" onclick="window.location.href='{{ route('daftar-produk') }}?cat=celana'">
      <div class="cat-icon w-15 h-15 rounded-full bg-white border-2 border-border flex items-center justify-center transition-all duration-200 hover:border-terra hover:bg-terra-xs hover:-translate-y-1 hover:shadow-lg" style="width:60px;height:60px;">
        <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#9C8B7E" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
          <path d="M6 2h12v4l-3 16H9L6 6V2z"/>
          <path d="M6 6h12"/><path d="M12 6v4"/>
        </svg>
      </div>
      <span class="cat-label text-xs font-medium text-muted whitespace-nowrap">Celana</span>
    </button>
    <button class="cat-btn flex flex-col items-center gap-2 bg-transparent border-0 p-0 cursor-pointer font-body" onclick="window.location.href='{{ route('daftar-produk') }}?cat=jaket'">
      <div class="cat-icon w-15 h-15 rounded-full bg-white border-2 border-border flex items-center justify-center transition-all duration-200 hover:border-terra hover:bg-terra-xs hover:-translate-y-1 hover:shadow-lg" style="width:60px;height:60px;">
        <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#9C8B7E" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
          <path d="M3 7 7 3h2.5L12 6l2.5-3H17l4 4-2.5 2L17 7v13a1 1 0 0 1-1 1H8a1 1 0 0 1-1-1V7L4.5 9 3 7z"/>
          <path d="M12 6v14"/>
        </svg>
      </div>
      <span class="cat-label text-xs font-medium text-muted whitespace-nowrap">Jaket</span>
    </button>
  </div>
</div>

<!-- ════ PRODUK TERBARU ════ -->
<div class="flex items-center justify-between px-5 pt-1 pb-3">
  <span class="text-base font-bold text-gray-900">Produk Terbaru</span>
</div>

<!-- Grid: mobile 2 kolom, sm 3, md 4, lg 5 -->
<div class="grid grid-cols-2 gap-3 px-3.5 pb-5 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5" id="productGrid"></div>

<!-- ════ DISKON SPESIAL ════ -->
<div class="h-1.5 bg-bg"></div>
<div class="flex items-center justify-between px-5 pt-3 pb-3">
  <span class="text-base font-bold text-gray-900">Diskon Spesial</span>
  <span class="text-xs font-medium text-terra cursor-pointer hover:underline">Lihat semua</span>
</div>

<div class="overflow-x-auto hide-scroll pb-6 pt-3">
  <div class="inline-flex gap-3 px-3.5 min-w-full" id="diskonRow"></div>
</div>

<!-- ════ FOOTER HUBUNGI KAMI ════ -->
<div class="mt-5 bg-gray-900 px-5 pt-8 pb-24">

  <!-- Judul -->
  <div class="mb-5">
  <span class="font-sans text-3xl font-bold text-white tracking-normal">Hubungi Kami</span>
  <div class="w-8 h-0.5 bg-terra mt-1 mb-2"></div>
</div>

  <!-- Kontak Cards -->
  <div class="flex flex-col sm:flex-row gap-3 mb-5">

    <!-- WhatsApp -->
    <a href="https://wa.me/6285261246660" target="_blank"
       class="flex items-center gap-3 bg-white/5 hover:bg-terra/20 border border-white/10 hover:border-terra/40 rounded-xl p-4 transition-all duration-200 group flex-1">
      <div class="w-10 h-10 bg-terra rounded-xl flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform duration-200">
        <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
          <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
        </svg>
      </div>
      <div class="min-w-0">
        <p class="text-xs text-gray-500 uppercase tracking-widest mb-0.5">WhatsApp</p>
        <p class="text-terra text-sm font-bold group-hover:text-terra-l transition-colors">0852-6124-6660</p>
      </div>
      <svg class="w-4 h-4 text-gray-600 group-hover:text-terra transition-colors ml-auto flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="m9 18 6-6-6-6"/></svg>
    </a>

    <!-- Instagram -->
    <a href="https://www.instagram.com/snd_store___?igsh=cmloaGdna3ptbnp5" target="_blank"
       class="flex items-center gap-3 bg-white/5 hover:bg-terra/20 border border-white/10 hover:border-terra/40 rounded-xl p-4 transition-all duration-200 group flex-1">
      <div class="w-10 h-10 bg-terra rounded-xl flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform duration-200">
        <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
          <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 1 0 0 12.324 6.162 6.162 0 0 0 0-12.324zM12 16a4 4 0 1 1 0-8 4 4 0 0 1 0 8zm6.406-11.845a1.44 1.44 0 1 0 0 2.881 1.44 1.44 0 0 0 0-2.881z"/>
        </svg>
      </div>
      <div class="min-w-0">
        <p class="text-xs text-gray-500 uppercase tracking-widest mb-0.5">Instagram</p>
        <p class="text-white text-sm font-medium group-hover:text-terra transition-colors">@snd_store___</p>
      </div>
      <svg class="w-4 h-4 text-gray-600 group-hover:text-terra transition-colors ml-auto flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="m9 18 6-6-6-6"/></svg>
    </a>

  </div>

  <!-- Lokasi & Map -->
  <div class="bg-white/5 border border-white/10 rounded-xl overflow-hidden mb-5">
    <div class="px-4 py-3 flex items-center gap-3 border-b border-white/10">
      <div class="w-8 h-8 bg-terra/20 rounded-lg flex items-center justify-center flex-shrink-0">
        <svg class="w-4 h-4 text-terra" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
          <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
        </svg>
      </div>
      <div>
        <p class="text-xs text-gray-500 uppercase tracking-widest">Lokasi Toko</p>
        <p class="text-white text-sm font-medium">Jl. Bromo No.171 C, Binjai, Kec. Medan Denai,</p>
        <p class="text-white text-sm font-medium">Kota Medan, Sumatera Utara 20227</p>
      </div>
      <a href="https://maps.app.goo.gl/AwT71cgeBkxNmFse9" target="_blank"
         class="ml-auto text-xs text-terra hover:text-terra-l transition-colors font-medium flex-shrink-0 whitespace-nowrap">
        Buka Maps →
      </a>
    </div>
    <!-- Embed Google Maps -->
    <div class="w-full h-52">
      <iframe
        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3982.0!2d98.6892!3d3.5952!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMy41OTUyLDk4LjY4OTI!5e0!3m2!1sid!2sid!4v1620000000000!5m2!1sid!2sid"
        width="100%" height="100%"
        style="border:0; filter: grayscale(30%) contrast(1.1);"
        allowfullscreen="" loading="lazy"
        referrerpolicy="no-referrer-when-downgrade">
      </iframe>
    </div>
  </div>

  <!-- Footer Brand -->
  <div class="relative bg-gray-950 rounded-xl overflow-hidden px-6 py-8 mb-5">
    <!-- Decorative leaves kiri -->
    <div class="absolute left-0 top-0 bottom-0 w-20 opacity-20">
      <svg viewBox="0 0 80 200" fill="none" xmlns="http://www.w3.org/2000/svg" class="h-full">
        <path d="M10 180 Q30 140 20 100 Q10 60 30 20" stroke="#C8966C" stroke-width="1.5" fill="none"/>
        <path d="M20 160 Q50 130 35 90" stroke="#C8966C" stroke-width="1" fill="none"/>
        <path d="M15 140 Q-10 110 10 80" stroke="#C8966C" stroke-width="1" fill="none"/>
        <path d="M25 120 Q55 100 40 70" stroke="#C8966C" stroke-width="1" fill="none"/>
        <path d="M10 100 Q-15 75 5 50" stroke="#C8966C" stroke-width="1" fill="none"/>
      </svg>
    </div>
    <!-- Decorative leaves kanan -->
    <div class="absolute right-0 top-0 bottom-0 w-20 opacity-20">
      <svg viewBox="0 0 80 200" fill="none" xmlns="http://www.w3.org/2000/svg" class="h-full">
        <path d="M70 180 Q50 140 60 100 Q70 60 50 20" stroke="#C8966C" stroke-width="1.5" fill="none"/>
        <path d="M60 160 Q30 130 45 90" stroke="#C8966C" stroke-width="1" fill="none"/>
        <path d="M65 140 Q90 110 70 80" stroke="#C8966C" stroke-width="1" fill="none"/>
        <path d="M55 120 Q25 100 40 70" stroke="#C8966C" stroke-width="1" fill="none"/>
        <path d="M70 100 Q95 75 75 50" stroke="#C8966C" stroke-width="1" fill="none"/>
      </svg>
    </div>

    <!-- Content -->
    <div class="relative z-10 text-center">
      <div class="font-sans text-3xl font-bold text-white text-white tracking-normal mb-3">SND STORE</div>
      <div class="w-12 h-0.5 bg-terra mx-auto mb-4"></div>
      <p class="text-gray-400 text-xs leading-relaxed max-w-xs mx-auto mb-6">
        SND Store adalah Toko Thrift terbaik untuk Anda. Kami menghadirkan beragam pilihan kategori pakaian yang selalu up to date dengan tren fashion masa kini. Setiap produk di SND Store telah melalui proses seleksi ketat sehingga tetap dalam kondisi terbaik, layaknya baru.
      </p>
      <!-- Heart icon -->
      <svg class="w-5 h-5 text-terra mx-auto mb-4" fill="currentColor" viewBox="0 0 24 24">
        <path d="M12 21.593c-5.63-5.539-11-10.297-11-14.402 0-3.791 3.068-5.191 5.281-5.191 1.312 0 4.151.501 5.719 4.457 1.59-3.968 4.464-4.447 5.726-4.447 2.54 0 5.274 1.621 5.274 5.181 0 4.069-5.136 8.625-11 14.402z"/>
      </svg>
      <p class="text-gray-600 text-xs">© 2026 SND Store. All rights reserved.</p>
    </div>
  </div>

</div>

<!-- BOTTOM NAV -->
<nav class="sticky bottom-0 z-50 bg-white border-t border-border flex justify-around py-2.5 pb-4 shadow-[0_-2px_12px_rgba(28,28,28,0.06)]">
  <button class="bn-item active flex flex-col items-center gap-1 flex-1 border-0 bg-transparent cursor-pointer font-body p-0">
    <div class="bn-icon w-10 h-10 rounded-xl flex items-center justify-center transition-all duration-200 hover:bg-terra-xs hover:-translate-y-0.5">
      <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#9C8B7E" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
        <polyline points="9 22 9 12 15 12 15 22"/>
      </svg>
    </div>
    <span class="bn-label text-xs font-medium text-muted transition-colors">Beranda</span>
  </button>
  <button class="bn-item flex flex-col items-center gap-1 flex-1 border-0 bg-transparent cursor-pointer font-body p-0" onclick="window.location.href='{{ route('daftar-produk') }}'">
    <div class="bn-icon w-10 h-10 rounded-xl flex items-center justify-center transition-all duration-200 hover:bg-terra-xs hover:-translate-y-0.5">
      <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#9C8B7E" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <path d="M4 6h16M4 12h16M4 18h16"/>
      </svg>
    </div>
    <span class="bn-label text-xs font-medium text-muted transition-colors">Daftar Produk</span>
  </button>
</nav>

<script>
const PRODUCTS = [
  { id:1, name:'Kulot Modis',      cat:'celana',   price:'Rp 76.000', old:'',          badge:'new',     bg:'linear-gradient(135deg,#e8ddd4,#d4c5b4)' },
  { id:2, name:'Kemeja Cokelat',   cat:'kemeja',   price:'Rp 52.000', old:'',          badge:'',        bg:'linear-gradient(135deg,#d4c9bc,#c4b8a8)' },
  { id:3, name:'Rok Putih Layer',  cat:'rok',      price:'Rp 70.000', old:'',          badge:'new',     bg:'linear-gradient(135deg,#ede0d4,#ddd0c4)' },
  { id:4, name:'Cardigan Rajut',   cat:'cardigan', price:'Rp 47.000', old:'',          badge:'',        bg:'linear-gradient(135deg,#e0d4c9,#d0c4b9)' },
  { id:5, name:'Kemeja Flannel',   cat:'kemeja',   price:'Rp 85.000', old:'',          badge:'branded', bg:'linear-gradient(135deg,#d9cfc4,#c9bfb4)' },
  { id:6, name:'Celana Cargo',     cat:'celana',   price:'Rp 120.000',old:'',          badge:'branded', bg:'linear-gradient(135deg,#cfc4b9,#bfb4a9)' },
  { id:7, name:'Jaket Denim',      cat:'jaket',    price:'Rp 150.000',old:'',          badge:'branded', bg:'linear-gradient(135deg,#c9cfe0,#b9c2d4)' },
  { id:8, name:'Rok Mini Plaid',   cat:'rok',      price:'Rp 95.000', old:'Rp 120.000',badge:'sale', discount:'-25%',    bg:'linear-gradient(135deg,#e0c9c9,#d0b9b9)' },
  { id:9, name:'Kaos Cream Pita',  cat:'kemeja',   price:'Rp 27.000', old:'Rp 37.000', badge: 'sale', desc:'Kaos cream aesthetic dengan pita manis.', bg:'linear-gradient(135deg,#ede0d4,#d9c5b0)'},
  { id:10, name:'Cardigan Krem Rajut', cat:'cardigan', price:'Rp 42.000', old:'Rp 70.000', badge:'sale', discount:'-40%', bg:'linear-gradient(135deg,#e0d4c9,#ccbfb0)' }
];

const ICONS = {
  kemeja:   `<path d="M20.38 3.46 16 2a4 4 0 0 1-8 0L3.62 3.46a2 2 0 0 0-1.34 2.23l.58 3.57a1 1 0 0 0 .99.84H6v10c0 1.1.9 2 2 2h8a2 2 0 0 0 2-2V10h2.15a1 1 0 0 0 .99-.84l.58-3.57a2 2 0 0 0-1.34-2.23z"/>`,
  celana:   `<path d="M6 2h12v4l-3 16H9L6 6V2z"/><path d="M6 6h12M12 6v4"/>`,
  rok:      `<rect x="7" y="2" width="10" height="4" rx="1"/><path d="M7 6 4 20h16L17 6"/>`,
  cardigan: `<path d="M3 6.5 7.5 3h3L12 5l1.5-2h3L21 6.5l-3 2.5v11a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V9L3 6.5z"/><path d="M12 5v15"/>`,
  jaket:    `<path d="M3 7 7 3h2.5L12 6l2.5-3H17l4 4-2.5 2L17 7v13a1 1 0 0 1-1 1H8a1 1 0 0 1-1-1V7L4.5 9 3 7z"/><path d="M12 6v14"/>`,
  default:  `<rect x="3" y="3" width="7" height="7" rx="1.5"/><rect x="14" y="3" width="7" height="7" rx="1.5"/><rect x="3" y="14" width="7" height="7" rx="1.5"/><rect x="14" y="14" width="7" height="7" rx="1.5"/>`,
};

const BADGE_LABELS = { new:'New', branded:'Branded', sale:'Sale' };
const BADGE_CLASSES = { new:'bg-gray-900 text-white', branded:'bg-terra text-white', sale:'bg-red-500 text-white' };

let currentCat = 'semua';
let selected = null;

function render() {
  const grid = document.getElementById('productGrid');
  const filtered = PRODUCTS.filter(p => currentCat === 'semua' || p.cat === currentCat);
  if (!filtered.length) {
    grid.innerHTML = `<div class="col-span-full text-center py-12 text-muted"><p class="text-sm">Produk tidak ditemukan</p></div>`;
    return;
  }
  grid.innerHTML = filtered.map((p, i) => {
    const icon = ICONS[p.cat] || ICONS.default;
    const badgeHtml = p.badge
      ? `<span class="absolute top-2 right-2 z-20 text-[10px] font-bold px-2 py-0.5 rounded-full ${BADGE_CLASSES[p.badge] || 'bg-gray-500 text-white'}">${BADGE_LABELS[p.badge] || p.badge}</span>`
      : '';
    return `
    <div class="card relative bg-white rounded-2xl overflow-hidden shadow-sm cursor-pointer border-2 border-transparent transition-all duration-200 hover:-translate-y-1 hover:shadow-md hover:border-terra-l" style="animation:fadeUp .35s ease ${i * .05}s both" onclick="goToDetail(${p.id})">
      ${badgeHtml}
      <div class="relative w-full overflow-hidden" style="aspect-ratio:3/3">
        <div class="absolute inset-0" style="background:${p.bg}"></div>
        <div class="relative z-10 w-full h-full flex items-center justify-center">
          <svg class="transition-transform duration-300 hover:scale-110" style="width:48%;height:48%" viewBox="0 0 24 24" fill="rgba(255,255,255,0.15)" stroke="rgba(255,255,255,0.6)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">${icon}</svg>
        </div>
      </div>
      <div class="p-2.5 pb-3">
        <div class="text-xs font-semibold text-gray-900 mb-1 leading-tight line-clamp-2">${p.name}</div>
        <div class="flex items-baseline gap-1.5 flex-wrap">
          <span class="text-sm font-bold text-terra">${p.price}</span>
          ${p.old ? `<span class="text-xs text-muted line-through">${p.old}</span>` : ''}
        </div>
      </div>
    </div>`;
  }).join('');
}

function renderDiskon() {
  const row = document.getElementById('diskonRow');
  const saleProducts = PRODUCTS.filter(p => p.badge === 'sale');
  row.innerHTML = saleProducts.map(p => {
    const icon = ICONS[p.cat] || ICONS.default;
    return `
    <div onclick="goToDetail(${p.id})" class="flex-shrink-0 w-36 bg-white rounded-2xl overflow-hidden shadow-sm cursor-pointer border-2 border-transparent hover:-translate-y-1 hover:shadow-md hover:border-terra-l transition-all duration-200">
      <div class="w-full h-28 flex items-center justify-center relative overflow-hidden" style="background:${p.bg}">
        <svg class="w-12 h-12" viewBox="0 0 24 24" fill="none" stroke="rgba(255,255,255,0.55)" stroke-width="1.5" stroke-linecap="round">${icon}</svg>
        <span class="absolute bottom-1.5 left-1.5 bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded">${p.discount || '-20%'}</span>
      </div>
      <div class="p-2.5 pb-3">
        <div class="text-xs font-medium text-gray-900 mb-1 leading-tight">${p.name}</div>
        <div class="flex items-baseline gap-1.5 flex-wrap">
          <span class="text-sm font-bold text-terra">${p.price}</span>
          <span class="text-xs text-muted line-through">${p.old}</span>
        </div>
      </div>
    </div>`;
  }).join('');
}

function goToDetail(id) {
  window.location.href = `/detail-produk/${id}`;
}

function setCat(el) {
  currentCat = el.dataset.cat;
  selected = null;
  document.querySelectorAll('.cat-btn').forEach(b => b.classList.remove('active'));
  el.classList.add('active');
  render();
}

render();
renderDiskon();
</script>
</body>
</html>