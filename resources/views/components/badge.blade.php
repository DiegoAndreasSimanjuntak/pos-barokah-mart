@props(['stock', 'threshold' => config('pos.low_stock_threshold')])

@php
    if ($stock <= 0) {
        $label = 'Habis';
        $warna = 'bg-red-100 text-red-700';
    } elseif ($stock < $threshold) {
        $label = 'Menipis';
        $warna = 'bg-yellow-100 text-yellow-700';
    } else {
        $label = 'Aman';
        $warna = 'bg-green-100 text-green-700';
    }
@endphp

<span {{ $attributes->merge(['class' => "inline-block px-2 py-0.5 rounded-full text-xs font-medium $warna"]) }}>
    {{ $label }}
</span>