<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Surat Hasil - {{ $pengajuan->nomor_pengajuan }}</title>
    <style>
        * { margin: 0; padding: 0; }
        body { 
            font-family: 'Calibri', 'Arial', sans-serif; 
            color: #000; 
            font-size: 12px; 
            line-height: 1.6; 
            background: #fff;
        }
        .surat { 
            max-width: 800px; 
            margin: 0 auto; 
            background: #fff; 
            padding: 40px 50px; 
            min-height: 100vh; 
            display: flex; 
            flex-direction: column; 
        }
        .content { flex: 1; }
        .footer-content { flex-grow: 1; margin-top: 40px; }
        .header { 
            text-align: center; 
            margin-bottom: 25px; 
            border-bottom: 3px solid #000; 
            padding-bottom: 15px; 
        }
        .header-title { 
            font-size: 14px; 
            font-weight: bold; 
            color: #000; 
            margin-bottom: 3px; 
            letter-spacing: 0.5px; 
        }
        .header-subtitle { 
            font-size: 13px; 
            font-weight: bold;
            color: #000; 
            margin-bottom: 5px; 
            letter-spacing: 0.3px; 
        }
        .nomor { 
            font-size: 11px; 
            color: #333; 
            margin-top: 8px; 
        }
        table { 
            width: 100%; 
            border-collapse: collapse; 
            margin: 10px 0;
        }
        td {
            padding: 5px 0;
            font-size: 11px;
            line-height: 1.6;
        }
        p {
            margin: 10px 0;
            font-size: 11px;
            line-height: 1.8;
            text-align: justify;
        }
        .signature-section { 
            margin-top: 40px; 
            display: flex; 
            justify-content: flex-end; 
        }
        .signature-box { 
            text-align: center; 
            width: 200px; 
        }
        .signature-line { 
            border-top: 1px solid #000; 
            width: 100%; 
            margin: 50px 0 3px 0; 
        }
        .signature-name { 
            font-weight: bold; 
            margin-top: 3px; 
            font-size: 11px; 
        }
        .signature-nip { 
            font-size: 10px; 
            color: #333; 
            margin-top: 2px; 
        }
        .date-place { 
            text-align: right; 
            margin-bottom: 30px; 
            font-size: 11px; 
        }
        .date-place-label { margin-bottom: 2px; }
        .date-place-value { 
            font-weight: bold; 
            margin-top: 3px; 
        }
        @media print { 
            body { background: #fff; } 
            .surat { box-shadow: none; min-height: auto; padding: 30px 40px; } 
        }
    </style>
</head>
<body>
    @include('pengajuan.surat-template', ['pengajuan' => $pengajuan])
</body>
</html>
