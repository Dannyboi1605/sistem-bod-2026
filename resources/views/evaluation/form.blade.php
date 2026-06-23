<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Borang Penilaian Program - KURSUS AHLI LEMBAGA PENGARAH BADAN BERKANUN NEGERI DAN SYARIKAT KERAJAAN NEGERI 2026</title>
    <!-- Google Fonts Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Self-hosted Tailwind CSS + Alpine.js via Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
<link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
</head>
<body class="bg-slate-50 text-slate-950 min-h-screen font-sans">

    <!-- Wrapper with full width, max width constraint, and explicit responsive padding -->
    <div class="w-full max-w-2xl mx-auto px-4 sm:px-6 py-6 md:py-8 space-y-6">
        
        <!-- Top Navigation -->
        <div class="flex items-center justify-between bg-white border border-slate-200 shadow-md backdrop-blur-md rounded-2xl border border-slate-200 px-5 sm:px-6 py-4 shadow-xl">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-2 text-xs font-bold text-slate-950 hover:text-slate-950 transition-colors uppercase tracking-wider">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>
                Kembali
            </a>
            <form action="{{ route('logout') }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="text-xs font-bold text-rose-500 hover:text-red-700 transition-colors cursor-pointer uppercase tracking-wider">
                    Log Keluar
                </button>
            </form>
        </div>

        <!-- Header -->
        <header class="bg-white border border-slate-200 shadow-md backdrop-blur-md rounded-2xl border border-slate-200 p-5 sm:p-6 shadow-xl text-center space-y-3">
            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-blue-50 text-blue-900 border border-blue-200 tracking-wider uppercase">
                Borang Penilaian
            </span>
            <h1 class="text-2xl sm:text-3xl font-black text-slate-950 tracking-tight leading-tight break-words whitespace-normal">PENILAIAN PROGRAM KURSUS AHLI LEMBAGA PENGARAH BADAN BERKANUN NEGERI DAN SYARIKAT KERAJAAN NEGERI 2026</h1>
            <div class="flex items-center justify-center gap-2 text-xs font-bold text-slate-500 break-words whitespace-normal">
                <span>VIP: {{ $user->name }}</span>
            </div>
        </header>

        <!-- Validation Errors -->
        @if ($errors->any())
            <div class="bg-red-100 border border-red-300 text-red-800 p-4 rounded-xl shadow-lg space-y-1">
                <span class="font-bold text-sm block">Sila lengkapkan semua soalan yang bertanda wajib.</span>
            </div>
        @endif

        <form action="{{ route('evaluation.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Rating Scale Legend -->
            <div class="bg-white border border-slate-200 shadow-md rounded-2xl border border-slate-200 p-5 shadow-lg space-y-3">
                <h3 class="text-xs font-bold text-slate-950 uppercase tracking-wider break-words whitespace-normal">Skala Penilaian Bintang</h3>
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between text-xs font-semibold gap-2 sm:px-2">
                    <span class="text-red-700 break-words">1 Bintang (Sangat Tidak Setuju)</span>
                    <span class="hidden sm:block text-slate-500">-----</span>
                    <span class="text-green-700 break-words">5 Bintang (Sangat Setuju)</span>
                </div>
            </div>

            <!-- ===================== SECTION B ===================== -->
            <div class="bg-white border border-slate-200 shadow-md rounded-2xl border border-slate-200 p-5 sm:p-6 shadow-lg space-y-5">
                <div class="flex flex-col sm:flex-row items-start sm:items-center gap-3 border-b border-slate-200 pb-4">
                    <span class="w-8 h-8 shrink-0 bg-blue-50 text-blue-900 rounded-lg flex items-center justify-center font-extrabold text-xs border border-blue-200">B</span>
                    <div>
                        <h2 class="text-sm font-bold text-slate-950 uppercase tracking-wider break-words whitespace-normal">Penilaian Keseluruhan Kursus</h2>
                        <p class="text-slate-500 text-xs font-semibold mt-1 break-words whitespace-normal">Nyatakan tahap persetujuan anda bagi setiap perkara (Wajib)</p>
                    </div>
                </div>

                @php
                    $bQuestions = [
                        'b1' => 'Objektif kursus ini telah tercapai dengan jayanya.',
                        'b2' => 'Kandungan kursus adalah relevan dan memenuhi keperluan saya.',
                        'b3' => 'Tempoh masa yang diperuntukkan adalah mencukupi dan bersesuaian.',
                        'b4' => 'Bahan-bahan edaran/rujukan yang disediakan adalah jelas dan berkualiti.',
                        'b5' => 'Kaedah penyampaian (ceramah/bengkel/perbincangan) adalah berkesan.',
                        'b6' => 'Kursus ini memberi manfaat secara langsung kepada peranan dan tugas saya.',
                        'b7' => 'Pengetahuan dan tahap pemahaman saya meningkat selepas mengikuti kursus ini.',
                        'b8' => 'Saya berkeyakinan untuk mengaplikasikan ilmu yang dipelajari dalam organisasi.',
                        'b9' => 'Pengurusan urus setia dan logistik kursus dikendalikan dengan baik.',
                        'b10' => 'Kemudahan tempat, makanan dan peralatan (audio/visual) adalah memuaskan.',
                    ];
                @endphp

                @foreach ($bQuestions as $field => $question)
                    <div class="bg-white shadow-sm rounded-xl border border-slate-200/80 p-4 space-y-3">
                        <p class="text-sm font-bold text-slate-950 leading-relaxed break-words whitespace-normal">
                            <span class="text-blue-900 mr-1">{{ strtoupper($field) }}.</span> {{ $question }}
                        </p>
                        
                        <div x-data="{ rating: {{ old($field, 0) }}, hoverRating: 0 }" class="flex items-center gap-1.5 sm:gap-2 flex-wrap">
                            @for ($i = 1; $i <= 5; $i++)
                                <label class="relative cursor-pointer group flex items-center justify-center w-10 h-10 sm:w-11 sm:h-11 shrink-0"
                                       @mouseenter="hoverRating = {{ $i }}" 
                                       @mouseleave="hoverRating = 0"
                                       @click="rating = {{ $i }}">
                                    <input type="radio" name="{{ $field }}" value="{{ $i }}" class="sr-only" x-model="rating" required>
                                    <svg xmlns="http://www.w3.org/2000/svg" 
                                         viewBox="0 0 24 24" 
                                         class="w-8 h-8 sm:w-10 sm:h-10 transition-all duration-200"
                                         :class="{
                                            'fill-amber-400 text-amber-700 drop-shadow-[0_0_8px_rgba(251,191,36,0.5)] scale-110': hoverRating >= {{ $i }} || (rating >= {{ $i }} && hoverRating == 0),
                                            'stroke-slate-600 text-transparent stroke-2 group-hover:stroke-slate-500': hoverRating < {{ $i }} && rating < {{ $i }}
                                         }">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z" />
                                    </svg>
                                </label>
                            @endfor
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- ===================== SECTION C ===================== -->
            <div class="bg-white border border-slate-200 shadow-md rounded-2xl border border-slate-200 p-5 sm:p-6 shadow-lg space-y-5">
                <div class="flex flex-col sm:flex-row items-start sm:items-center gap-3 border-b border-slate-200 pb-4">
                    <span class="w-8 h-8 shrink-0 bg-indigo-100 text-indigo-700 rounded-lg flex items-center justify-center font-extrabold text-xs border border-indigo-300">C</span>
                    <div>
                        <h2 class="text-sm font-bold text-slate-950 uppercase tracking-wider break-words whitespace-normal">Penilaian Penceramah / Fasilitator</h2>
                        <p class="text-slate-500 text-xs font-semibold mt-1 break-words whitespace-normal">Nyatakan tahap persetujuan anda terhadap setiap penceramah (Wajib)</p>
                    </div>
                </div>

                @php
                    $cSpeakers = [
                        'c2_fuad_bee' => 'Datuk Mohd Fuad Bee Bin Haji Basah, JP',
                        'c1_idris_jala' => 'Dato\' Sri Idris Jala',
                        'c3_petrus_gimbad' => 'Datuk Petrus Gimbad',
                        'c6_saravana_kumar' => 'Dato\' S Saravana Kumar',
                        'c4_lee_min_onn' => 'Encik Lee Min Onn',
                        'c5_khairunnizat' => 'Encik Mohamad Khairunnizat Bin Khori',
                    ];
                    $counter = 1;
                @endphp

                @foreach ($cSpeakers as $field => $speaker)
                    <div class="bg-white shadow-sm rounded-xl border border-slate-200/80 p-4 space-y-3">
                        <p class="text-sm font-bold text-slate-950 leading-relaxed break-words whitespace-normal">
                            <span class="text-indigo-700 mr-1">C{{ $counter++ }}.</span> {{ $speaker }}
                        </p>
                        
                        <div x-data="{ rating: {{ old($field, 0) }}, hoverRating: 0 }" class="flex items-center gap-1.5 sm:gap-2 flex-wrap">
                            @for ($i = 1; $i <= 5; $i++)
                                <label class="relative cursor-pointer group flex items-center justify-center w-10 h-10 sm:w-11 sm:h-11 shrink-0"
                                       @mouseenter="hoverRating = {{ $i }}" 
                                       @mouseleave="hoverRating = 0"
                                       @click="rating = {{ $i }}">
                                    <input type="radio" name="{{ $field }}" value="{{ $i }}" class="sr-only" x-model="rating" required>
                                    <svg xmlns="http://www.w3.org/2000/svg" 
                                         viewBox="0 0 24 24" 
                                         class="w-8 h-8 sm:w-10 sm:h-10 transition-all duration-200"
                                         :class="{
                                            'fill-amber-400 text-amber-700 drop-shadow-[0_0_8px_rgba(251,191,36,0.5)] scale-110': hoverRating >= {{ $i }} || (rating >= {{ $i }} && hoverRating == 0),
                                            'stroke-slate-600 text-transparent stroke-2 group-hover:stroke-slate-500': hoverRating < {{ $i }} && rating < {{ $i }}
                                         }">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z" />
                                    </svg>
                                </label>
                            @endfor
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- ===================== SECTION D ===================== -->
            <div class="bg-white border border-slate-200 shadow-md rounded-2xl border border-slate-200 p-5 sm:p-6 shadow-lg space-y-5">
                <div class="flex flex-col sm:flex-row items-start sm:items-center gap-3 border-b border-slate-200 pb-4">
                    <span class="w-8 h-8 shrink-0 bg-green-100 text-green-700 rounded-lg flex items-center justify-center font-extrabold text-xs border border-green-300">D</span>
                    <div>
                        <h2 class="text-sm font-bold text-slate-950 uppercase tracking-wider break-words whitespace-normal">Komen dan Cadangan</h2>
                        <p class="text-slate-500 text-xs font-semibold mt-1 break-words whitespace-normal">Bahagian ini adalah pilihan (Tidak Wajib)</p>
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 break-words whitespace-normal">D1. Apakah aspek kursus yang paling bermanfaat kepada anda?</label>
                    <textarea name="d1_beneficial" rows="3" placeholder="Nyatakan perkara yang paling bermanfaat..." 
                              class="w-full box-border bg-white border border-slate-200 focus:border-emerald-500 focus:ring-emerald-500/20 text-slate-950 placeholder-slate-600 rounded-xl p-3 sm:p-4 text-sm font-semibold focus:outline-none focus:ring-4 transition-all duration-200 resize-none">{{ old('d1_beneficial') }}</textarea>
                </div>

                <div class="space-y-2">
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 break-words whitespace-normal">D2. Cadangan penambahbaikan untuk program akan datang</label>
                    <textarea name="d2_improvements" rows="3" placeholder="Nyatakan cadangan penambahbaikan..." 
                              class="w-full box-border bg-white border border-slate-200 focus:border-emerald-500 focus:ring-emerald-500/20 text-slate-950 placeholder-slate-600 rounded-xl p-3 sm:p-4 text-sm font-semibold focus:outline-none focus:ring-4 transition-all duration-200 resize-none">{{ old('d2_improvements') }}</textarea>
                </div>

                <div class="space-y-2">
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 break-words whitespace-normal">D3. Cadangan tajuk/topik kursus yang ingin dicadangkan pada masa hadapan</label>
                    <textarea name="d3_future_topics" rows="3" placeholder="Nyatakan topik cadangan untuk masa hadapan..." 
                              class="w-full box-border bg-white border border-slate-200 focus:border-emerald-500 focus:ring-emerald-500/20 text-slate-950 placeholder-slate-600 rounded-xl p-3 sm:p-4 text-sm font-semibold focus:outline-none focus:ring-4 transition-all duration-200 resize-none">{{ old('d3_future_topics') }}</textarea>
                </div>
            </div>

            <!-- ===================== SECTION E ===================== -->
            <div class="bg-white border border-slate-200 shadow-md rounded-2xl border border-slate-200 p-5 sm:p-6 shadow-lg space-y-5">
                <div class="flex flex-col sm:flex-row items-start sm:items-center gap-3 border-b border-slate-200 pb-4">
                    <span class="w-8 h-8 shrink-0 bg-amber-100 text-amber-700 rounded-lg flex items-center justify-center font-extrabold text-xs border border-amber-300">E</span>
                    <div>
                        <h2 class="text-sm font-bold text-slate-950 uppercase tracking-wider break-words whitespace-normal">Penilaian Keseluruhan Program</h2>
                        <p class="text-slate-500 text-xs font-semibold mt-1 break-words whitespace-normal">Sila berikan rating keseluruhan anda untuk program ini (Wajib)</p>
                    </div>
                </div>

                <div class="flex justify-center py-4">
                    <div x-data="{ rating: {{ old('e_overall', 0) }}, hoverRating: 0 }" class="flex items-center gap-1.5 sm:gap-2 flex-wrap justify-center w-full">
                        @for ($i = 1; $i <= 5; $i++)
                            <label class="relative cursor-pointer group flex items-center justify-center w-12 h-12 sm:w-16 sm:h-16 shrink-0"
                                   @mouseenter="hoverRating = {{ $i }}" 
                                   @mouseleave="hoverRating = 0"
                                   @click="rating = {{ $i }}">
                                <input type="radio" name="e_overall" value="{{ $i }}" class="sr-only" x-model="rating" required>
                                <svg xmlns="http://www.w3.org/2000/svg" 
                                     viewBox="0 0 24 24" 
                                     class="w-10 h-10 sm:w-14 sm:h-14 transition-all duration-300"
                                     :class="{
                                        'fill-amber-400 text-amber-700 drop-shadow-[0_0_12px_rgba(251,191,36,0.6)] scale-110': hoverRating >= {{ $i }} || (rating >= {{ $i }} && hoverRating == 0),
                                        'stroke-slate-600 text-transparent stroke-2 group-hover:stroke-slate-500': hoverRating < {{ $i }} && rating < {{ $i }}
                                     }">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z" />
                                </svg>
                            </label>
                        @endfor
                    </div>
                </div>
            </div>

            <!-- ===================== SECTION F ===================== -->
            <div class="bg-white border border-slate-200 shadow-md rounded-2xl border border-slate-200 p-5 sm:p-6 shadow-lg space-y-5" x-data="{ isInterested: '{{ old('f_interested', '') }}' }">
                <div class="flex flex-col sm:flex-row items-start sm:items-center gap-3 border-b border-slate-200 pb-4">
                    <span class="w-8 h-8 shrink-0 bg-violet-500/10 text-violet-400 rounded-lg flex items-center justify-center font-extrabold text-xs border border-violet-500/20">F</span>
                    <div>
                        <h2 class="text-sm font-bold text-slate-950 uppercase tracking-wider break-words whitespace-normal">Minat Masa Hadapan</h2>
                        <p class="text-slate-500 text-xs font-semibold mt-1 break-words whitespace-normal">Adakah anda berminat untuk menyertai program seumpama ini pada masa akan datang?</p>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row gap-4 w-full">
                    <label class="flex items-center gap-3 bg-white shadow-sm p-4 rounded-xl border border-slate-200 cursor-pointer flex-1 transition-all hover:border-violet-500/50"
                           :class="{ 'border-violet-500 bg-violet-500/10': isInterested === '1' }">
                        <input type="radio" name="f_interested" value="1" x-model="isInterested" class="w-5 h-5 shrink-0 text-violet-600 bg-white border-slate-300 focus:ring-violet-600 focus:ring-2">
                        <span class="text-sm font-bold text-slate-950 break-words whitespace-normal">Ya</span>
                    </label>
                    <label class="flex items-center gap-3 bg-white shadow-sm p-4 rounded-xl border border-slate-200 cursor-pointer flex-1 transition-all hover:border-rose-500/50"
                           :class="{ 'border-rose-500 bg-red-100': isInterested === '0' }">
                        <input type="radio" name="f_interested" value="0" x-model="isInterested" class="w-5 h-5 shrink-0 text-rose-600 bg-white border-slate-300 focus:ring-rose-600 focus:ring-2">
                        <span class="text-sm font-bold text-slate-950 break-words whitespace-normal">Tidak</span>
                    </label>
                </div>

                <div class="space-y-2 transition-all duration-300 w-full" x-show="isInterested === '1'" x-transition>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 break-words whitespace-normal">Jika ya, nyatakan bidang yang diminati</label>
                    <input type="text" name="f_field" value="{{ old('f_field') }}" placeholder="Contoh: Pengurusan Strategik, Inovasi Digital" 
                           class="w-full box-border bg-white border border-slate-200 focus:border-violet-500 focus:ring-violet-500/20 text-slate-950 placeholder-slate-600 rounded-xl p-3 sm:p-4 text-sm font-semibold focus:outline-none focus:ring-4 transition-all duration-200">
                </div>
            </div>

            <!-- Submit Button -->
            <div class="pt-2 pb-8 w-full">
                <button type="submit" 
                        class="w-full py-4 bg-blue-900 hover:bg-blue-800 active:scale-[0.99] text-white font-extrabold text-base rounded-2xl shadow-xl border border-blue-400/20 shadow-blue-950/40 transition-all duration-200 flex items-center justify-center gap-3 cursor-pointer uppercase tracking-wider">
                    Hantar Penilaian
                </button>
                <p class="text-center text-xs text-slate-500 font-semibold mt-3 break-words whitespace-normal px-4">
                    Penilaian ini diperlukan untuk anda layak menerima sijil penyertaan.
                </p>
            </div>

        </form>
    </div>

</body>
</html>

