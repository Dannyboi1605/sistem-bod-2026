<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Panel Pemantauan Kehadiran Admin - KURSUS AHLI LEMBAGA PENGARAH BADAN BERKANUN NEGERI DAN SYARIKAT KERAJAAN NEGERI 2026</title>
    <!-- Google Fonts Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 text-slate-950 min-h-screen p-4 md:p-8">
    <div class="max-w-7xl mx-auto space-y-6">
        
        <!-- Header -->
        <header class="bg-white rounded-2xl border border-slate-200 p-6 flex flex-col md:flex-row items-center justify-between gap-4 shadow-sm">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-blue-50 text-blue-900 rounded-xl flex items-center justify-center border border-blue-100 shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                </div>
                <div>
                    <h1 class="text-sm font-black text-slate-950 uppercase tracking-wider leading-tight max-w-[200px] truncate">KURSUS AHLI LEMBAGA PENGARAH BADAN BERKANUN NEGERI DAN SYARIKAT KERAJAAN NEGERI 2026</h1>
                    <p class="text-slate-500 text-xs font-semibold mt-1.5 uppercase">Dashboard & Urus Kehadiran</p>
                </div>
            </div>
            
            <div class="flex items-center gap-3 w-full md:w-auto">
                <button onclick="toggleModal('create-modal', true)" 
                        class="flex-1 md:flex-initial flex items-center justify-center gap-2 bg-blue-900 hover:bg-blue-800 active:scale-[0.98] text-white px-5 py-3.5 rounded-xl border border-blue-400/20 text-xs font-bold shadow-md transition-all duration-200 cursor-pointer uppercase tracking-wider">
                    Tambah Kehadiran
                </button>
                <!-- Burger Button -->
                <button onclick="toggleAdminDrawer(true)" class="w-10 h-10 bg-slate-100 hover:bg-slate-200 active:scale-[0.95] rounded-xl flex items-center justify-center border border-slate-200 transition-all duration-200 cursor-pointer text-slate-900" title="Menu Navigasi">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </header>

        <!-- Flash Messages -->
        @if (session('success'))
            <div class="bg-green-100 border border-green-300 text-green-800 p-4 rounded-xl flex items-center gap-3 shadow-lg">
                <span class="font-bold text-sm">{{ session('success') }}</span>
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-100 border border-red-300 text-red-800 p-4 rounded-xl flex items-center gap-3 shadow-lg">
                <span class="font-bold text-sm">{{ session('error') }}</span>
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-red-100 border border-red-300 text-rose-600 p-4 rounded-xl shadow-lg space-y-1">
                <span class="font-extrabold text-sm block text-rose-700">Terdapat ralat pada borang pendaftaran:</span>
                <ul class="list-disc pl-5 text-xs font-semibold space-y-0.5 text-rose-700">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Session Tabs -->
        <div class="bg-white p-1.5 rounded-2xl border border-slate-200 flex max-w-md mx-auto shadow-sm">
            <a href="{{ route('admin.attendance.index', ['session' => 'HARI_1']) }}" 
               class="flex-1 py-3 text-center text-xs font-bold rounded-xl transition-all duration-300 flex items-center justify-center gap-2 {{ $sessionName === 'HARI_1' ? 'bg-blue-900 text-white shadow-md' : 'text-slate-500 hover:text-slate-700 hover:bg-slate-50' }} uppercase tracking-wider">
                Hari 1
            </a>
            <a href="{{ route('admin.attendance.index', ['session' => 'HARI_2']) }}" 
               class="flex-1 py-3 text-center text-xs font-bold rounded-xl transition-all duration-300 flex items-center justify-center gap-2 {{ $sessionName === 'HARI_2' ? 'bg-blue-900 text-white shadow-md' : 'text-slate-500 hover:text-slate-700 hover:bg-slate-50' }} uppercase tracking-wider">
                Hari 2
            </a>
        </div>

        <!-- Metrics Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Total Registered -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between">
                <div class="space-y-2">
                    <p class="text-slate-500 font-bold text-xs uppercase tracking-widest">Jumlah Peserta</p>
                    <p class="text-5xl font-black text-slate-950 leading-none">{{ $totalRegistered }}</p>
                </div>
            </div>

            <!-- Present -->
            <div class="bg-white p-6 rounded-2xl border border-green-200 shadow-sm flex items-center justify-between">
                <div class="space-y-2">
                    <p class="text-green-700 font-bold text-xs uppercase tracking-widest">Jumlah Hadir</p>
                    <div class="flex items-baseline gap-2">
                        <span class="text-5xl font-black text-green-700 leading-none">{{ $totalPresent }}</span>
                        <span class="bg-green-100 text-green-800 px-2 py-0.5 rounded text-[10px] font-bold">
                            {{ $totalRegistered > 0 ? number_format(($totalPresent / $totalRegistered) * 100, 0) : 0 }}%
                        </span>
                    </div>
                </div>
            </div>

            <!-- Absent -->
            <div class="bg-white p-6 rounded-2xl border border-red-200 shadow-sm flex items-center justify-between">
                <div class="space-y-2">
                    <p class="text-red-700 font-bold text-xs uppercase tracking-widest">Jumlah Tak Hadir</p>
                    <div class="flex items-baseline gap-2">
                        <span class="text-5xl font-black text-red-700 leading-none">{{ $totalAbsent }}</span>
                        <span class="bg-red-100 text-red-800 px-2 py-0.5 rounded text-[10px] font-bold">
                            {{ $totalRegistered > 0 ? number_format(($totalAbsent / $totalRegistered) * 100, 0) : 0 }}%
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter Panel -->
        <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm mb-6">
            <form action="{{ route('admin.attendance.index') }}" method="GET" class="flex flex-col sm:flex-row items-end gap-4">
                <input type="hidden" name="session" value="{{ $sessionName }}">
                
                <!-- Search Filter -->
                <div class="w-full sm:w-1/3">
                    <label for="search" class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-2">Cari Peserta</label>
                    <div class="relative">
                        <svg xmlns="http://www.w3.org/2000/svg" class="absolute left-3.5 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-400 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        <input type="text" name="search" id="search" value="{{ $search ?? '' }}" placeholder="Nama / Agensi..." class="w-full bg-slate-50 border border-slate-200 text-slate-900 text-sm font-semibold rounded-xl focus:ring-blue-500 focus:border-blue-500 pl-10 pr-4 py-3.5 transition-colors">
                    </div>
                </div>

                <!-- Agency Filter -->
                <div class="w-full sm:w-1/3">
                    <label for="agency" class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-2">Tapis Agensi</label>
                    <select name="agency" id="agency" class="w-full bg-slate-50 border border-slate-200 text-slate-900 text-sm font-semibold rounded-xl focus:ring-blue-500 focus:border-blue-500 block p-3.5 transition-colors">
                        <option value="all" {{ $filterAgency === 'all' ? 'selected' : '' }}>Semua Agensi</option>
                        @foreach($agencies as $agency)
                            <option value="{{ $agency }}" {{ $filterAgency === $agency ? 'selected' : '' }}>{{ $agency }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Status Filter -->
                <div class="w-full sm:w-1/4">
                    <label for="status" class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-2">Tapis Status</label>
                    <select name="status" id="status" class="w-full bg-slate-50 border border-slate-200 text-slate-900 text-sm font-semibold rounded-xl focus:ring-blue-500 focus:border-blue-500 block p-3.5 transition-colors">
                        <option value="all" {{ $filterStatus === 'all' ? 'selected' : '' }}>Semua Status</option>
                        <option value="hadir" {{ $filterStatus === 'hadir' ? 'selected' : '' }}>Hadir Saja</option>
                        <option value="tidak_hadir" {{ $filterStatus === 'tidak_hadir' ? 'selected' : '' }}>Tidak Hadir Saja</option>
                    </select>
                </div>

                <!-- Buttons -->
                <div class="flex gap-2 w-full sm:w-auto">
                    <button type="submit" class="flex-1 sm:flex-none bg-blue-900 hover:bg-blue-800 text-white px-6 py-3.5 rounded-xl text-xs font-bold transition-colors shadow-sm uppercase tracking-wider border border-blue-800">
                        Tapis
                    </button>
                    @if($filterAgency !== 'all' || $filterStatus !== 'all' || !empty($search))
                        <a href="{{ route('admin.attendance.index', ['session' => $sessionName]) }}" class="flex-1 sm:flex-none text-center bg-slate-100 hover:bg-slate-200 text-slate-600 px-6 py-3.5 rounded-xl text-xs font-bold transition-colors shadow-sm uppercase tracking-wider border border-slate-200">
                            Padam
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Export Panel -->
        <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm flex flex-col sm:flex-row items-center justify-between gap-4 mb-6">
            <div>
                <h3 class="text-sm font-bold text-slate-950 uppercase tracking-wider">Eksport Laporan (PDF)</h3>
                <p class="text-slate-500 text-xs">Muat turun laporan kehadiran mengikut agensi yang ditapis di atas.</p>
            </div>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('admin.attendance.export-pdf', ['status' => 'all', 'session' => $sessionName, 'agency' => $filterAgency]) }}"
                   class="bg-blue-900 hover:bg-blue-800 text-white px-4 py-2 rounded-xl text-xs font-bold transition-colors shadow-sm uppercase tracking-wider">
                    Eksport Semua
                </a>
                <a href="{{ route('admin.attendance.export-pdf', ['status' => 'hadir', 'session' => $sessionName, 'agency' => $filterAgency]) }}"
                   class="bg-blue-900 hover:bg-blue-800 text-white px-4 py-2 rounded-xl text-xs font-bold transition-colors shadow-sm uppercase tracking-wider">
                    Eksport Hadir
                </a>
                <a href="{{ route('admin.attendance.export-pdf', ['status' => 'tidak_hadir', 'session' => $sessionName, 'agency' => $filterAgency]) }}"
                   class="bg-blue-900 hover:bg-blue-800 text-white px-4 py-2 rounded-xl text-xs font-bold transition-colors shadow-sm uppercase tracking-wider">
                    Eksport Tak Hadir
                </a>
            </div>
        </div>

        <!-- Agency Lists -->
        <div class="space-y-6">
            @forelse($groupedByAgency as $agency => $users)
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="bg-slate-50 px-6 py-4 border-b border-slate-200 flex justify-between items-center">
                    <h4 class="text-sm font-black text-slate-950 uppercase tracking-wider">{{ $agency }}</h4>
                    <span class="bg-slate-200 text-slate-700 px-2.5 py-1 rounded-full text-[10px] font-bold">{{ $users->count() }} Peserta</span>
                </div>
                <div class="divide-y divide-slate-100">
                    @foreach($users as $index => $user)
                        @php
                            $attendance = $user->attendances->firstWhere('session_name', $sessionName);
                        @endphp
                        <div id="attendance-row-{{ $attendance ? $attendance->id : 'none-'.$user->id }}" class="p-4 sm:px-6 flex flex-col sm:flex-row justify-between sm:items-center gap-4 hover:bg-slate-50 transition-colors">
                            <div class="flex gap-4 items-start">
                                <span class="text-slate-400 font-bold text-sm w-6">{{ $index + 1 }}.</span>
                                <div>
                                    <p class="text-sm font-bold text-slate-950">{{ $user->name }}</p>
                                    <p class="text-xs text-slate-500">{{ $user->position }}</p>
                                </div>
                            </div>
                            <div class="sm:text-right shrink-0 flex items-center justify-end gap-3">
                                @if($attendance && $attendance->scanned_at)
                                    <span class="inline-flex items-center gap-1.5 bg-green-100 text-green-900 border border-green-300 px-3 py-1 rounded-lg text-xs font-bold">
                                        <span class="w-1.5 h-1.5 bg-green-600 rounded-full"></span>
                                        Hadir &middot; {{ \Carbon\Carbon::parse($attendance->scanned_at)->format('h:i A') }}
                                    </span>
                                    
                                    <!-- Edit Button -->
                                    <button onclick='openEditModal(@json($attendance))' class="w-8 h-8 bg-slate-50 hover:bg-white active:scale-[0.90] text-slate-950 hover:text-slate-950 rounded-lg flex items-center justify-center border border-slate-200 transition-all cursor-pointer" title="Kemaskini">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </button>
                                    
                                    <!-- Delete Button (AJAX) -->
                                    <button onclick="deleteAttendance({{ $attendance->id }}, '{{ addslashes($user->name) }}')" class="w-8 h-8 bg-red-100 hover:bg-rose-600 text-red-700 hover:text-white rounded-lg flex items-center justify-center border border-red-300 transition-all cursor-pointer" title="Padam">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                @else
                                    <span class="inline-flex items-center gap-1.5 bg-red-100 text-red-900 border border-red-300 px-3 py-1 rounded-lg text-xs font-bold">
                                        <span class="w-1.5 h-1.5 bg-red-600 rounded-full"></span>
                                        Tidak Hadir
                                    </span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            @empty
            <div class="bg-white rounded-2xl border border-slate-200 p-8 text-center shadow-sm">
                <p class="text-slate-500 font-bold">Tiada data peserta dijumpai.</p>
            </div>
            @endforelse
        </div>

    </div>

    <!-- Create Attendance Modal -->
    <div id="create-modal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-50/80 backdrop-blur-sm hidden transition-opacity duration-300">
        <div class="bg-white border border-slate-200 shadow-md border border-slate-200 rounded-2xl w-full max-w-lg shadow-2xl overflow-hidden transform transition-all duration-300">
            <div class="p-6 border-b border-slate-200 flex items-center justify-between">
                <h3 class="text-sm font-bold text-slate-950 uppercase tracking-wider">
                    Tambah Rekod Kehadiran
                </h3>
                <button onclick="toggleModal('create-modal', false)" class="text-slate-500 hover:text-slate-950 cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            
            <form action="{{ route('admin.attendance.store') }}" method="POST" class="p-6 space-y-4">
                @csrf
                <div class="space-y-2">
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-500">Nama Peserta</label>
                    <select name="user_id" required class="w-full bg-white border border-slate-200 focus:border-blue-500 focus:ring-blue-500/20 text-slate-950 rounded-xl px-4 py-3.5 text-sm font-semibold focus:outline-none focus:ring-4 transition-all duration-200">
                        <option value="">Pilih Peserta...</option>
                        @foreach($participants as $p)
                            <option value="{{ $p->id }}">{{ $p->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="space-y-2">
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-500">Sesi</label>
                    <select name="session_name" required class="w-full bg-white border border-slate-200 focus:border-blue-500 focus:ring-blue-500/20 text-slate-950 rounded-xl px-4 py-3.5 text-sm font-semibold focus:outline-none focus:ring-4 transition-all duration-200">
                        <option value="HARI_1" {{ $sessionName == 'HARI_1' ? 'selected' : '' }}>HARI 1</option>
                        <option value="HARI_2" {{ $sessionName == 'HARI_2' ? 'selected' : '' }}>HARI 2</option>
                    </select>
                </div>

                <div class="space-y-2">
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-500">Waktu Imbas (Pilihan)</label>
                    <input type="datetime-local" name="scanned_at" 
                           class="w-full bg-white border border-slate-200 focus:border-blue-500 focus:ring-blue-500/20 text-slate-950 placeholder-slate-600 rounded-xl px-4 py-3.5 text-sm font-semibold focus:outline-none focus:ring-4 transition-all duration-200">
                    <p class="text-xs text-slate-400 font-semibold">Biarkan kosong untuk gunakan waktu sekarang.</p>
                </div>

                <div class="pt-4 flex items-center justify-end gap-3">
                    <button type="button" onclick="toggleModal('create-modal', false)" 
                            class="px-5 py-3 rounded-xl text-slate-500 hover:text-slate-950 font-bold text-sm transition cursor-pointer">
                        Batal
                    </button>
                    <button type="submit" 
                            class="bg-blue-900 hover:bg-blue-800 active:scale-[0.98] text-white px-6 py-3 rounded-xl font-bold text-sm shadow-md border border-blue-400/20 shadow-blue-950/50 transition-all cursor-pointer">
                        Simpan Rekod
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Attendance Modal -->
    <div id="edit-modal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-50/80 backdrop-blur-sm hidden transition-opacity duration-300">
        <div class="bg-white border border-slate-200 shadow-md border border-slate-200 rounded-2xl w-full max-w-lg shadow-2xl overflow-hidden transform transition-all duration-300">
            <div class="p-6 border-b border-slate-200 flex items-center justify-between">
                <h3 class="text-sm font-bold text-slate-950 uppercase tracking-wider">
                    Kemaskini Rekod Kehadiran
                </h3>
                <button onclick="toggleModal('edit-modal', false)" class="text-slate-500 hover:text-slate-950 cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            
            <form id="edit-form" method="POST" class="p-6 space-y-4">
                @csrf
                @method('PUT')
                
                <div class="space-y-2">
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-500">Nama Peserta</label>
                    <select name="user_id" id="edit-user-id" required class="w-full bg-slate-50 border border-slate-200 focus:border-indigo-500 focus:ring-indigo-500/20 text-slate-950 rounded-xl px-4 py-3.5 text-sm font-semibold focus:outline-none focus:ring-4 transition-all duration-200 pointer-events-none" readonly>
                        @foreach($participants as $p)
                            <option value="{{ $p->id }}">{{ $p->name }}</option>
                        @endforeach
                    </select>
                    <p class="text-[10px] text-slate-400 font-bold uppercase">Peserta tidak boleh ditukar semasa kemaskini.</p>
                </div>

                <div class="space-y-2">
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-500">Sesi</label>
                    <select name="session_name" id="edit-session-name" required class="w-full bg-white border border-slate-200 focus:border-indigo-500 focus:ring-indigo-500/20 text-slate-950 rounded-xl px-4 py-3.5 text-sm font-semibold focus:outline-none focus:ring-4 transition-all duration-200">
                        <option value="HARI_1">HARI 1</option>
                        <option value="HARI_2">HARI 2</option>
                    </select>
                </div>

                <div class="space-y-2">
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-500">Waktu Imbas</label>
                    <input type="datetime-local" name="scanned_at" id="edit-scanned-at"
                           class="w-full bg-white border border-slate-200 focus:border-indigo-500 focus:ring-indigo-500/20 text-slate-950 placeholder-slate-600 rounded-xl px-4 py-3.5 text-sm font-semibold focus:outline-none focus:ring-4 transition-all duration-200">
                </div>

                <div class="pt-4 flex items-center justify-end gap-3">
                    <button type="button" onclick="toggleModal('edit-modal', false)" 
                            class="px-5 py-3 rounded-xl text-slate-500 hover:text-slate-950 font-bold text-sm transition cursor-pointer">
                        Batal
                    </button>
                    <button type="submit" 
                            class="bg-indigo-600 hover:bg-indigo-550 active:scale-[0.98] text-white px-6 py-3 rounded-xl font-bold text-sm shadow-md border border-indigo-400/20 shadow-indigo-950/50 transition-all cursor-pointer">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
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
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-bold transition-all text-slate-600 hover:bg-slate-50 hover:text-slate-900">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" /></svg>
                    Dashboard
                </a>
                
                <a href="{{ route('admin.users.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-bold transition-all text-slate-600 hover:bg-slate-50 hover:text-slate-900">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                    Urus Pengguna
                </a>

                <a href="{{ route('admin.attendance.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-bold transition-all bg-blue-50 text-blue-900 border border-blue-100">
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

    <!-- Scripts Logic -->
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

        document.getElementById('admin-drawer-backdrop').addEventListener('click', () => toggleAdminDrawer(false));

        // Modal Logic
        function toggleModal(modalId, show) {
            const modal = document.getElementById(modalId);
            if (show) {
                modal.classList.remove('hidden');
                setTimeout(() => {
                    modal.classList.remove('opacity-0');
                }, 20);
            } else {
                modal.classList.add('opacity-0');
                setTimeout(() => {
                    modal.classList.add('hidden');
                }, 300);
            }
        }

        function openEditModal(attendance) {
            const form = document.getElementById('edit-form');
            form.action = `/admin/attendance-records/${attendance.id}`;

            document.getElementById('edit-user-id').value = attendance.user_id;
            document.getElementById('edit-session-name').value = attendance.session_name;
            
            if (attendance.scanned_at) {
                // Remove the timezone suffix for datetime-local
                let dateStr = attendance.scanned_at;
                if (dateStr.includes('T')) {
                    dateStr = dateStr.slice(0, 16);
                } else {
                    dateStr = dateStr.replace(' ', 'T').slice(0, 16);
                }
                document.getElementById('edit-scanned-at').value = dateStr;
            } else {
                document.getElementById('edit-scanned-at').value = '';
            }

            toggleModal('edit-modal', true);
        }

        // Close modal when clicking on backdrop
        window.addEventListener('click', function(e) {
            const createModal = document.getElementById('create-modal');
            const editModal = document.getElementById('edit-modal');
            
            if (e.target === createModal) toggleModal('create-modal', false);
            if (e.target === editModal) toggleModal('edit-modal', false);
        });

        // SweetAlert Delete Logic
        function deleteAttendance(id, participantName) {
            Swal.fire({
                title: 'Pengesahan',
                text: `Adakah anda pasti mahu memadam rekod kehadiran untuk ${participantName}?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#1e3a8a', // blue-900
                cancelButtonColor: '#64748b', // slate-500
                confirmButtonText: 'Ya, Padam!',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    // Show loading
                    Swal.fire({
                        title: 'Memproses...',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    fetch(`/admin/attendance-records/${id}`, {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'X-Requested-With': 'XMLHttpRequest',
                        },
                    })
                    .then(r => {
                        if (!r.ok) throw new Error('Gagal memadam rekod.');
                        return r.json();
                    })
                    .then(data => {
                        if (data.success) {
                            const row = document.getElementById(`attendance-row-${id}`);
                            if(row) {
                                // Add a fade out transition before removing
                                row.classList.add('opacity-0', 'transition-opacity', 'duration-300');
                                setTimeout(() => row.remove(), 300);
                            }
                            Swal.fire('Berjaya!', data.message, 'success').then(() => {
                                // Optional: reload page to update counters if needed
                                window.location.reload();
                            });
                        }
                    })
                    .catch(err => {
                        console.error(err);
                        Swal.fire('Ralat!', 'Tidak dapat memadam rekod kehadiran.', 'error');
                    });
                }
            });
        }
    </script>
</body>
</html>
