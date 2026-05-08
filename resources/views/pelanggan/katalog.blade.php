<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katalog Produk - Kashy</title>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,600;0,700;1,400&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Poppins', sans-serif; }
        .font-display { font-family: 'Cormorant Garamond', serif; }
    </style>
</head>
<body class="min-h-screen bg-[#f0e6d8] flex flex-col">

    {{-- Navbar --}}
    <nav class="w-full flex items-center justify-between py-4 px-6 md:px-12 bg-[#1c1c1c] sticky top-0 z-50">
        <a href="#" class="text-gray-400 hover:text-white text-sm transition-colors duration-200">
            ← Kembali
        </a>
        <span class="font-display text-white text-2xl font-semibold tracking-widest italic">Kashy</span>
        <a href="{{ route('login') }}" class="text-xs text-[#C8966C] hover:text-[#e5b18a] font-medium transition-colors duration-200">
            Login →
        </a>
    </nav>

    {{-- Header --}}
    <div class="w-full px-6 md:px-12 py-10 text-center">
        <h1 class="font-display text-4xl md:text-5xl font-bold text-[#1c1c1c] mb-2">Katalog Produk</h1>
        <div class="w-12 h-0.5 bg-[#C8966C] mx-auto mb-4"></div>
        <p class="text-sm text-gray-500 font-light">Temukan koleksi fashion terbaik SND Store</p>
    </div>

    {{-- Filter Kategori --}}
    <div class="w-full px-6 md:px-12 mb-8">
        <div class="flex gap-3 flex-wrap justify-center">
            <button class="px-5 py-2 bg-[#1c1c1c] text-white text-xs font-medium rounded-full">Semua</button>
            <button class="px-5 py-2 bg-white text-[#1c1c1c] text-xs font-medium rounded-full border border-[#e5d5c5] hover:border-[#C8966C] transition-colors">Baju</button>
            <button class="px-5 py-2 bg-white text-[#1c1c1c] text-xs font-medium rounded-full border border-[#e5d5c5] hover:border-[#C8966C] transition-colors">Celana</button>
            <button class="px-5 py-2 bg-white text-[#1c1c1c] text-xs font-medium rounded-full border border-[#e5d5c5] hover:border-[#C8966C] transition-colors">Jaket</button>
            <button class="px-5 py-2 bg-white text-[#1c1c1c] text-xs font-medium rounded-full border border-[#e5d5c5] hover:border-[#C8966C] transition-colors">Thrift</button>
            <button class="px-5 py-2 bg-white text-[#1c1c1c] text-xs font-medium rounded-full border border-[#e5d5c5] hover:border-[#C8966C] transition-colors">Branded</button>
        </div>
    </div>

    {{-- Search Bar --}}
    <div class="w-full px-6 md:px-12 mb-10">
        <div class="max-w-md mx-auto relative">
            <input
                type="text"
                placeholder="Cari produk..."
                class="w-full px-5 py-3 border border-[#e5d5c5] rounded-full bg-white text-sm focus:outline-none focus:border-[#C8966C] focus:ring-2 focus:ring-[#C8966C]/20 transition-all duration-200 pr-12"
            >
            <span class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-300">🔍</span>
        </div>
    </div>

    {{-- Product Grid --}}
    <div class="w-full px-6 md:px-12 pb-16">
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-6">

            @php
            $products = [
                ['name' => 'Kemeja Flannel Oversize', 'category' => 'Baju', 'price' => 'Rp 85.000', 'badge' => 'Thrift', 'color' => '#e8d5c4'],
                ['name' => 'Celana Cargo Panjang', 'category' => 'Celana', 'price' => 'Rp 120.000', 'badge' => 'Branded', 'color' => '#d4c9bc'],
                ['name' => 'Jaket Denim Vintage', 'category' => 'Jaket', 'price' => 'Rp 150.000', 'badge' => 'Thrift', 'color' => '#c9d4e0'],
                ['name' => 'Kaos Polos Premium', 'category' => 'Baju', 'price' => 'Rp 65.000', 'badge' => 'New', 'color' => '#e0d4c9'],
                ['name' => 'Celana Jeans Slim', 'category' => 'Celana', 'price' => 'Rp 135.000', 'badge' => 'Branded', 'color' => '#c9cfe0'],
                ['name' => 'Hoodie Polos Cream', 'category' => 'Baju', 'price' => 'Rp 175.000', 'badge' => 'New', 'color' => '#ede0d4'],
                ['name' => 'Jaket Bomber Hitam', 'category' => 'Jaket', 'price' => 'Rp 200.000', 'badge' => 'Branded', 'color' => '#c8c8c8'],
                ['name' => 'Rok Mini Plaid', 'category' => 'Baju', 'price' => 'Rp 95.000', 'badge' => 'Thrift', 'color' => '#e0c9c9'],
            ];
            @endphp

            @foreach($products as $product)
            <div class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition-shadow duration-200 group">

                {{-- Product Image Placeholder --}}
                <div class="w-full aspect-square flex items-center justify-center relative overflow-hidden"
                     style="background-color: {{ $product['color'] }}">
                    <span class="text-4xl">👗</span>
                    {{-- Badge --}}
                    <span class="absolute top-3 left-3 text-xs font-semibold px-2 py-1 rounded-full
                        {{ $product['badge'] === 'New' ? 'bg-[#1c1c1c] text-white' : ($product['badge'] === 'Branded' ? 'bg-[#C8966C] text-white' : 'bg-white text-[#1c1c1c]') }}">
                        {{ $product['badge'] }}
                    </span>
                </div>

                {{-- Product Info --}}
                <div class="p-4">
                    <p class="text-xs text-[#C8966C] font-medium mb-1">{{ $product['category'] }}</p>
                    <h3 class="text-sm font-semibold text-[#1c1c1c] mb-2 leading-snug">{{ $product['name'] }}</h3>
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-bold text-[#1c1c1c]">{{ $product['price'] }}</span>
                        <button class="w-8 h-8 flex items-center justify-center rounded-full bg-[#f0e6d8] hover:bg-[#C8966C] hover:text-white transition-colors duration-200 text-sm">
                            ♡
                        </button>
                    </div>
                </div>

            </div>
            @endforeach

        </div>
    </div>

    {{-- Footer --}}
    <footer class="w-full py-6 bg-[#1c1c1c] text-center">
        <span class="font-display text-white/50 text-sm italic">Kashy © 2026 — SND Store</span>
    </footer>

</body>
</html>