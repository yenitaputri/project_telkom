@extends('layouts.app')

@section('title', 'Target Sales')

@section('content')
    <h2 class="text-3xl font-bold text-gray-800 mb-6">Settings</h2>

    <div x-data="salesData()" class="bg-white rounded-lg shadow-md p-6 min-h-[calc(100vh-160px)] flex flex-col">

        {{-- Header --}}
        <div class="flex justify-between items-center">
            <h2 class="text-2xl font-bold text-gray-700">🎯 Target Sales Tahunan</h2>

            <form method="GET" action="{{ route('setting.sales') }}" class="flex items-end gap-3">
                <div>
                    <label class="block text-gray-700 font-semibold mb-1">Tahun</label>
                    <input type="number" name="tahun" value="{{ $tahun ?? now()->year }}" min="2020" max="2100"
                        class="border-gray-300 rounded-md border px-3 py-2 w-28">
                </div>

                <div class="flex gap-2">
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition">
                        Filter
                    </button>
                    <a href="{{ route('setting.sales') }}"
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

        {{-- Modal Tambah Target Sales --}}
        <div x-show="openSalesModal"
            class="fixed inset-0 bg-gray-600 bg-opacity-75 flex items-center justify-center z-50 p-4" x-cloak>
            <div @click.away="openSalesModal = false"
                class="bg-white rounded-lg shadow-xl p-6 w-full max-w-md mx-auto relative">
                <h3 class="text-xl font-bold mb-4 text-center text-indigo-600">Tambah Target Sales</h3>

                <form action="{{ route('target.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="target_type" value="sales">

                    <div class="space-y-3">
                        <div>
                            <label class="block text-gray-700 font-semibold mb-1">Tahun</label>
                            <input type="number" name="tahun" value="{{ now()->year }}" min="2020" max="2100" required
                                class="w-full border-gray-300 rounded-md border px-3 py-2">
                        </div>


                        <div>
                            <label class="block text-gray-700 font-semibold mb-1">Sales</label>
                            <select name="target_ref" required class="w-full border-gray-300 rounded-md border px-3 py-2">
                                <option value="">-- Pilih Sales --</option>
                                @foreach ($sales as $sale)
                                    <option value="{{ $sale->kode_sales }}">
                                        {{ $sale->kode_sales }} — {{ $sale->nama_sales }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-gray-700 font-semibold mb-1">Nilai Target</label>
                            <input type="number" name="target_value" step="0.01" min="0" required
                                class="w-full border-gray-300 rounded-md border px-3 py-2">
                        </div>
                    </div>

                    <div class="flex justify-end space-x-3 mt-5">
                        <button type="button" @click="openSalesModal = false"
                            class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded transition">
                            Batal
                        </button>
                        <button type="submit"
                            class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded transition">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Modal Edit Target Sales --}}
        <div x-show="openEditSalesModal"
            class="fixed inset-0 bg-gray-600 bg-opacity-75 flex items-center justify-center z-50 p-4" x-cloak>
            <div @click.away="openEditSalesModal = false"
                class="bg-white rounded-lg shadow-xl p-6 w-full max-w-md mx-auto relative">
                <h3 class="text-xl font-bold mb-4 text-center text-yellow-600">Edit Target Sales</h3>

                <form :action="`/target/${editSalesData.id}`" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="target_type" value="sales">

                    <div class="space-y-3">
                        <div>
                            <label class="block text-gray-700 font-semibold mb-1">Tahun</label>
                            <input type="number" name="tahun" x-model="editSalesData.tahun" min="2020" max="2100"
                                class="w-full border-gray-300 rounded-md border px-3 py-2" required>
                        </div>

                        <div>
                            <label class="block text-gray-700 font-semibold mb-1">Nama Target</label>
                            <input type="text" name="target_ref" x-model="editSalesData.target_ref" required
                                class="w-full border-gray-300 rounded-md border px-3 py-2">
                        </div>

                        <div>
                            <label class="block text-gray-700 font-semibold mb-1">Nilai Target</label>
                            <input type="number" name="target_value" x-model="editSalesData.target_value" min="0" max="120"
                                class="w-full border-gray-300 rounded-md border px-3 py-2" required>
                        </div>
                    </div>

                    <div class="flex justify-end space-x-3 mt-5">
                        <button type="button" @click="openEditSalesModal = false"
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

        {{-- Tabel Target Sales --}}
        <div class="overflow-x-auto mt-8">
            <div class="my-4 flex justify-between">
                <h3 class="text-lg font-semibold mb-2 text-gray-700">📅 Daftar Target Sales</h3>
                <button @click="openSalesModal = true"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-lg flex items-center transition-colors duration-200">
                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Tambah Target Sales
                </button>
            </div>

            <table class="min-w-full bg-white border border-gray-200 rounded-lg">
                <thead>
                    <tr class="bg-gray-100 text-gray-600 uppercase text-sm leading-normal">
                        <th class="py-3 px-6 text-left">No.</th>
                        <th class="py-3 px-6 text-left">Tahun</th>
                        <th class="py-3 px-6 text-left">Nama Target</th>
                        <th class="py-3 px-6 text-left">Nilai Target</th>
                        <th class="py-3 px-6 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 text-sm font-light">
                    @forelse ($targetSales as $item)
                        <tr class="border-b border-gray-200 hover:bg-gray-50">
                            <td class="py-3 px-6">{{ $loop->iteration }}</td>
                            <td class="py-3 px-6">{{ $item->tahun }}</td>
                            <td class="py-3 px-6">{{ $item->target_ref }}</td>
                            <td class="py-3 px-6">{{ number_format($item->target_value, 0, ',', '.') }}</td>
                            <td class="py-3 px-6 flex justify-center gap-2">
                                <button @click="
                                                                                                                    openEditSalesModal = true;
                                                                                                                    editSalesData = {
                                                                                                                        id: '{{ $item->id }}',
                                                                                                                        tahun: '{{ $item->tahun }}',
                                                                                                                        target_ref: '{{ $item->target_ref }}',
                                                                                                                        target_value: '{{ $item->target_value }}'
                                                                                                                    };"
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
                            <td colspan="5" class="py-3 px-6 text-center text-gray-500">
                                Tidak ada data target sales
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
        function salesData() {
            return {
                openSalesModal: false,
                openEditSalesModal: false,
                editSalesData: {
                    id: '',
                    tahun: '',
                    target_ref: '',
                    target_value: ''
                }
            }
        }

        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.delete-btn').forEach(btn => {
                btn.addEventListener('click', function () {
                    const form = btn.closest('form');
                    Swal.fire({
                        title: 'Hapus Target Sales?',
                        text: "Data target akan dihapus permanen!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Ya, hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) form.submit();
                    });
                });
            });
        });
    </script>
@endpush