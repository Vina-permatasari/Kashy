<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Kashy</title>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,600;0,700;1,400&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Poppins', sans-serif; }
        .font-display { font-family: 'Cormorant Garamond', serif; }
    </style>
</head>
<body class="min-h-screen bg-[#f0e6d8] flex flex-col">

    {{-- Navbar --}}
    <nav class="w-full flex items-center justify-center py-4 bg-[#1c1c1c] sticky top-0 z-50">
        <span class="font-display text-white text-2xl font-semibold tracking-widest italic">Kashy</span>
    </nav>

    {{-- Main Content --}}
    <div class="flex-1 flex items-center justify-center px-4 py-10">
    <div class="w-full max-w-md sm:max-w-lg lg:max-w-xl bg-white rounded-3xl shadow-xl overflow-hidden">

            {{-- Card Top Accent --}}
            <div class="h-2 w-full bg-gradient-to-r from-[#C8966C] via-[#e5b18a] to-[#C8966C]"></div>

            <div class="px-8 sm:px-12 py-10 sm:py-14">

                {{-- Header --}}
                <div class="mb-10">
                    <h1 class="font-display text-3xl sm:text-4xl font-bold text-[#1c1c1c] tracking-wide mb-1">
                        SND STORE
                    </h1>
                    <div class="w-12 h-0.5 bg-[#C8966C] mb-4"></div>
                    <h2 class="text-lg sm:text-xl font-semibold text-[#1c1c1c] mb-2">
                        Selamat Datang
                    </h2>
                    <p class="text-sm text-gray-400 font-light leading-relaxed">
                        Masukkan kredensial Anda untuk mengakses portal
                    </p>
                </div>

                {{-- Form --}}
                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    {{-- Email --}}
                    <div>
                        <label class="block text-xs font-semibold text-[#1c1c1c] uppercase tracking-widest mb-2">
                            Email
                        </label>
                        <input
                            type="email"
                            name="email"
                            placeholder="nama@email.com"
                            value="{{ old('email') }}"
                            class="w-full px-5 py-4 border border-[#e5d5c5] rounded-xl bg-[#fdf8f4] text-sm text-[#1c1c1c] placeholder-gray-300 focus:outline-none focus:border-[#C8966C] focus:ring-2 focus:ring-[#C8966C]/20 transition-all duration-200"
                            required
                        >
                        @error('email')
                            <p class="text-red-400 text-xs mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Password --}}
                    <div>
                        <label class="block text-xs font-semibold text-[#1c1c1c] uppercase tracking-widest mb-2">
                            Password
                        </label>
                        <div class="relative">
                            <input
                                type="password"
                                name="password"
                                id="password"
                                placeholder="••••••••"
                                class="w-full px-5 py-4 border border-[#e5d5c5] rounded-xl bg-[#fdf8f4] text-sm text-[#1c1c1c] placeholder-gray-300 focus:outline-none focus:border-[#C8966C] focus:ring-2 focus:ring-[#C8966C]/20 transition-all duration-200 pr-12"
                                required
                            >
                            <button
                                type="button"
                                onclick="togglePassword()"
                                class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-300 hover:text-[#C8966C] transition-colors duration-200 text-lg">
                                👁
                            </button>
                        </div>
                        @error('password')
                            <p class="text-red-400 text-xs mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Forgot Password --}}
                    <div class="flex justify-end">
                        <a href="{{ route('password.request') }}"
                           class="text-xs text-[#C8966C] hover:text-[#b8845a] font-medium transition-colors duration-200">
                            Lupa password?
                        </a>
                    </div>

                    {{-- Button --}}
                    <button type="submit"
                        class="w-full py-4 bg-[#1c1c1c] hover:bg-[#C8966C] text-white font-semibold rounded-xl flex items-center justify-center gap-3 transition-all duration-300 text-sm sm:text-base tracking-wide group">
                        <span>Masuk</span>
                        <span class="group-hover:translate-x-1 transition-transform duration-200">→</span>
                    </button>

                </form>

                {{-- Divider --}}
                <div class="flex items-center gap-4 my-8">
                    <div class="flex-1 h-px bg-gray-100"></div>
                    <span class="text-xs text-gray-300 font-light">KASHY © 2026</span>
                    <div class="flex-1 h-px bg-gray-100"></div>
                </div>

                {{-- Back to Landing --}}
                <div class="text-center">
                    <a href="#"
                       class="text-xs text-gray-400 hover:text-[#C8966C] transition-colors duration-200">
                        ← Kembali ke beranda
                    </a>
                </div>

            </div>
        </div>
    </div>

    <script>
        function togglePassword() {
            const input = document.getElementById('password');
            input.type = input.type === 'password' ? 'text' : 'password';
        }
    </script>

</body>
</html>