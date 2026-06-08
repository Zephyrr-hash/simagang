@extends('layouts.pdf')

@section('pdf-title', 'Logbook — ' . $project->nama_project)
@section('pdf-subtitle', $mhs->nama_mhs ?? '')

@section('content')
<table class="detail-table" style="margin-bottom:16px;">
    <tr><td class="label">Mahasiswa</td><td class="separator">:</td><td class="value">{{ $mhs->nama_mhs ?? '—' }}</td></tr>
    <tr><td class="label">NIM</td><td class="separator">:</td><td class="value">{{ $mhs->NIM ?? '—' }}</td></tr>
    <tr><td class="label">Jurusan</td><td class="separator">:</td><td class="value">{{ $mhs->jurusan?->jurusan ?? '—' }}</td></tr>
    <tr><td class="label">Project</td><td class="separator">:</td><td class="value">{{ $project->nama_project }}</td></tr>
    <tr><td class="label">Teknologi</td><td class="separator">:</td><td class="value">{{ $project->teknologi ?? '—' }}</td></tr>
    @if($magang)
    <tr><td class="label">Tempat Magang</td><td class="separator">:</td><td class="value">{{ $magang->lowongan?->mitra?->nama_mitra ?? '—' }}</td></tr>
    <tr><td class="label">Posisi</td><td class="separator">:</td><td class="value">{{ $magang->lowongan?->nama_low ?? '—' }}</td></tr>
    <tr><td class="label">Dosen Pembimbing</td><td class="separator">:</td><td class="value">{{ $magang->dosen?->nama_dosen ?? '—' }}</td></tr>
    <tr><td class="label">Supervisor</td><td class="separator">:</td><td class="value">{{ $magang->spv?->nama_spv ?? '—' }}</td></tr>
    @endif
</table>

<hr style="border:none;border-top:1px solid #E0E7FF;margin:12px 0;">
<h2>Daftar Aktivitas Logbook</h2>

@if($logbooks->isEmpty())
    <p class="text-muted">Belum ada entri logbook.</p>
@else
<table>
    <thead>
        <tr>
            <th style="width:5%;">#</th>
            <th style="width:12%;">Tanggal</th>
            <th style="width:20%;">Kegiatan</th>
            <th style="width:30%;">Deskripsi</th>
            <th style="width:18%;">Saran</th>
            <th style="width:15%;">Catatan SPV</th>
        </tr>
    </thead>
    <tbody>
        @foreach($logbooks as $i => $log)
        <tr>
            <td>{{ $i + 1 }}</td>
            <td>{{ \Carbon\Carbon::parse($log->tanggal)->format('d/m/Y') }}</td>
            <td>{{ $log->kegiatan }}</td>
            <td>{{ $log->deskripsi_log }}</td>
            <td>{{ $log->saran ?? '—' }}</td>
            <td>{{ $log->catatan_spv ?? '—' }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
<p class="text-muted mt-10">Total: {{ $logbooks->count() }} entri</p>
@endif

<div class="signature-area" style="margin-top:40px;">
    <table style="width:100%;border:none;">
        <tr>
            <td style="width:50%;text-align:center;border:none;padding:0;">
                <p style="font-size:10pt;margin-bottom:50px;">Mengetahui,<br>Dosen Pembimbing</p>
                <p style="font-size:10pt;border-top:1px solid #374151;padding-top:6px;display:inline-block;min-width:150px;">{{ $magang?->dosen?->nama_dosen ?? '___________________' }}</p>
            </td>
            <td style="width:50%;text-align:center;border:none;padding:0;">
                <p style="font-size:10pt;margin-bottom:50px;">Mahasiswa,</p>
                <p style="font-size:10pt;border-top:1px solid #374151;padding-top:6px;display:inline-block;min-width:150px;">{{ $mhs->nama_mhs ?? '___________________' }}</p>
            </td>
        </tr>
    </table>
</div>
@endsection
