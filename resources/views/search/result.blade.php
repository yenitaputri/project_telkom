@extends('layouts.app')

@section('content')
    <h1>Hasil Pencarian: "{{ $keyword }}"</h1>

    @forelse ($results as $type => $items)
        <h2>{{ ucfirst($type) }}</h2>
        <ul>
            @foreach ($items as $item)
                <li>{{ $item->name ?? 'Tanpa Nama' }}</li>
            @endforeach
        </ul>
    @empty
        <p>Tidak ada hasil ditemukan.</p>
    @endforelse
@endsection
