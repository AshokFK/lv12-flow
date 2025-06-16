@props(['disabled' => false])
@php
    $attributes = $attributes->merge([
        'disabled' => $disabled,
    ]);
@endphp
<div wire:ignore>
    <select {{ $attributes }}>
        {{ $slot }}
    </select>
</div>