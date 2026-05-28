@props([
    'status' => 0,
])

@php
    /**
     * Mapping status approval ke warna dan label.
     *
     * Integer: 0 = Menunggu, 1 = Diterima, 2 = Ditolak, 3 = Selesai
     * String : 'pending', 'diterima', 'ditolak', 'selesai'
     */
    $statusMap = [
        // Nilai integer
        0           => ['bg' => '#FEF3C7', 'text' => '#92400E', 'label' => 'Menunggu'],
        1           => ['bg' => '#D1FAE5', 'text' => '#065F46', 'label' => 'Diterima'],
        2           => ['bg' => '#FEE2E2', 'text' => '#991B1B', 'label' => 'Ditolak'],
        3           => ['bg' => '#DBEAFE', 'text' => '#1E40AF', 'label' => 'Selesai'],
        // Nilai string (alias)
        'pending'   => ['bg' => '#FEF3C7', 'text' => '#92400E', 'label' => 'Menunggu'],
        'diterima'  => ['bg' => '#D1FAE5', 'text' => '#065F46', 'label' => 'Diterima'],
        'ditolak'   => ['bg' => '#FEE2E2', 'text' => '#991B1B', 'label' => 'Ditolak'],
        'selesai'   => ['bg' => '#DBEAFE', 'text' => '#1E40AF', 'label' => 'Selesai'],
    ];

    // Normalisasi: coba integer dulu, lalu string lowercase
    $key = is_numeric($status) ? (int) $status : strtolower((string) $status);

    $style = $statusMap[$key] ?? ['bg' => '#F3F4F6', 'text' => '#374151', 'label' => 'Tidak Diketahui'];
@endphp

<span style="
    display: inline-flex;
    align-items: center;
    background-color: {{ $style['bg'] }};
    color: {{ $style['text'] }};
    border-radius: 100px;
    padding: 2px 10px;
    font-size: 0.75rem;
    font-weight: 600;
    line-height: 1.5;
    white-space: nowrap;
" role="status" aria-label="Status: {{ $style['label'] }}">
    {{ $style['label'] }}
</span>
