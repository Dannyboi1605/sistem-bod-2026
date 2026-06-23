<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log Masuk Pentadbir - KURSUS AHLI LEMBAGA PENGARAH BADAN BERKANUN NEGERI DAN SYARIKAT KERAJAAN NEGERI 2026</title>
    <!-- Google Fonts Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Self-hosted Tailwind CSS + Alpine.js via Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
<link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
</head>
<body class="bg-slate-50 text-slate-950 min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md bg-white border border-slate-200 shadow-md backdrop-blur-md rounded-2xl shadow-2xl border border-slate-200 p-8 md:p-10 transition-all duration-300 relative overflow-hidden">
        
        <!-- Admin Accent Bar -->
        <div class="absolute top-0 left-0 w-full h-1.5 bg-gradient-to-r from-red-600 via-rose-500 to-orange-500"></div>

        <!-- Event Header / Branding -->
        <div class="text-center mb-8 mt-2">
            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-red-100 text-red-700 border border-red-300 tracking-wider uppercase mb-3 text-center leading-tight">
                Zon Pentadbir Tertutup
            </span>
            <h1 class="text-2xl md:text-3xl font-black text-slate-950 tracking-tight leading-none mb-3">
                Log Masuk Admin
            </h1>
            <p class="text-[10px] text-slate-500 font-semibold uppercase tracking-widest leading-relaxed">
                KURSUS AHLI LEMBAGA PENGARAH BADAN BERKANUN NEGERI DAN SYARIKAT KERAJAAN NEGERI 2026
            </p>
        </div>

        <!-- Login Form -->
        <form action="{{ route('admin.login') }}" method="POST" class="space-y-6">
            @csrf
            
            <div class="space-y-4">
                <!-- Email Field -->
                <div class="space-y-2">
                    <label for="email" class="block text-sm font-bold uppercase tracking-wider text-slate-500">
                        Alamat E-mel
                    </label>
                    <div class="relative">
                        <input 
                            type="email" 
                            name="email" 
                            id="email" 
                            value="{{ old('email') }}"
                            class="w-full text-lg p-4 bg-white border border-slate-200 focus:border-rose-500 focus:ring-rose-500/20 text-slate-950 placeholder-slate-600 rounded-xl focus:outline-none focus:ring-4 transition-all duration-200 font-semibold"
                            placeholder="admin@sistem.com"
                            required
                            autofocus
                        >
                    </div>
                    @error('email')
                        <p class="text-xs font-bold text-red-700 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password Field -->
                <div class="space-y-2">
                    <label for="password" class="block text-sm font-bold uppercase tracking-wider text-slate-500">
                        Kata Laluan
                    </label>
                    <div class="relative">
                        <input 
                            type="password" 
                            name="password" 
                            id="password" 
                            class="w-full text-lg p-4 bg-white border border-slate-200 focus:border-rose-500 focus:ring-rose-500/20 text-slate-950 placeholder-slate-600 rounded-xl focus:outline-none focus:ring-4 transition-all duration-200 font-semibold"
                            placeholder="••••••••"
                            required
                        >
                    </div>
                    @error('password')
                        <p class="text-xs font-bold text-red-700 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Submit Button -->
            <button 
                type="submit" 
                class="w-full py-4 px-6 bg-rose-600 hover:bg-rose-500 active:scale-[0.99] text-white text-base font-extrabold rounded-xl shadow-lg border border-rose-400/20 shadow-rose-950/40 transition-all duration-200 focus:outline-none focus:ring-4 focus:ring-rose-500/30 cursor-pointer"
            >
                Akses Panel Pentadbir
            </button>
        </form>

        <!-- Footer / Back Link -->
        <div class="mt-8 text-center border-t border-slate-200 pt-6">
            <a href="{{ route('login') }}" class="text-xs text-slate-500 hover:text-slate-950 font-semibold transition-colors flex items-center justify-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali ke Log Masuk Peserta
            </a>
        </div>
    </div>
</body>
</html>

