@props(['label' => null])
<ts-button {{ $attributes }}>
    {{ $label ?: $slot }}
</ts-button>
