<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>KURSUS AHLI LEMBAGA PENGARAH BADAN BERKANUN NEGERI DAN SYARIKAT KERAJAAN NEGERI 2026</title>
    <!-- Google Fonts Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-950 min-h-screen flex flex-col justify-between p-6 md:p-12 selection:bg-blue-500/30 selection:text-slate-950">
    <!-- Top Navigation -->
    <header class="w-full max-w-5xl mx-auto flex items-center justify-between">
        <span class="text-[10px] font-extrabold text-slate-950 uppercase tracking-wider text-center leading-tight">KURSUS AHLI LEMBAGA PENGARAH BADAN BERKANUN NEGERI DAN SYARIKAT KERAJAAN NEGERI 2026</span>
        @if (Route::has('login'))
            <nav>
                @auth
                    <a href="{{ url('/dashboard') }}" 
                       class="text-xs font-bold text-blue-900 hover:text-blue-800 border border-blue-200 hover:border-blue-400/40 px-5 py-2.5 rounded-xl transition duration-200 uppercase tracking-wider">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" 
                       class="text-xs font-bold text-white bg-blue-900 hover:bg-blue-800 active:scale-[0.98] px-5 py-2.5 rounded-xl transition-all duration-200 uppercase tracking-wider shadow-lg shadow-blue-950/40">
                        Log Masuk
                    </a>
                @endauth
            </nav>
        @endif
    </header>

    <!-- Main Content -->
    <main class="w-full max-w-4xl mx-auto flex-1 flex flex-col items-center justify-center text-center my-12">
        <div class="bg-white border border-slate-200 shadow-md backdrop-blur-md border border-slate-200 p-8 md:p-12 rounded-3xl shadow-2xl space-y-8 max-w-2xl">
            <!-- Badge -->
            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-blue-50 text-blue-900 border border-blue-200 tracking-widest uppercase">
                Bengkel Outcome Delivery
            </span>

            <!-- Title & Description -->
            <div class="space-y-4">
                <h1 class="text-3xl md:text-5xl font-black text-slate-950 tracking-tight leading-none">
                    DO WHAT IS RIGHT.
                </h1>
                <p class="text-slate-950 text-base md:text-lg font-medium leading-relaxed max-w-lg mx-auto">
                    Portal rasmi pendaftaran kehadiran dan penilaian program untuk ahli Lembaga Pengarah dan Urus Setia BOD 2026.
                </p>
            </div>

            <!-- Call to action -->
            <div class="pt-4 flex flex-col sm:flex-row items-center justify-center gap-4">
                @auth
                    <a href="{{ url('/dashboard') }}" 
                       class="w-full sm:w-auto py-4 px-8 bg-blue-900 hover:bg-blue-800 active:scale-[0.98] text-white font-bold text-base rounded-xl transition-all duration-200 shadow-xl shadow-blue-950/50 border border-blue-400/20 text-center">
                        Masuk Ke Dashboard Anda
                    </a>
                @else
                    <a href="{{ route('login') }}" 
                       class="w-full sm:w-auto py-4 px-8 bg-blue-900 hover:bg-blue-800 active:scale-[0.98] text-white font-bold text-base rounded-xl transition-all duration-200 shadow-xl shadow-blue-950/50 border border-blue-400/20 text-center">
                        Log Masuk Ke Portal
                    </a>
                @endauth
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="w-full max-w-5xl mx-auto text-center border-t border-slate-900 pt-6">
        <p class="text-xs text-slate-500 font-semibold tracking-wide">
            &copy; 2026 Urus Setia BOD. Hak Cipta Terpelihara.
        </p>
    </footer>
</body>
</html>
