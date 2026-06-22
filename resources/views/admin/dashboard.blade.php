<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Pemantauan Kehadiran Admin - KURSUS AHLI LEMBAGA PENGARAH BADAN BERKANUN NEGERI DAN SYARIKAT KERAJAAN NEGERI 2026</title>
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
<body class="bg-slate-50 text-slate-950 min-h-screen p-4 md:p-8">

    <div class="max-w-7xl mx-auto space-y-6">
        
        <!-- Header -->
        <header class="bg-white border border-slate-200 shadow-md backdrop-blur-md rounded-2xl border border-slate-200 p-6 flex flex-col md:flex-row items-center justify-between gap-4 shadow-xl">
            <div class="flex items-center gap-4">
                <!-- <div class="w-12 h-12 bg-blue-50 text-blue-900 rounded-xl flex items-center justify-center border border-blue-200 shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                </div> -->
                <div>
                    <h1 class="text-sm font-black text-slate-950 uppercase tracking-wider leading-tight max-w-[200px] truncate">KURSUS AHLI LEMBAGA PENGARAH BADAN BERKANUN NEGERI DAN SYARIKAT KERAJAAN NEGERI 2026</h1>
                    <p class="text-slate-600 text-xs font-semibold mt-1.5 uppercase">Dashboard Pemantauan Admin</p>
                </div>
            </div>
            
            <div class="flex items-center gap-3">
                <!-- Burger Button -->
                <button onclick="toggleAdminDrawer(true)" class="w-10 h-10 bg-slate-100 hover:bg-slate-200 active:scale-[0.95] rounded-xl flex items-center justify-center border border-slate-200 transition-all duration-200 cursor-pointer text-slate-900" title="Menu Navigasi">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </header>

        <!-- Flash Message -->
        @if (session('success'))
            <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-xl text-sm font-bold flex items-center gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                {{ session('success') }}
            </div>
        @endif

        <!-- Global Session Control Card -->
        <div class="bg-slate-900 text-white rounded-2xl shadow-xl p-5 flex flex-col md:flex-row items-center justify-between gap-4 border border-blue-800/50 relative overflow-hidden">
            <!-- Decorative background elements -->
            <div class="absolute -right-10 -top-10 w-40 h-40 bg-blue-600/20 rounded-full blur-3xl pointer-events-none"></div>
            
            <div class="flex items-center gap-4 relative z-10">
                <div class="w-12 h-12 bg-blue-800/80 rounded-xl flex items-center justify-center border border-blue-600/50 shadow-inner">
                    <svg class="w-6 h-6 text-blue-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <h2 class="text-sm font-black tracking-wider uppercase text-blue-100 mb-0.5">Kawalan Sesi Global</h2>
                    <p class="text-xs text-blue-300 font-semibold">Sesi lalai semasa untuk semua peserta: <span class="text-white font-black bg-blue-800/50 px-2 py-0.5 rounded ml-1">{{ \Illuminate\Support\Facades\Cache::get('global_active_session', 'HARI_1') == 'HARI_1' ? 'HARI 1' : 'HARI 2' }}</span></p>
                </div>
            </div>
            
            <form action="{{ route('admin.settings.toggle-session') }}" method="POST" class="flex bg-slate-800/80 p-1.5 rounded-xl border border-slate-700/50 shadow-inner relative z-10 w-full md:w-auto">
                @csrf
                @php $globalSession = \Illuminate\Support\Facades\Cache::get('global_active_session', 'HARI_1'); @endphp
                <button type="submit" name="session" value="HARI_1" class="flex-1 md:flex-none px-6 py-2 text-xs font-bold uppercase tracking-wider rounded-lg transition-all duration-200 {{ $globalSession === 'HARI_1' ? 'bg-blue-600 text-white shadow-md border border-blue-500' : 'text-slate-400 hover:text-white hover:bg-slate-700/50 border border-transparent' }}">Hari 1</button>
                <button type="submit" name="session" value="HARI_2" class="flex-1 md:flex-none px-6 py-2 text-xs font-bold uppercase tracking-wider rounded-lg transition-all duration-200 {{ $globalSession === 'HARI_2' ? 'bg-blue-600 text-white shadow-md border border-blue-500' : 'text-slate-400 hover:text-white hover:bg-slate-700/50 border border-transparent' }}">Hari 2</button>
            </form>
        </div>

        <!-- Dynamic Day Tabs -->
        <div class="bg-white border border-slate-200 shadow-md p-1.5 rounded-2xl border border-slate-200 flex max-w-md mx-auto shadow-inner">
            <a href="{{ route('admin.dashboard', ['day' => 'HARI_1']) }}" 
               class="flex-1 py-3 text-center text-xs font-bold rounded-xl transition-all duration-300 flex items-center justify-center gap-2 {{ $sessionName === 'HARI_1' ? 'bg-blue-900 text-white border border-blue-200 shadow-md' : 'text-slate-500 hover:text-slate-900' }} uppercase tracking-wider">
                Hari 1
            </a>
            <a href="{{ route('admin.dashboard', ['day' => 'HARI_2']) }}" 
               class="flex-1 py-3 text-center text-xs font-bold rounded-xl transition-all duration-300 flex items-center justify-center gap-2 {{ $sessionName === 'HARI_2' ? 'bg-blue-900 text-white border border-blue-200 shadow-md' : 'text-slate-500 hover:text-slate-900' }} uppercase tracking-wider">
                Hari 2
            </a>
        </div>

        <!-- Metrics Grid (Counts inside clean grid layouts using massive, high-visibility numbers) -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Total Registered -->
            <div class="bg-white border border-slate-200 shadow-md p-6 rounded-2xl border border-slate-200 shadow-lg flex items-center justify-between">
                <div class="space-y-2">
                    <p class="text-slate-500 font-bold text-xs uppercase tracking-widest">VIP Berdaftar</p>
                    <p class="text-5xl font-black text-slate-950 leading-none">{{ $totalRegistered }}</p>
                    <p class="text-slate-500 text-xs font-semibold">Jumlah ahli Lembaga Pengarah berdaftar</p>
                </div>
                <div class="w-12 h-12 bg-white text-slate-500 rounded-xl flex items-center justify-center border border-slate-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
            </div>

            <!-- Present -->
            <div class="bg-white border border-slate-200 shadow-md p-6 rounded-2xl border border-green-300 shadow-lg flex items-center justify-between">
                <div class="space-y-2">
                    <p class="text-green-700 font-bold text-xs uppercase tracking-widest">Hadir</p>
                    <div class="flex items-baseline gap-2">
                        <span class="text-5xl font-black text-green-700 leading-none">{{ $totalPresent }}</span>
                        <span class="bg-green-100 text-green-800 border border-green-300 px-2 py-0.5 rounded text-[10px] font-bold">
                            {{ $totalRegistered > 0 ? number_format(($totalPresent / $totalRegistered) * 100, 0) : 0 }}%
                        </span>
                    </div>
                    <p class="text-slate-500 text-xs font-semibold">Telah mengimbas kehadiran</p>
                </div>
                <div class="w-12 h-12 bg-green-100 text-green-700 rounded-xl flex items-center justify-center border border-green-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>

            <!-- Absent -->
            <div class="bg-white border border-slate-200 shadow-md p-6 rounded-2xl border border-red-300 shadow-lg flex items-center justify-between">
                <div class="space-y-2">
                    <p class="text-red-700 font-bold text-xs uppercase tracking-widest">Belum Hadir</p>
                    <div class="flex items-baseline gap-2">
                        <span class="text-5xl font-black text-red-700 leading-none">{{ $totalAbsent }}</span>
                        <span class="bg-red-100 text-red-800 border border-red-300 px-2 py-0.5 rounded text-[10px] font-bold">
                            {{ $totalRegistered > 0 ? number_format(($totalAbsent / $totalRegistered) * 100, 0) : 0 }}%
                        </span>
                    </div>
                    <p class="text-slate-500 text-xs font-semibold">Menunggu pendaftaran kehadiran</p>
                </div>
                <div class="w-12 h-12 bg-red-100 text-red-700 rounded-xl flex items-center justify-center border border-red-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Attendance Rate Progress Bar -->
        <div class="bg-white border border-slate-200 shadow-md rounded-2xl border border-slate-200 p-6 shadow-lg space-y-3">
            <div class="flex justify-between items-center text-xs">
                <span class="font-bold text-slate-950 uppercase tracking-wider">Kadar Kehadiran Sesi</span>
                <span class="font-black text-blue-900">
                    {{ $totalRegistered > 0 ? number_format(($totalPresent / $totalRegistered) * 100, 1) : 0 }}%
                </span>
            </div>
            <div class="w-full bg-slate-50 rounded-full h-3 overflow-hidden border border-slate-200">
                <div class="bg-blue-500 h-full rounded-full transition-all duration-1000 ease-out" 
                     style="width: {{ $totalRegistered > 0 ? ($totalPresent / $totalRegistered) * 100 : 0 }}%">
                </div>
            </div>
        </div>

        <!-- Lists Container -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            
            <!-- Present List -->
            <div class="bg-white border border-slate-200 shadow-md rounded-2xl border border-slate-200 shadow-xl overflow-hidden flex flex-col">
                <div class="p-6 border-b border-slate-200 bg-slate-50 border-b border-slate-200 flex items-center justify-between">
                    <h3 class="text-sm font-bold text-slate-950 uppercase tracking-wider">Senarai Hadir ({{ $totalPresent }})</h3>
                    <span class="bg-green-100 text-green-800 border border-green-300 px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider">Hadir</span>
                </div>
                
                <div class="p-6 overflow-y-auto max-h-[500px] space-y-4">
                    @forelse ($presentUsers as $user)
                        <div class="bg-slate-50 border border-slate-200 shadow-sm border border-slate-200/60 rounded-xl p-4 flex justify-between items-start gap-4 hover:border-slate-200 transition duration-200">
                            <div class="space-y-1 min-w-0">
                                <h4 class="text-slate-950 font-bold truncate text-sm">{{ $user->name }}</h4>
                                <p class="text-slate-600 text-xs font-semibold truncate">{{ $user->position }}</p>
                                <p class="text-slate-500 text-[10px] font-semibold truncate">{{ $user->agency }}</p>
                            </div>
                            <div class="flex flex-col items-end gap-1.5 shrink-0">
                                @php
                                    $attendance = $user->attendances->firstWhere('session_name', $sessionName);
                                @endphp
                                @if ($attendance && $attendance->scanned_at)
                                    <span class="text-green-800 bg-green-100 border border-green-300 px-2 py-0.5 rounded text-[9px] font-bold tracking-wider uppercase flex items-center gap-1">
                                        {{ $attendance->scanned_at->format('h:i A') }}
                                    </span>
                                @else
                                    <span class="text-green-800 bg-green-100 border border-green-300 px-2 py-0.5 rounded text-[9px] font-bold tracking-wider uppercase">Hadir</span>
                                @endif
                                <span class="text-[10px] text-slate-450 font-mono font-semibold">{{ $user->phone_number }}</span>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-12 text-slate-500">
                            <p class="font-bold text-xs text-slate-500 uppercase tracking-wider">Tiada rekod kehadiran</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Absent List -->
            <div class="bg-white border border-slate-200 shadow-md rounded-2xl border border-slate-200 shadow-xl overflow-hidden flex flex-col">
                <div class="p-6 border-b border-slate-200 bg-slate-50 border-b border-slate-200 flex items-center justify-between">
                    <h3 class="text-sm font-bold text-slate-950 uppercase tracking-wider">Senarai Belum Hadir ({{ $totalAbsent }})</h3>
                    <span class="bg-red-100 text-red-800 border border-red-300 px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider">Belum Hadir</span>
                </div>
                
                <div class="p-6 overflow-y-auto max-h-[500px] space-y-4">
                    @forelse ($absentUsers as $user)
                        <div class="bg-slate-50 border border-slate-200 shadow-sm border border-slate-200/60 rounded-xl p-4 flex justify-between items-start gap-4 hover:border-slate-200 transition duration-200">
                            <div class="space-y-1 min-w-0">
                                <h4 class="text-slate-950 font-bold truncate text-sm">{{ $user->name }}</h4>
                                <p class="text-slate-355 text-xs font-semibold truncate">{{ $user->position }}</p>
                                <p class="text-slate-500 text-[10px] font-semibold truncate">{{ $user->agency }}</p>
                            </div>
                            <div class="flex flex-col items-end gap-1.5 shrink-0">
                                <span class="text-slate-450 text-[10px] font-mono font-semibold">{{ $user->phone_number }}</span>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-12 text-slate-500">
                            <p class="font-bold text-xs text-slate-500 uppercase tracking-wider">Semua VIP telah hadir</p>
                        </div>
                    @endforelse
                </div>
            </div>

        </div>

    </div>

    <!-- Burger Drawer Backdrop -->
    <div id="admin-drawer-backdrop" class="fixed inset-0 z-[100] bg-slate-900/50 backdrop-blur-sm hidden transition-opacity duration-300 opacity-0"></div>

    <!-- Burger Drawer Sidebar -->
    <div id="admin-drawer" class="fixed top-0 right-0 z-[110] h-full w-80 bg-white border-l border-slate-200 shadow-2xl p-6 flex flex-col justify-between transform translate-x-full transition-transform duration-300 ease-in-out">
        <div class="space-y-6">
            <!-- Drawer Header -->
            <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                <div>
                    <h3 class="text-xs font-bold text-slate-400 uppercase tracking-widest">Menu Pentadbir</h3>
                    <div class="flex items-center gap-2 mt-1.5">
                        <span class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></span>
                        <span class="text-sm font-extrabold text-slate-950">{{ Auth::user()->name ?? 'Super Admin' }}</span>
                    </div>
                </div>
                <button onclick="toggleAdminDrawer(false)" class="w-8 h-8 rounded-lg bg-slate-100 hover:bg-rose-100 hover:text-rose-600 flex items-center justify-center text-slate-500 transition-colors cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Navigation Links -->
            <nav class="flex flex-col gap-2">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-bold transition-all bg-blue-50 text-blue-900 border border-blue-100">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" /></svg>
                    Dashboard
                </a>
                
                <a href="{{ route('admin.users.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-bold transition-all text-slate-600 hover:bg-slate-50 hover:text-slate-900">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                    Urus Pengguna
                </a>

                <a href="{{ route('admin.attendance.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-bold transition-all text-slate-600 hover:bg-slate-50 hover:text-slate-900">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2" /></svg>
                    Kehadiran
                </a>

                <a href="{{ route('admin.evaluation.analytics') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-bold transition-all text-slate-600 hover:bg-slate-50 hover:text-slate-900">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z" /><path stroke-linecap="round" stroke-linejoin="round" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z" /></svg>
                    Analitik Penilaian
                </a>

                @if(Auth::user()->hasRole('jawatankuasa'))
                <a href="{{ route('secretariat.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-bold text-slate-600 hover:bg-slate-50 hover:text-slate-900 transition-all border border-transparent">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h.01M16 12h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    Mod Urus Setia
                </a>
                @endif
            </nav>
        </div>

        <!-- Drawer Footer -->
        <div class="border-t border-slate-100 pt-4">
            <form action="{{ route('logout') }}" method="POST" class="w-full">
                @csrf
                <button type="submit" class="flex items-center justify-center gap-2 w-full bg-rose-600 hover:bg-rose-500 active:scale-[0.98] text-white py-3 rounded-xl border border-red-300 text-xs font-bold shadow-md transition-all cursor-pointer uppercase tracking-wider">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
                    Log Keluar
                </button>
            </form>
        </div>
    </div>

    <!-- Drawer Logic -->
    <script>
        function toggleAdminDrawer(show) {
            const backdrop = document.getElementById('admin-drawer-backdrop');
            const drawer = document.getElementById('admin-drawer');
            if (!backdrop || !drawer) return;

            if (show) {
                backdrop.classList.remove('hidden');
                setTimeout(() => backdrop.classList.remove('opacity-0'), 20);
                drawer.classList.remove('translate-x-full');
                document.body.style.overflow = 'hidden';
            } else {
                backdrop.classList.add('opacity-0');
                drawer.classList.add('translate-x-full');
                document.body.style.overflow = '';
                setTimeout(() => backdrop.classList.add('hidden'), 300);
            }
        }

        // Close on backdrop click
        document.getElementById('admin-drawer-backdrop').addEventListener('click', () => toggleAdminDrawer(false));
    </script>
</body>
</html>
