@php use Illuminate\Contracts\Pagination\Paginator; @endphp
@props([
    'head', 'body', 'records', 'filter', 'filterPlaceholder'
])

<div>
    <div class="p-4 bg-gray-50 mt-3 rounded border border-gray-200">
        <div class="text-lg font-bold">Filtrar dados</div>
        <div>
            @if(isset($filter))
                {!! $filter !!}
            @endif
            @if(!isset($filter) && property_exists($this, 'stringFilter') && property_exists($this, 'dataFilter'))
                <div class="space-y-2">
                    <x-taggable />
                    <x-taggable.data />
                </div>
            @endif
        </div>
    </div>

    <div class="overflow-x-auto">
        @if($records->count() > 0)
            <table class="min-w-full divide-y divide-gray-300">
                @if(isset($head))
                    <thead>
                    {!! $head !!}
                    </thead>
                @endif

                <tbody class="divide-y divide-gray-200 bg-white">
                    {{ $slot }}
                </tbody>
            </table>
        @endif

        @if($records->count() === 0)
            <div class="p-4 mt-4 text-center text-gray-500">Nenhum registro encontrado</div>
        @endif

        @if($records instanceof Paginator)
            <div class="px-3 pt-2 pb-3">
                {!! $records->links(data: ['scrollTo' => false]) !!}
            </div>
        @endif
    </div>
</div>
