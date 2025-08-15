@extends('layouts.app')

@section('content')
    {{-- Tombol kembali --}}
    <div class="mb-4">
        <a href="{{ url()->previous() }}" class="w-max flex gap-2 items-center text-sm font-bold text-blue-500">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-5">
                <path fill-rule="evenodd"
                    d="M18 10a.75.75 0 0 1-.75.75H4.66l2.1 1.95a.75.75 0 1 1-1.02 1.1l-3.5-3.25a.75.75 0 0 1 0-1.1l3.5-3.25a.75.75 0 1 1 1.02 1.1l-2.1 1.95h12.59A.75.75 0 0 1 18 10Z"
                    clip-rule="evenodd" />
            </svg>
            <p>Kembali</p>
        </a>
    </div>

    <h1 class="text-lg font-medium py-4">
        Hasil Pencarian: <span class="font-semibold">"{{ $keyword }}"</span>
    </h1>

    @forelse ($results as $type => $items)
        <h2 class="py-4 text-xl font-bold">{{ ucfirst($type) }}</h2>

        @if (!empty($items))
            <div class="overflow-x-auto">
                <table class="bg-white border border-gray-200 rounded-lg table-fixed">
                    <thead>
                        <tr class="bg-gray-100 text-gray-600 uppercase text-sm leading-normal">
                            @foreach (array_keys($items[0]) as $column)
                                <th class="min-w-[100px]">
                                    {{ ucwords(str_replace('_', ' ', $column)) }}
                                </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody class="text-gray-600 text-sm font-light">
                        @foreach ($items as $item)
                            <tr class="border-b border-gray-200 hover:bg-gray-50">
                                @foreach ($item as $column => $value)
                                    <td class="py-3 px-6 text-left">
                                        @php
                                            // Daftar nama kolom yang dianggap gambar
                                            $isImageColumn = in_array(strtolower($column), ['image', 'photo', 'thumbnail', 'gambar']);

                                            // Deteksi kalau value berupa URL gambar
                                            $isImageUrl = filter_var($value, FILTER_VALIDATE_URL)
                                                && preg_match('/\.(jpg|jpeg|png|gif|webp)$/i', $value);

                                            // Deteksi kalau value berupa path file lokal di storage/public
                                            $isLocalImage = preg_match('/\.(jpg|jpeg|png|gif|webp)$/i', $value)
                                                && file_exists(public_path($value));
                                        @endphp

                                        @if ($isImageColumn || $isImageUrl || $isLocalImage)
                                            <img src="{{ $isLocalImage ? asset($value) : $value }}" alt="Image"
                                                class="h-16 w-auto rounded border border-gray-200">
                                        @else
                                            {!! preg_replace(
                                                '/(' . preg_quote($keyword, '/') . ')/i',
                                                '<mark>$1</mark>',
                                                e($value)
                                            ) !!}
                                        @endif
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