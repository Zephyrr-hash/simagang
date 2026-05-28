<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>@yield('pdf-title', 'Dokumen') — SIMAGANG</title>
    <style>
        /* ===== RESET & BASE ===== */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 11pt;
            color: #1F2937;
            line-height: 1.5;
            background-color: #ffffff;
        }

        /* ===== HEADER ===== */
        .pdf-header {
            background-color: #4F46E5;
            color: #ffffff;
            padding: 14px 20px;
            margin-bottom: 20px;
            border-radius: 4px;
        }

        .pdf-header-top {
            display: block;
            margin-bottom: 6px;
        }

        .pdf-header-system {
            font-size: 9pt;
            font-weight: normal;
            color: rgba(255, 255, 255, 0.75);
            text-transform: uppercase;
            letter-spacing: 0.08em;
        }

        .pdf-header-title {
            font-size: 16pt;
            font-weight: bold;
            color: #ffffff;
            margin-top: 2px;
        }

        .pdf-header-meta {
            font-size: 8.5pt;
            color: rgba(255, 255, 255, 0.7);
            margin-top: 6px;
            border-top: 1px solid rgba(255, 255, 255, 0.2);
            padding-top: 6px;
        }

        /* ===== DIVIDER ===== */
        .pdf-divider {
            border: none;
            border-top: 1px solid #E0E7FF;
            margin: 14px 0;
        }

        /* ===== SECTION TITLE ===== */
        h1 {
            font-size: 14pt;
            font-weight: bold;
            color: #1E1B4B;
            margin-bottom: 10px;
            padding-bottom: 4px;
            border-bottom: 2px solid #4F46E5;
        }

        h2 {
            font-size: 12pt;
            font-weight: bold;
            color: #1E1B4B;
            margin-top: 14px;
            margin-bottom: 8px;
        }

        h3 {
            font-size: 11pt;
            font-weight: bold;
            color: #374151;
            margin-top: 10px;
            margin-bottom: 6px;
        }

        p {
            margin-bottom: 8px;
            font-size: 10.5pt;
            color: #374151;
        }

        /* ===== TABLE ===== */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 14px;
            font-size: 10pt;
        }

        table thead tr {
            background-color: #4F46E5;
            color: #ffffff;
        }

        table thead th {
            padding: 8px 10px;
            text-align: left;
            font-weight: bold;
            font-size: 9.5pt;
            border: 1px solid #4338CA;
        }

        table tbody tr {
            background-color: #ffffff;
        }

        table tbody tr:nth-child(even) {
            background-color: #EEF2FF;
        }

        table tbody td {
            padding: 7px 10px;
            border: 1px solid #E0E7FF;
            vertical-align: top;
            font-size: 10pt;
            color: #374151;
        }

        table tfoot tr {
            background-color: #F5F3FF;
        }

        table tfoot td {
            padding: 7px 10px;
            border: 1px solid #E0E7FF;
            font-weight: bold;
            font-size: 10pt;
        }

        /* ===== INFO BOX ===== */
        .info-box {
            background-color: #EEF2FF;
            border-left: 4px solid #4F46E5;
            padding: 10px 14px;
            margin-bottom: 14px;
            border-radius: 0 4px 4px 0;
        }

        .info-box p {
            margin: 0;
            font-size: 10pt;
            color: #374151;
        }

        /* ===== LABEL-VALUE PAIRS ===== */
        .detail-table {
            width: 100%;
            margin-bottom: 14px;
        }

        .detail-table td {
            padding: 5px 8px;
            font-size: 10.5pt;
            vertical-align: top;
            border: none;
        }

        .detail-table td.label {
            width: 35%;
            font-weight: bold;
            color: #4B5563;
        }

        .detail-table td.separator {
            width: 3%;
            color: #9CA3AF;
        }

        .detail-table td.value {
            width: 62%;
            color: #1F2937;
        }

        /* ===== BADGE / STATUS ===== */
        .badge {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 10px;
            font-size: 8.5pt;
            font-weight: bold;
        }

        .badge-success {
            background-color: #D1FAE5;
            color: #065F46;
        }

        .badge-warning {
            background-color: #FEF3C7;
            color: #92400E;
        }

        .badge-danger {
            background-color: #FEE2E2;
            color: #991B1B;
        }

        .badge-info {
            background-color: #DBEAFE;
            color: #1E40AF;
        }

        /* ===== SIGNATURE AREA ===== */
        .signature-area {
            margin-top: 30px;
        }

        .signature-box {
            display: inline-block;
            width: 45%;
            text-align: center;
            padding: 10px;
        }

        .signature-line {
            border-top: 1px solid #374151;
            margin-top: 50px;
            padding-top: 6px;
            font-size: 10pt;
            color: #374151;
        }

        /* ===== FOOTER ===== */
        .pdf-footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            height: 30px;
            background-color: #F5F3FF;
            border-top: 1px solid #E0E7FF;
            padding: 6px 20px;
            font-size: 8pt;
            color: #6B7280;
        }

        .pdf-footer-left {
            float: left;
        }

        .pdf-footer-right {
            float: right;
        }

        .pdf-footer-center {
            text-align: center;
        }

        /* DomPDF page counter */
        .page-number:before {
            content: counter(page);
        }

        .page-total:before {
            content: counter(pages);
        }

        /* ===== UTILITY ===== */
        .text-center { text-align: center; }
        .text-right  { text-align: right; }
        .text-left   { text-align: left; }
        .text-muted  { color: #6B7280; font-size: 9.5pt; }
        .font-bold   { font-weight: bold; }
        .mt-10       { margin-top: 10px; }
        .mt-20       { margin-top: 20px; }
        .mb-10       { margin-bottom: 10px; }
        .mb-20       { margin-bottom: 20px; }
        .page-break  { page-break-after: always; }
    </style>
</head>
<body>

    {{-- ===== HEADER ===== --}}
    <div class="pdf-header">
        <div class="pdf-header-top">
            <span class="pdf-header-system">SIMAGANG — Sistem Informasi Magang</span>
        </div>
        <div class="pdf-header-title">@yield('pdf-title', 'Dokumen')</div>
        <div class="pdf-header-meta">
            Dicetak pada: {{ \Carbon\Carbon::now()->translatedFormat('d F Y, H:i') }} WIB
            @hasSection('pdf-subtitle')
                &nbsp;&bull;&nbsp; @yield('pdf-subtitle')
            @endif
        </div>
    </div>

    {{-- ===== KONTEN UTAMA ===== --}}
    <div class="pdf-content">
        @yield('content')
    </div>

    {{-- ===== FOOTER ===== --}}
    <div class="pdf-footer">
        <span class="pdf-footer-left">SIMAGANG &copy; {{ date('Y') }}</span>
        <span class="pdf-footer-right">
            Halaman <span class="page-number"></span> dari <span class="page-total"></span>
        </span>
    </div>

</body>
</html>
