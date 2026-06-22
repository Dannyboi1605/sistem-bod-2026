<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Analitik Penilaian Program - KURSUS AHLI LEMBAGA PENGARAH BADAN BERKANUN NEGERI DAN SYARIKAT KERAJAAN NEGERI 2026</title>
    <!-- Google Fonts Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 text-slate-950 min-h-screen p-4 md:p-8">

    <div class="max-w-7xl mx-auto space-y-6">
        
        <!-- Header -->
        <header class="bg-white border border-slate-200 shadow-md backdrop-blur-md rounded-2xl border border-slate-200 p-6 flex flex-col md:flex-row items-center justify-between gap-4 shadow-xl">
            <div class="flex items-center gap-4">
                <div>
                    <h1 class="text-xl font-black text-slate-950 uppercase tracking-wider leading-none">Analitik Penilaian</h1>
                    <p class="text-slate-600 text-xs font-semibold mt-1.5 uppercase">KURSUS AHLI LEMBAGA PENGARAH BADAN BERKANUN NEGERI DAN SYARIKAT KERAJAAN NEGERI 2026</p>
                </div>
            </div>
            
            <div class="flex flex-wrap items-center gap-3 w-full md:w-auto justify-end">
                <!-- Total Response Badge -->
                <div class="flex items-center gap-2 bg-white shadow-sm px-4 py-2.5 rounded-xl border border-slate-200">
                    <span class="text-xs font-bold text-slate-950 uppercase tracking-wider">Respons:</span>
                    <span class="bg-blue-50 text-blue-900 border border-blue-200 px-2.5 py-0.5 rounded-full text-xs font-black">{{ $totalResponses }}</span>
                </div>
                
                <!-- CSV Export Button -->
                <a href="{{ route('admin.evaluation.export') }}" 
                   class="flex-1 md:flex-initial flex items-center justify-center gap-2 bg-emerald-600 hover:bg-emerald-500 active:scale-[0.98] text-white px-4 py-2.5 rounded-xl border border-emerald-500/30 text-xs font-bold shadow-md transition-all duration-200 uppercase tracking-wider">
                    Muat Turun CSV
                </a>

                <!-- Burger Button -->
                <button onclick="toggleAdminDrawer(true)" class="w-10 h-10 bg-slate-100 hover:bg-slate-200 active:scale-[0.95] rounded-xl flex items-center justify-center border border-slate-200 transition-all duration-200 cursor-pointer text-slate-900" title="Menu Navigasi">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </header>

        <!-- Session Flash Messages -->
        @if (session('success'))
            <div class="bg-green-100 border border-green-300 text-green-800 p-4 rounded-2xl shadow-sm font-bold text-sm">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="bg-red-100 border border-red-300 text-red-800 p-4 rounded-2xl shadow-sm font-bold text-sm">
                {{ session('error') }}
            </div>
        @endif

        <!-- Toggle Access Card -->
        <div class="bg-white border border-slate-200 shadow-md backdrop-blur-md rounded-2xl border border-slate-200 p-6 flex flex-col md:flex-row items-center justify-between gap-4 shadow-xl">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center border {{ $isFormOpen ? 'bg-green-100 text-green-700 border-green-300' : 'bg-red-100 text-red-700 border-red-300' }}">
                    @if ($isFormOpen)
                        <!-- Unlocked/Open icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 11V7a4 4 0 118 0m-4 8v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2z" />
                        </svg>
                    @else
                        <!-- Locked/Closed icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    @endif
                </div>
                <div>
                    <h2 class="text-sm font-bold text-slate-950 uppercase tracking-wider">Status Akses Borang Penilaian</h2>
                    <p class="text-xs font-semibold mt-1 text-slate-600">
                        Status Semasa: 
                        <span class="px-2 py-0.5 rounded-md text-[10px] font-black tracking-widest {{ $isFormOpen ? 'bg-green-100 text-green-800 border border-green-300' : 'bg-red-100 text-red-800 border border-red-300' }}">
                            {{ $isFormOpen ? 'TERBUKA' : 'TERKUNCI' }}
                        </span>
                    </p>
                </div>
            </div>
            
            <form action="{{ route('admin.evaluation.toggle') }}" method="POST" class="w-full md:w-auto">
                @csrf
                <input type="hidden" name="status" value="{{ $isFormOpen ? 'close' : 'open' }}">
                <button type="submit" class="w-full md:w-auto cursor-pointer font-extrabold text-xs px-6 py-3.5 rounded-xl transition-all duration-200 shadow-md border {{ $isFormOpen ? 'bg-rose-600 hover:bg-rose-500 text-white border-rose-500/30' : 'bg-emerald-600 hover:bg-emerald-500 text-white border-emerald-500/30' }} uppercase tracking-wider">
                    {{ $isFormOpen ? 'TUTUP AKSES BORANG' : 'BUKA AKSES BORANG' }}
                </button>
            </form>
        </div>

        <!-- Summary Metrics -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white border border-slate-200 shadow-md p-6 rounded-2xl border border-slate-200 shadow-lg flex items-center justify-between">
                <div class="space-y-2">
                    <p class="text-slate-500 font-bold text-xs uppercase tracking-widest">Purata Keseluruhan</p>
                    <p class="text-5xl font-black text-slate-950 leading-none">{{ $eAverage }}<span class="text-sm text-slate-500 font-bold"> / 5</span></p>
                </div>
                <div class="w-12 h-12 bg-amber-100 text-amber-700 rounded-xl flex items-center justify-center border border-amber-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" /></svg>
                </div>
            </div>
            <div class="bg-white border border-slate-200 shadow-md p-6 rounded-2xl border border-slate-200 shadow-lg flex items-center justify-between">
                <div class="space-y-2">
                    <p class="text-slate-500 font-bold text-xs uppercase tracking-widest">Berminat Program Depan</p>
                    <div class="flex items-baseline gap-2">
                        <span class="text-5xl font-black text-slate-950 leading-none">{{ $fInterestedCount }}</span>
                    </div>
                </div>
                <div class="w-12 h-12 bg-indigo-100 text-indigo-700 rounded-xl flex items-center justify-center border border-indigo-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" /></svg>
                </div>
            </div>
            <div class="bg-white border border-slate-200 shadow-md p-6 rounded-2xl border border-slate-200 shadow-lg flex items-center justify-between">
                <div class="space-y-2">
                    <p class="text-slate-500 font-bold text-xs uppercase tracking-widest">Jumlah Borang Lengkap</p>
                    <p class="text-5xl font-black text-slate-950 leading-none">{{ $totalResponses }}</p>
                </div>
                <div class="w-12 h-12 bg-green-100 text-green-700 rounded-xl flex items-center justify-center border border-green-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                </div>
            </div>
        </div>

        <!-- Charts Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            
            <!-- Section B Chart -->
            <div class="bg-white border border-slate-200 shadow-md rounded-2xl border border-slate-200 p-6 shadow-xl">
                <div class="flex items-center gap-3 mb-6">
                    <h3 class="text-sm font-bold text-slate-950 uppercase tracking-wider">Purata Skor Penilaian Umum</h3>
                </div>
                <div class="relative" style="height: 320px;">
                    <canvas id="chartSectionB"></canvas>
                </div>
            </div>

            <!-- Section C Chart -->
            <div class="bg-white border border-slate-200 shadow-md rounded-2xl border border-slate-200 p-6 shadow-xl">
                <div class="flex items-center gap-3 mb-6">
                    <h3 class="text-sm font-bold text-slate-950 uppercase tracking-wider">Purata Skor Penceramah</h3>
                </div>
                <div class="relative" style="height: 320px;">
                    <canvas id="chartSectionC"></canvas>
                </div>
            </div>

            <!-- Section E Chart -->
            <div class="bg-white border border-slate-200 shadow-md rounded-2xl border border-slate-200 p-6 shadow-xl">
                <div class="flex items-center gap-3 mb-6">
                    <h3 class="text-sm font-bold text-slate-950 uppercase tracking-wider">Taburan Penilaian Keseluruhan</h3>
                </div>
                <div class="relative mx-auto" style="height: 320px; max-width: 320px;">
                    <canvas id="chartSectionE"></canvas>
                </div>
            </div>

            <!-- Detailed Table -->
            <div class="bg-white border border-slate-200 shadow-md rounded-2xl border border-slate-200 p-6 shadow-xl">
                <div class="flex items-center gap-3 mb-6">
                    <h3 class="text-sm font-bold text-slate-950 uppercase tracking-wider">Perincian Skor Penilaian Umum</h3>
                </div>
                <div class="space-y-3">
                    @php
                        $bLabels = [
                            'b1' => 'Objektif program tercapai',
                            'b2' => 'Kandungan sesuai & menepati keperluan',
                            'b3' => 'Tempoh masa mencukupi',
                            'b4' => 'Bahan rujukan berkualiti',
                            'b5' => 'Kaedah penyampaian berkesan',
                            'b6' => 'Memberi manfaat kepada tugas',
                            'b7' => 'Pengetahuan & kemahiran bertambah',
                            'b8' => 'Dapat mengaplikasikan ilmu',
                            'b9' => 'Pengurusan & logistik memuaskan',
                            'b10' => 'Kemudahan tempat & peralatan memuaskan',
                        ];
                    @endphp
                    @foreach ($bLabels as $key => $label)
                        <div class="flex items-center gap-3">
                            <span class="text-xs text-slate-500 font-extrabold w-8 shrink-0">{{ strtoupper($key) }}</span>
                            <div class="flex-1">
                                <div class="flex items-center justify-between mb-1">
                                    <span class="text-xs font-semibold text-slate-950 truncate pr-2">{{ $label }}</span>
                                    <span class="text-xs font-extrabold text-amber-700 shrink-0">{{ $bAverages[$key] }}/5</span>
                                </div>
                                <div class="w-full bg-slate-50 rounded-full h-2">
                                    <div class="bg-amber-400 h-2 rounded-full transition-all" style="width: {{ ($bAverages[$key] / 5) * 100 }}%"></div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Attendance Frequency Distribution Chart -->
            <div class="bg-white border border-slate-200 shadow-md rounded-2xl p-6 shadow-xl lg:col-span-2">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 bg-violet-100 text-violet-700 rounded-xl flex items-center justify-center border border-violet-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-slate-950 uppercase tracking-wider">Taburan Frekuensi Kehadiran</h3>
                        <p class="text-xs text-slate-500 font-semibold mt-0.5">Bilangan peserta mengikut jumlah sesi yang dihadiri</p>
                    </div>
                </div>
                <div class="relative" style="height: 320px;">
                    <canvas id="chartAttendanceFreq"></canvas>
                </div>
            </div>
        </div>

        <!-- Section D: Text Responses -->
        <div class="bg-white border border-slate-200 shadow-md rounded-2xl border border-slate-200 p-6 shadow-xl">
            <div class="flex items-center gap-3 mb-6">
                <h3 class="text-sm font-bold text-slate-950 uppercase tracking-wider">Komen dan Cadangan Peserta ({{ $textResponses->count() }} respons)</h3>
            </div>

            @if ($textResponses->isEmpty())
                <div class="text-center py-12 text-slate-500">
                    <p class="font-bold text-xs uppercase tracking-wider">Tiada komen diterima</p>
                </div>
            @else
                <div class="space-y-4 max-h-[600px] overflow-y-auto pr-2">
                    @foreach ($textResponses as $response)
                        <div class="bg-slate-50 border border-slate-200 shadow-sm border border-slate-200 rounded-xl p-5 space-y-3">
                            <div class="flex items-center gap-2 border-b border-slate-200 pb-2">
                                <span class="text-xs font-bold text-slate-900">{{ $response['user'] }}</span>
                            </div>
                            @if ($response['d1'])
                                <div>
                                    <p class="text-[9px] font-bold uppercase tracking-wider text-green-700 mb-1">Perkara Bermanfaat</p>
                                    <p class="text-xs text-slate-950 font-medium leading-relaxed">{{ $response['d1'] }}</p>
                                </div>
                            @endif
                            @if ($response['d2'])
                                <div>
                                    <p class="text-[9px] font-bold uppercase tracking-wider text-amber-700 mb-1">Cadangan Penambahbaikan</p>
                                    <p class="text-xs text-slate-950 font-medium leading-relaxed">{{ $response['d2'] }}</p>
                                </div>
                            @endif
                            @if ($response['d3'])
                                <div>
                                    <p class="text-[9px] font-bold uppercase tracking-wider text-indigo-700 mb-1">Topik Masa Depan</p>
                                    <p class="text-xs text-slate-950 font-medium leading-relaxed">{{ $response['d3'] }}</p>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
        
    </div>

    <!-- Chart.js Initialization -->
    <script>
        // Shared chart defaults for dark theme with WCAG compliant colors
        Chart.defaults.color = '#cbd5e1'; // slate-300
        Chart.defaults.borderColor = 'rgba(51, 65, 85, 0.2)';
        Chart.defaults.font.family = "'Inter', sans-serif";
        Chart.defaults.font.weight = 600;

        // ===================== Section B Bar Chart =====================
        const ctxB = document.getElementById('chartSectionB').getContext('2d');
        new Chart(ctxB, {
            type: 'bar',
            data: {
                labels: ['B1', 'B2', 'B3', 'B4', 'B5', 'B6', 'B7', 'B8', 'B9', 'B10'],
                datasets: [{
                    label: 'Purata Skor',
                    data: [
                        {{ $bAverages['b1'] }}, {{ $bAverages['b2'] }}, {{ $bAverages['b3'] }},
                        {{ $bAverages['b4'] }}, {{ $bAverages['b5'] }}, {{ $bAverages['b6'] }},
                        {{ $bAverages['b7'] }}, {{ $bAverages['b8'] }}, {{ $bAverages['b9'] }},
                        {{ $bAverages['b10'] }}
                    ],
                    backgroundColor: 'rgba(251, 191, 36, 0.7)',
                    borderColor: 'rgba(251, 191, 36, 1)',
                    borderWidth: 2,
                    borderRadius: 8,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 5,
                        ticks: { stepSize: 1 },
                        grid: { color: 'rgba(51, 65, 85, 0.2)' },
                    },
                    x: {
                        grid: { display: false },
                    },
                },
            }
        });

        // ===================== Section C Horizontal Bar Chart =====================
        const ctxC = document.getElementById('chartSectionC').getContext('2d');
        new Chart(ctxC, {
            type: 'bar',
            data: {
                labels: [
                    @foreach ($cAverages as $field => $data)
                        '{{ Str::limit($data['label'], 25) }}',
                    @endforeach
                ],
                datasets: [{
                    label: 'Purata Skor',
                    data: [
                        @foreach ($cAverages as $field => $data)
                            {{ $data['average'] }},
                        @endforeach
                    ],
                    backgroundColor: 'rgba(59, 130, 246, 0.7)',
                    borderColor: 'rgba(59, 130, 246, 1)',
                    borderWidth: 2,
                    borderRadius: 8,
                }]
            },
            options: {
                indexAxis: 'y',
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                },
                scales: {
                    x: {
                        beginAtZero: true,
                        max: 5,
                        ticks: { stepSize: 1 },
                        grid: { color: 'rgba(51, 65, 85, 0.2)' },
                    },
                    y: {
                        grid: { display: false },
                        ticks: { font: { size: 10 } },
                    },
                },
            }
        });

        // ===================== Section E Doughnut Chart =====================
        const ctxE = document.getElementById('chartSectionE').getContext('2d');
        new Chart(ctxE, {
            type: 'doughnut',
            data: {
                labels: ['1 Bintang', '2 Bintang', '3 Bintang', '4 Bintang', '5 Bintang'],
                datasets: [{
                    data: [{{ $eDistribution[1] }}, {{ $eDistribution[2] }}, {{ $eDistribution[3] }}, {{ $eDistribution[4] }}, {{ $eDistribution[5] ?? 0 }}],
                    backgroundColor: [
                        'rgba(244, 63, 94, 0.8)',
                        'rgba(245, 158, 11, 0.8)',
                        'rgba(59, 130, 246, 0.8)',
                        'rgba(16, 185, 129, 0.8)',
                        'rgba(168, 85, 247, 0.8)'
                    ],
                    borderColor: [
                        'rgba(244, 63, 94, 1)',
                        'rgba(245, 158, 11, 1)',
                        'rgba(59, 130, 246, 1)',
                        'rgba(16, 185, 129, 1)',
                        'rgba(168, 85, 247, 1)'
                    ],
                    borderWidth: 2,
                    hoverOffset: 10,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '55%',
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 16,
                            usePointStyle: true,
                            font: { size: 10, weight: 700 },
                        },
                    },
                },
            }
        });

        // ===================== Attendance Frequency Bar Chart =====================
        const ctxAttFreq = document.getElementById('chartAttendanceFreq').getContext('2d');
        new Chart(ctxAttFreq, {
            type: 'bar',
            data: {
                labels: {!! json_encode($attendanceFreqLabels) !!},
                datasets: [{
                    label: 'Bilangan Peserta',
                    data: {!! json_encode($attendanceFreqData) !!},
                    backgroundColor: [
                        'rgba(244, 63, 94, 0.75)',   // rose — 0 sessions (absent)
                        'rgba(251, 191, 36, 0.75)',  // amber — 1 session
                        'rgba(16, 185, 129, 0.75)',  // emerald — 2 sessions (full)
                    ],
                    borderColor: [
                        'rgba(244, 63, 94, 1)',
                        'rgba(251, 191, 36, 1)',
                        'rgba(16, 185, 129, 1)',
                    ],
                    borderWidth: 2,
                    borderRadius: 8,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: function(ctx) {
                                return ctx.parsed.y + ' peserta';
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1,
                            precision: 0,
                            color: '#64748b',
                            font: { weight: 600 }
                        },
                        grid: { color: 'rgba(51, 65, 85, 0.1)' },
                    },
                    x: {
                        grid: { display: false },
                        ticks: {
                            color: '#334155',
                            font: { weight: 700, size: 12 }
                        },
                    },
                },
            }
        });
    </script>

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

                <a href="{{ route('admin.attendance.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-bold transition-all text-slate-600 hover:bg-slate-50 hover:text-slate-900">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2" /></svg>
                    Kehadiran
                </a>

                <a href="{{ route('admin.evaluation.analytics') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-bold transition-all bg-blue-50 text-blue-900 border border-blue-100">
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
