@props(['status', 'type' => 'booking'])

@php
    $bookingStatus = [
        'menunggu' => ['label' => 'Menunggu', 'class' => 'badge-amber'],
        'dikonfirmasi' => ['label' => 'Dikonfirmasi', 'class' => 'badge-sky'],
        'dikerjakan' => ['label' => 'Sedang Dikerjakan', 'class' => 'badge-violet'],
        'selesai' => ['label' => 'Selesai', 'class' => 'badge-mint'],
        'dibatalkan' => ['label' => 'Dibatalkan', 'class' => 'badge-rose'],
    ];

    $paymentStatus = [
        'belum' => ['label' => 'Belum Dibayar', 'class' => 'badge-amber'],
        'verifikasi' => ['label' => 'Menunggu Verifikasi', 'class' => 'badge-sky'],
        'dibayar' => ['label' => 'Dibayar', 'class' => 'badge-mint'],
        'ditolak' => ['label' => 'Ditolak', 'class' => 'badge-rose'],
    ];

    $map = $type === 'payment' ? $paymentStatus : $bookingStatus;
    $badge = $map[$status] ?? ['label' => ucfirst($status), 'class' => 'badge-slate'];
@endphp

<span {{ $attributes->merge(['class' => 'badge '.$badge['class']]) }}>
    <span class="badge-dot"></span>{{ $badge['label'] }}
</span>
