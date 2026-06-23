<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log Masuk - KURSUS AHLI LEMBAGA PENGARAH BADAN BERKANUN NEGERI DAN SYARIKAT KERAJAAN NEGERI 2026</title>
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
        /* Custom scrollbar for dropdowns */
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: #0f172a; 
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #334155; 
            border-radius: 10px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #475569; 
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-950 min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md bg-white border border-slate-200 shadow-md backdrop-blur-md rounded-2xl shadow-2xl border border-slate-200 p-8 md:p-10 transition-all duration-300">
        <!-- Event Header / Branding -->
        <div class="text-center mb-8">
            <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-bold bg-blue-50 text-blue-900 border border-blue-200 tracking-wider uppercase mb-3 text-center leading-tight">
                KURSUS AHLI LEMBAGA PENGARAH BADAN BERKANUN NEGERI DAN SYARIKAT KERAJAAN NEGERI 2026
            </span>
            <h1 class="text-2xl md:text-3xl font-black text-slate-950 tracking-tight leading-none">
                Log Masuk Portal
            </h1>
            <p class="text-slate-950 text-sm mt-3 font-semibold uppercase tracking-widest">
                DO WHAT IS RIGHT.
            </p>
        </div>

        <!-- Login Form -->
        <form action="/login" method="POST" class="space-y-6" x-data="loginForm()">
            @csrf
            
            <input type="hidden" name="user_id" :value="selectedUserId">

            <div class="space-y-4">
                <!-- Agency Dropdown (Searchable) -->
                <div class="space-y-2 relative" @click.away="agencyOpen = false">
                    <label class="block text-sm font-bold uppercase tracking-wider text-slate-500">
                        Pilih Agensi
                    </label>
                    <div 
                        @click="agencyOpen = !agencyOpen; if(agencyOpen) { $nextTick(() => $refs.agencySearch.focus()) }"
                        class="w-full flex justify-between items-center text-lg p-4 bg-white border border-slate-200 text-slate-950 rounded-xl focus:outline-none focus:ring-4 transition-all duration-200 font-semibold cursor-pointer"
                        :class="agencyOpen ? 'border-blue-500 ring-blue-500/20 ring-4' : 'hover:border-slate-300'"
                    >
                        <span x-text="selectedAgency ? selectedAgency : '-- Sila Pilih Agensi --'" :class="selectedAgency ? 'text-slate-950 truncate pr-4' : 'text-slate-600'"></span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-slate-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>

                    <!-- Dropdown List -->
                    <div x-show="agencyOpen" x-transition.opacity.duration.200ms style="display: none;" class="absolute z-20 w-full mt-2 bg-white border border-slate-300 rounded-xl shadow-2xl overflow-hidden">
                        <div class="p-3 border-b border-slate-200 bg-white border border-slate-200 shadow-md">
                            <input 
                                x-ref="agencySearch"
                                type="text" 
                                x-model="agencySearch" 
                                placeholder="Cari Agensi..." 
                                class="w-full bg-slate-50 border border-slate-300 text-slate-950 p-3 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all placeholder-slate-500"
                            >
                        </div>
                        <ul class="max-h-60 overflow-y-auto custom-scrollbar">
                            <template x-for="agency in filteredAgencies" :key="agency">
                                <li @click="selectAgency(agency)" 
                                    class="px-5 py-4 text-slate-950 hover:bg-blue-900 hover:text-white cursor-pointer transition-colors border-b border-slate-200/50 last:border-0 font-medium"
                                    x-text="agency"></li>
                            </template>
                            <li x-show="filteredAgencies.length === 0" class="p-5 text-slate-500 text-center font-medium">Tiada Padanan Dijumpai</li>
                        </ul>
                    </div>
                </div>

                <!-- Name Dropdown (Searchable) -->
                <div class="space-y-2 relative" @click.away="userOpen = false">
                    <label class="block text-sm font-bold uppercase tracking-wider text-slate-500">
                        Nama Peserta
                    </label>
                    <div 
                        @click="if(selectedAgency) { userOpen = !userOpen; if(userOpen) { $nextTick(() => $refs.userSearch.focus()) } }"
                        class="w-full flex justify-between items-center text-lg p-4 bg-white border border-slate-200 text-slate-950 rounded-xl transition-all duration-200 font-semibold cursor-pointer"
                        :class="{
                            'border-blue-500 ring-blue-500/20 ring-4': userOpen,
                            'opacity-50 cursor-not-allowed': !selectedAgency,
                            'hover:border-slate-300': selectedAgency && !userOpen
                        }"
                    >
                        <span x-text="getSelectedUserName()" :class="selectedUserId ? 'text-slate-950 truncate pr-4' : 'text-slate-600'"></span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-slate-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>

                    <!-- Dropdown List -->
                    <div x-show="userOpen" x-transition.opacity.duration.200ms style="display: none;" class="absolute z-10 w-full mt-2 bg-white border border-slate-300 rounded-xl shadow-2xl overflow-hidden">
                        <div class="p-3 border-b border-slate-200 bg-white border border-slate-200 shadow-md">
                            <input 
                                x-ref="userSearch"
                                type="text" 
                                x-model="userSearch" 
                                placeholder="Cari Nama..." 
                                class="w-full bg-slate-50 border border-slate-300 text-slate-950 p-3 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all placeholder-slate-500"
                            >
                        </div>
                        <ul class="max-h-60 overflow-y-auto custom-scrollbar">
                            <template x-for="user in filteredUsers" :key="user.id">
                                <li @click="selectUser(user.id)" 
                                    class="px-5 py-4 text-slate-950 hover:bg-blue-900 hover:text-white cursor-pointer transition-colors border-b border-slate-200/50 last:border-0 font-medium"
                                    x-text="user.name"></li>
                            </template>
                            <li x-show="filteredUsers.length === 0" class="p-5 text-slate-500 text-center font-medium">Tiada Padanan Dijumpai</li>
                        </ul>
                    </div>
                </div>
                
                @error('user_id')
                    <div class="bg-red-100 border border-red-300 p-4 rounded-xl mt-2 transition-all duration-200">
                        <div class="flex items-center gap-2">
                            <span class="text-sm font-bold text-red-700">
                                {{ $message }}
                            </span>
                        </div>
                    </div>
                @enderror
            </div>

            <!-- Submit Button -->
            <button 
                type="submit" 
                :disabled="!selectedUserId"
                class="w-full py-4 px-6 bg-blue-900 hover:bg-blue-800 disabled:bg-blue-800 disabled:text-blue-800 disabled:opacity-50 disabled:cursor-not-allowed active:scale-[0.99] text-white text-base font-extrabold rounded-xl shadow-lg border border-blue-400/20 shadow-blue-950/40 transition-all duration-200 focus:outline-none focus:ring-4 focus:ring-blue-500/30 cursor-pointer"
            >
                Log Masuk Ke Portal
            </button>
        </form>

        <!-- Footer / Technical Help info -->
        <div class="mt-8 text-center border-t border-slate-200 pt-6">
            <p class="text-xs text-slate-500 font-semibold leading-relaxed mb-4">
                Log masuk terus tanpa kata laluan. Sila pilih agensi dan nama anda dengan tepat.
            </p>
            <a href="{{ route('admin.login') }}" class="text-[10px] text-slate-600 hover:text-slate-500 font-bold uppercase tracking-widest transition-colors">
                Log Masuk Urus Setia / Pentadbir
            </a>
        </div>
    </div>

    <script>
        function loginForm() {
            const data = @json($groupedUsers);
            let oldUserId = '{{ old('user_id') ?? '' }}';
            let initialAgency = '';
            
            // Restore selection if there's an old user_id from a failed validation
            if (oldUserId) {
                for (const [agency, users] of Object.entries(data)) {
                    if (users.find(u => u.id == oldUserId)) {
                        initialAgency = agency;
                        break;
                    }
                }
            }

            return {
                agenciesData: data,
                selectedAgency: initialAgency,
                selectedUserId: oldUserId,
                agencySearch: '',
                userSearch: '',
                agencyOpen: false,
                userOpen: false,

                get filteredAgencies() {
                    return Object.keys(this.agenciesData).filter(agency => 
                        agency.toLowerCase().includes(this.agencySearch.toLowerCase())
                    );
                },

                get filteredUsers() {
                    if (!this.selectedAgency) return [];
                    return this.agenciesData[this.selectedAgency].filter(user => 
                        user.name.toLowerCase().includes(this.userSearch.toLowerCase())
                    );
                },

                selectAgency(agency) {
                    this.selectedAgency = agency;
                    this.selectedUserId = '';
                    this.agencyOpen = false;
                    this.agencySearch = '';
                },

                selectUser(userId) {
                    this.selectedUserId = userId;
                    this.userOpen = false;
                    this.userSearch = '';
                },

                getSelectedUserName() {
                    if (!this.selectedAgency || !this.selectedUserId) return '-- Sila Pilih Nama --';
                    const user = this.agenciesData[this.selectedAgency].find(u => u.id == this.selectedUserId);
                    return user ? user.name : '-- Sila Pilih Nama --';
                }
            }
        }
    </script>

    {{-- Defense-in-depth: detect if Alpine.js failed to load --}}
    <div id="alpine-error-banner" style="display:none"
         class="fixed top-0 left-0 right-0 bg-red-600 text-white text-center p-3 text-sm font-bold z-50">
        Laman ini gagal dimuat sepenuhnya. Sila cuba semula atau gunakan Wi-Fi.
        <button onclick="location.reload()" class="ml-2 underline cursor-pointer">Muat Semula</button>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                var el = document.querySelector('[x-data]');
                if (el && !el._x_dataStack) {
                    document.getElementById('alpine-error-banner').style.display = 'block';
                }
            }, 3000);
        });
    </script>
</body>
</html>
