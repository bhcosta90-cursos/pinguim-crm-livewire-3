@props(['text' => null])

<td {{ $attributes->class(['whitespace-nowrap px-3 py-5 text-sm']) }}>
    {{ $text ?: $slot }}
</td>

