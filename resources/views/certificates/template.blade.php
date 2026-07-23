<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>E-Sertifikat - {{ $eventTitle }}</title>
    <style>
        /* Catatan: DOMPDF lebih stabil menggunakan vanilla CSS (bukan Tailwind) */
        @page { margin: 0px; }
        body { 
            font-family: 'Helvetica', 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8fafc;
            color: #1e293b;
        }
        .container {
            width: 100%;
            height: 100%;
            padding: 50px;
            box-sizing: border-box;
            background: #ffffff;
            border: 20px solid #2563eb; /* Biru tebal sebagai bingkai luar */
            position: relative;
        }
        .inner-border {
            border: 2px solid #93c5fd; /* Garis tipis bagian dalam */
            padding: 50px 30px;
            height: 100%;
            box-sizing: border-box;
            text-align: center;
        }
        .header {
            font-size: 24px;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 4px;
            margin-bottom: 10px;
        }
        .title {
            font-size: 54px;
            font-weight: bold;
            color: #1e40af;
            margin: 10px 0 40px 0;
        }
        .text {
            font-size: 18px;
            color: #475569;
            margin-bottom: 15px;
        }
        .name {
            font-size: 42px;
            font-weight: bold;
            color: #0f172a;
            border-bottom: 2px solid #cbd5e1;
            display: inline-block;
            padding-bottom: 5px;
            margin-bottom: 30px;
            width: 60%;
        }
        .event-title {
            font-size: 24px;
            font-weight: bold;
            color: #2563eb;
            margin: 20px 0;
        }
        .footer {
            position: absolute;
            bottom: 80px;
            width: 100%;
            left: 0;
        }
        .signature-box {
            display: inline-block;
            width: 30%;
        }
        .signature-line {
            border-top: 1px solid #000;
            margin-top: 50px;
            padding-top: 10px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="inner-border">
            
            <div class="header">Diberikan Kepada</div>
            
            <div class="name">{{ strtoupper($buyerName) }}</div>
            
            <div class="text">Atas partisipasinya sebagai peserta dalam acara:</div>
            
            <div class="event-title">"{{ $eventTitle }}"</div>
            
            <div class="text">Yang diselenggarakan dengan sukses pada tanggal {{ $eventDate }}.</div>
            
            <div class="footer">
                <div class="signature-box">
                    <div class="signature-line">{{ $organizer }}</div>
                    <div style="font-size: 14px; color: #64748b;">Penyelenggara Acara</div>
                </div>
            </div>

        </div>
    </div>
</body>
</html>