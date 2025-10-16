@extends('layouts.app')

@section('title', 'Beranda')

@section('content')
    <h2 class="text-3xl font-bold text-gray-800 mb-6">Settings</h2>

    <div class="bg-white rounded-lg shadow-md p-6 border-2 flex flex-col  gap-y-6">
        <a href="{{ route('target.index') }}" class="flex items-center justify-between w-full max-w-md bg-gray-50 px-6 py-4 rounded-lg border border-gray-200
                              hover:bg-gray-100 hover:shadow transition-all duration-200 ease-in-out">

            <!-- Kiri: ikon + teks -->
            <div class="flex items-center gap-3 text-gray-800 font-medium">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-6 h-6 text-gray-600">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M15.042 21.672 13.684 16.6m0 0-2.51 2.225.569-9.47 5.227 7.917-3.286-.672Zm-7.518-.267A8.25 8.25 0 1 1 20.25 10.5M8.288 14.212A5.25 5.25 0 1 1 17.25 10.5" />
                </svg>
                <span>Target</span>
            </div>

            <!-- Kanan: ikon panah -->
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                class="w-6 h-6 text-gray-500">
                <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
            </svg>
        </a>
    </div>
@endsection