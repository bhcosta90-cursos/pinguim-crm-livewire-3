@props([
    'menu',
    'open' => false,
    'ml' => false,
])

<ul>
    @foreach($menu as $item)
        <li>
            @if($item['submenu'] ?? null)
                <details {{ ($item['open'] ?? null) ? 'open' : '' }}>
                    <summary
                        @class([
                            'cursor-pointer' => $item['submenu'] ?? null,
                        ])
                    >
                        <div>{{ __($item['title']) }}</div>
                    </summary>

                    <x-layouts.partials.menu
                        :menu="$item['submenu']"
                        :ml="true"
                    />
                </details>
            @else
                <a
                    href="{{ isset($item['route']) ? route($item['route']) : '#' }}"
                    @class([
                        'active' => $item['open'] ?? false,
                    ])
                >
                    <div>{{ __($item['title']) }}</div>
                </a>
            @endif
        </li>
    @endforeach
</ul>
