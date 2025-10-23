@extends('layouts.app')

@section('title', 'Data Target')

@section('content')
    <h2 class="text-3xl font-bold text-gray-800 mb-6">Settings</h2>
    <div x-data="targetData()" class="bg-white rounded-lg shadow-md p-6 min-h-[calc(100vh-160px)] flex flex-col">

        {{-- Header --}}
        <div class="flex justify-between items-center">
            <h2 class="text-2xl font-bold text-gray-700">Daftar Target</h2>
            {{-- Filter Bulan & Tahun --}}
            <form method="GET" action="{{ route('target.index') }}" class="flex flex-wrap items-end gap-3">
                <div>
                    <label class="block text-gray-700 font-semibold mb-1">Bulan</label>
                    <select name="bulan" class="border-gray-300 rounded-md border px-3 py-2 pr-10">
                        <option value="" {{ $bulan == '' ? 'selected' : '' }}>Semua Bulan</option>
                        @for ($i = 1; $i <= 12; $i++)
                            <option value="{{ $i }}" {{ $i == $bulan ? 'selected' : '' }}>
                                {{ \Carbon\Carbon::create()->month($i)->translatedFormat('F') }}
                            </option>
                        @endfor
                    </select>
                </div>

                <div>
                    <label class="block text-gray-700 font-semibold mb-1">Tahun</label>
                    <input type="number" name="tahun" value="{{ $tahun }}" min="2020" max="2100"
                        class="border-gray-300 rounded-md border px-3 py-2 w-24">
                </div>
                <div class="flex gap-2">
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition">
                        Filter
                    </button>
                    <a href="{{ route('target.index') }}"
                        class="bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-md p-2 px-4 transition duration-200 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" />
                        </svg>
                    </a>
                </div>
            </form>
        </div>

        {{-- ================= Modal Tambah Target AGENCY ================= --}}
        <div x-show="openAgencyModal"
            class="fixed inset-0 bg-gray-600 bg-opacity-75 flex items-center justify-center z-50 p-4" x-cloak>
            <div @click.away="openAgencyModal = false"
                class="bg-white rounded-lg shadow-xl p-6 w-full max-w-md mx-auto relative">
                <h3 class="text-xl font-bold mb-4 text-center text-blue-600">Tambah Target Agency</h3>

                <form action="{{ route('target.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="target_type" value="agency">

                    <div class="space-y-3">
                        <div>
                            <label class="block text-gray-700 font-semibold mb-1">Nama Agency</label>
                            <input type="text" name="target_ref" placeholder="Contoh: IMDAA" required
                                class="w-full border-gray-300 rounded-md border px-3 py-2">
                        </div>

                        <div class="flex space-x-2">
                            <div class="w-1/2">
                                <label class="block text-gray-700 font-semibold mb-1">Bulan</label>
                                <select name="bulan" required class="w-full border-gray-300 rounded-md border px-3 py-2">
                                    @for ($i = 1; $i <= 12; $i++)
                                        <option value="{{ $i }}" {{ $i == now()->month ? 'selected' : '' }}>
                                            {{ \Carbon\Carbon::create()->month($i)->translatedFormat('F') }}
                                        </option>
                                    @endfor
                                </select>
                            </div>
                            <div class="w-1/2">
                                <label class="block text-gray-700 font-semibold mb-1">Tahun</label>
                                <input type="number" name="tahun" value="{{ now()->year }}" min="2020" max="2100" required
                                    class="w-full border-gray-300 rounded-md border px-3 py-2">
                            </div>
                        </div>

                        <div>
                            <label class="block text-gray-700 font-semibold mb-1">Nilai Target</label>
                            <input type="number" name="target_value" step="1" min="0"
                                class="w-full border-gray-300 rounded-md border px-3 py-2" required>
                        </div>
                    </div>

                    <div class="flex justify-end space-x-3 mt-5">
                        <button type="button" @click="openAgencyModal = false"
                            class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded transition">
                            Batal
                        </button>
                        <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- ================= Modal Tambah Target PRODIGI ================= --}}
        <div x-show="openProdigiModal"
            class="fixed inset-0 bg-gray-600 bg-opacity-75 flex items-center justify-center z-50 p-4" x-cloak>
            <div @click.away="openProdigiModal = false"
                class="bg-white rounded-lg shadow-xl p-6 w-full max-w-md mx-auto relative">
                <h3 class="text-xl font-bold mb-4 text-center text-green-600">Tambah Target Prodigi</h3>

                <form action="{{ route('target.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="target_type" value="prodigi">

                    <div class="space-y-3">
                        <div>
                            <label class="block text-gray-700 font-semibold mb-1">Nama Prodigi</label>
                            <input type="text" name="target_ref" placeholder="Contoh: Indihome" required
                                class="w-full border-gray-300 rounded-md border px-3 py-2">
                        </div>

                        <div class="flex space-x-2">
                            <div class="w-1/2">
                                <label class="block text-gray-700 font-semibold mb-1">Bulan</label>
                                <select name="bulan" required class="w-full border-gray-300 rounded-md border px-3 py-2">
                                    @for ($i = 1; $i <= 12; $i++)
                                        <option value="{{ $i }}" {{ $i == now()->month ? 'selected' : '' }}>
                                            {{ \Carbon\Carbon::create()->month($i)->translatedFormat('F') }}
                                        </option>
                                    @endfor
                                </select>
                            </div>
                            <div class="w-1/2">
                                <label class="block text-gray-700 font-semibold mb-1">Tahun</label>
                                <input type="number" name="tahun" value="{{ now()->year }}" min="2020" max="2100" required
                                    class="w-full border-gray-300 rounded-md border px-3 py-2">
                            </div>
                        </div>

                        <div>
                            <label class="block text-gray-700 font-semibold mb-1">Nilai Target</label>
                            <input type="number" name="target_value" step="1" min="0"
                                class="w-full border-gray-300 rounded-md border px-3 py-2" required>
                        </div>
                    </div>

                    <div class="flex justify-end space-x-3 mt-5">
                        <button type="button" @click="openProdigiModal = false"
                            class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded transition">
                            Batal
                        </button>
                        <button type="submit"
                            class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded transition">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- ================= Modal UPDATE Target AGENCY ================= --}}
        <div x-show="openEditAgencyModal"
            class="fixed inset-0 bg-gray-600 bg-opacity-75 flex items-center justify-center z-50 p-4" x-cloak>
            <div @click.away="openEditAgencyModal = false"
                class="bg-white rounded-lg shadow-xl p-6 w-full max-w-md mx-auto relative">
                <h3 class="text-xl font-bold mb-4 text-center text-yellow-600">Edit Target Agency</h3>

                <form :action="`/target/${editAgencyData.id}`" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="target_type" :value="editAgencyData.target_type">

                    <div class="space-y-3">
                        <div>
                            <label class="block text-gray-700 font-semibold mb-1">Nama Agency</label>
                            <input type="text" name="target_ref" x-model="editAgencyData.target_ref" required
                                class="w-full border-gray-300 rounded-md border px-3 py-2">
                        </div>

                        <div class="flex space-x-2">
                            <div class="w-1/2">
                                <label class="block text-gray-700 font-semibold mb-1">Bulan</label>
                                <select name="bulan" x-model="editAgencyData.bulan"
                                    class="w-full border-gray-300 rounded-md border px-3 py-2">
                                    @for ($i = 1; $i <= 12; $i++)
                                        <option value="{{ $i }}">
                                            {{ \Carbon\Carbon::create()->month($i)->translatedFormat('F') }}
                                        </option>
                                    @endfor
                                </select>
                            </div>
                            <div class="w-1/2">
                                <label class="block text-gray-700 font-semibold mb-1">Tahun</label>
                                <input type="number" name="tahun" x-model="editAgencyData.tahun" min="2020" max="2100"
                                    class="w-full border-gray-300 rounded-md border px-3 py-2" required>
                            </div>
                        </div>

                        <div>
                            <label class="block text-gray-700 font-semibold mb-1">Nilai Target</label>
                            <input type="number" name="target_value" x-model="editAgencyData.target_value" step="1" min="0"
                                class="w-full border-gray-300 rounded-md border px-3 py-2" required>
                        </div>
                    </div>

                    <div class="flex justify-end space-x-3 mt-5">
                        <button type="button" @click="openEditAgencyModal = false"
                            class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded transition">
                            Batal
                        </button>
                        <button type="submit"
                            class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded transition">
                            Update
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- ================= Modal UPDATE Target PRODIGI ================= --}}
        <div x-show="openEditProdigiModal"
            class="fixed inset-0 bg-gray-600 bg-opacity-75 flex items-center justify-center z-50 p-4" x-cloak>
            <div @click.away="openEditProdigiModal = false"
                class="bg-white rounded-lg shadow-xl p-6 w-full max-w-md mx-auto relative">
                <h3 class="text-xl font-bold mb-4 text-center text-yellow-600">Edit Target Prodigi</h3>

                <form :action="`/target/${editProdigiData.id}`" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="target_type" :value="editProdigiData.target_type">

                    <div class="space-y-3">
                        <div>
                            <label class="block text-gray-700 font-semibold mb-1">Nama Prodigi</label>
                            <input type="text" name="target_ref" x-model="editProdigiData.target_ref" required
                                class="w-full border-gray-300 rounded-md border px-3 py-2">
                        </div>

                        <div class="flex space-x-2">
                            <div class="w-1/2">
                                <label class="block text-gray-700 font-semibold mb-1">Bulan</label>
                                <select name="bulan" x-model="editProdigiData.bulan"
                                    class="w-full border-gray-300 rounded-md border px-3 py-2">
                                    @for ($i = 1; $i <= 12; $i++)
                                        <option value="{{ $i }}">
                                            {{ \Carbon\Carbon::create()->month($i)->translatedFormat('F') }}
                                        </option>
                                    @endfor
                                </select>
                            </div>
                            <div class="w-1/2">
                                <label class="block text-gray-700 font-semibold mb-1">Tahun</label>
                                <input type="number" name="tahun" x-model="editProdigiData.tahun" min="2020" max="2100"
                                    class="w-full border-gray-300 rounded-md border px-3 py-2" required>
                            </div>
                        </div>

                        <div>
                            <label class="block text-gray-700 font-semibold mb-1">Nilai Target</label>
                            <input type="number" name="target_value" x-model="editProdigiData.target_value" step="1" min="0"
                                class="w-full border-gray-300 rounded-md border px-3 py-2" required>
                        </div>
                    </div>

                    <div class="flex justify-end space-x-3 mt-5">
                        <button type="button" @click="openEditProdigiModal = false"
                            class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded transition">
                            Batal
                        </button>
                        <button type="submit"
                            class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded transition">
                            Update
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- === Target per Agency === --}}
        <div class="overflow-x-auto mt-4">
            <div class="my-4 flex justify-between">
                <h3 class="text-lg font-semibold mb-2 text-gray-700">🎯 Target per Agency</h3>
                <button @click="openAgencyModal = true"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg flex items-center transition-colors duration-200">
                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Tambah Target Agency
                </button>
            </div>
            <table class="min-w-full bg-white border border-gray-200 rounded-lg">
                <thead>
                    <tr class="bg-gray-100 text-gray-600 uppercase text-sm leading-normal">
                        <th class="py-3 px-6 text-left">No.</th>
                        <th class="py-3 px-6 text-left">Bulan</th>
                        <th class="py-3 px-6 text-left">Tahun</th>
                        <th class="py-3 px-6 text-left">Agency</th>
                        <th class="py-3 px-6 text-left">Nilai Target</th>
                        <th class="py-3 px-6 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 text-sm font-light">
                    @forelse ($targetAgency as $item)
                        <tr class="border-b border-gray-200 hover:bg-gray-50">
                            <td class="py-3 px-6">{{ $loop->iteration }}</td>
                            <td class="py-3 px-6">
                                {{ \Carbon\Carbon::create()->month($item->bulan)->translatedFormat('F') }}
                            </td>
                            <td class="py-3 px-6">{{ $item->tahun }}</td>
                            <td class="py-3 px-6">{{ $item->target_ref }}</td>
                            <td class="py-3 px-6">{{ $item->target_value }}</td>
                            <td class="py-3 px-6 flex justify-center gap-2">
                                {{-- Tombol Edit --}}
                                <button
                                    @click="
                                                                                                                                    openEditAgencyModal = true;
                                                                                                                                    editAgencyData = {
                                                                                                                                        id: '{{ $item->id }}',
                                                                                                                                        bulan: '{{ $item->bulan }}',
                                                                                                                                        tahun: '{{ $item->tahun }}',
                                                                                                                                        target_ref: '{{ $item->target_ref }}',
                                                                                                                                        target_value: '{{ $item->target_value }}',
                                                                                                                                        target_type: 'agency'
                                                                                                                                    };
                                                                                                                                "
                                    class="bg-yellow-400 hover:bg-yellow-500 text-white font-bold py-1 px-3 rounded text-xs">
                                    Edit
                                </button>

                                {{-- Tombol Hapus --}}
                                <form action="{{ route('target.destroy', $item->id) }}" method="POST"
                                    class="delete-target-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button"
                                        class="bg-red-500 hover:bg-red-600 text-white font-bold py-1 px-3 rounded text-xs delete-btn">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-3 px-6 text-center text-gray-500">
                                Tidak ada data target agency
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- === Target per Prodigi === --}}
        <div class="overflow-x-auto mt-10">
            <div class="my-4 flex justify-between">
                <h3 class="text-lg font-semibold mb-2 text-gray-700">⚡ Target per Prodigi</h3>
                <button @click="openProdigiModal = true"
                    class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg flex items-center transition-colors duration-200">
                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Tambah Target Prodigi
                </button>
            </div>
            <table class="min-w-full bg-white border border-gray-200 rounded-lg">
                <thead>
                    <tr class="bg-gray-100 text-gray-600 uppercase text-sm leading-normal">
                        <th class="py-3 px-6 text-left">No.</th>
                        <th class="py-3 px-6 text-left">Bulan</th>
                        <th class="py-3 px-6 text-left">Tahun</th>
                        <th class="py-3 px-6 text-left">Prodigi</th>
                        <th class="py-3 px-6 text-left">Nilai Target</th>
                        <th class="py-3 px-6 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 text-sm font-light">
                    @forelse ($targetProdigi as $item)
                        <tr class="border-b border-gray-200 hover:bg-gray-50">
                            <td class="py-3 px-6">{{ $loop->iteration }}</td>
                            <td class="py-3 px-6">
                                {{ \Carbon\Carbon::create()->month($item->bulan)->translatedFormat('F') }}
                            </td>

                            <td class="py-3 px-6">{{ $item->tahun }}</td>
                            <td class="py-3 px-6">{{ $item->target_ref }}</td>
                            <td class="py-3 px-6">{{ $item->target_value }}</td>
                            <td class="py-3 px-6 flex justify-center gap-2">
                                {{-- Tombol Edit --}}
                                <button
                                    @click="
                                                                                                                                    openEditProdigiModal = true;
                                                                                                                                    editProdigiData = {
                                                                                                                                        id: '{{ $item->id }}',
                                                                                                                                        bulan: '{{ $item->bulan }}',
                                                                                                                                        tahun: '{{ $item->tahun }}',
                                                                                                                                        target_ref: '{{ $item->target_ref }}',
                                                                                                                                        target_value: '{{ $item->target_value }}',
                                                                                                                                        target_type: 'prodigi'
                                                                                                                                    };
                                                                                                                                "
                                    class="bg-yellow-400 hover:bg-yellow-500 text-white font-bold py-1 px-3 rounded text-xs">
                                    Edit
                                </button>
                                <form action="{{ route('target.destroy', $item->id) }}" method="POST"
                                    class="delete-target-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button"
                                        class="bg-red-500 hover:bg-red-600 text-white font-bold py-1 px-3 rounded text-xs delete-btn">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-3 px-6 text-center text-gray-500">
                                Tidak ada data target prodigi
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function targetData() {
            return {
                openAgencyModal: false,
                openProdigiModal: false,
                openEditAgencyModal: false,
                openEditProdigiModal: false,
                editAgencyData: {
                    id: '',
                    bulan: '',
                    tahun: '',
                    target_ref: '',
                    target_value: '',
                    target_type: 'agency'
                },
                editProdigiData: {
                    id: '',
                    bulan: '',
                    tahun: '',
                    target_ref: '',
                    target_value: '',
                    target_type: 'prodigi'
                }
            }
        }

        document.addEventListener('DOMContentLoaded', function () {
            // Konfirmasi hapus untuk semua tombol delete
            document.querySelectorAll('.delete-btn').forEach(btn => {
                btn.addEventListener('click', function () {
                    const form = btn.closest('form');

                    Swal.fire({
                        title: 'Hapus Target?',
                        text: "Data target akan dihapus permanen!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Ya, hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });

            // Format angka input target value
            document.querySelectorAll('input[name="target_value"]').forEach(input => {
                input.addEventListener('blur', function () {
                    if (this.value) {
                        this.value = parseFloat(this.value).toFixed(2);
                    }
                });
            });
        });
    </script>
@endpush