@php
    $nameLength = mb_strlen($user->name);

    // Only font-size changes per length — NO top adjustments needed.
    // The table-cell vertical-align:middle handles centering automatically.
    $fontSize = match (true) {
        $nameLength <= 35 => '36px',  // 1 baris
        $nameLength <= 50 => '32px',  // Mungkin 2 baris
        $nameLength <= 70 => '24px',  // Sah 2 baris
        default           => '20px',  // Nama sangat panjang
    };
@endphp
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Sijil Penyertaan — {{ $user->name }}</title>
    <style>
        /* Strip all default margins for full-bleed background */
        @page {
            margin: 0px;
            padding: 0px;
            size: A4 landscape;
        }

        body {
            margin: 0px;
            padding: 0px;
            font-family: sans-serif;
        }

        /* Full-canvas container */
        .canvas {
            position: relative;
            width: 100%;
            height: 100%;
        }

        /* Background image covering entire A4 landscape */
        .bg-image {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
        }

        @font-face {
            font-family: 'Saira';
            src: url('{{ public_path("fonts/saira-bold.ttf") }}') format('truetype');
            font-weight: bold;
            font-style: normal;
        }

        /*
         * THE FIX: display:table container with a fixed height that
         * exactly spans the blank gap on the certificate background.
         *
         * Gap runs from ~37% to ~50% of the page height (13% tall).
         * The table-cell inside uses vertical-align:middle so the
         * name is ALWAYS centered — whether it renders as 1, 2, or
         * even 3 lines. No per-length `top` hacks needed.
         */
        .name-container {
            position: absolute;
            top: 38.7%;
            left: 10%;
            width: 80%;
            height: 13%;
            display: table;
            z-index: 10;
        }

        .name-overlay {
            display: table-cell;
            vertical-align: middle;
            text-align: center;
            color: #001c5b;
            font-family: 'Saira', sans-serif;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
            white-space: normal;
            word-wrap: break-word;
            line-height: 1.15;
        }
    </style>
</head>

<body>
    <div class="canvas">
        {{-- Full-bleed certificate background --}}
        <img src="{{ public_path('images/Template-Sijil-Penyertaan.jpg') }}" class="bg-image">

        {{-- Dynamic participant name — table-cell auto-centers any line count --}}
        <div class="name-container">
            <div class="name-overlay" style="font-size: {{ $fontSize }};">
                {{ $user->name }}
            </div>
        </div>
    </div>
</body>

</html>