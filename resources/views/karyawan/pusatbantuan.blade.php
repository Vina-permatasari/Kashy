<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Pusat Bantuan – Kashy</title>

<!-- Poppins -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<!-- Tailwind CDN -->
<script src="https://cdn.tailwindcss.com"></script>

<script>
  tailwind.config = {
    theme: {
      extend: {
        fontFamily: { poppins: ['Poppins', 'sans-serif'] },
        colors: {
          kashy: {
            black:  '#1C1C1C',
            gray1:  '#2E2E2E',
            gray2:  '#414141',
            terra:  '#C8966C',
            'terra-l':  '#E5B18A',
            'terra-ll': '#F0D7C7',
            bg:     '#F5F0EB',
            'bg-2': '#F9F5F0',
            muted:  '#9C8B7E',
            border: '#EAE0D6',
          }
        },
        boxShadow: {
          'card': '0 2px 12px rgba(28,28,28,0.06)',
          'card-md': '0 6px 24px rgba(28,28,28,0.10)',
        }
      }
    }
  }
</script>

<style>
  * { margin:0; padding:0; box-sizing:border-box; }
  body { font-family:'Poppins',sans-serif; }

  /* ── FAQ accordion ── */
  .faq-item { border-radius: 12px; overflow: hidden; }
  .faq-answer {
    max-height: 0;
    overflow: hidden;
    transition: max-height .35s cubic-bezier(.4,0,.2,1), padding .3s ease;
  }
  .faq-answer.open { max-height: 400px; }

  /* ── Chevron rotate ── */
  .faq-chevron { transition: transform .3s ease; }
  .faq-chevron.open { transform: rotate(180deg); }

  /* ── Search focus ring ── */
  .search-input:focus { outline: none; }

  /* ── Contact card gradient ── */
  .contact-card {
    background: linear-gradient(145deg, #1C1C1C 0%, #2E2E2E 100%);
  }

  /* ── Subtle hover on FAQ ── */
  .faq-trigger:hover { background-color: #F0E8DE; }

  /* ── Animation ── */
  @keyframes fadeUp {
    from { opacity:0; transform:translateY(18px); }
    to   { opacity:1; transform:translateY(0); }
  }
  .anim { animation: fadeUp .45s ease both; }
  .anim-1 { animation-delay: .05s; }
  .anim-2 { animation-delay: .12s; }
  .anim-3 { animation-delay: .19s; }
  .anim-4 { animation-delay: .26s; }
  .anim-5 { animation-delay: .33s; }
  .anim-6 { animation-delay: .40s; }
</style>
</head>

<body class="bg-kashy-bg font-poppins min-h-screen flex flex-col">

  <!-- ══════════════════════════════════════
       TOPBAR
  ══════════════════════════════════════ -->
<nav class="sticky top-0 z-50 bg-gray-900 flex items-center justify-between px-5 shadow-md h-[52px]">
  <a href="{{ route('karyawan.profile') }}" class="flex items-center gap-1.5 text-xs text-gray-400 hover:text-white">
    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M19 12H5m7-7-7 7 7 7"/></svg>
    Kembali
  </a>
  <span class="font-poppins text-xl font-bold text-white tracking-widest">Kashy</span>
  <div class="w-14"></div> <!-- placeholder kanan agar simetris -->
</nav>


  <!-- ══════════════════════════════════════
       MAIN CONTENT
  ══════════════════════════════════════ -->
  <main class="flex-1 w-full max-w-2xl mx-auto px-5 pb-16 pt-8">

    <!-- ── Header ── -->
    <div class="anim anim-1 mb-7">
      <h1 class="text-[28px] sm:text-[32px] font-bold text-kashy-black leading-tight mb-1">
        Pusat Bantuan
      </h1>
      <p class="text-sm text-kashy-muted font-normal">
        Bagaimana kami bisa membantu Anda hari ini?
      </p>
    </div>

    <!-- ── Search bar ── -->
    <div class="anim anim-2 mb-8">
      <div class="flex items-center gap-3 bg-white border border-kashy-border rounded-2xl px-4 py-3.5 shadow-card focus-within:border-kashy-terra focus-within:shadow-[0_0_0_3px_rgba(200,150,108,.14)] transition-all duration-200">
        <svg class="flex-shrink-0 text-kashy-muted" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
          <circle cx="11" cy="11" r="8"/>
          <path d="m21 21-4.35-4.35"/>
        </svg>
        <input
          type="text"
          placeholder="Cari topik bantuan..."
          class="search-input flex-1 bg-transparent text-sm text-kashy-black placeholder-[#C0AFA3] font-normal"
          oninput="filterFaq(this.value)"
        >
        <!-- Clear button -->
        <button id="clearBtn" onclick="clearSearch()" class="hidden text-kashy-muted hover:text-kashy-black transition-colors duration-150">
          <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" viewBox="0 0 24 24">
            <path d="M18 6 6 18M6 6l12 12"/>
          </svg>
        </button>
      </div>
    </div>

    <!-- ── Pertanyaan Populer ── -->
    <div class="anim anim-3 mb-3">
      <p class="text-[11px] font-semibold tracking-[.1em] uppercase text-kashy-muted" id="sectionLabel">
        Pertanyaan Populer
      </p>
    </div>

    <!-- ── FAQ List ── -->
    <div class="anim anim-4 bg-white rounded-2xl shadow-card overflow-hidden mb-8" id="faqContainer">

      <!-- item 1 -->
      <div class="faq-item" data-question="cara melakukan reset password sistem">
        <button class="faq-trigger w-full flex items-center justify-between gap-4 px-5 py-4 text-left transition-colors duration-150 border-b border-kashy-border/60" onclick="toggleFaq(this)">
          <span class="text-sm font-medium text-kashy-black leading-snug">
            Cara melakukan reset password sistem?
          </span>
          <svg class="faq-chevron flex-shrink-0 text-kashy-muted" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
            <path d="m6 9 6 6 6-6"/>
          </svg>
        </button>
        <div class="faq-answer bg-kashy-bg-2">
          <div class="px-5 py-4 text-sm text-kashy-muted leading-relaxed">
            Untuk mereset password sistem, buka halaman <strong class="text-kashy-black">Login</strong> lalu klik tombol <em>"Lupa Password?"</em>. Masukkan email yang terdaftar, lalu cek kotak masuk email Anda untuk tautan reset. Tautan berlaku selama <strong class="text-kashy-black">15 menit</strong>. Jika tidak menerima email, periksa folder spam atau hubungi admin.
          </div>
        </div>
      </div>

      <!-- item 2 -->
      <div class="faq-item" data-question="prosedur pengembalian barang cacat">
        <button class="faq-trigger w-full flex items-center justify-between gap-4 px-5 py-4 text-left transition-colors duration-150 border-b border-kashy-border/60" onclick="toggleFaq(this)">
          <span class="text-sm font-medium text-kashy-black leading-snug">
            Prosedur pengembalian barang cacat?
          </span>
          <svg class="faq-chevron flex-shrink-0 text-kashy-muted" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
            <path d="m6 9 6 6 6-6"/>
          </svg>
        </button>
        <div class="faq-answer bg-kashy-bg-2">
          <div class="px-5 py-4 text-sm text-kashy-muted leading-relaxed">
            Laporkan barang cacat dalam <strong class="text-kashy-black">3 x 24 jam</strong> setelah diterima. Sertakan foto barang dan nomor transaksi, lalu hubungi admin melalui tombol di bawah. Tim kami akan memproses pengembalian atau penggantian dalam <strong class="text-kashy-black">2–3 hari kerja</strong>.
          </div>
        </div>
      </div>

      <!-- item 3 -->
      <div class="faq-item" data-question="jadwal cuti bersama tahun 2024">
        <button class="faq-trigger w-full flex items-center justify-between gap-4 px-5 py-4 text-left transition-colors duration-150 border-b border-kashy-border/60" onclick="toggleFaq(this)">
          <span class="text-sm font-medium text-kashy-black leading-snug">
            Jadwal cuti bersama tahun 2024?
          </span>
          <svg class="faq-chevron flex-shrink-0 text-kashy-muted" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
            <path d="m6 9 6 6 6-6"/>
          </svg>
        </button>
        <div class="faq-answer bg-kashy-bg-2">
          <div class="px-5 py-4 text-sm text-kashy-muted leading-relaxed">
            Jadwal cuti bersama mengikuti ketetapan pemerintah. Informasi lengkap tersedia di menu <strong class="text-kashy-black">Pengumuman</strong> pada dashboard karyawan. Pengajuan cuti dilakukan minimal <strong class="text-kashy-black">3 hari sebelumnya</strong> melalui sistem.
          </div>
        </div>
      </div>

      <!-- item 4 -->
      <div class="faq-item" data-question="cara melihat laporan penjualan harian">
        <button class="faq-trigger w-full flex items-center justify-between gap-4 px-5 py-4 text-left transition-colors duration-150 border-b border-kashy-border/60" onclick="toggleFaq(this)">
          <span class="text-sm font-medium text-kashy-black leading-snug">
            Cara melihat laporan penjualan harian?
          </span>
          <svg class="faq-chevron flex-shrink-0 text-kashy-muted" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
            <path d="m6 9 6 6 6-6"/>
          </svg>
        </button>
        <div class="faq-answer bg-kashy-bg-2">
          <div class="px-5 py-4 text-sm text-kashy-muted leading-relaxed">
            Masuk ke menu <strong class="text-kashy-black">Laporan Transaksi</strong> di sidebar, lalu pilih filter <em>Hari Ini</em>. Laporan dapat diunduh dalam format PDF atau dicetak langsung dari sistem. Hanya admin dan kasir yang memiliki akses ke fitur ini.
          </div>
        </div>
      </div>

      <!-- item 5 -->
      <div class="faq-item" data-question="cara menambah produk baru ke sistem">
        <button class="faq-trigger w-full flex items-center justify-between gap-4 px-5 py-4 text-left transition-colors duration-150 border-b border-kashy-border/60" onclick="toggleFaq(this)">
          <span class="text-sm font-medium text-kashy-black leading-snug">
            Cara menambah produk baru ke sistem?
          </span>
          <svg class="faq-chevron flex-shrink-0 text-kashy-muted" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
            <path d="m6 9 6 6 6-6"/>
          </svg>
        </button>
        <div class="faq-answer bg-kashy-bg-2">
          <div class="px-5 py-4 text-sm text-kashy-muted leading-relaxed">
            Buka menu <strong class="text-kashy-black">Manajemen Produk</strong> di panel admin, klik tombol <em>"+ Tambah Produk"</em>, lalu isi nama, kategori, harga, dan stok awal. Unggah foto produk (maks. 2MB, format JPG/PNG). Klik <strong class="text-kashy-black">Simpan</strong> untuk menyimpan.
          </div>
        </div>
      </div>

      <!-- item 6 -->
      <div class="faq-item" data-question="cara melakukan absensi karyawan">
        <button class="faq-trigger w-full flex items-center justify-between gap-4 px-5 py-4 text-left transition-colors duration-150" onclick="toggleFaq(this)">
          <span class="text-sm font-medium text-kashy-black leading-snug">
            Cara melakukan absensi karyawan?
          </span>
          <svg class="faq-chevron flex-shrink-0 text-kashy-muted" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
            <path d="m6 9 6 6 6-6"/>
          </svg>
        </button>
        <div class="faq-answer bg-kashy-bg-2">
          <div class="px-5 py-4 text-sm text-kashy-muted leading-relaxed">
            Karyawan bisa melakukan absensi melalui menu <strong class="text-kashy-black">Absensi</strong> di dashboard. Tekan <em>Check-in</em> saat masuk dan <em>Check-out</em> saat pulang. Sistem mencatat waktu secara otomatis. Absensi yang terlambat akan ditandai dengan <strong class="text-kashy-black">warna kuning</strong> pada riwayat.
          </div>
        </div>
      </div>

      <!-- empty state (hidden by default) -->
      <div id="emptyState" class="hidden px-5 py-10 text-center">
        <div class="flex justify-center mb-3">
          <svg width="40" height="40" fill="none" stroke="#EAE0D6" stroke-width="1.5" viewBox="0 0 24 24">
            <circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/>
          </svg>
        </div>
        <p class="text-sm text-kashy-muted">Pertanyaan tidak ditemukan.</p>
        <p class="text-xs text-kashy-border mt-1">Coba kata kunci lain atau hubungi admin.</p>
      </div>

    </div><!-- /faqContainer -->


    <!-- ── Kategori Bantuan (bonus – hanya muncul di tablet) ── -->
    <div class="anim anim-5 hidden sm:grid grid-cols-3 gap-3 mb-8">
      <div class="bg-white rounded-xl p-4 shadow-card text-center hover:shadow-card-md hover:-translate-y-0.5 transition-all duration-200 cursor-pointer">
        <div class="w-10 h-10 rounded-full bg-kashy-bg flex items-center justify-center mx-auto mb-2.5">
          <svg width="20" height="20" fill="none" stroke="#C8966C" stroke-width="1.8" stroke-linecap="round" viewBox="0 0 24 24"><rect x="2" y="3" width="20" height="14" rx="2"/><path d="M8 21h8M12 17v4"/></svg>
        </div>
        <p class="text-xs font-600 text-kashy-black font-semibold">Sistem & Akun</p>
        <p class="text-[10px] text-kashy-muted mt-0.5">Login, password, akses</p>
      </div>
      <div class="bg-white rounded-xl p-4 shadow-card text-center hover:shadow-card-md hover:-translate-y-0.5 transition-all duration-200 cursor-pointer">
        <div class="w-10 h-10 rounded-full bg-kashy-bg flex items-center justify-center mx-auto mb-2.5">
          <svg width="20" height="20" fill="none" stroke="#C8966C" stroke-width="1.8" stroke-linecap="round" viewBox="0 0 24 24"><path d="M6 2h12v4l-3 16H9L6 6V2z"/><path d="M6 6h12M12 6v4"/></svg>
        </div>
        <p class="text-xs font-semibold text-kashy-black">Produk & Stok</p>
        <p class="text-[10px] text-kashy-muted mt-0.5">Tambah, edit, stok</p>
      </div>
      <div class="bg-white rounded-xl p-4 shadow-card text-center hover:shadow-card-md hover:-translate-y-0.5 transition-all duration-200 cursor-pointer">
        <div class="w-10 h-10 rounded-full bg-kashy-bg flex items-center justify-center mx-auto mb-2.5">
          <svg width="20" height="20" fill="none" stroke="#C8966C" stroke-width="1.8" stroke-linecap="round" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
        </div>
        <p class="text-xs font-semibold text-kashy-black">Laporan</p>
        <p class="text-[10px] text-kashy-muted mt-0.5">Penjualan, keuangan</p>
      </div>
    </div>


    <!-- ── Contact card ── -->
    <div class="anim anim-6 contact-card rounded-2xl px-6 py-8 text-center shadow-card-md">

      <!-- headset icon -->
      <div class="w-12 h-12 rounded-full bg-white/10 flex items-center justify-center mx-auto mb-5">
        <svg width="24" height="24" fill="none" stroke="white" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
          <path d="M3 18v-6a9 9 0 0 1 18 0v6"/>
          <path d="M21 19a2 2 0 0 1-2 2h-1a2 2 0 0 1-2-2v-3a2 2 0 0 1 2-2h3zM3 19a2 2 0 0 0 2 2h1a2 2 0 0 0 2-2v-3a2 2 0 0 0-2-2H3z"/>
        </svg>
      </div>

      <h2 class="text-white font-bold text-[18px] sm:text-xl mb-3 leading-snug">
        Butuh bantuan lebih lanjut?
      </h2>
      <p class="text-white/60 text-sm leading-relaxed mb-6 max-w-xs mx-auto">
        Admin kami tersedia pukul 09:00 – 18:00 WIB untuk membantu kendala teknis atau administratif Anda.
      </p>

      <button
        onclick="hubungiAdmin()"
        class="w-full bg-kashy-terra hover:bg-kashy-terra-l active:scale-95 text-white font-semibold text-sm py-3.5 rounded-2xl transition-all duration-200 flex items-center justify-center gap-2.5 shadow-lg shadow-kashy-terra/30"
      >
        <svg width="17" height="17" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
          <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.15 13a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 3.06 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 21 16.92z"/>
        </svg>
        Hubungi Admin
      </button>

    </div><!-- /contact card -->

  </main>


  <!-- ══════════════════════════════════════
       SCRIPT
  ══════════════════════════════════════ -->
  <script>
    /* ── Toggle FAQ ── */
    function toggleFaq(btn) {
      const item    = btn.closest('.faq-item');
      const answer  = item.querySelector('.faq-answer');
      const chevron = btn.querySelector('.faq-chevron');
      const isOpen  = answer.classList.contains('open');

      // close all others
      document.querySelectorAll('.faq-answer.open').forEach(a => {
        a.classList.remove('open');
        a.closest('.faq-item').querySelector('.faq-chevron').classList.remove('open');
        a.closest('.faq-item').querySelector('.faq-trigger').classList.remove('bg-[#F0E8DE]');
      });

      if (!isOpen) {
        answer.classList.add('open');
        chevron.classList.add('open');
        btn.classList.add('bg-[#F0E8DE]');
      }
    }

    /* ── Search filter ── */
    function filterFaq(query) {
      const items     = document.querySelectorAll('.faq-item');
      const clearBtn  = document.getElementById('clearBtn');
      const empty     = document.getElementById('emptyState');
      const label     = document.getElementById('sectionLabel');
      const q         = query.toLowerCase().trim();

      clearBtn.classList.toggle('hidden', q === '');
      label.textContent = q ? 'Hasil Pencarian' : 'Pertanyaan Populer';

      let found = 0;
      items.forEach(item => {
        const text = item.dataset.question || '';
        const match = text.includes(q) || q === '';
        item.style.display = match ? '' : 'none';
        if (match) found++;
      });

      empty.classList.toggle('hidden', found > 0);
    }

    function clearSearch() {
      const input = document.querySelector('.search-input');
      input.value = '';
      filterFaq('');
      input.focus();
    }

    /* ── Hubungi Admin ── */
    function hubungiAdmin() {
      alert('Menghubungi Admin...\nWaktu operasional: 09:00 – 18:00 WIB');
    }
  </script>
</body>
</html>