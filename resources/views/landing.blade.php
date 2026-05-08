<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kashy</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
<style>
    body { font-family: 'Inter', sans-serif; }
    .font-display { font-family: 'Playfair Display', serif; }
</style>
</head>
<body>

<div class="min-h-screen flex flex-col bg-[#1c1c1c]">

    {{-- Navbar --}}
    <nav class="w-full flex items-center justify-center py-4 px-6 bg-[#1c1c1c] z-10">
    <span class="font-display text-white text-xl font-semibold tracking-widest">Kashy</span>
    </nav>

    {{-- Hero Section --}}
    <div class="relative flex-1 flex items-center justify-center mx-4 mb-6 md:mx-8 md:mb-8 rounded-2xl overflow-hidden"
         style="min-height: 80vh;">

        {{-- Background Image --}}
        <img
            src="{{ asset('images/baju.jpeg') }}"
            alt="SND Store"
            class="absolute inset-0 w-full h-full object-cover"
        >

        {{-- Dark Overlay --}}
        <div class="absolute inset-0 bg-black/50"></div>

        {{-- Hero Content --}}
        <div class="relative z-10 flex flex-col items-center justify-end h-full w-full px-6 pb-12 md:pb-16 text-center"
             style="min-height: 80vh;">

            {{-- Store Name & Tagline --}}
            <div class="mb-8 md:mb-10">
                <h1 class="text-white text-4xl md:text-5xl lg:text-6xl font-bold tracking-wide mb-2">
                    SND STORE
                </h1>
                <p class="text-white/80 text-base md:text-lg italic font-light">
                    cantik bagus murah
                </p>
            </div>

            {{-- Buttons --}}
            <div class="flex flex-col gap-3 w-full max-w-xs md:max-w-sm">

                {{-- Lihat Katalog Produk --}}
                <a href="{{ route('katalog') }}"
                   class="w-full py-4 bg-[#C8966C] hover:bg-[#b8845a] text-white text-center text-base md:text-lg font-medium rounded-lg transition-colors duration-200">
                    Lihat Katalog Produk
                </a>

                {{-- Login Aplikasi --}}
                <a href="{{ route('login') }}"
                   class="w-full py-4 bg-transparent hover:bg-white/10 text-white text-center text-base md:text-lg font-medium rounded-lg border border-white transition-colors duration-200">
                    Login Aplikasi
                </a>

            </div>
        </div>
    </div>

</div>

</body>
</html>