@extends('layouts.app')

@section('content')
    <h1 class="text-lg font-medium py-4">Hasil Pencarian: <span class="font-semibold">"{{ $keyword }}"</span></h1>

    @forelse ($results as $type => $items)
        <h2 class="py-4 text-xl font-bold">{{ ucfirst($type) }}</h2>

        @if (!empty($items))
            <div class="overflow-x-auto">
                <table class="bg-white border border-gray-200 rounded-lg table-fixed">
                    <thead>
                        <tr class="bg-gray-100 text-gray-600 uppercase text-sm leading-normal">
                            @foreach (array_keys($items[0]) as $column)
                                <th class="min-w-[100px]">{{ ucwords(str_replace('_', ' ', $column)) }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody class=" text-gray-600 text-sm font-light">
                        @foreach ($items as $item)
                            <tr class="border-b border-gray-200 hover:bg-gray-50">
                                @foreach ($item as $value)
                                    <td class="py-3 px-6 text-left">
                                        {!! preg_replace(
                                        '/(' . preg_quote($keyword, '/') . ')/i',
                                        '<mark>$1</mark>',
                                        e($value)
                                    ) !!}
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p>Tidak ada data untuk {{ ucfirst($type) }}</p>
        @endif

    @empty
        <p>Tidak ada hasil ditemukan.</p>
    @endforelse
@endsection