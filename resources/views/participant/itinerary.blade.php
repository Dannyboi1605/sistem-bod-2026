<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Atur Cara Program — KURSUS AHLI LEMBAGA PENGARAH BADAN BERKANUN NEGERI DAN SYARIKAT KERAJAAN NEGERI 2026</title>
    <meta name="description" content="Jadual dan pengisian atur cara program KURSUS AHLI LEMBAGA PENGARAH BADAN BERKANUN NEGERI DAN SYARIKAT KERAJAAN NEGERI 2026.">
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        inter: ['Inter', 'sans-serif'],
                    },
                    animation: {
                        'fade-in':  'fadeIn 0.5s ease-out forwards',
                        'slide-up': 'slideUp 0.4s ease-out forwards',
                    },
                    keyframes: {
                        fadeIn:  { from: { opacity: 0 }, to: { opacity: 1 } },
                        slideUp: { from: { opacity: 0, transform: 'translateY(12px)' }, to: { opacity: 1, transform: 'translateY(0)' } },
                    }
                }
            }
        }
    </script>
    <style>
        * { font-family: 'Inter', sans-serif; }
        body { -webkit-font-smoothing: antialiased; -moz-osx-font-smoothing: grayscale; }
        .safe-bottom { padding-bottom: env(safe-area-inset-bottom, 1rem); }
        ::-webkit-scrollbar { width: 4px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 2px; }
        .tap-target { min-height: 48px; min-width: 48px; }

        /* Timeline dot highlight for active items */
        .timeline-item-active .dot { border-color: #1e3a8a; }
    </style>
</head>
<body class="bg-slate-50 text-slate-950 min-h-screen">

    <!-- ══════════════════════════════════════════════ -->
    <!--  STICKY TOPBAR                                -->
    <!-- ══════════════════════════════════════════════ -->
    <header class="sticky top-0 z-50 bg-white/90 backdrop-blur-xl border-b border-slate-200">
        <div class="max-w-md mx-auto px-4 h-14 flex items-center justify-between">
            <!-- Back button + Brand -->
            <div class="flex items-center gap-2.5">
                <a href="{{ route('dashboard') }}" id="btn-back-dashboard"
                   class="tap-target flex items-center gap-1 text-slate-500 hover:text-slate-900 transition-colors -ml-1 pr-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                    </svg>
                </a>
                <span class="text-[10px] font-black text-slate-950 tracking-tight leading-tight">KURSUS AHLI LEMBAGA PENGARAH BADAN BERKANUN NEGERI DAN SYARIKAT KERAJAAN NEGERI <span class="text-blue-900">2026</span></span>
            </div>

            <!-- Right Actions -->
            <div class="flex items-center gap-2">
                @if ($user->hasRole('admin'))
                    <a href="{{ route('admin.dashboard') }}" class="text-[11px] font-bold text-blue-900 hover:text-blue-800 transition-colors uppercase tracking-wider px-2 py-1 rounded-md hover:bg-slate-100 tap-target flex items-center">
                        Admin
                    </a>
                @endif
                @if ($user->hasRole('jawatankuasa'))
                    <a href="{{ route('secretariat.dashboard') }}" class="text-[11px] font-bold text-blue-900 hover:text-blue-800 transition-colors uppercase tracking-wider px-2 py-1 rounded-md hover:bg-slate-100 tap-target flex items-center">
                        Urus Setia
                    </a>
                @endif

                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" id="logout-btn" class="tap-target flex items-center gap-1.5 px-3 py-2 rounded-lg bg-slate-100 hover:bg-slate-200 active:scale-95 text-slate-700 transition-all text-[11px] font-bold uppercase tracking-wider cursor-pointer border border-slate-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        Keluar
                    </button>
                </form>
            </div>
        </div>
    </header>

    <!-- ══════════════════════════════════════════════ -->
    <!--  MAIN CONTENT                                 -->
    <!-- ══════════════════════════════════════════════ -->
    <main class="max-w-md md:max-w-4xl mx-auto px-4 py-6 space-y-6 safe-bottom">

        <!-- Page Heading -->
        <div class="flex items-center gap-3.5 animate-slide-up">
            <div class="w-10 h-10 bg-blue-50 rounded-xl flex items-center justify-center border border-blue-100 flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-blue-900" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
            </div>
            <div>
                <h1 class="text-xl font-black text-slate-900 tracking-tight">Atur Cara Program</h1>
                <p class="text-xs text-slate-500 font-medium">Jadual dan pengisian kursus sepanjang 2 hari</p>
            </div>
        </div>

        <!-- Grid: Stack on mobile, 2 columns on desktop -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 animate-fade-in">

            <!-- ═══════════ HARI 1 ═══════════ -->
            <section class="bg-white border border-slate-200 rounded-2xl shadow-sm p-6">
                <!-- Day Title & Location -->
                <div class="mb-6 pb-4 border-b border-slate-100">
                    <div class="flex items-center gap-2 mb-2">
                        <span class="px-2.5 py-0.5 bg-blue-50 border border-blue-200 text-blue-900 text-[10px] font-bold rounded uppercase tracking-wider">HARI 1</span>
                        <h2 class="text-sm font-bold text-slate-900">24 Jun 2026 (Rabu)</h2>
                    </div>
                    <div class="flex items-start gap-1.5 text-xs text-slate-500 font-medium">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-slate-400 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <span>Ballroom The Magellan, Sutera Harbour Resort Kota Kinabalu</span>
                    </div>
                </div>

                <!-- Vertical Timeline -->
                <div class="relative pl-6 border-l-2 border-slate-200 space-y-6">
                    <!-- Item 1 -->
                    <div class="relative">
                        <div class="absolute -left-[31px] top-1.5 w-3 h-3 rounded-full bg-white border-2 border-slate-300"></div>
                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-bold bg-blue-50 text-blue-900 border border-blue-200 mb-1.5">07.30 am</span>
                        <h3 class="text-slate-900 font-bold text-sm leading-snug">Ketibaan dan Pendaftaran Peserta / Sarapan</h3>
                    </div>
                    <!-- Item 2 -->
                    <div class="relative">
                        <div class="absolute -left-[31px] top-1.5 w-3 h-3 rounded-full bg-white border-2 border-slate-300"></div>
                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-bold bg-blue-50 text-blue-900 border border-blue-200 mb-1.5">08.00 am</span>
                        <h3 class="text-slate-900 font-bold text-sm leading-snug">Ketibaan Timbalan Setiausaha Tetap</h3>
                    </div>
                    <!-- Item 3 -->
                    <div class="relative">
                        <div class="absolute -left-[31px] top-1.5 w-3 h-3 rounded-full bg-white border-2 border-slate-300"></div>
                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-bold bg-blue-50 text-blue-900 border border-blue-200 mb-1.5">08.15 am</span>
                        <h3 class="text-slate-900 font-bold text-sm leading-snug">Ketibaan Setiausaha Tetap Kementerian & Dif Jemputan</h3>
                    </div>
                    <!-- Item 4 -->
                    <div class="relative">
                        <div class="absolute -left-[31px] top-1.5 w-3 h-3 rounded-full bg-white border-2 border-blue-300"></div>
                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-bold bg-blue-50 text-blue-900 border border-blue-200 mb-1.5">08.45 am</span>
                        <h3 class="text-slate-900 font-bold text-sm leading-snug">Sesi 1: Memelihara Dana Awam (Liabiliti Korporat)</h3>
                        <p class="text-slate-500 text-xs mt-1 font-medium">Speaker: Datuk Mohd Fuad Bee Bin Haji Basrah</p>
                    </div>
                    <!-- Item 5 -->
                    <div class="relative">
                        <div class="absolute -left-[31px] top-1.5 w-3 h-3 rounded-full bg-white border-2 border-blue-300"></div>
                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-bold bg-blue-50 text-blue-900 border border-blue-200 mb-1.5">10.15 am</span>
                        <h3 class="text-slate-900 font-bold text-sm leading-snug">Ucaptama dan Majlis Perasmian</h3>
                        <p class="text-slate-500 text-xs mt-1 font-medium">Oleh: YB Datuk Seri Panglima Haji Masidi bin Manjun</p>
                    </div>
                    <!-- Item 6 -->
                    <div class="relative">
                        <div class="absolute -left-[31px] top-1.5 w-3 h-3 rounded-full bg-white border-2 border-slate-300"></div>
                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-bold bg-blue-50 text-blue-900 border border-blue-200 mb-1.5">12.00 pm</span>
                        <h3 class="text-slate-900 font-bold text-sm leading-snug">Makan Tengah Hari, Rehat dan Solat</h3>
                    </div>
                    <!-- Item 7 -->
                    <div class="relative">
                        <div class="absolute -left-[31px] top-1.5 w-3 h-3 rounded-full bg-white border-2 border-blue-300"></div>
                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-bold bg-blue-50 text-blue-900 border border-blue-200 mb-1.5">02.00 pm</span>
                        <h3 class="text-slate-900 font-bold text-sm leading-snug">Sesi 2: Transformational Leadership</h3>
                        <p class="text-slate-500 text-xs mt-1 font-medium">Speaker: Dato' Sri Idris Jala</p>
                    </div>
                    <!-- Item 8 -->
                    <div class="relative">
                        <div class="absolute -left-[31px] top-1.5 w-3 h-3 rounded-full bg-white border-2 border-slate-300"></div>
                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-bold bg-blue-50 text-blue-900 border border-blue-200 mb-1.5">04.30 pm</span>
                        <h3 class="text-slate-900 font-bold text-sm leading-snug">Minum Petang dan Selesai</h3>
                    </div>
                </div>
            </section>

            <!-- ═══════════ HARI 2 ═══════════ -->
            <section class="bg-white border border-slate-200 rounded-2xl shadow-sm p-6">
                <!-- Day Title & Location -->
                <div class="mb-6 pb-4 border-b border-slate-100">
                    <div class="flex items-center gap-2 mb-2">
                        <span class="px-2.5 py-0.5 bg-blue-50 border border-blue-200 text-blue-900 text-[10px] font-bold rounded uppercase tracking-wider">HARI 2</span>
                        <h2 class="text-sm font-bold text-slate-900">25 Jun 2026 (Khamis)</h2>
                    </div>
                    <div class="flex items-start gap-1.5 text-xs text-slate-500 font-medium">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-slate-400 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <span>Ballroom The Magellan, Sutera Harbour Resort Kota Kinabalu</span>
                    </div>
                </div>

                <!-- Vertical Timeline -->
                <div class="relative pl-6 border-l-2 border-slate-200 space-y-6">
                    <!-- Item 1 -->
                    <div class="relative">
                        <div class="absolute -left-[31px] top-1.5 w-3 h-3 rounded-full bg-white border-2 border-slate-300"></div>
                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-bold bg-blue-50 text-blue-900 border border-blue-200 mb-1.5">08.00 am</span>
                        <h3 class="text-slate-900 font-bold text-sm leading-snug">Ketibaan dan Pendaftaran Peserta / Sarapan</h3>
                    </div>
                    <!-- Item 2 -->
                    <div class="relative">
                        <div class="absolute -left-[31px] top-1.5 w-3 h-3 rounded-full bg-white border-2 border-blue-300"></div>
                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-bold bg-blue-50 text-blue-900 border border-blue-200 mb-1.5">08.30 am</span>
                        <h3 class="text-slate-900 font-bold text-sm leading-snug">Sesi 3: Enhancing Board Oversight (Risk & ESG)</h3>
                        <p class="text-slate-500 text-xs mt-1 font-medium">Speaker: Encik Lee Min Onn</p>
                    </div>
                    <!-- Item 3 -->
                    <div class="relative">
                        <div class="absolute -left-[31px] top-1.5 w-3 h-3 rounded-full bg-white border-2 border-slate-300"></div>
                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-bold bg-blue-50 text-blue-900 border border-blue-200 mb-1.5">10.30 am</span>
                        <h3 class="text-slate-900 font-bold text-sm leading-snug">Minum Pagi</h3>
                    </div>
                    <!-- Item 4 -->
                    <div class="relative">
                        <div class="absolute -left-[31px] top-1.5 w-3 h-3 rounded-full bg-white border-2 border-blue-300"></div>
                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-bold bg-blue-50 text-blue-900 border border-blue-200 mb-1.5">10.45 am</span>
                        <h3 class="text-slate-900 font-bold text-sm leading-snug">Sesi 4: Statutory Duties and Governance</h3>
                        <p class="text-slate-500 text-xs mt-1 font-medium">Speaker: Encik Mohamad Khairunnizat Bin Khori</p>
                    </div>
                    <!-- Item 5 -->
                    <div class="relative">
                        <div class="absolute -left-[31px] top-1.5 w-3 h-3 rounded-full bg-white border-2 border-slate-300"></div>
                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-bold bg-blue-50 text-blue-900 border border-blue-200 mb-1.5">12.30 pm</span>
                        <h3 class="text-slate-900 font-bold text-sm leading-snug">Makan Tengah Hari, Rehat dan Solat</h3>
                    </div>
                    <!-- Item 6 -->
                    <div class="relative">
                        <div class="absolute -left-[31px] top-1.5 w-3 h-3 rounded-full bg-white border-2 border-blue-300"></div>
                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-bold bg-blue-50 text-blue-900 border border-blue-200 mb-1.5">02.00 pm</span>
                        <h3 class="text-slate-900 font-bold text-sm leading-snug">Sesi 5: Financial Prudence and Audit Committee</h3>
                        <p class="text-slate-500 text-xs mt-1 font-medium">Speaker: Datuk Petrus Gimbad</p>
                    </div>
                    <!-- Item 7 -->
                    <div class="relative">
                        <div class="absolute -left-[31px] top-1.5 w-3 h-3 rounded-full bg-white border-2 border-blue-300"></div>
                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-bold bg-blue-50 text-blue-900 border border-blue-200 mb-1.5">03.30 pm</span>
                        <h3 class="text-slate-900 font-bold text-sm leading-snug">Sesi 6: Tax Planning and Corporate Governance</h3>
                        <p class="text-slate-500 text-xs mt-1 font-medium">Speaker: Dato' S. Saravana</p>
                    </div>
                    <!-- Item 8 -->
                    <div class="relative">
                        <div class="absolute -left-[31px] top-1.5 w-3 h-3 rounded-full bg-white border-2 border-slate-300"></div>
                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-bold bg-blue-50 text-blue-900 border border-blue-200 mb-1.5">05.00 pm</span>
                        <h3 class="text-slate-900 font-bold text-sm leading-snug">Minum Petang dan Bersurai</h3>
                    </div>
                </div>
            </section>

        </div>

        <!-- Footer -->
        <footer class="max-w-md mx-auto text-center py-4">
            <p class="text-[10px] text-slate-500 font-semibold uppercase tracking-widest leading-tight">KURSUS AHLI LEMBAGA PENGARAH BADAN BERKANUN NEGERI DAN SYARIKAT KERAJAAN NEGERI 2026 &bull; Hak Cipta Terpelihara</p>
        </footer>

    </main>
</body>
</html>
