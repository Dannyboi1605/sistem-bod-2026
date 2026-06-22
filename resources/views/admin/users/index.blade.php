<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Urus Pengguna - KURSUS AHLI LEMBAGA PENGARAH BADAN BERKANUN NEGERI DAN SYARIKAT KERAJAAN NEGERI 2026</title>
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
                <div>
                    <h1 class="text-xl font-black text-slate-950 uppercase tracking-wider leading-none">Urus Pengguna</h1>
                    <p class="text-slate-600 text-[10px] font-semibold mt-1.5 uppercase leading-tight">KURSUS AHLI LEMBAGA PENGARAH BADAN BERKANUN NEGERI DAN SYARIKAT KERAJAAN NEGERI 2026 - Pendaftaran & Senarai</p>
                </div>
            </div>
            
            <div class="flex items-center gap-3 w-full md:w-auto">
                <button onclick="toggleModal('create-modal', true)" 
                        class="flex-1 md:flex-initial flex items-center justify-center gap-2 bg-blue-900 hover:bg-blue-800 active:scale-[0.98] text-white px-5 py-3.5 rounded-xl border border-blue-400/20 text-xs font-bold shadow-md transition-all duration-200 cursor-pointer uppercase tracking-wider">
                    Tambah Peserta
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
            <div class="bg-red-100 border border-red-300 text-rose-350 p-4 rounded-xl shadow-lg space-y-1">
                <span class="font-extrabold text-sm block">Terdapat ralat pada borang pendaftaran:</span>
                <ul class="list-disc pl-5 text-xs font-semibold space-y-0.5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Search Bar -->
        <div class="bg-white border border-slate-200 shadow-md rounded-2xl p-4">
            <form action="{{ route('admin.users.index') }}" method="GET" class="flex items-center gap-3">
                <div class="relative flex-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="absolute left-3.5 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-400 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    <input type="text"
                           name="search"
                           id="search-input"
                           value="{{ $search ?? '' }}"
                           placeholder="Cari nama, jawatan, atau agensi..."
                           class="w-full bg-slate-50 border border-slate-200 focus:border-blue-500 focus:ring-blue-500/20 text-slate-950 placeholder-slate-400 rounded-xl pl-10 pr-4 py-3 text-sm font-semibold focus:outline-none focus:ring-4 transition-all duration-200">
                </div>
                <button type="submit"
                        class="bg-blue-900 hover:bg-blue-800 active:scale-[0.98] text-white px-5 py-3 rounded-xl text-xs font-bold shadow-md transition-all duration-200 cursor-pointer uppercase tracking-wider border border-blue-400/20">
                    Cari
                </button>
                @if (!empty($search))
                    <a href="{{ route('admin.users.index') }}"
                       class="bg-slate-100 hover:bg-slate-200 active:scale-[0.98] text-slate-600 px-4 py-3 rounded-xl text-xs font-bold transition-all duration-200 cursor-pointer uppercase tracking-wider border border-slate-200">
                        Padam
                    </a>
                @endif
            </form>
            @if (!empty($search))
                <p class="mt-3 text-xs font-semibold text-slate-500">
                    Menunjukkan <span class="text-slate-900 font-bold">{{ $users->total() }}</span> hasil untuk "<span class="text-blue-900 font-bold">{{ $search }}</span>"
                </p>
            @endif
        </div>

        <!-- Users Table Card -->
        <div class="bg-white border border-slate-200 shadow-md backdrop-blur-md rounded-2xl overflow-hidden shadow-xl p-4 md:p-0">
            <div class="w-full overflow-x-auto">
                <!-- Table for Desktop, Grid for Mobile -->
                <table class="w-full text-left border-collapse block md:table">
                    <thead class="hidden md:table-header-group">
                        <tr class="border-b border-slate-200 bg-white/40 text-slate-500 text-[10px] font-bold uppercase tracking-wider">
                            <th class="px-6 py-4">Nama</th>
                            <th class="px-6 py-4">Jawatan</th>
                            <th class="px-6 py-4">Agensi / Jabatan</th>
                            <th class="px-6 py-4 text-center">Peranan</th>
                            <th class="px-6 py-4 text-center">Doorgift</th>
                            <th class="px-6 py-4 text-center">Tindakan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-850 text-sm font-semibold block md:table-row-group">
                        @forelse ($users as $user)
                            <tr class="block md:table-row hover:bg-white/20 transition duration-150 py-4 md:py-0 border-b border-slate-200/60 md:border-none space-y-2.5 md:space-y-0">
                                
                                <!-- Name Column -->
                                <td class="block md:table-cell py-1.5 md:py-4 px-0 md:px-6">
                                    <span class="inline-block md:hidden text-[9px] font-bold text-slate-500 uppercase tracking-widest w-28 align-middle">Nama</span>
                                    <div class="inline-flex items-center gap-3 align-middle">
                                        <div class="w-8 h-8 rounded-full bg-slate-50 text-slate-950 flex items-center justify-center font-extrabold text-xs border border-slate-200 shrink-0">
                                            {{ strtoupper(substr($user->name, 0, 2)) }}
                                        </div>
                                        <div class="min-w-0">
                                            <p class="text-slate-950 font-bold truncate text-sm">{{ $user->name }}</p>
                                            @if($user->is_eligible_cert)
                                                <span class="inline-flex items-center gap-1 text-[9px] font-extrabold text-green-700 bg-green-100 px-2 py-0.5 rounded border border-green-300">
                                                    Layak Sijil
                                                </span>
                                            @else
                                                <span class="inline-flex items-center gap-1 text-[9px] font-extrabold text-slate-500 bg-slate-100 px-2 py-0.5 rounded border border-slate-200">
                                                    Tiada Sijil
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </td>

                                <!-- Position Column -->
                                <td class="block md:table-cell py-1.5 md:py-4 px-0 md:px-6">
                                    <span class="inline-block md:hidden text-[9px] font-bold text-slate-500 uppercase tracking-widest w-28 align-middle">Jawatan</span>
                                    <span class="text-slate-950 text-xs truncate max-w-[180px] inline-block md:block align-middle" title="{{ $user->position }}">{{ $user->position }}</span>
                                </td>

                                <!-- Agency Column -->
                                <td class="block md:table-cell py-1.5 md:py-4 px-0 md:px-6">
                                    <span class="inline-block md:hidden text-[9px] font-bold text-slate-500 uppercase tracking-widest w-28 align-middle">Agensi</span>
                                    <span class="text-slate-500 text-xs truncate max-w-[180px] inline-block md:block align-middle" title="{{ $user->agency }}">{{ $user->agency }}</span>
                                </td>

                                <!-- Role Column -->
                                <td class="block md:table-cell py-1.5 md:py-4 px-0 md:px-6 text-left md:text-center">
                                    <span class="inline-block md:hidden text-[9px] font-bold text-slate-500 uppercase tracking-widest w-28 align-middle">Peranan</span>
                                    <div class="inline-flex flex-wrap gap-1 justify-start md:justify-center align-middle">
                                        @if ($user->hasRole('admin'))
                                            <span class="bg-indigo-100 text-indigo-800 border border-indigo-200 px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider">Admin</span>
                                        @endif
                                        @if ($user->hasRole('jawatankuasa'))
                                            <span class="bg-green-100 text-green-800 border border-green-300 px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider">Urus Setia</span>
                                        @endif
                                        @if ($user->hasRole('peserta'))
                                            <span class="bg-blue-50 text-blue-800 border border-blue-200 px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider">Peserta</span>
                                        @endif
                                    </div>
                                </td>

                                <!-- Doorgift Column -->
                                <td class="block md:table-cell py-1.5 md:py-4 px-0 md:px-6 text-left md:text-center">
                                    <span class="inline-block md:hidden text-[9px] font-bold text-slate-500 uppercase tracking-widest w-28 align-middle">Doorgift</span>
                                    <div class="inline-block align-middle">
                                        <button
                                            type="button"
                                            class="doorgift-toggle-btn px-3 py-1.5 rounded-lg text-xs font-bold transition-all duration-200 active:scale-[0.95] cursor-pointer {{ $user->has_received_doorgift ? 'bg-green-100 text-green-800 border border-green-300' : 'bg-slate-100 text-slate-600 border border-slate-200 hover:bg-slate-200' }}"
                                            data-user-id="{{ $user->id }}"
                                            data-current-state="{{ $user->has_received_doorgift ? 'true' : 'false' }}"
                                        >
                                            @if ($user->has_received_doorgift)
                                                ✓ Diterima
                                            @else
                                                Belum
                                            @endif
                                        </button>
                                    </div>
                                </td>

                                <!-- Actions Column -->
                                <td class="block md:table-cell py-1.5 md:py-4 px-0 md:px-6">
                                    <span class="inline-block md:hidden text-[9px] font-bold text-slate-500 uppercase tracking-widest w-28 align-middle">Tindakan</span>
                                    <div class="inline-flex items-center gap-3 align-middle">
                                        <!-- Edit Button (large touch target py-3 px-4 equivalent w-9 h-9) -->
                                        <button 
                                            onclick="openEditModal({{ json_encode($user) }})"
                                            class="w-10 h-10 bg-slate-50 hover:bg-white active:scale-[0.90] text-slate-950 hover:text-slate-950 rounded-lg flex items-center justify-center border border-slate-200 transition-all cursor-pointer"
                                            title="Kemaskini"
                                        >
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </button>

                                        <!-- Delete Button -->
                                        @if(auth()->id() !== $user->id)
                                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Adakah anda pasti mahu pemadam pengguna {{ $user->name }}? Kehadiran mereka juga akan dipadamkan.');" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button 
                                                    type="submit"
                                                    class="w-10 h-10 bg-red-100 hover:bg-rose-650 text-red-700 hover:text-slate-950 rounded-lg flex items-center justify-center border border-red-300 transition-all cursor-pointer"
                                                    title="Padam"
                                                >
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </form>
                                        @else
                                            <button 
                                                disabled 
                                                class="w-10 h-10 bg-slate-50 text-slate-800 rounded-lg flex items-center justify-center border border-slate-900 cursor-not-allowed opacity-30"
                                                title="Akaun anda sendiri"
                                            >
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                                </svg>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr class="block md:table-row">
                                <td colspan="6" class="block md:table-cell px-6 py-12 text-center text-slate-500">
                                    <p class="font-bold text-sm text-slate-500">Tiada pengguna ditemui</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination Footer -->
            @if ($users->hasPages())
                <div class="px-6 py-4 bg-white/40 border-t border-slate-200">
                    {{ $users->links() }}
                </div>
            @endif
        </div>
        
    </div>

    <!-- Create User Modal (Glassmorphic border/bg overlay) -->
    <div id="create-modal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-50/80 backdrop-blur-sm hidden transition-opacity duration-300">
        <div class="bg-white border border-slate-200 shadow-md border border-slate-200 rounded-2xl w-full max-w-lg shadow-2xl overflow-hidden transform transition-all duration-300">
            <div class="p-6 border-b border-slate-200 flex items-center justify-between">
                <h3 class="text-sm font-bold text-slate-950 uppercase tracking-wider">
                    Daftar Peserta / Pengguna Baru
                </h3>
                <button onclick="toggleModal('create-modal', false)" class="text-slate-500 hover:text-slate-950 cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            
            <form action="{{ route('admin.users.store') }}" method="POST" class="p-6 space-y-4">
                @csrf
                
                <div class="space-y-2">
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-500">Nama Penuh</label>
                    <input type="text" name="name" required placeholder="Masukkan nama penuh" 
                           class="w-full bg-white border border-slate-200 focus:border-blue-500 focus:ring-blue-500/20 text-slate-950 placeholder-slate-600 rounded-xl px-4 py-3.5 text-sm font-semibold focus:outline-none focus:ring-4 transition-all duration-200">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="space-y-2">
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-500">Jawatan</label>
                        <input type="text" name="position" required placeholder="Masukkan jawatan rasmi" 
                               class="w-full bg-white border border-slate-200 focus:border-blue-500 focus:ring-blue-500/20 text-slate-950 placeholder-slate-600 rounded-xl px-4 py-3.5 text-sm font-semibold focus:outline-none focus:ring-4 transition-all duration-200">
                    </div>

                    <div class="space-y-2">
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-500">Agensi / Jabatan</label>
                        <input type="text" name="agency" required placeholder="Masukkan agensi / kementerian" 
                               class="w-full bg-white border border-slate-200 focus:border-blue-500 focus:ring-blue-500/20 text-slate-950 placeholder-slate-600 rounded-xl px-4 py-3.5 text-sm font-semibold focus:outline-none focus:ring-4 transition-all duration-200">
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-500">Peranan Pengguna</label>
                    <div class="flex flex-wrap gap-4 bg-white shadow-sm p-4 rounded-xl border border-slate-200">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="roles[]" value="admin" class="w-4 h-4 text-blue-600 border-slate-300 rounded focus:ring-blue-500">
                            <span class="text-xs font-bold text-slate-700">Admin</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="roles[]" value="jawatankuasa" class="w-4 h-4 text-blue-600 border-slate-300 rounded focus:ring-blue-500">
                            <span class="text-xs font-bold text-slate-700">Urus Setia</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="roles[]" value="peserta" checked class="w-4 h-4 text-blue-600 border-slate-300 rounded focus:ring-blue-500">
                            <span class="text-xs font-bold text-slate-700">Peserta</span>
                        </label>
                    </div>
                </div>

                <div class="flex items-center gap-3 bg-white shadow-sm p-4 rounded-xl border border-slate-200">
                    <input type="checkbox" name="is_eligible_cert" id="is_eligible_cert_create" value="1" checked
                           class="w-5 h-5 bg-slate-50 border border-slate-200 rounded text-blue-600 focus:ring-0 focus:ring-offset-0 cursor-pointer">
                    <label for="is_eligible_cert_create" class="text-xs font-bold text-slate-950 select-none cursor-pointer">Layak menerima sijil penyertaan acara</label>
                </div>

                <div class="flex items-center gap-3 bg-white shadow-sm p-4 rounded-xl border border-slate-200">
                    <input type="checkbox" name="has_received_doorgift" id="has_received_doorgift_create" value="1"
                           class="w-5 h-5 bg-slate-50 border border-slate-200 rounded text-blue-600 focus:ring-0 focus:ring-offset-0 cursor-pointer">
                    <label for="has_received_doorgift_create" class="text-xs font-bold text-slate-950 select-none cursor-pointer">Telah menerima doorgift</label>
                </div>

                <div class="pt-4 flex items-center justify-end gap-3">
                    <button type="button" onclick="toggleModal('create-modal', false)" 
                            class="px-5 py-3 rounded-xl text-slate-500 hover:text-slate-950 font-bold text-sm transition cursor-pointer">
                        Batal
                    </button>
                    <button type="submit" 
                            class="bg-blue-900 hover:bg-blue-800 active:scale-[0.98] text-white px-6 py-3 rounded-xl font-bold text-sm shadow-md border border-blue-400/20 shadow-blue-950/50 transition-all cursor-pointer">
                        Daftar Pengguna
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit User Modal (Glassmorphic border/bg overlay) -->
    <div id="edit-modal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-50/80 backdrop-blur-sm hidden transition-opacity duration-300">
        <div class="bg-white border border-slate-200 shadow-md border border-slate-200 rounded-2xl w-full max-w-lg shadow-2xl overflow-hidden transform transition-all duration-300">
            <div class="p-6 border-b border-slate-200 flex items-center justify-between">
                <h3 class="text-sm font-bold text-slate-950 uppercase tracking-wider">
                    Kemaskini Maklumat Pengguna
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
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-500">Nama Penuh</label>
                    <input type="text" name="name" id="edit-name" required placeholder="Masukkan nama penuh" 
                           class="w-full bg-white border border-slate-200 focus:border-indigo-500 focus:ring-indigo-500/20 text-slate-950 placeholder-slate-600 rounded-xl px-4 py-3.5 text-sm font-semibold focus:outline-none focus:ring-4 transition-all duration-200">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="space-y-2">
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-500">Jawatan</label>
                        <input type="text" name="position" id="edit-position" required placeholder="Masukkan jawatan rasmi" 
                               class="w-full bg-white border border-slate-200 focus:border-indigo-500 focus:ring-indigo-500/20 text-slate-950 placeholder-slate-600 rounded-xl px-4 py-3.5 text-sm font-semibold focus:outline-none focus:ring-4 transition-all duration-200">
                    </div>

                    <div class="space-y-2">
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-500">Agensi / Jabatan</label>
                        <input type="text" name="agency" id="edit-agency" required placeholder="Masukkan agensi / kementerian" 
                               class="w-full bg-white border border-slate-200 focus:border-indigo-500 focus:ring-indigo-500/20 text-slate-950 placeholder-slate-600 rounded-xl px-4 py-3.5 text-sm font-semibold focus:outline-none focus:ring-4 transition-all duration-200">
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-500">Peranan Pengguna</label>
                    <div class="flex flex-wrap gap-4 bg-white shadow-sm p-4 rounded-xl border border-slate-200">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="roles[]" value="admin" class="w-4 h-4 text-indigo-600 border-slate-300 rounded focus:ring-indigo-500">
                            <span class="text-xs font-bold text-slate-700">Admin</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="roles[]" value="jawatankuasa" class="w-4 h-4 text-indigo-600 border-slate-300 rounded focus:ring-indigo-500">
                            <span class="text-xs font-bold text-slate-700">Urus Setia</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="roles[]" value="peserta" class="w-4 h-4 text-indigo-600 border-slate-300 rounded focus:ring-indigo-500">
                            <span class="text-xs font-bold text-slate-700">Peserta</span>
                        </label>
                    </div>
                </div>

                <div class="flex items-center gap-3 bg-white shadow-sm p-4 rounded-xl border border-slate-200">
                    <input type="checkbox" name="is_eligible_cert" id="edit-cert" value="1"
                           class="w-5 h-5 bg-slate-50 border border-slate-200 rounded text-indigo-600 focus:ring-0 focus:ring-offset-0 cursor-pointer">
                    <label for="edit-cert" class="text-xs font-bold text-slate-950 select-none cursor-pointer">Layak menerima sijil penyertaan acara</label>
                </div>

                <div class="flex items-center gap-3 bg-white shadow-sm p-4 rounded-xl border border-slate-200">
                    <input type="checkbox" name="has_received_doorgift" id="edit-doorgift" value="1"
                           class="w-5 h-5 bg-slate-50 border border-slate-200 rounded text-indigo-600 focus:ring-0 focus:ring-offset-0 cursor-pointer">
                    <label for="edit-doorgift" class="text-xs font-bold text-slate-950 select-none cursor-pointer">Telah menerima doorgift</label>
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

    <!-- Modals Script Logic -->
    <script>
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

        function openEditModal(user) {
            // Set Form action endpoint dynamically
            const form = document.getElementById('edit-form');
            form.action = `/admin/users/${user.id}`;

            // Populate form values
            document.getElementById('edit-name').value = user.name;
            document.getElementById('edit-position').value = user.position;
            document.getElementById('edit-agency').value = user.agency;
            document.getElementById('edit-cert').checked = user.is_eligible_cert === true || user.is_eligible_cert === 1 || user.is_eligible_cert === "1";

            // Synchronize modal state with the latest inline table button state to prevent stale data
            const toggleBtn = document.querySelector(`.doorgift-toggle-btn[data-user-id="${user.id}"]`);
            const hasReceived = toggleBtn 
                ? (toggleBtn.dataset.currentState === 'true') 
                : (user.has_received_doorgift === true || user.has_received_doorgift === 1 || user.has_received_doorgift === "1");
            document.getElementById('edit-doorgift').checked = hasReceived;

            // Check roles
            const roleCheckboxes = document.querySelectorAll('#edit-modal input[name="roles[]"]');
            roleCheckboxes.forEach(cb => {
                cb.checked = user.roles && user.roles.includes(cb.value);
            });

            // Open Modal
            toggleModal('edit-modal', true);
        }

        // Close modal when clicking on backdrop
        window.addEventListener('click', function(e) {
            const createModal = document.getElementById('create-modal');
            const editModal = document.getElementById('edit-modal');
            
            if (e.target === createModal) {
                toggleModal('create-modal', false);
            }
            if (e.target === editModal) {
                toggleModal('edit-modal', false);
            }
        });

        // Inline JS handler (delegated event for doorgift toggles)
        document.addEventListener('click', function(e) {
            const btn = e.target.closest('.doorgift-toggle-btn');
            if (!btn) return;

            const userId = btn.dataset.userId;
            const currentState = btn.dataset.currentState === 'true';
            const newStatus = !currentState;

            btn.disabled = true;

            fetch(`/admin/users/${userId}/doorgift`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'X-Requested-With': 'XMLHttpRequest',
                },
                body: JSON.stringify({ status: newStatus })
            })
            .then(r => {
                if (!r.ok) {
                    throw new Error('Ralat tindak balas pelayan.');
                }
                return r.json();
            })
            .then(data => {
                if (data.success) {
                    const received = data.has_received_doorgift;
                    btn.dataset.currentState = received ? 'true' : 'false';
                    btn.textContent = received ? '✓ Diterima' : 'Belum';
                    
                    if (received) {
                        btn.className = "doorgift-toggle-btn px-3 py-1.5 rounded-lg text-xs font-bold transition-all duration-200 active:scale-[0.95] cursor-pointer bg-green-100 text-green-800 border border-green-300";
                    } else {
                        btn.className = "doorgift-toggle-btn px-3 py-1.5 rounded-lg text-xs font-bold transition-all duration-200 active:scale-[0.95] cursor-pointer bg-slate-100 text-slate-600 border border-slate-200 hover:bg-slate-200";
                    }
                }
            })
            .catch(err => {
                console.error(err);
                alert('Ralat semasa mengemas kini status doorgift.');
            })
            .finally(() => {
                btn.disabled = false;
            });
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
                
                <a href="{{ route('admin.users.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-bold transition-all bg-blue-50 text-blue-900 border border-blue-100">
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
