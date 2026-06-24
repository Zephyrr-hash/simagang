@extends('layouts.app')

@section('title', 'Detail Log Aktivitas — SIMAGANG')

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('depart.home') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('activity-logs.index') }}">Log Aktivitas</a></li>
        <li class="breadcrumb-item active" aria-current="page">Detail</li>
    </ol>
</nav>
@endsection

@push('styles')
<style>
    .detail-card {
        background: #fff;
        border: 1px solid #E2E8F0;
        border-radius: 12px;
        padding: 2rem;
        max-width: 900px;
        margin: 0 auto;
    }
    .detail-header {
        display: flex;
        align-items: flex-start;
        gap: 1.5rem;
        padding-bottom: 1.5rem;
        border-bottom: 2px solid #F1F5F9;
        margin-bottom: 1.5rem;
    }
    .detail-icon {
        width: 64px;
        height: 64px;
        border-radius: 12px;
        background: linear-gradient(135deg, #0EA5E9, #14B8A6);
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        flex-shrink: 0;
    }
    .detail-title-group {
        flex: 1;
    }
    .detail-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: #0F172A;
        margin: 0 0 0.5rem;
    }
    .detail-meta {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
    }
    .meta-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.375rem;
        padding: 0.375rem 0.75rem;
        border-radius: 9999px;
        font-size: 0.8125rem;
        font-weight: 600;
    }
    .meta-badge.primary {
        background: #F0F9FF;
        color: #075985;
    }
    .meta-badge.success {
        background: #F0FDFA;
        color: #0F766E;
    }
    .meta-badge.warning {
        background: #FFFBEB;
        color: #92400E;
    }
    .meta-badge.danger {
        background: #FEF2F2;
        color: #991B1B;
    }
    .detail-section {
        margin-bottom: 2rem;
    }
    .section-title {
        font-size: 0.875rem;
        font-weight: 700;
        color: #64748B;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 1rem;
    }
    .info-grid {
        display: grid;
        gap: 1rem;
    }
    .info-row {
        display: flex;
        align-items: flex-start;
        gap: 1rem;
        padding: 1rem;
        background: #F8FAFC;
        border-radius: 8px;
    }
    .info-label {
        font-size: 0.875rem;
        font-weight: 600;
        color: #64748B;
        min-width: 140px;
    }
    .info-value {
        font-size: 0.9375rem;
        color: #0F172A;
        flex: 1;
        word-break: break-word;
    }
    .details-json {
        background: #1E293B;
        color: #E2E8F0;
        padding: 1.25rem;
        border-radius: 8px;
        font-family: 'Courier New', monospace;
        font-size: 0.8125rem;
        overflow-x: auto;
        line-height: 1.6;
    }
    .user-card {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1.25rem;
        background: linear-gradient(135deg, #F0F9FF, #F0FDFA);
        border-radius: 10px;
        border: 1px solid #BAE6FD;
    }
    .user-avatar {
        width: 56px;
        height: 56px;
        border-radius: 50%;
        background: linear-gradient(135deg, #0EA5E9, #14B8A6);
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        font-weight: 700;
        flex-shrink: 0;
    }
    .user-info h3 {
        font-size: 1.125rem;
        font-weight: 700;
        color: #0F172A;
        margin: 0 0 0.25rem;
    }
    .user-info p {
        font-size: 0.875rem;
        color: #64748B;
        margin: 0;
    }
    .btn-back {
        padding: 0.625rem 1.5rem;
        background: #F1F5F9;
        color: #475569;
        border: 1.5px solid #CBD5E1;
        border-radius: 8px;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.15s;
    }
    .btn-back:hover {
        background: #E2E8F0;
        color: #334155;
        transform: translateX(-2px);
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    
    <div class="detail-card">
        {{-- Header --}}
        <div class="detail-header">
            <div class="detail-icon">
                {{ $log->action_icon }}
            </div>
            <div class="detail-title-group">
                <h1 class="detail-title">{{ $log->description }}</h1>
                <div class="detail-meta">
                    <span class="meta-badge {{ $log->action_badge }}">
                        {{ ucfirst($log->action) }}
                    </span>
                    <span class="meta-badge primary">
                        📦 {{ ucfirst($log->module) }}
                    </span>
                    <span class="meta-badge primary">
                        🕐 {{ $log->created_at->format('d/m/Y H:i:s') }}
                    </span>
                </div>
            </div>
        </div>

        {{-- User Info --}}
        @if($log->user)
        <div class="detail-section">
            <h2 class="section-title">👤 Informasi User</h2>
            <div class="user-card">
                <div class="user-avatar">
                    {{ strtoupper(substr($log->user->name, 0, 2)) }}
                </div>
                <div class="user-info">
                    <h3>{{ $log->user->name }}</h3>
                    <p>{{ $log->role ?? 'Unknown Role' }} • {{ $log->user->email }}</p>
                </div>
            </div>
        </div>
        @endif

        {{-- Activity Details --}}
        <div class="detail-section">
            <h2 class="section-title">📋 Detail Aktivitas</h2>
            <div class="info-grid">
                <div class="info-row">
                    <div class="info-label">ID Log:</div>
                    <div class="info-value"><code>#{{ $log->id }}</code></div>
                </div>
                <div class="info-row">
                    <div class="info-label">Aksi:</div>
                    <div class="info-value">
                        <span class="meta-badge {{ $log->action_badge }}">
                            {{ $log->action_icon }} {{ ucfirst($log->action) }}
                        </span>
                    </div>
                </div>
                <div class="info-row">
                    <div class="info-label">Module:</div>
                    <div class="info-value"><strong>{{ ucfirst($log->module) }}</strong></div>
                </div>
                <div class="info-row">
                    <div class="info-label">Deskripsi:</div>
                    <div class="info-value">{{ $log->description }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Waktu:</div>
                    <div class="info-value">
                        {{ $log->created_at->format('d F Y, H:i:s') }}
                        <span style="color: #64748B;">({{ $log->time_ago }})</span>
                    </div>
                </div>
                <div class="info-row">
                    <div class="info-label">IP Address:</div>
                    <div class="info-value">
                        <code style="color: #0EA5E9;">{{ $log->ip_address ?? '-' }}</code>
                    </div>
                </div>
                <div class="info-row">
                    <div class="info-label">User Agent:</div>
                    <div class="info-value">
                        <small style="color: #64748B;">{{ $log->user_agent ?? '-' }}</small>
                    </div>
                </div>
            </div>
        </div>

        {{-- Additional Details (JSON) --}}
        @if($log->details)
        <div class="detail-section">
            <h2 class="section-title">🔍 Detail Tambahan (JSON)</h2>
            <pre class="details-json">{{ json_encode($log->details, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
        </div>
        @endif

        {{-- Back Button --}}
        <div style="margin-top: 2rem;">
            <a href="{{ route('activity-logs.index') }}" class="btn-back">
                ← Kembali ke Daftar Log
            </a>
        </div>
    </div>

</div>
@endsection
