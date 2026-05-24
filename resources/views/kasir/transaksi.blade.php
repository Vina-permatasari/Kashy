<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
<title>Transaksi Kasir – Kashy</title>
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
  body { font-family: 'Poppins',sans-serif; background:#f8f8f8; }
  input::-webkit-outer-spin-button,
  input::-webkit-inner-spin-button { -webkit-appearance: none; margin: 0; }
  input[type=number] { -moz-appearance: textfield; }
  .modal-transition {
    transition: opacity 0.2s ease, visibility 0.2s ease;
  }
</style>
</head>

<body class="bg-[#f8f8f8] min-h-screen font-poppins">

<!-- TOPBAR with Back Button -->
<nav class="sticky top-0 z-20 bg-gray-900 px-4 py-3 flex items-center justify-between shadow-md">
  <button onclick="window.location.href='{{ route('dashboard-kasir') }}'" class="w-9 h-9 flex items-center justify-center rounded-lg hover:bg-white/10 transition">
    <svg width="25" height="25" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5">
      <path d="M19 12H5M12 19l-7-7 7-7"/>
    </svg>
  </button>
  <span class="font-poppins text-xl font-bold text-white tracking-widest">Kashy</span>
  <div class="w-9"></div>
</nav>

<main class="max-w-2xl mx-auto w-full px-4 pt-6 pb-28">
  
<!-- MEMBER SECTION -->
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 mb-5">

  <!-- Header -->
  <div class="flex items-center justify-between mb-4">
    <h2 class="font-bold text-lg text-gray-900">Member</h2>
  </div>

  <!-- Search -->
  <div class="flex items-center gap-2 mb-4">
    <div class="flex-1 relative">
      <svg class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"
        width="18" height="18" viewBox="0 0 24 24" fill="none"
        stroke="currentColor" stroke-width="2">

        <circle cx="11" cy="11" r="8"/>
        <path d="m21 21-4.35-4.35"/>
      </svg>

      <input 
        type="text"
        id="searchMemberInput"
        class="w-full pl-11 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm"
        placeholder="Cari nama / no HP member..."
      >
    </div>

    <button id="searchButton"
      class="w-11 h-11 bg-terra hover:bg-terra-l rounded-xl flex items-center justify-center">
      
      <svg width="20" height="20" viewBox="0 0 24 24"
        fill="none" stroke="white" stroke-width="2.5">

        <circle cx="11" cy="11" r="8"/>
        <path d="m21 21-4.35-4.35"/>
      </svg>
    </button>
  </div>

  <!-- HASIL MEMBER -->
  <div id="searchResultsContainer"></div>

</div>

  <!-- KERANJANG SECTION -->
  <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
    <div class="flex items-center justify-between mb-4">
      <h2 class="font-bold text-xl text-gray-900">Keranjang</h2>
      <span class="text-xs font-medium text-gray-500" id="orderNumber">Order #8821</span>
    </div>

    <div class="flex items-center justify-between mb-5 pb-4 border-b border-gray-100">
      <div class="flex items-center gap-2">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#666" stroke-width="2">
          <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
          <circle cx="12" cy="7" r="4"/>
        </svg>
        <span class="text-sm text-gray-700" id="customerName">Pelanggan Umum</span>
      </div>
      <button onclick="editCustomer()" class="p-1 hover:bg-gray-50 rounded-lg transition">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#666" stroke-width="2">
          <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
          <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
        </svg>
      </button>
    </div>

    <div class="space-y-4 mb-5" id="cartItems">
      <div class="text-center text-gray-400 py-4">Belum ada produk, tambah produk dulu yuk!</div>
    </div>

    <button onclick="openAddProductModal()" class="w-full py-3 mb-5 border-2 border-dashed border-terra/40 rounded-xl flex items-center justify-center gap-2 text-sm font-semibold text-terra bg-terra/5 hover:bg-terra/10 transition">
      <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <line x1="12" y1="5" x2="12" y2="19"/>
        <line x1="5" y1="12" x2="19" y2="12"/>
      </svg>
      Tambah Produk
    </button>

    <button onclick="openDiscountModal()" class="w-full py-3 mb-5 border-2 border-dashed border-gray-300 rounded-xl flex items-center justify-center gap-2 text-sm font-medium text-gray-600 hover:border-gray-500 hover:bg-gray-100/50 transition">
      <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/>
        <line x1="7" y1="7" x2="7.01" y2="7"/>
      </svg>
      Tambah Diskon
    </button>

    <div class="space-y-3 mb-5">
      <div class="flex items-center justify-between text-sm">
        <span class="text-gray-600">Subtotal</span>
        <span class="font-bold text-gray-900" id="subtotal">Rp 0</span>
      </div>

      <!-- BARIS DISKON (akan muncul jika diskon > 0) -->
      <div id="discountRow" class="flex items-center justify-between text-sm hidden">
        <span class="text-gray-600">Diskon <span id="discountPercentLabel" class="text-xs text-green"></span></span>
        <span class="font-medium text-green-500" id="discountAmount">Rp 0</span>
      </div>

      <div class="flex items-center justify-between text-lg pt-3 border-t border-gray-100">
        <span class="font-bold text-gray-900">Total</span>
        <span class="font-bold text-gray-900" id="total">Rp 0</span>
      </div>
    </div>

    <button onclick="window.location.href='{{ route('kasir.pembayaran') }}'" class="w-full bg-black hover:bg-gray-900 text-white font-bold py-4 rounded-xl flex items-center justify-center gap-2 transition shadow-lg">
      Lanjut ke Pembayaran
      <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5">
        <line x1="5" y1="12" x2="19" y2="12"/>
        <polyline points="12 5 19 12 12 19"/>
      </svg>
    </button>
  </div>
</main>

<!-- MODAL TAMBAH MEMBER -->
<div id="addMemberModal" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 modal-transition opacity-0 invisible transition-all">
  <div class="bg-white w-[90%] max-w-sm rounded-2xl p-6 shadow-2xl">
    <div class="flex justify-between items-center mb-4">
      <h3 class="font-bold text-xl text-gray-900">Tambah Member Baru</h3>
      <button onclick="closeAddMemberModal()" class="text-gray-400 hover:text-gray-600">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
        </svg>
      </button>
    </div>
    <div class="space-y-4">
      <div>
        <label class="block text-xs font-semibold text-gray-700 mb-1">Nama Lengkap</label>
        <input type="text" id="modalMemberName" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm" placeholder="Contoh: Ani Wijaya">
      </div>
      <div>
        <label class="block text-xs font-semibold text-gray-700 mb-1">Nomor HP</label>
        <input type="tel" id="modalMemberPhone" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm" placeholder="08123456789">
      </div>
      <button onclick="saveNewMemberFromModal()" class="w-full bg-terra hover:bg-terra-l text-white font-bold py-3 rounded-xl transition mt-2">
        Simpan Member
      </button>
    </div>
  </div>
</div>

<!-- MODAL TAMBAH PRODUK -->
<div id="addProductModal" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 modal-transition opacity-0 invisible transition-all p-3">
  <div class="bg-white w-full max-w-[95%] rounded-xl shadow-xl overflow-hidden">
    <div class="flex justify-between items-center px-4 py-3 border-b border-gray-100">
      <h3 class="font-semibold text-base text-gray-900">Tambah Produk</h3>
      <button onclick="closeAddProductModal()" class="text-gray-400 hover:text-gray-600 p-1">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
        </svg>
      </button>
    </div>
    <div class="p-3">
      <div class="relative mb-3">
        <svg class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <circle cx="11" cy="11" r="8"/>
          <path d="m21 21-4.35-4.35"/>
        </svg>
        <input type="text" id="searchProductInput" class="w-full pl-8 pr-3 py-2 border border-gray-200 rounded-lg text-sm" placeholder="Cari produk...">
      </div>
      <div id="productListContainer" class="space-y-2 max-h-[50vh] overflow-y-auto"></div>
      <div class="text-center text-[11px] text-gray-400 mt-3 pt-2 border-t border-gray-100">
        Produk tersedia untuk Kasir, Karyawan & Pelanggan
      </div>
    </div>
  </div>
</div>

<!-- MODAL DISKON -->
<div id="discountModal" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 modal-transition opacity-0 invisible transition-all p-3">
  <div class="bg-white w-full max-w-sm rounded-2xl shadow-xl overflow-hidden">
    <div class="flex justify-between items-center px-5 py-4 border-b border-gray-100">
      <h3 class="font-bold text-lg text-gray-900">Tambah Diskon</h3>
      <button onclick="closeDiscountModal()" class="text-gray-400 hover:text-gray-600 p-1">
        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
        </svg>
      </button>
    </div>
    <div class="p-5">
      <label class="block text-xs font-semibold text-gray-700 mb-2">Persentase Diskon (%)</label>
      <input type="number" id="discountPercent" class="w-full px-3 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-terra/30" placeholder="Contoh: 10" min="0" max="100" step="1">
      <div class="flex gap-3 mt-5">
        <button onclick="closeDiscountModal()" class="flex-1 border border-gray-300 hover:bg-gray-50 text-gray-700 font-semibold py-2.5 rounded-lg transition">Batal</button>
        <button onclick="applyDiscount()" class="flex-1 bg-terra hover:bg-terra-l text-white font-semibold py-2.5 rounded-lg transition">Terapkan</button>
      </div>
    </div>
  </div>
</div>

<!-- TOAST -->
<div id="toast" class="fixed bottom-8 left-1/2 -translate-x-1/2 z-50 bg-gray-900 text-white text-sm font-medium px-5 py-3 rounded-full shadow-xl flex items-center gap-2 pointer-events-none transition-all duration-300 opacity-0 translate-y-4">
  <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5"><path d="M20 6 9 17l-5-5"/></svg>
  <span id="toastMsg">—</span>
</div>

<script>
  // ======================= DATABASE PRODUK =======================
  const productsDatabase = [
    { id: 1, name: "Silk Scarf", price: 1250000, img: "data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='40' height='40'%3E%3Crect fill='%23d4a574' width='40' height='40'/%3E%3Cpath d='M10 10 Q20 5 30 10 L30 30 Q20 35 10 30 Z' fill='%23f4d03f' opacity='0.3'/%3E%3C/svg%3E" },
    { id: 2, name: "Leather Bag", price: 4750000, img: "data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='40' height='40'%3E%3Crect fill='%238B4513' width='40' height='40'/%3E%3Crect x='10' y='15' width='20' height='15' rx='2' fill='%23A0522D'/%3E%3C/svg%3E" },
    { id: 3, name: "Tote Bag", price: 350000, img: "data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='40' height='40'%3E%3Crect fill='%236B8E23' width='40' height='40'/%3E%3Cpath d='M10 15 L30 15 L28 28 L12 28 Z' fill='%23808020'/%3E%3C/svg%3E" },
    { id: 4, name: "Wallet", price: 250000, img: "data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='40' height='40'%3E%3Crect fill='%23B8860B' width='40' height='40'/%3E%3Crect x='12' y='12' width='16' height='16' rx='2' fill='%23D2B48C'/%3E%3C/svg%3E" },
    { id: 5, name: "Sneakers", price: 890000, img: "data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='40' height='40'%3E%3Crect fill='%23555' width='40' height='40'/%3E%3Cpath d='M8 20 L32 20 L30 28 L10 28 Z' fill='%23777'/%3E%3C/svg%3E" },
    { id: 6, name: "Watch", price: 1250000, img: "data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='40' height='40'%3E%3Ccircle cx='20' cy='20' r='14' fill='%23CD7F32'/%3E%3Ccircle cx='20' cy='20' r='10' fill='%23FFF8DC'/%3E%3C/svg%3E" }
  ];

  let members = [
    { id: 1, name: "Budi Santoso", phone: "08123456789" },
    { id: 2, name: "Siti Aisyah", phone: "08234567890" },
    { id: 3, name: "Agus Salim", phone: "08345678901" },
    { id: 4, name: "Dewi Lestari", phone: "08567891234" }
  ];
  let nextMemberId = 5;
  let currentSelectedMember = null;
  let cart = [];
  let currentDiscountPercent = 0;

  function formatRupiah(angka) {
    return 'Rp ' + angka.toLocaleString('id-ID');
  }
  function parseRupiah(str) {
    return parseInt(str.replace(/[^\d]/g, '')) || 0;
  }
  function showToast(msg, isError = false) {
    const toast = document.getElementById('toast');
    const toastMsg = document.getElementById('toastMsg');
    toastMsg.textContent = msg;
    toast.style.backgroundColor = isError ? '#dc2626' : '#1f2937';
    toast.style.opacity = '1';
    toast.style.transform = 'translateX(-50%) translateY(0)';
    setTimeout(() => {
      toast.style.opacity = '0';
      toast.style.transform = 'translateX(-50%) translateY(16px)';
    }, 2600);
  }
  function escapeHtml(str) {
    if (!str) return '';
    return str.replace(/[&<>]/g, m => m === '&' ? '&amp;' : m === '<' ? '&lt;' : '&gt;');
  }

  // ======================= MEMBER CARD DEFAULT (TAMBAH MEMBER) =======================
  function showDefaultMemberCard() {
    const container = document.getElementById('searchResultsContainer');
    container.innerHTML = `
      <div class="text-center py-3">
        <p class="text-sm text-gray-500 mb-3">Tambah member baru untuk mendapatkan poin & promo</p>
        <button onclick="openAddMemberModal()" class="inline-flex items-center gap-2 px-5 py-2.5 bg-terra hover:bg-terra-l text-white font-semibold rounded-xl transition shadow-sm text-sm">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
          Tambah Member Baru
        </button>
      </div>
    `;
  }

  // ======================= MEMBER SEARCH =======================
  function performSearch() {
    const query = document.getElementById('searchMemberInput').value.trim();
    const resultsContainer = document.getElementById('searchResultsContainer');
    
    // Jika query kosong, tampilkan card tambah member
    if (query === "") {
      showDefaultMemberCard();
      return;
    }
    
    const lowerQuery = query.toLowerCase();
    const filtered = members.filter(m => m.name.toLowerCase().includes(lowerQuery) || m.phone.includes(query));
    
    if (filtered.length === 0) {
      resultsContainer.innerHTML = `
        <div class="text-center py-3">
          <p class="text-sm text-gray-500 mb-3">Tidak ditemukan member dengan kata "${escapeHtml(query)}"</p>
          <button onclick="openAddMemberModal()" class="inline-flex items-center gap-2 px-5 py-2.5 bg-terra hover:bg-terra-l text-white font-semibold rounded-xl transition shadow-sm text-sm">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Tambah Member Baru
          </button>
        </div>
      `;
      return;
    }
    
    let html = `<div class="space-y-3"><p class="text-xs font-medium text-gray-500 mb-1">📋 ${filtered.length} member ditemukan:</p>`;
    filtered.forEach(member => {
      html += `
        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-xl border border-gray-100">
          <div class="flex-1">
            <p class="font-semibold text-gray-900 text-sm">${escapeHtml(member.name)}</p>
            <p class="text-xs text-gray-500">${escapeHtml(member.phone)}</p>
          </div>
          <button onclick="selectMember(${member.id})" class="px-4 py-2 bg-terra/10 hover:bg-terra/20 text-terra font-semibold text-sm rounded-lg">Pilih</button>
        </div>
      `;
    });
    html += `</div>`;
    resultsContainer.innerHTML = html;
  }

  function selectMember(memberId) {
    const member = members.find(m => m.id === memberId);
    if (member) {
      currentSelectedMember = member;
      document.getElementById('customerName').textContent = member.name;
      showToast(`✅ Member ${member.name} dipilih`);
      // Reset search input dan tampilkan default card
      document.getElementById('searchMemberInput').value = '';
      showDefaultMemberCard();
    }
  }

  function openAddMemberModal() {
    const modal = document.getElementById('addMemberModal');
    document.getElementById('modalMemberName').value = '';
    document.getElementById('modalMemberPhone').value = '';
    modal.classList.remove('invisible', 'opacity-0');
    modal.classList.add('opacity-100', 'visible');
  }
  function closeAddMemberModal() {
    const modal = document.getElementById('addMemberModal');
    modal.classList.remove('opacity-100', 'visible');
    modal.classList.add('invisible', 'opacity-0');
  }
  function saveNewMemberFromModal() {
    const name = document.getElementById('modalMemberName').value.trim();
    const phone = document.getElementById('modalMemberPhone').value.trim();
    if (!name || !phone) {
      showToast('⚠️ Nama dan nomor HP wajib diisi!', true);
      return;
    }
    if (members.find(m => m.phone === phone)) {
      showToast(`Nomor ${phone} sudah terdaftar`, true);
      return;
    }
    const newMember = { id: nextMemberId++, name, phone };
    members.push(newMember);
    currentSelectedMember = newMember;
    document.getElementById('customerName').textContent = newMember.name;
    showToast(`🎉 Member ${newMember.name} berhasil ditambahkan & dipilih`);
    closeAddMemberModal();
    // Reset search input dan tampilkan default card
    document.getElementById('searchMemberInput').value = '';
    showDefaultMemberCard();
  }

  function editCustomer() {
    const newName = prompt('Edit nama pelanggan:', document.getElementById('customerName').textContent);
    if (newName?.trim()) {
      document.getElementById('customerName').textContent = newName.trim();
      currentSelectedMember = null;
      showToast('✅ Nama pelanggan diperbarui');
    }
  }

  // ======================= KERANJANG =======================
  function renderCart() {
    const container = document.getElementById('cartItems');
    if (!cart.length) {
      container.innerHTML = `<div class="text-center text-gray-400 py-4">Belum ada produk, tambah produk dulu yuk!</div>`;
      calculateTotal();
      return;
    }
    let html = '';
    cart.forEach((item, index) => {
      html += `
        <div class="flex items-start gap-3">
          <button onclick="removeCartItem(${index})" class="mt-2 text-gray-400 hover:text-red-500 transition" title="Hapus produk">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M3 6h18M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
              <line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/>
            </svg>
          </button>
          <img src="${item.img}" alt="${item.name}" class="w-16 h-16 rounded-xl object-cover border border-gray-100">
          <div class="flex-1">
            <h4 class="font-medium text-sm text-gray-900 mb-2">${escapeHtml(item.name)}</h4>
            <div class="flex items-center justify-between">
              <div class="flex items-center gap-3">
                <button onclick="changeQty(${index}, -1)" class="w-7 h-7 flex items-center justify-center rounded-lg bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold transition">-</button>
                <span class="w-8 text-center font-semibold text-sm">${item.qty}</span>
                <button onclick="changeQty(${index}, 1)" class="w-7 h-7 flex items-center justify-center rounded-lg bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold transition">+</button>
              </div>
              <span class="font-bold text-sm text-gray-900">${formatRupiah(item.price * item.qty)}</span>
            </div>
          </div>
        </div>
      `;
    });
    container.innerHTML = html;
    calculateTotal();
  }
  function changeQty(index, delta) {
    if (cart[index]) {
      let newQty = cart[index].qty + delta;
      if (newQty < 1) newQty = 1;
      cart[index].qty = newQty;
      renderCart();
    }
  }
  function removeCartItem(index) {
    cart.splice(index, 1);
    renderCart();
    showToast('Item dihapus dari keranjang');
  }
  function calculateTotal() {
    let subtotal = cart.reduce((sum, item) => sum + (item.price * item.qty), 0);
    let discountAmount = subtotal * (currentDiscountPercent / 100);
    let afterDiscount = subtotal - discountAmount;
    const total = afterDiscount * 1.11; // pajak 11%
    
    document.getElementById('subtotal').textContent = formatRupiah(subtotal);
    document.getElementById('total').textContent = formatRupiah(Math.round(total));
    
    const discountRow = document.getElementById('discountRow');
    const discountPercentLabel = document.getElementById('discountPercentLabel');
    const discountAmountSpan = document.getElementById('discountAmount');
    
    if (currentDiscountPercent > 0) {
      discountRow.classList.remove('hidden');
      discountPercentLabel.textContent = `(${currentDiscountPercent}%)`;
      discountAmountSpan.textContent = formatRupiah(Math.round(discountAmount));
    } else {
      discountRow.classList.add('hidden');
    }
  }
  function addProductToCart(product) {
    const existing = cart.find(item => item.name === product.name);
    if (existing) existing.qty += 1;
    else cart.push({ ...product, qty: 1 });
    renderCart();
    showToast(`✅ ${product.name} ditambahkan ke keranjang`);
  }

  // ======================= PRODUK SEARCH =======================
  function renderProductList(searchTerm = '') {
    const container = document.getElementById('productListContainer');
    const lowerTerm = searchTerm.toLowerCase().trim();
    let filtered = productsDatabase;
    if (lowerTerm) filtered = productsDatabase.filter(p => p.name.toLowerCase().includes(lowerTerm));
    if (!filtered.length) {
      container.innerHTML = `<div class="text-center text-gray-400 py-4 text-sm">Tidak ada produk yang cocok</div>`;
      return;
    }
    let html = '';
    filtered.forEach(prod => {
      html += `
        <div class="product-item flex justify-between items-center p-3 border border-gray-100 rounded-xl hover:bg-terra/5">
          <div class="flex items-center gap-3">
            <img src="${prod.img}" class="w-10 h-10 rounded-lg object-cover">
            <div>
              <p class="font-semibold text-gray-900">${escapeHtml(prod.name)}</p>
              <p class="text-xs text-gray-500">${formatRupiah(prod.price)}</p>
            </div>
          </div>
          <button onclick="addProductFromModal(${prod.id})" class="px-3 py-1 bg-terra text-white text-sm rounded-lg">Tambah</button>
        </div>
      `;
    });
    container.innerHTML = html;
  }
  function addProductFromModal(productId) {
    const product = productsDatabase.find(p => p.id === productId);
    if (product) {
      addProductToCart(product);
      closeAddProductModal();
    }
  }
  let searchTimeout;
  function setupProductSearch() {
    const input = document.getElementById('searchProductInput');
    if (input) {
      input.addEventListener('input', (e) => {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => renderProductList(e.target.value), 300);
      });
    }
  }
  function openAddProductModal() {
    const modal = document.getElementById('addProductModal');
    const searchInput = document.getElementById('searchProductInput');
    if (searchInput) searchInput.value = '';
    renderProductList('');
    modal.classList.remove('invisible', 'opacity-0');
    modal.classList.add('opacity-100', 'visible');
  }
  function closeAddProductModal() {
    const modal = document.getElementById('addProductModal');
    modal.classList.remove('opacity-100', 'visible');
    modal.classList.add('invisible', 'opacity-0');
  }

  // ======================= DISKON MODAL =======================
  function openDiscountModal() {
    const modal = document.getElementById('discountModal');
    document.getElementById('discountPercent').value = currentDiscountPercent;
    modal.classList.remove('invisible', 'opacity-0');
    modal.classList.add('opacity-100', 'visible');
  }
  function closeDiscountModal() {
    const modal = document.getElementById('discountModal');
    modal.classList.remove('opacity-100', 'visible');
    modal.classList.add('invisible', 'opacity-0');
  }
  function applyDiscount() {
    let percent = parseFloat(document.getElementById('discountPercent').value);
    if (isNaN(percent)) percent = 0;
    percent = Math.min(100, Math.max(0, percent));
    currentDiscountPercent = percent;
    calculateTotal();
    showToast(`✅ Diskon ${percent}% diterapkan`);
    closeDiscountModal();
  }

  function goToPayment() {
    if (!cart.length) {
      showToast('⚠️ Keranjang masih kosong!', true);
      return;
    }
    const customer = document.getElementById('customerName').textContent;
    showToast(`🚀 Menuju pembayaran untuk ${customer}...`);
  }
  function generateOrderNumber() {
    const num = Math.floor(Math.random() * 9000) + 1000;
    document.getElementById('orderNumber').textContent = 'Order #' + num;
  }

  function init() {
    generateOrderNumber();
    document.getElementById('customerName').textContent = "Pelanggan Umum";
    cart = [];
    renderCart();
    // Tampilkan card tambah member dari awal
    showDefaultMemberCard();
    
    document.getElementById('searchButton').addEventListener('click', performSearch);
    document.getElementById('searchMemberInput').addEventListener('keypress', (e) => {
      if (e.key === 'Enter') performSearch();
    });
    document.getElementById('searchMemberInput').addEventListener('input', (e) => {
      // Jika input kosong, tampilkan default card
      if (e.target.value.trim() === '') {
        showDefaultMemberCard();
      } else {
        performSearch();
      }
    });
    setupProductSearch();
    document.getElementById('addProductModal').addEventListener('click', (e) => {
      if (e.target === e.currentTarget) closeAddProductModal();
    });
    document.getElementById('addMemberModal').addEventListener('click', (e) => {
      if (e.target === e.currentTarget) closeAddMemberModal();
    });
    document.getElementById('discountModal').addEventListener('click', (e) => {
      if (e.target === e.currentTarget) closeDiscountModal();
    });
  }
  init();
</script>
</body>
</html>