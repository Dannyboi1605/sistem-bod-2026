<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Utama — KURSUS AHLI LEMBAGA PENGARAH BADAN BERKANUN NEGERI DAN SYARIKAT KERAJAAN NEGERI 2026</title>
    <meta name="description" content="Portal peserta untuk KURSUS AHLI LEMBAGA PENGARAH BADAN BERKANUN NEGERI DAN SYARIKAT KERAJAAN NEGERI 2026.">
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- QRCode.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        inter: ['Inter', 'sans-serif'],
                    },
                    animation: {
                        'pulse-slow': 'pulse 3s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                        'fade-in': 'fadeIn 0.5s ease-out forwards',
                        'slide-up': 'slideUp 0.4s ease-out forwards',
                    },
                    keyframes: {
                        fadeIn: { from: { opacity: 0 }, to: { opacity: 1 } },
                        slideUp: { from: { opacity: 0, transform: 'translateY(12px)' }, to: { opacity: 1, transform: 'translateY(0)' } },
                    }
                }
            }
        }
    </script>
    <style>
        * { font-family: 'Inter', sans-serif; }
        body { -webkit-font-smoothing: antialiased; -moz-osx-font-smoothing: grayscale; }
        
        /* Safe area support for notched phones */
        .safe-bottom { padding-bottom: env(safe-area-inset-bottom, 1rem); }
        
        /* QR Wrapper */
        #qrcode-container canvas, #qrcode-container img {
            border-radius: 8px;
            display: block;
        }
        
        /* Custom scrollbar */
        ::-webkit-scrollbar { width: 4px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 2px; }
        
        /* Touch-friendly minimum tap targets */
        .tap-target { min-height: 48px; min-width: 48px; }
    </style>
