<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kashy</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,600;0,700;1,400&family=DM+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        display: ['Cormorant Garamond', 'serif'],
                        body:    ['DM Sans', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'DM Sans', sans-serif; }
    </style>
</head>
<body>

<div class="min-h-screen flex flex-col bg-[#1c1c1c]">

    {{-- Navbar --}}
    <nav class="w-full flex items-center justify-center py-4 px-6 bg-[#1c1c1c] z-10">
    </nav>

    {{-- Hero Section --}}
    <div class="relative flex-1 flex items-center justify-center mx-4 mb-6 md:mx-8 md:mb-8 rounded-2xl overflow-hidden"
         style="min-height: 80vh;">

        {{-- Background Image --}}
        <img
            src="{{ asset('images/bajuuu.jpg') }}"
            alt="SND Store"
            class="absolute inset-0 w-full h-full object-cover"
        >

        {{-- Dark Overlay --}}
        <div class="absolute inset-0 bg-black/50"></div>

        {{-- Hero Content (DI TENGAH) --}}
        <div class="relative z-10 flex flex-col items-center justify-center h-full w-full px-6 text-center"
             style="min-height: 80vh;">

            {{-- Store Name & Tagline --}}
            <div class="mb-8 md:mb-10">
                <h1 class="font-sans text-white text-5xl md:text-6xl lg:text-7xl font-extrabold tracking-normal mb-3 uppercase">
                    SND STORE
                </h1>
                <p class="text-white/70 text-base md:text-lg italic font-light tracking-wide">
                    cantik bagus murah
                </p>
            </div>

            {{-- Buttons --}}
            <div class="flex flex-col gap-3 w-full max-w-xs md:max-w-sm">

                {{-- Lihat Katalog Produk --}}
                <a href="{{ route('katalog') }}"
                   class="w-full py-4 bg-[#C8966C] hover:bg-[#b8845a] text-white text-center text-base font-medium rounded-xl transition-all duration-200 hover:-translate-y-0.5 hover:shadow-lg">
                    Lihat Katalog Produk
                </a>

                {{-- Login Aplikasi --}}
                <a href="{{ route('login') }}"
                   class="w-full py-4 bg-transparent hover:bg-white/10 text-white text-center text-base font-medium rounded-xl border border-white/60 hover:border-white transition-all duration-200">
                    Login Aplikasi
                </a>

            </div>
        </div>
    </div>

</div>

</body>
</html>