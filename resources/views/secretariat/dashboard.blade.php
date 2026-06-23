<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kaunter Urus Setia - Imbasan Kehadiran</title>
    <!-- Google Fonts Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Html5 Qrcode Library CDN -->
    <script src="https://unpkg.com/html5-qrcode"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        /* Custom styles to make html5-qrcode look modern and clean */
        #reader {
            border: none !important;
        }
        #reader__dashboard_section_csr button {
            background-color: #2563eb !important; /* bg-blue-900 */
            color: white !important;
            padding: 0.75rem 1.5rem !important;
            border-radius: 0.75rem !important;
            font-weight: 700 !important;
            font-size: 0.875rem !important;
            border: 1px solid rgba(59, 130, 246, 0.3) !important;
            cursor: pointer;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            transition: all 0.2s;
        }
        #reader__dashboard_section_csr button:hover {
            background-color: #1d4ed8 !important; /* bg-blue-700 */
        }
        #reader img {
            display: inline-block;
        }
    </style>
<link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
</head>
<body class="bg-slate-50 text-slate-950 min-h-screen p-4 md:p-8">
    <div class="max-w-xl mx-auto space-y-6">
        
        <!-- Header -->
        <div class="bg-white border border-slate-200 shadow-md backdrop-blur-md rounded-2xl border border-slate-200 p-6 flex flex-col items-center justify-between md:flex-row gap-4 shadow-xl">
            <div class="flex items-center gap-4">
                <!-- <div class="w-12 h-12 bg-blue-50 text-blue-900 rounded-xl flex items-center justify-center border border-blue-200 shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h.01M16 12h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div> -->
                <div>
                    <h1 class="text-lg font-black text-slate-950 uppercase tracking-wider leading-none">Kaunter Urus Setia</h1>
                    <p class="text-slate-600 text-xs font-semibold mt-1.5">Imbasan Kehadiran & Pengesahan</p>
                </div>
            </div>
            
            <!-- Secretariat User Display & Logout -->
            <div class="flex flex-wrap items-center gap-3">
                <div class="flex items-center gap-2 bg-white shadow-sm px-4 py-2.5 rounded-xl border border-slate-200">
                    <span class="w-2.5 h-2.5 bg-emerald-500 rounded-full animate-pulse"></span>
                    <span class="text-xs font-bold text-slate-950">{{ Auth::user()->name ?? 'Urus Setia' }}</span>
                </div>
                @if(Auth::user()->hasRole('admin'))
                <a href="{{ route('admin.dashboard') }}" 
                   class="flex items-center gap-2 bg-indigo-600 hover:bg-indigo-500 active:scale-[0.98] text-white px-4 py-2.5 rounded-xl border border-indigo-300 text-xs font-bold shadow-sm transition-all cursor-pointer uppercase tracking-wider">
                    Mod Admin
                </a>
                @endif
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="bg-rose-600 hover:bg-rose-500 active:scale-[0.98] text-white px-4 py-2.5 rounded-xl border border-red-300 text-xs font-bold shadow-sm transition-all cursor-pointer uppercase tracking-wider">
                        Log Keluar
                    </button>
                </form>
            </div>
        </div>

        <!-- Scanning Card Container -->
        <div class="bg-white border border-slate-200 shadow-md backdrop-blur-md border border-slate-200 p-6 md:p-8 rounded-2xl shadow-xl space-y-6">
            <h2 class="text-sm font-bold text-slate-500 uppercase tracking-widest text-center">Imbas Kod QR Peserta</h2>
            
            <!-- Camera QR scanner container (Centered & Fluid Scale) -->
            <div class="bg-white shadow-sm rounded-xl overflow-hidden border border-slate-200/80 mb-6 flex flex-col items-center justify-center p-4">
                <div id="reader" class="w-full max-w-md"></div>
            </div>

            <!-- Dynamic Alert Toast/Status Box -->
            <div id="status-box" class="p-5 rounded-xl border text-center font-bold text-sm transition-all duration-300 bg-white shadow-sm border-slate-200 text-slate-950">
                <div id="status-text">Sedia untuk mengimbas QR kod.</div>
                <div id="doorgift-container" class="mt-4 hidden"></div>
            </div>

            <!-- Action Control Container -->
            <div id="scan-next-container" class="hidden text-center">
                <button 
                    onclick="startScanner()" 
                    class="w-full py-4 bg-emerald-600 hover:bg-emerald-500 active:scale-[0.99] text-white font-extrabold text-sm rounded-xl shadow-lg border border-green-300 shadow-emerald-950/50 transition-all duration-200 cursor-pointer uppercase tracking-wider"
                >
                    Imbas Seterusnya
                </button>
            </div>
        </div>
    </div>

    <!-- Scanning Script Logic -->
    <script>
        let html5QrcodeScanner = null;

        function onScanSuccess(decodedText, decodedResult) {
            console.log(`Code scanned: ${decodedText}`);

            // Berhentikan pengimbas seketika untuk mengelakkan imbasan bertindan
            if (html5QrcodeScanner) {
                html5QrcodeScanner.clear().then(() => {
                    // Show "Scan Next" button to allow restarting
                    document.getElementById('scan-next-container').classList.remove('hidden');

                    // Show loader state
                    showStatus('loading', 'Sedang memproses kehadiran...');

                    try {
                        // Tukarkan URL mutlak daripada kod QR kepada laluan relatif (relative path)
                        const urlObj = new URL(decodedText);
                        const relativeUrl = urlObj.pathname + urlObj.search;

                        // Lakukan fetch menggunakan laluan relatif untuk menjamin kuki sesi dihantar bersama
                        fetch(relativeUrl, {
                            method: 'GET',
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'Accept': 'application/json'
                            }
                        })
                        .then(response => {
                            return response.json().then(data => {
                                if (response.status === 201) {
                                    showStatus('success', `<div class="text-xs opacity-75">${data.message || 'Kehadiran berjaya didaftarkan.'}</div><div class="text-base font-extrabold mt-1 uppercase tracking-wide">${data.participant_name}</div>`);
                                    renderDoorgiftButton(data.participant_id, data.has_received_doorgift);
                                } else if (response.status === 200) {
                                    showStatus('warning', `<div class="text-xs opacity-75">${data.message || 'Peserta sudah mendaftar hadir untuk sesi ini.'}</div><div class="text-base font-extrabold mt-1 uppercase tracking-wide">${data.participant_name}</div>`);
                                    renderDoorgiftButton(data.participant_id, data.has_received_doorgift);
                                } else {
                                    showStatus('danger', data.error || 'Ralat pengesahan kod QR.');
                                }
                            });
                        })
                        .catch(err => {
                            console.error('Fetch error:', err);
                            showStatus('danger', 'Ralat sambungan pelayan.');
                        });
                    } catch (e) {
                        // Jika teks yang diimbas bukan format URL yang sah
                        showStatus('danger', 'Format kod QR tidak dikenali.');
                    }
                }).catch(err => {
                    console.error('Failed to clear scanner:', err);
                });
            }
        }

        function renderDoorgiftButton(participantId, hasReceived) {
            const container = document.getElementById('doorgift-container');
            if (!container) return;
            
            container.classList.remove('hidden');
            container.innerHTML = '';
            
            const btn = document.createElement('button');
            btn.type = 'button';
            btn.id = 'doorgift-action-btn';
            
            if (hasReceived) {
                btn.className = "w-full py-2.5 bg-slate-200 text-slate-500 border border-slate-300 font-bold text-xs rounded-lg cursor-not-allowed transition-all uppercase tracking-wider";
                btn.disabled = true;
                btn.innerHTML = `🎁 ✓ Doorgift Telah Diterima`;
            } else {
                btn.className = "w-full py-2.5 bg-blue-600 hover:bg-blue-500 active:scale-[0.98] text-white border border-blue-400 font-extrabold text-xs rounded-lg shadow-sm transition-all cursor-pointer uppercase tracking-wider";
                btn.innerHTML = `🎁 Tandakan Doorgift Diterima`;
                btn.addEventListener('click', function() {
                    submitDoorgiftStatus(btn, participantId);
                });
            }
            container.appendChild(btn);
        }

        function submitDoorgiftStatus(btn, participantId) {
            btn.disabled = true;
            const originalHTML = btn.innerHTML;
            btn.innerHTML = `<span class="inline-block animate-spin mr-2">⏳</span> Sedang memproses...`;
            
            fetch(`/secretariat/users/${participantId}/doorgift`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({ status: true })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Ralat sistem.');
                }
                return response.json();
            })
            .then(data => {
                if (data.success && data.has_received_doorgift) {
                    btn.className = "w-full py-2.5 bg-slate-200 text-slate-500 border border-slate-300 font-bold text-xs rounded-lg cursor-not-allowed transition-all uppercase tracking-wider";
                    btn.disabled = true;
                    btn.innerHTML = `🎁 ✓ Doorgift Telah Diterima`;
                } else {
                    btn.disabled = false;
                    btn.innerHTML = originalHTML;
                    alert('Gagal menandakan doorgift.');
                }
            })
            .catch(err => {
                console.error(err);
                btn.disabled = false;
                btn.innerHTML = originalHTML;
                alert('Ralat sambungan pelayan atau kebenaran ditolak.');
            });
        }

        function showStatus(type, message) {
            const box = document.getElementById('status-box');
            const text = document.getElementById('status-text');
            const doorgiftContainer = document.getElementById('doorgift-container');
            
            if (doorgiftContainer) {
                doorgiftContainer.classList.add('hidden');
                doorgiftContainer.innerHTML = '';
            }
            
            if (type === 'success') {
                box.className = "p-5 rounded-xl border text-center font-bold text-sm transition-all duration-300 bg-green-100 border-green-300 text-green-800";
            } else if (type === 'warning') {
                box.className = "p-5 rounded-xl border text-center font-bold text-sm transition-all duration-300 bg-amber-100 border-amber-300 text-amber-800";
            } else if (type === 'danger') {
                box.className = "p-5 rounded-xl border text-center font-bold text-sm transition-all duration-300 bg-red-100 border-red-300 text-red-800";
            } else if (type === 'loading') {
                box.className = "p-5 rounded-xl border text-center font-bold text-sm transition-all duration-300 bg-blue-50 border-blue-200 text-blue-800 animate-pulse";
            } else {
                box.className = "p-5 rounded-xl border text-center font-bold text-sm transition-all duration-300 bg-white shadow-sm border-slate-200 text-slate-950";
            }
            
            text.innerHTML = message;
        }

        function startScanner() {
            // Re-hide Scan Next button
            document.getElementById('scan-next-container').classList.add('hidden');
            showStatus('idle', 'Sedia untuk mengimbas QR kod.');

            // Instantiate and start scanner
            html5QrcodeScanner = new Html5QrcodeScanner(
                "reader", 
                { 
                    fps: 15, 
                    qrbox: { width: 220, height: 220 },
                    rememberLastUsedCamera: true
                },
                /* verbose= */ false
            );
            html5QrcodeScanner.render(onScanSuccess);
        }

        // Initialize scanner automatically on load
        window.addEventListener('load', startScanner);
    </script>
</body>
</html>

