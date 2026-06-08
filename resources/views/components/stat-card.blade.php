@props([
    'title'       => '',
    'value'       => '',
    'icon'        => '',
    'color'       => 'indigo',
    'description' => '',
    'link'        => '',
])

@php
    /**
     * Peta warna untuk gradient ikon dan aksen teks.
     * Mendukung: indigo, violet, emerald, amber, red, blue
     */
    $colorMap = [
        'indigo'  => ['gradient' => 'linear-gradient(135deg, #4F46E5, #6366F1)', 'text' => '#4F46E5'],
        'violet'  => ['gradient' => 'linear-gradient(135deg, #7C3AED, #8B5CF6)', 'text' => '#7C3AED'],
        'emerald' => ['gradient' => 'linear-gradient(135deg, #059669, #10B981)', 'text' => '#059669'],
        'amber'   => ['gradient' => 'linear-gradient(135deg, #D97706, #F59E0B)', 'text' => '#D97706'],
        'red'     => ['gradient' => 'linear-gradient(135deg, #DC2626, #EF4444)', 'text' => '#DC2626'],
        'blue'    => ['gradient' => 'linear-gradient(135deg, #2563EB, #3B82F6)', 'text' => '#2563EB'],
    ];

    $palette  = $colorMap[$color] ?? $colorMap['indigo'];
    $gradient = $palette['gradient'];
    $accent   = $palette['text'];

    $cardId = 'stat-card-' . uniqid();
@endphp

<style>
    .stat-card {
        background: #ffffff;
        border-radius: 12px;
        box-shadow: 0 1px 4px rgba(0, 0, 0, 0.06), 0 1px 2px rgba(0, 0, 0, 0.04);
        padding: 1.25rem 1.5rem;
        display: flex;
        align-items: flex-start;
        gap: 1rem;
        transition: box-shadow 0.2s ease, transform 0.2s ease;
        text-decoration: none;
        color: inherit;
        width: 100%;
        min-height: 100px;
    }

    .stat-card:hover {
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1), 0 2px 8px rgba(0, 0, 0, 0.06);
        transform: translateY(-2px);
        text-decoration: none;
        color: inherit;
    }

    .stat-card__icon {
        width: 48px;
        height: 48px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .stat-card__icon svg {
        width: 24px;
        height: 24px;
        color: #ffffff;
    }

    .stat-card__body {
        flex: 1;
        min-width: 0;
    }

    .stat-card__value {
        font-size: 2rem;
        font-weight: 700;
        line-height: 1.1;
        color: #111827;
        letter-spacing: -0.02em;
    }

    .stat-card__title {
        font-size: 0.8125rem;
        font-weight: 500;
        color: #6B7280;
        margin-top: 0.125rem;
    }

    .stat-card__description {
        font-size: 0.75rem;
        color: #9CA3AF;
        margin-top: 0.375rem;
        display: flex;
        align-items: center;
        gap: 0.25rem;
    }
</style>

@if($link)
    <a href="{{ $link }}" class="stat-card" id="{{ $cardId }}" aria-label="{{ $title }}: {{ $value }}">
@else
    <div class="stat-card" id="{{ $cardId }}" role="region" aria-label="{{ $title }}: {{ $value }}">
@endif

    {{-- Ikon dengan gradient background --}}
    <div class="stat-card__icon" style="background: {{ $gradient }};" aria-hidden="true">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
             stroke-width="1.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="{{ $icon }}" />
        </svg>
    </div>

    {{-- Konten teks --}}
    <div class="stat-card__body">
        <div class="stat-card__value">{{ $value }}</div>
        <div class="stat-card__title">{{ $title }}</div>

        @if($description)
            <div class="stat-card__description">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                     stroke-width="1.5" stroke="currentColor"
                     style="width:12px;height:12px;color:{{ $accent }};flex-shrink:0;"
                     aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
                </svg>
                <span>{{ $description }}</span>
            </div>
        @endif
    </div>

@if($link)
    </a>
@else
    </div>
@endif
