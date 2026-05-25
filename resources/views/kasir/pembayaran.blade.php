<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover"/>
  <title>Kashy – Pembayaran</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet"/>
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          fontFamily: { poppins: ['Poppins','sans-serif'] },
          colors: {
            terra:      '#C8966C',
            'terra-l':  '#E5B18A',
            'terra-ll': '#F0D7C7',
            'terra-xs': '#FAF2EC',
            muted:      '#9C8B7E',
            border:     '#EAE0D6',
            bg:         '#F5F0EB',
          },
          boxShadow: {
            card: '0 2px 18px 0 rgba(60,40,10,.07)',
            btn:  '0 4px 12px 0 rgba(200,150,108,.30)',
          }
        }
      }
    }
  </script>
  <style>
    * { font-family:'Poppins',sans-serif; }
    body { background:#f8f8f8; }

    @keyframes fadeUp {
      from { opacity:0; transform:translateY(16px); }
      to   { opacity:1; transform:translateY(0); }
    }
    .fade-up           { animation: fadeUp .4s ease both; }
    .delay-1           { animation-delay:.07s; }
    .delay-2           { animation-delay:.14s; }

    .pay-card {
      transition: all 0.2s ease;
    }
    .pay-card:active { transform: scale(0.97); }
    .pay-card.selected {
      background: #FAF2EC;
      border-color: #C8966C !important;
      border-width: 2px;
    }
    .pay-card.selected .pay-label {
      color: #C8966C;
      font-weight: 600;
    }
    .pay-card.selected .pay-icon {
      color: #C8966C;
    }

    ::-webkit-scrollbar { width:5px; }
    ::-webkit-scrollbar-track { background:#EAE0D6; }
    ::-webkit-scrollbar-thumb { background:#C8966C; border-radius:10px; }

    .modal-overlay {
      transition: opacity 0.2s ease, visibility 0.2s ease;
    }
  </style>
</head>
<body class="min-h-screen bg-[#f8f8f8] font-poppins">

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

<!-- MAIN CONTENT -->
<main class="max-w-2xl mx-auto w-full px-4 pt-6 pb-28">
  <div class="flex flex-col gap-5">

    <!-- RINGKASAN PESANAN -->
    <div class="fade-up bg-white rounded-2xl p-5 shadow-card border border-border">
      <h2 class="font-bold text-xl text-gray-900 mb-4">Ringkasan Pesanan</h2>

      @foreach ($transaction['cart'] as $item)
      <div class="flex justify-between items-start mb-3">
        <div>
          <p class="font-semibold text-gray-900 text-sm">{{ $item['name'] }}</p>
          <p class="text-xs text-muted mt-0.5">Qty: {{ $item['qty'] }}</p>
        </div>
        <span class="text-sm font-medium text-gray-900 whitespace-nowrap ml-4">
          Rp {{ number_format($item['price'] * $item['qty'], 0, ',', '.') }}
        </span>
      </div>
      @endforeach

      <div class="h-px bg-border my-4"></div>

      <div class="flex justify-between text-sm mb-2">
        <span class="text-muted">Subtotal</span>
        <span class="text-gray-900 font-medium">
          Rp {{ number_format($transaction['subtotal'], 0, ',', '.') }}
        </span>
      </div>

      @php
        $discountAmount = $transaction['subtotal'] * (($transaction['discount_percent'] ?? 0) / 100);
      @endphp
      <div class="flex justify-between text-sm mb-3">
        <span class="text-muted">Diskon {{ ($transaction['discount_percent'] ?? 0) > 0 ? '(' . $transaction['discount_percent'] . '%)' : '' }}</span>
        <span class="text-green-500 font-medium">
          -Rp {{ number_format($discountAmount, 0, ',', '.') }}
        </span>
      </div>

      <div class="flex justify-between items-center pt-1 mt-1 border-t border-border">
        <span class="text-xs font-semibold tracking-wider text-gray-900 uppercase">Total Akhir</span>
        <span class="text-2xl font-bold text-terra" id="totalTagihan">
          Rp {{ number_format($transaction['total'], 0, ',', '.') }}
        </span>
      </div>
    </div>

    <!-- PILIH METODE PEMBAYARAN (TAMPILAN LAMA) -->
    <div class="fade-up delay-1 bg-white rounded-2xl p-5 shadow-card border border-border">
      <h2 class="font-semibold text-lg text-gray-900 mb-4">Pilih Metode Pembayaran</h2>

      <div class="flex flex-col gap-3" id="payment-methods">
        <!-- Tunai -->
        <button onclick="selectMethod(this)" data-method="tunai"
          class="pay-card w-full flex flex-col items-center justify-center gap-1.5 py-4 rounded-xl border border-border bg-white hover:bg-terra-xs transition">
          <svg class="pay-icon w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8">
            <rect x="2" y="6" width="20" height="12" rx="2"/>
            <circle cx="12" cy="12" r="3"/>
            <path d="M6 12h.01M18 12h.01"/>
          </svg>
          <span class="pay-label text-sm font-medium text-gray-700">Tunai</span>
        </button>

        <!-- QRIS -->
        <button onclick="selectMethod(this)" data-method="qris"
          class="pay-card w-full flex flex-col items-center justify-center gap-1.5 py-4 rounded-xl border border-border bg-white hover:bg-terra-xs transition">
          <svg class="pay-icon w-6 h-6 text-gray-700" viewBox="0 0 24 24" fill="currentColor">
            <path d="M3 3h7v7H3V3zm1 1v5h5V4H4zm1 1h3v3H5V5zM14 3h7v7h-7V3zm1 1v5h5V4h-5zm1 1h3v3h-3V5zM3 14h7v7H3v-7zm1 1v5h5v-5H4zm1 1h3v3H5v-3zM14 14h2v2h-2v-2zm3 0h2v2h-2v-2zm-3 3h2v2h-2v-2zm3 0h2v2h-2v-2z"/>
          </svg>
          <span class="pay-label text-sm font-medium text-gray-700">QRIS</span>
        </button>

        <!-- Debit -->
        <button onclick="selectMethod(this)" data-method="debit"
          class="pay-card w-full flex flex-col items-center justify-center gap-1.5 py-4 rounded-xl border border-border bg-white hover:bg-terra-xs transition">
          <svg class="pay-icon w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8">
            <rect x="2" y="5" width="20" height="14" rx="2"/>
            <line x1="2" y1="10" x2="22" y2="10"/>
          </svg>
          <span class="pay-label text-sm font-medium text-gray-700">Debit</span>
        </button>
      </div>

      <!-- Input khusus untuk TUNAI -->
      <div id="cashPaymentSection" class="hidden mt-4 p-4 bg-gray-50 rounded-xl">
        <label class="text-sm font-semibold text-gray-700 block mb-2">Jumlah Uang Dibayar</label>
        <input type="number" id="jumlahBayar" class="w-full border-2 border-border rounded-xl p-3 text-lg font-semibold" placeholder="Masukkan nominal" oninput="hitungKembalian()">
        <div id="kembalianInfo" class="mt-3 text-sm"></div>
      </div>

      <!-- Informasi untuk QRIS & Debit -->
      <div id="qrisInfo" class="hidden mt-4 p-4 bg-blue-50 rounded-xl">
        <p class="text-sm text-blue-800">🔹 Total yang harus dibayar: <strong id="qrisTotal"></strong></p>
        <p class="text-xs text-blue-600 mt-1">Scan QRIS menggunakan aplikasi payment (Dana, OVO, GoPay, Bank Mobile)</p>
      </div>

      <div id="debitInfo" class="hidden mt-4 p-4 bg-purple-50 rounded-xl">
        <p class="text-sm text-purple-800">💳 Total yang harus dibayar: <strong id="debitTotal"></strong></p>
        <p class="text-xs text-purple-600 mt-1">Lakukan pembayaran dengan kartu debit di mesin EDC</p>
      </div>

      <!-- Submit Button -->
      <button id="submit-btn"
        class="mt-5 w-full bg-terra hover:bg-terra-l text-white font-bold py-4 rounded-xl flex items-center justify-center gap-2 transition shadow-md">
        Submit Pembayaran
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5">
          <line x1="5" y1="12" x2="19" y2="12"/>
          <polyline points="12 5 19 12 12 19"/>
        </svg>
      </button>
    </div>
  </div>
</main>

<!-- MODAL WARNING (belum pilih metode) -->
<div id="warningModal" class="fixed inset-0 z-50 flex items-center justify-center px-4 modal-overlay opacity-0 invisible transition-all">
  <div class="absolute inset-0 bg-black/50" onclick="closeWarningModal()"></div>
  <div class="bg-white w-full max-w-sm rounded-2xl shadow-xl overflow-hidden relative z-10 text-center p-6">
    <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-red-100 flex items-center justify-center">
      <svg class="w-8 h-8 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <circle cx="12" cy="12" r="10"/>
        <line x1="12" y1="8" x2="12" y2="12"/>
        <line x1="12" y1="16" x2="12.01" y2="16"/>
      </svg>
    </div>
    <h3 class="text-lg font-bold text-gray-900 mb-2">Belum Pilih Metode</h3>
    <p class="text-sm text-gray-600 mb-5">Silakan pilih metode pembayaran terlebih dahulu.</p>
    <button onclick="closeWarningModal()" class="w-full bg-terra text-white font-semibold py-2.5 rounded-lg">Tutup</button>
  </div>
</div>

<!-- MODAL KONFIRMASI -->
<div id="confirmModal" class="fixed inset-0 z-50 flex items-center justify-center px-4 modal-overlay opacity-0 invisible transition-all">
  <div class="absolute inset-0 bg-black/50" onclick="closeConfirmModal()"></div>
  <div class="bg-white w-full max-w-sm rounded-2xl shadow-xl overflow-hidden relative z-10">
    <div class="p-6">
      <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-green-100 flex items-center justify-center">
        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
          <polyline points="22 4 12 14.01 9 11.01"/>
        </svg>
      </div>
      <h3 class="text-lg font-bold text-gray-900 text-center mb-2">Konfirmasi Pembayaran</h3>
      <div class="bg-gray-50 rounded-xl p-3 my-3 text-sm">
        <div class="flex justify-between mb-2">
          <span class="text-muted">Metode</span>
          <span class="font-semibold text-gray-900" id="confirmMethod">-</span>
        </div>
        <div class="flex justify-between mb-2">
          <span class="text-muted">Total Tagihan</span>
          <span class="font-bold text-terra" id="confirmTotal">-</span>
        </div>
        <div class="flex justify-between" id="confirmKembalianRow" style="display:none;">
          <span class="text-muted">Kembalian</span>
          <span class="font-bold text-green-600" id="confirmKembalian">-</span>
        </div>
      </div>
      <p class="text-xs text-gray-500 text-center mb-4">Pastikan data sudah benar. Pembayaran akan diproses.</p>
      <div class="flex gap-3">
        <button onclick="closeConfirmModal()" class="flex-1 border border-gray-300 text-gray-700 font-medium py-2.5 rounded-lg hover:bg-gray-50 transition">Batal</button>
        <button onclick="processPayment()" class="flex-1 bg-green-600 hover:bg-green-700 text-white font-semibold py-2.5 rounded-lg transition">Lanjutkan</button>
      </div>
    </div>
  </div>
</div>

<!-- MODAL SUKSES -->
<div id="successModal" class="fixed inset-0 z-50 flex items-center justify-center px-4 modal-overlay opacity-0 invisible transition-all">
  <div class="absolute inset-0 bg-black/50" onclick="closeSuccessModal()"></div>
  <div class="bg-white w-full max-w-sm rounded-2xl shadow-xl overflow-hidden relative z-10 text-center p-6">
    <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-green-100 flex items-center justify-center">
      <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
        <polyline points="22 4 12 14.01 9 11.01"/>
      </svg>
    </div>
    <h3 class="text-lg font-bold text-gray-900 mb-2">Pembayaran Berhasil!</h3>
    <p class="text-sm text-gray-600 mb-5">Terima kasih, transaksi Anda telah diproses.</p>
    <button onclick="closeSuccessModalAndReset()" class="w-full bg-terra hover:bg-terra-l text-white font-semibold py-2.5 rounded-lg transition">Selesai</button>
  </div>
</div>

<script>
  let selectedPaymentMethod = null;
  let bayarNominal = 0;
  let kembalianNominal = 0;
  const totalTagihan = {{ $transaction['total'] }};

  function goBack() { window.history.back(); }

  function selectMethod(btn) {
    document.querySelectorAll('.pay-card').forEach(card => {
      card.classList.remove('selected');
      const label = card.querySelector('.pay-label');
      const icon = card.querySelector('.pay-icon');
      if (label) {
        label.classList.remove('text-terra', 'font-semibold');
        label.classList.add('text-gray-700', 'font-medium');
      }
      if (icon) {
        icon.classList.remove('text-terra');
        icon.classList.add('text-gray-700');
      }
    });
    btn.classList.add('selected');
    const label = btn.querySelector('.pay-label');
    const icon = btn.querySelector('.pay-icon');
    if (label) {
      label.classList.remove('text-gray-700', 'font-medium');
      label.classList.add('text-terra', 'font-semibold');
    }
    if (icon) {
      icon.classList.remove('text-gray-700');
      icon.classList.add('text-terra');
    }
    selectedPaymentMethod = btn.getAttribute('data-method');
    
    // Sembunyikan semua panel tambahan
    document.getElementById('cashPaymentSection').classList.add('hidden');
    document.getElementById('qrisInfo').classList.add('hidden');
    document.getElementById('debitInfo').classList.add('hidden');
    
    // Tampilkan panel sesuai metode
    if (selectedPaymentMethod === 'tunai') {
      document.getElementById('cashPaymentSection').classList.remove('hidden');
    } else if (selectedPaymentMethod === 'qris') {
      document.getElementById('qrisInfo').classList.remove('hidden');
      document.getElementById('qrisTotal').innerText = 'Rp ' + totalTagihan.toLocaleString('id-ID');
    } else if (selectedPaymentMethod === 'debit') {
      document.getElementById('debitInfo').classList.remove('hidden');
      document.getElementById('debitTotal').innerText = 'Rp ' + totalTagihan.toLocaleString('id-ID');
    }
  }

  function hitungKembalian() {
    const bayar = parseInt(document.getElementById('jumlahBayar')?.value) || 0;
    const kembalian = bayar - totalTagihan;
    const infoDiv = document.getElementById('kembalianInfo');
    
    if (bayar === 0) {
      infoDiv.innerHTML = '';
    } else if (bayar < totalTagihan) {
      infoDiv.innerHTML = `<p class="text-red-600 font-semibold">⚠️ Kurang: Rp ${(totalTagihan - bayar).toLocaleString('id-ID')}</p>`;
    } else {
      infoDiv.innerHTML = `<p class="text-green-600 font-semibold">✅ Kembalian: Rp ${kembalian.toLocaleString('id-ID')}</p>`;
    }
  }

  function showModal(modalId) {
    const modal = document.getElementById(modalId);
    modal.classList.remove('invisible', 'opacity-0');
    modal.classList.add('opacity-100', 'visible');
    document.body.style.overflow = 'hidden';
  }
  
  function hideModal(modalId) {
    const modal = document.getElementById(modalId);
    modal.classList.remove('opacity-100', 'visible');
    modal.classList.add('invisible', 'opacity-0');
    document.body.style.overflow = '';
  }
  
  function closeWarningModal() { hideModal('warningModal'); }
  function closeConfirmModal() { hideModal('confirmModal'); }
  function closeSuccessModal() { hideModal('successModal'); }

  document.getElementById('submit-btn')?.addEventListener('click', () => {
    if (!selectedPaymentMethod) {
      showModal('warningModal');
      return;
    }
    
    if (selectedPaymentMethod === 'tunai') {
      const bayar = parseInt(document.getElementById('jumlahBayar')?.value) || 0;
      if (bayar < totalTagihan) {
        alert('Jumlah uang kurang!');
        return;
      }
      bayarNominal = bayar;
      kembalianNominal = bayar - totalTagihan;
    } else {
      bayarNominal = totalTagihan;
      kembalianNominal = 0;
    }
    
    let methodName = '';
    if (selectedPaymentMethod === 'tunai') methodName = 'Tunai';
    else if (selectedPaymentMethod === 'qris') methodName = 'QRIS';
    else if (selectedPaymentMethod === 'debit') methodName = 'Debit';
    
    document.getElementById('confirmMethod').innerText = methodName;
    document.getElementById('confirmTotal').innerText = 'Rp ' + totalTagihan.toLocaleString('id-ID');
    
    if (selectedPaymentMethod === 'tunai' && kembalianNominal > 0) {
      document.getElementById('confirmKembalianRow').style.display = 'flex';
      document.getElementById('confirmKembalian').innerText = 'Rp ' + kembalianNominal.toLocaleString('id-ID');
    } else {
      document.getElementById('confirmKembalianRow').style.display = 'none';
    }
    
    showModal('confirmModal');
  });

  function processPayment() {
    fetch("{{ route('kasir.finalize-payment') }}", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
      },
      body: JSON.stringify({
        payment_method: selectedPaymentMethod,
        bayar: bayarNominal,
        kembalian: kembalianNominal
      })
    })
    .then(res => res.json())
    .then(data => {
      if (data.success) {
        hideModal('confirmModal');
        showModal('successModal');
      } else {
        alert(data.message || 'Gagal menyimpan transaksi');
      }
    })
    .catch(error => {
      console.error(error);
      alert('Terjadi kesalahan server');
    });
  }

  function closeSuccessModalAndReset() {
    hideModal('successModal');
    window.location.href = '{{ route('kasir.transaksi') }}';
  }
</script>
</body>
</html>