</head>
<body class="bg-slate-50 text-slate-950 min-h-screen">

    <!-- ══════════════════════════════════════════════ -->
    <!--  STICKY TOPBAR                                -->
    <!-- ══════════════════════════════════════════════ -->
    <header class="sticky top-0 z-50 bg-white/90 backdrop-blur-xl border-b border-slate-200">
        <div class="max-w-md mx-auto px-4 h-14 flex items-center justify-between">
            <!-- Brand -->
            <div class="flex items-center gap-2.5">
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
    <!--  MAIN CONTENT — Single Column                 -->
    <!-- ══════════════════════════════════════════════ -->
    <main class="max-w-md md:max-w-4xl mx-auto px-4 py-6 space-y-6 safe-bottom">

        <!-- Constrained container for mobile-app profile, qr, evaluation, certificate -->
        <div class="max-w-md mx-auto space-y-4 w-full">
            <!-- ── FLASH MESSAGES ── -->
            @if (session('success'))
                <div id="flash-success" role="alert" class="flex items-start gap-3 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-xl text-sm font-semibold animate-fade-in">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 flex-shrink-0 mt-0.5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    <span>{{ session('success') }}</span>
                </div>
            @endif
            @if (session('warning'))
                <div id="flash-warning" role="alert" class="flex items-start gap-3 bg-yellow-50 border border-yellow-200 text-yellow-800 px-4 py-3 rounded-xl text-sm font-semibold animate-fade-in">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 flex-shrink-0 mt-0.5 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                    <span>{{ session('warning') }}</span>
                </div>
            @endif
            @if (session('error'))
                <div id="flash-error" role="alert" class="flex items-start gap-3 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-xl text-sm font-semibold animate-fade-in">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 flex-shrink-0 mt-0.5 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            <!-- ══════════════════════════════════════════ -->
            <!--  SECTION 1 — EXECUTIVE PROFILE CARD        -->
            <!-- ══════════════════════════════════════════ -->
            <section id="section-profile" class="bg-white border border-slate-200 rounded-2xl shadow-sm p-6 animate-slide-up">
                <div class="flex items-center gap-4 mb-5">
                    <!-- Avatar initials -->
                    <div class="w-14 h-14 rounded-full bg-slate-100 flex items-center justify-center flex-shrink-0 border border-slate-200">
                        <span class="text-blue-900 font-black text-xl leading-none">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                    </div>
                    <div class="min-w-0">
                        <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-0.5">Peserta Berdaftar</p>
                        <h1 class="text-xl font-black text-slate-900 uppercase tracking-wide leading-tight truncate">{{ $user->name }}</h1>
                    </div>
                </div>

                <!-- Details grid -->
                <div class="grid grid-cols-2 gap-3">
                    <div class="bg-slate-50 rounded-xl p-3 border border-slate-100">
                        <p class="text-[10px] font-semibold text-slate-500 uppercase tracking-wider mb-1">Jawatan</p>
                        <p class="text-sm font-bold text-slate-900 leading-snug break-words">{{ $user->position ?: '—' }}</p>
                    </div>
                    <div class="bg-slate-50 rounded-xl p-3 border border-slate-100">
                        <p class="text-[10px] font-semibold text-slate-500 uppercase tracking-wider mb-1">Agensi / Syarikat</p>
                        <p class="text-sm font-bold text-slate-900 leading-snug break-words">{{ $user->agency ?: '—' }}</p>
                    </div>
                </div>
            </section>

            <!-- ══════════════════════════════════════════ -->
            <!--  SECTION 1.5 — ITINERARY CARD              -->
            <!-- ══════════════════════════════════════════ -->
            <section id="section-itinerary" class="bg-white border border-slate-200 rounded-2xl shadow-sm p-5 animate-slide-up" style="animation-delay: 0.1s;">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2.5">
                        <div class="w-8 h-8 bg-blue-50 rounded-lg flex items-center justify-center border border-blue-100">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-blue-900" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-sm font-bold text-slate-900 leading-none">Atur Cara</h2>
                            <p class="text-[11px] text-slate-500 mt-0.5">Jadual penuh program dan aktiviti</p>
                        </div>
                    </div>
                    <a href="{{ route('participant.itinerary') }}" class="tap-target bg-blue-900 hover:bg-blue-800 text-white text-[11px] font-bold px-3 py-1.5 rounded-lg transition-colors uppercase tracking-wider shadow-sm active:scale-95 flex items-center">
                        Lihat
                    </a>
                </div>
            </section>

            <!-- ══════════════════════════════════════════ -->
            <!--  SECTION 2 — DYNAMIC QR CODE MODULE        -->
            <!-- ══════════════════════════════════════════ -->
            <section id="section-qr" class="bg-white border border-slate-200 rounded-2xl shadow-sm p-6">
                <!-- Header -->
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-2.5">
                        <div class="w-8 h-8 bg-blue-50 rounded-lg flex items-center justify-center border border-blue-100">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-blue-900" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-sm font-bold text-slate-900 leading-none">Kod QR Kehadiran</h2>
                            <p class="text-[11px] text-slate-500 mt-0.5">Imbas untuk daftar kehadiran</p>
                        </div>
                    </div>
                    <!-- Live indicator -->
                    <div class="flex items-center gap-1.5 px-2.5 py-1 bg-green-50 rounded-full border border-green-200">
                        <div class="w-1.5 h-1.5 bg-green-500 rounded-full animate-pulse"></div>
                        <span class="text-[10px] font-bold text-green-700 uppercase tracking-wider">Langsung</span>
                    </div>
                </div>

                <!-- Session badge -->
                <div class="flex items-center justify-between bg-slate-50 border border-slate-100 rounded-xl px-4 py-3 mb-4">
                    <div>
                        <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">Sesi Aktif</p>
                        <p id="session-display-text" class="text-sm font-bold text-slate-900 mt-0.5">Menyemak...</p>
                    </div>
                    <div>
                        <span id="session-badge-text" class="bg-blue-900 text-white font-bold px-3 py-1 rounded-lg text-xs uppercase tracking-wider">—</span>
                    </div>
                </div>

                <!-- QR Canvas — Centered (tap to fullscreen) -->
                <div class="flex flex-col items-center justify-center bg-slate-50 border border-slate-100 rounded-xl py-6 min-h-[280px] mb-4"
                     onclick="openQRFullscreen()" title="Ketik untuk besarkan">
                    <div id="qrcode-container" class="bg-white rounded-xl p-4 border border-slate-200 shadow-sm cursor-pointer active:scale-95 transition-transform">
                        <div class="w-[256px] h-[256px] flex items-center justify-center">
                            <div class="text-center space-y-2">
                                <div class="w-8 h-8 border-2 border-slate-200 border-t-blue-900 rounded-full animate-spin mx-auto"></div>
                                <p class="text-slate-500 text-[10px] font-semibold">Menjana kod...</p>
                            </div>
                        </div>
                    </div>
                    <p class="text-[11px] text-slate-500 font-medium mt-3 text-center flex items-center gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4" /></svg>
                        Ketik untuk besarkan &bull; Tunjukkan kepada urus setia
                    </p>
                </div>

                <!-- Fullscreen QR Overlay -->
                <div id="qr-fullscreen-overlay"
                     class="fixed inset-0 z-[200] bg-white hidden flex-col items-center justify-center"
                     onclick="closeQRFullscreen()">
                    <!-- Close hint -->
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-widest mb-6">Ketik di mana-mana untuk tutup</p>
                    <!-- Large QR -->
                    <div id="qrcode-fullscreen" class="bg-white p-4 rounded-2xl shadow-2xl border border-slate-200"></div>
                    <!-- Session label -->
                    <div class="mt-6 flex flex-col items-center gap-1">
                        <span id="fs-session-badge" class="bg-blue-900 text-white font-bold px-4 py-1.5 rounded-lg text-sm uppercase tracking-widest">—</span>
                        <p class="text-[11px] text-slate-400 font-medium mt-1">Tunjukkan kod ini kepada urus setia</p>
                    </div>
                </div>

                <!-- Auto-refresh progress bar -->
                <div class="space-y-2">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-1.5">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                            </svg>
                            <span class="text-[10px] font-bold text-slate-500 uppercase tracking-wider">Penyegaran automatik</span>
                        </div>
                        <span id="timer-text" class="text-[11px] font-black text-blue-900 tabular-nums">30s</span>
                    </div>
                    <div class="w-full bg-slate-100 rounded-full h-2 overflow-hidden">
                        <div id="progress-bar" class="bg-blue-900 h-full w-full rounded-full transition-all duration-1000 ease-linear"></div>
                    </div>
                </div>
            </section>

            <!-- ══════════════════════════════════════════ -->
            <!--  SECTION 2.5 — ATTENDANCE STATUS CARD     -->
            <!-- ══════════════════════════════════════════ -->
            @php
                $attDay1 = $user->attendances->firstWhere('session_name', 'HARI_1');
                $attDay2 = $user->attendances->firstWhere('session_name', 'HARI_2');
            @endphp

            <section id="section-attendance-status" class="bg-white border border-slate-200 rounded-2xl shadow-sm p-5">
                <!-- Header -->
                <div class="flex items-center gap-2.5 mb-4">
                    <div class="w-8 h-8 bg-slate-50 rounded-lg flex items-center justify-center border border-slate-100">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-slate-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-sm font-bold text-slate-900 leading-none">Status Kehadiran</h2>
                        <p class="text-[11px] text-slate-500 mt-0.5">Rekod kehadiran anda sepanjang kursus</p>
                    </div>
                </div>

                <!-- Day 1 & Day 2 cards -->
                <div class="grid grid-cols-2 gap-3">
                    <!-- Day 1 -->
                    <div class="rounded-xl border {{ $attDay1 ? 'bg-green-50 border-green-200' : 'bg-slate-50 border-slate-100' }} p-3.5">
                        <div class="flex items-center gap-2 mb-2">
                            @if ($attDay1)
                                <div class="w-6 h-6 rounded-full bg-green-100 flex items-center justify-center border border-green-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                    </svg>
                                </div>
                            @else
                                <div class="w-6 h-6 rounded-full bg-slate-100 flex items-center justify-center border border-slate-200">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                            @endif
                            <span class="text-[10px] font-black uppercase tracking-wider {{ $attDay1 ? 'text-green-800' : 'text-slate-500' }}">Hari 1</span>
                        </div>
                        <p class="text-xs font-bold {{ $attDay1 ? 'text-green-700' : 'text-slate-400' }}">
                            @if ($attDay1)
                                Hadir
                            @else
                                Belum Hadir
                            @endif
                        </p>
                        @if ($attDay1)
                            <p class="text-[10px] text-green-600 font-semibold mt-0.5">{{ \Carbon\Carbon::parse($attDay1->scanned_at)->format('d/m/Y, h:i A') }}</p>
                        @endif
                    </div>

                    <!-- Day 2 -->
                    <div class="rounded-xl border {{ $attDay2 ? 'bg-green-50 border-green-200' : 'bg-slate-50 border-slate-100' }} p-3.5">
                        <div class="flex items-center gap-2 mb-2">
                            @if ($attDay2)
                                <div class="w-6 h-6 rounded-full bg-green-100 flex items-center justify-center border border-green-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                    </svg>
                                </div>
                            @else
                                <div class="w-6 h-6 rounded-full bg-slate-100 flex items-center justify-center border border-slate-200">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                            @endif
                            <span class="text-[10px] font-black uppercase tracking-wider {{ $attDay2 ? 'text-green-800' : 'text-slate-500' }}">Hari 2</span>
                        </div>
                        <p class="text-xs font-bold {{ $attDay2 ? 'text-green-700' : 'text-slate-400' }}">
                            @if ($attDay2)
                                Hadir
                            @else
                                Belum Hadir
                            @endif
                        </p>
                        @if ($attDay2)
                            <p class="text-[10px] text-green-600 font-semibold mt-0.5">{{ \Carbon\Carbon::parse($attDay2->scanned_at)->format('d/m/Y, h:i A') }}</p>
                        @endif
                    </div>
                </div>
            </section>

            <!-- ══════════════════════════════════════════ -->
            <!--  SECTION 2.6 — DOORGIFT STATUS CARD        -->
            <!-- ══════════════════════════════════════════ -->
            <section id="section-doorgift-status" class="bg-white border border-slate-200 rounded-2xl shadow-sm p-5">
                <!-- Header -->
                <div class="flex items-center gap-2.5 mb-4">
                    <div class="w-8 h-8 bg-slate-50 rounded-lg flex items-center justify-center border border-slate-100">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-slate-650" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-sm font-bold text-slate-900 leading-none">Doorgift</h2>
                        <p class="text-[11px] text-slate-500 mt-0.5">Status penerimaan doorgift anda</p>
                    </div>
                </div>

                <!-- Status Card -->
                <div class="rounded-xl border {{ $user->has_received_doorgift ? 'bg-green-50 border-green-200' : 'bg-slate-50 border-slate-100' }} p-4">
                    <div class="flex items-center gap-3">
                        @if ($user->has_received_doorgift)
                            <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center border border-green-300">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <div>
                                <span class="text-xs font-black uppercase tracking-wider text-green-800">Telah Diterima</span>
                                <p class="text-[11px] text-green-600 font-semibold mt-0.5">Doorgift anda telah diserahkan oleh urus setia.</p>
                            </div>
                        @else
                            <div class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center border border-slate-200">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                            </div>
                            <div>
                                <span class="text-xs font-black uppercase tracking-wider text-slate-500">Belum Diterima</span>
                                <p class="text-[11px] text-slate-400 font-semibold mt-0.5">Sila tuntut doorgift anda di kaunter urus setia.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </section>

            <!-- ══════════════════════════════════════════ -->
            <!--  SECTION 3 — EVALUATION FORM STATE CARD   -->
            <!-- ══════════════════════════════════════════ -->
            @php
                $hasSubmitted = \App\Models\Evaluation::where('user_id', $user->id)->exists();
                $isFormOpen   = \Illuminate\Support\Facades\Cache::get('evaluation_status', false);
            @endphp

            <section id="section-evaluation">
                @if ($hasSubmitted)
                    {{-- ─── STATE: COMPLETED ─── --}}
                    <div class="bg-white border border-green-200 rounded-xl shadow-sm p-4">
                        <div class="flex items-center gap-4">
                            <!-- Icon -->
                            <div class="w-10 h-10 bg-green-50 rounded-full flex items-center justify-center flex-shrink-0 border border-green-200">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="min-w-0 flex-1">
                                <div class="flex items-center justify-between mb-0.5">
                                    <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wide">Penilaian Selesai</h3>
                                    <span class="px-2 py-0.5 bg-green-100 text-green-800 text-[10px] font-black rounded-md uppercase tracking-wider">✓ Dihantar</span>
                                </div>
                                <p class="text-xs text-slate-500 font-medium leading-snug">Terima kasih. Respons anda telah berjaya direkodkan.</p>
                            </div>
                        </div>
                    </div>

                @elseif ($isFormOpen)
                    {{-- ─── STATE: OPEN / ACTION REQUIRED ─── --}}
                    <div class="bg-blue-50 border border-blue-200 rounded-xl shadow-sm p-5">
                        <div class="flex items-center gap-4 mb-4">
                            <!-- Animated icon -->
                            <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center flex-shrink-0 border border-blue-200">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-blue-900" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                </svg>
                            </div>
                            <div>
                                <div class="flex items-center gap-2 mb-0.5">
                                    <h3 class="text-sm font-bold text-blue-900 uppercase tracking-wide">Tindakan Diperlukan</h3>
                                </div>
                                <p class="text-xs text-blue-800 font-medium">Borang penilaian telah dibuka. Sila lengkapkan sekarang.</p>
                            </div>
                        </div>

                        <a href="{{ route('evaluation.form') }}"
                           id="btn-open-evaluation"
                           class="tap-target flex items-center justify-center gap-2 w-full py-3 px-6 bg-blue-900 hover:bg-blue-800 active:scale-[0.98] text-white rounded-lg font-bold text-sm transition-all shadow-md uppercase tracking-wider">
                            Buka Borang Penilaian
                        </a>
                    </div>

                @else
                    {{-- ─── STATE: LOCKED ─── --}}
                    <div class="bg-white border border-slate-200 rounded-xl shadow-sm p-4 opacity-75">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 bg-slate-50 rounded-full flex items-center justify-center flex-shrink-0 border border-slate-200">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center justify-between mb-0.5">
                                    <h3 class="text-sm font-bold text-slate-500 uppercase tracking-wide">Borang Penilaian</h3>
                                    <span class="px-2 py-0.5 bg-slate-100 text-slate-500 text-[10px] font-black rounded-md uppercase tracking-wider border border-slate-200">Terkunci</span>
                                </div>
                                <p class="text-xs text-slate-400 font-semibold">Belum dibuka oleh urus setia.</p>
                            </div>
                        </div>
                    </div>
                @endif
            </section>

            <!-- ══════════════════════════════════════════ -->
            <!--  SECTION 4 — DIGITAL CERTIFICATE HUB      -->
            <!-- ══════════════════════════════════════════ -->
            <section id="section-certificate" class="bg-white border border-slate-200 rounded-xl shadow-sm p-4">
                <div class="flex items-center gap-4">
                    <!-- Icon -->
                    <div class="w-10 h-10 bg-slate-50 rounded-full flex items-center justify-center flex-shrink-0 border border-slate-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 {{ Auth::user()->is_eligible_cert ? 'text-blue-600' : 'text-slate-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>

                    <!-- Content -->
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center justify-between mb-0.5">
                            <h3 class="text-sm font-bold {{ Auth::user()->is_eligible_cert ? 'text-slate-900' : 'text-slate-500' }} uppercase tracking-wide">Sijil Penyertaan</h3>
                            @if (Auth::user()->is_eligible_cert)
                                <span class="px-2 py-0.5 bg-blue-50 text-blue-800 text-[10px] font-black rounded-md border border-blue-100 uppercase">✓ Tersedia</span>
                            @else
                                <span class="px-2 py-0.5 bg-slate-100 text-slate-500 text-[10px] font-black rounded-md border border-slate-200 uppercase">Dikunci</span>
                            @endif
                        </div>
                        <p class="text-xs {{ Auth::user()->is_eligible_cert ? 'text-slate-600' : 'text-slate-400' }} font-medium leading-snug">
                            @if (Auth::user()->is_eligible_cert)
                                Sijil digital sedia untuk dimuat turun.
                            @else
                                Lengkapkan penilaian untuk membuka kunci.
                            @endif
                        </p>
                    </div>
                </div>

                @if (Auth::user()->is_eligible_cert)
                    {{-- Active download button --}}
                    <div class="mt-4">
                        <a href="{{ route('certificate.download') }}"
                           id="btn-download-cert"
                           class="tap-target flex items-center justify-center gap-2.5 w-full py-3 px-6 bg-blue-900 hover:bg-blue-800 active:scale-[0.98] text-white rounded-lg font-bold text-sm transition-all shadow-md tracking-wide uppercase">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                            </svg>
                            Muat Turun Sijil
                        </a>
                    </div>
                @else
                    {{-- Locked button with lock icon --}}
                    <div class="mt-4">
                        <button type="button"
                                disabled
                                id="btn-download-cert-locked"
                                class="tap-target flex items-center justify-center gap-2.5 w-full py-3 px-6 bg-slate-100 text-slate-400 rounded-lg font-bold text-sm cursor-not-allowed border border-slate-200 tracking-wide uppercase">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                            Dikunci
                        </button>
                    </div>
                @endif
            </section>
        </div>

        <!-- ── Footer Branding ── -->
        <footer class="max-w-md mx-auto text-center py-4">
            <p class="text-[10px] text-slate-500 font-semibold uppercase tracking-widest leading-tight">KURSUS AHLI LEMBAGA PENGARAH BADAN BERKANUN NEGERI DAN SYARIKAT KERAJAAN NEGERI 2026 &bull; Hak Cipta Terpelihara</p>
        </footer>

    </main>

    <!-- ══════════════════════════════════════════════ -->
    <!--  CONGRATULATIONS MODAL — Certificate Unlocked -->
    <!-- ══════════════════════════════════════════════ -->
    @if (session('cert_unlocked'))
        <div id="cert-modal-overlay"
             class="fixed inset-0 z-[100] bg-black/60 backdrop-blur-sm flex items-center justify-center p-4"
             onclick="if(event.target===this) this.remove()">
            <div class="bg-white rounded-2xl shadow-2xl max-w-sm w-full p-8 text-center animate-slide-up">
                <!-- Success icon -->
                <div class="w-16 h-16 mx-auto mb-5 bg-green-50 rounded-full flex items-center justify-center border-2 border-green-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>

                <h2 class="text-xl font-black text-slate-900 mb-2 uppercase tracking-wide">Tahniah!</h2>
                <p class="text-sm text-slate-600 font-medium mb-6 leading-relaxed">
                    Anda layak menerima <span class="font-bold text-blue-900">E-Sijil Penyertaan</span>. Klik butang di bawah untuk memuat turun sijil anda.
                </p>

                <!-- Download button -->
                <a href="{{ route('certificate.download') }}"
                   id="btn-modal-download-cert"
                   class="tap-target flex items-center justify-center gap-2.5 w-full py-3.5 px-6 bg-blue-900 hover:bg-blue-800 active:scale-[0.98] text-white rounded-xl font-bold text-sm transition-all shadow-lg tracking-wide uppercase">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4.5 h-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                    Muat Turun E-Sijil
                </a>

                <!-- Dismiss link -->
                <button type="button"
                        onclick="document.getElementById('cert-modal-overlay').remove()"
                        class="mt-3 text-xs font-semibold text-slate-400 hover:text-slate-600 transition-colors cursor-pointer uppercase tracking-wider">
                    Tutup
                </button>
            </div>
        </div>
    @endif

    <!-- ══════════════════════════════════════════════ -->
    <!--  SCRIPTS                                      -->
    <!-- ══════════════════════════════════════════════ -->
    <script>
        // ── QR Code Logic ────────────────────────────
        let countdownValue = 30;
        let countdownInterval = null;
        let qrInitialized = false;

        function fetchNewQRCode() {
            const container    = document.getElementById('qrcode-container');
            const sessionText  = document.getElementById('session-display-text');
            const sessionBadge = document.getElementById('session-badge-text');

            // Determine session from global active session
            const sessName = '{{ $activeSession }}';
            const isDay1  = sessName === 'HARI_1';

            sessionText.textContent  = isDay1 ? 'Hari 1 Mesyuarat BOD' : 'Hari 2 Mesyuarat BOD';
            sessionBadge.textContent = isDay1 ? 'HARI 1' : 'HARI 2';

            // Show loading in container
            container.innerHTML = `
                <div class="w-[256px] h-[256px] flex items-center justify-center">
                    <div class="text-center space-y-2">
                        <div class="w-6 h-6 border-2 border-slate-200 border-t-blue-900 rounded-full animate-spin mx-auto"></div>
                        <p class="text-slate-500 text-[10px] font-semibold">Menjana...</p>
                    </div>
                </div>`;

            fetch('/attendance/qrcode', {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Content-Type':     'application/json',
                    'Accept':           'application/json',
                    'X-CSRF-TOKEN':     '{{ csrf_token() }}'
                },
                body: JSON.stringify({ session_name: sessName })
            })
            .then(response => {
                if (!response.ok) throw new Error('Ralat server');
                return response.json();
            })
            .then(data => {
                // Store URL for fullscreen use
                window._qrUrl = data.url;

                container.innerHTML = '';

                // ── Main QR (256px, Level L = fewer modules = bigger dots = easier far scan)
                new QRCode(container, {
                    text:         data.url,
                    width:        256,
                    height:       256,
                    colorDark:    '#0f172a', /* slate-900 */
                    colorLight:   '#ffffff',
                    correctLevel: QRCode.CorrectLevel.L
                });

                // ── Fullscreen QR (320px) — rebuild if overlay already open
                const fsContainer = document.getElementById('qrcode-fullscreen');
                fsContainer.innerHTML = '';
                new QRCode(fsContainer, {
                    text:         data.url,
                    width:        320,
                    height:       320,
                    colorDark:    '#0f172a',
                    colorLight:   '#ffffff',
                    correctLevel: QRCode.CorrectLevel.L
                });

                resetTimer();
            })
            .catch(err => {
                console.error(err);
                container.innerHTML = `
                    <div class="w-[256px] h-[256px] flex items-center justify-center">
                        <div class="text-center space-y-2 px-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-red-500 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                            <p class="text-red-700 text-[10px] font-bold">Ralat memuatkan kod.</p>
                        </div>
                    </div>`;
            });
        }

        function resetTimer() {
            clearInterval(countdownInterval);
            countdownValue = 30;
            updateProgressBar(30);

            countdownInterval = setInterval(() => {
                countdownValue--;
                updateProgressBar(countdownValue);
                if (countdownValue <= 0) {
                    clearInterval(countdownInterval);
                    fetchNewQRCode();
                }
            }, 1000);
        }

        function updateProgressBar(value) {
            const bar   = document.getElementById('progress-bar');
            const label = document.getElementById('timer-text');
            const pct   = (value / 30) * 100;

            bar.style.width = `${pct}%`;
            label.textContent = `${value}s`;

            if (value <= 8) {
                bar.className = 'bg-red-500 h-full rounded-full transition-all duration-1000 ease-linear';
            } else {
                bar.className = 'bg-blue-900 h-full rounded-full transition-all duration-1000 ease-linear';
            }
        }

        // ── Auto-dismiss flash messages ──────────────
        ['flash-success', 'flash-warning', 'flash-error'].forEach(id => {
            const el = document.getElementById(id);
            if (el) {
                setTimeout(() => {
                    el.style.transition = 'opacity 0.5s ease';
                    el.style.opacity = '0';
                    setTimeout(() => el.remove(), 500);
                }, 5000);
            }
        });

        // ── Fullscreen QR overlay ─────────────────────
        function openQRFullscreen() {
            const overlay = document.getElementById('qr-fullscreen-overlay');
            const badge   = document.getElementById('fs-session-badge');
            const sessName = '{{ $activeSession }}';
            badge.textContent = sessName === 'HARI_1' ? 'HARI 1' : 'HARI 2';
            overlay.classList.remove('hidden');
            overlay.classList.add('flex');
            // Prevent body scroll while overlay is open
            document.body.style.overflow = 'hidden';
        }

        function closeQRFullscreen() {
            const overlay = document.getElementById('qr-fullscreen-overlay');
            overlay.classList.add('hidden');
            overlay.classList.remove('flex');
            document.body.style.overflow = '';
        }

        // Close fullscreen on Escape key
        document.addEventListener('keydown', e => {
            if (e.key === 'Escape') closeQRFullscreen();
        });

        // ── Init on page load ─────────────────────────
        window.addEventListener('load', fetchNewQRCode);
    </script>
</body>
</html>
