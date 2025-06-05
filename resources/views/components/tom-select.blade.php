@props(['disabled' => false])
@php
    $attributes = $attributes->merge([
        'class' => 'tom-select w-full rounded-lg border block bg-white text-sm font-normal shadow-sm',
        'disabled' => $disabled,
    ]);
@endphp
<div wire:ignore>
    <select {{ $attributes }}>
        {{ $slot }}
    </select>
</div>