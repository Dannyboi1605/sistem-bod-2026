<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>{{ $title }}</title>
    <style>
        /* Royal Navy Light theme for print */
        body { font-family: sans-serif; font-size: 11px; color: #020617; margin: 20px; }
        .header { text-align: center; margin-bottom: 24px; }
        .header h2 { font-size: 14px; margin: 8px 0 4px; color: #020617; }
        .header h3 { font-size: 13px; margin: 4px 0; color: #1e3a8a; }
        .header .session { font-size: 11px; color: #475569; }
        table { width: 100%; border-collapse: collapse; }
        thead { display: table-header-group; }
        tr { page-break-inside: avoid; }
        th { background-color: #1e3a8a; color: #ffffff; font-weight: bold;
             padding: 8px 10px; text-align: left; font-size: 10px;
             text-transform: uppercase; letter-spacing: 0.5px; }
        td { border: 1px solid #cbd5e1; padding: 6px 10px; font-size: 10px; }
        tbody tr:nth-child(even) { background-color: #f8fafc; }
        .badge-hadir { background: #dcfce7; color: #14532d;
                       padding: 2px 8px; border-radius: 4px; font-weight: bold; }
        .badge-absent { background: #fee2e2; color: #7f1d1d;
                        padding: 2px 8px; border-radius: 4px; font-weight: bold; }
        .footer { margin-top: 20px; font-size: 9px; color: #64748b;
                  border-top: 1px solid #e2e8f0; padding-top: 8px; }
    </style>
<link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
</head>
<body>
    <!-- Letterhead -->
    <div class="header">
        <img src="{{ public_path('images/logo.png') }}" width="80">
        <h2>KURSUS AHLI LEMBAGA PENGARAH BADAN BERKANUN NEGERI<br>
            DAN SYARIKAT KERAJAAN NEGERI 2026</h2>
        <h3>{{ $title }}</h3>
        <p class="session">Sesi: {{ $sessionLabel }} &nbsp;|&nbsp; Agensi: {{ $agencyLabel ?? 'Semua Agensi' }}</p>
    </div>

    <!-- Participant Table -->
    <table>
        <thead>
            <tr>
                <th style="width: 5%;">No.</th>
                <th style="width: 30%;">Nama</th>
                <th style="width: 25%;">Jawatan</th>
                <th style="width: 25%;">Agensi</th>
                <th style="width: 15%;">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $index => $user)
            @php
                $att = $user->attendances->firstWhere('session_name', $sessionName);
            @endphp
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->position }}</td>
                <td>{{ $user->agency }}</td>
                <td>
                    @if($att)
                        <span class="badge-hadir">Hadir</span><br>
                        <span style="font-size: 8px; color: #475569; display: block; margin-top: 4px;">{{ \Carbon\Carbon::parse($att->scanned_at)->format('h:i A') }}</span>
                    @else
                        <span class="badge-absent">Tidak Hadir</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Footer -->
    <div class="footer">
        Dijana pada: {{ now()->format('d/m/Y H:i') }} &nbsp;|&nbsp;
        Jumlah rekod: {{ $users->count() }}
    </div>
</body>
</html>

