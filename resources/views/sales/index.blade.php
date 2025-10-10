@extends('layouts.app')

@section('title', 'Data Sales')

@section('content')

    <div class="bg-white rounded-lg shadow p-4 min-h-[calc(100vh-160px)] flex flex-col">

        {{-- Tombol Tambah --}}
        <div class="flex justify-end mb-4">
            <form action="{{ route('sales.index') }}" method="get" class="mr-auto">
                <div class="relative w-full max-w-xs">
                    <input type="text" name="q" placeholder="Cari di sini..."
                        class="w-full py-2 px-4 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent pr-10">
                    <button type="submit"
                        class="absolute top-0 bottom-0 right-4 text-gray-500 hover:text-gray-700 transition-colors duration-200">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z">
                            </path>
                        </svg>
                    </button>
                </div>
            </form>
            <button id="openAddModalBtn"
                class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded flex items-center text-sm transition-colors">
                <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Tambah Data
            </button>
        </div>

        @if(request('q') || (request('start') && request('end')))
            <p class="mb-4 text-sm text-gray-600">
                Hasil pencarian untuk:
                @if(request('q'))
                    <span class="font-semibold">"{{ request('q') }}"</span>
                @endif
                <a href="{{ route('sales.index') }}" class="text-blue-500 hover:underline ml-2">Reset</a>
            </p>
        @endif
        {{-- Tabel Sales --}}
        <div class="overflow-x-auto">
            <table class="min-w-full table-auto bg-white border border-gray-200 rounded text-sm">
                <thead class="bg-blue-100 text-gray-700">
                    <tr>
                        <th class="border px-2 py-2 font-bold text-left align-middle">No</th>
                        <th class="border px-2 py-2 font-bold text-left align-middle">Gambar</th>
                        <th class="border px-2 py-2 font-bold text-left align-middle">Kode Sales</th>
                        <th class="border px-2 py-2 font-bold text-left align-middle">Nama Sales</th>
                        <th class="border px-2 py-2 font-bold text-left align-middle">Agency</th>
                        <th class="border px-2 py-2 font-bold text-center align-middle">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600">
                    @forelse($sales as $index => $sale)
                        <tr class="border-t hover:bg-gray-100 transition">
                            <td class="px-2 py-2 text-left align-middle">{{ $loop->iteration }}</td>
                            <td class="px-2 py-2 text-left align-middle">
                                <div class="w-10 h-10 flex items-center">
                                    <img src="{{ asset('storage/'.$sale->gambar_sales) }}" alt="gambar"
                                        class="w-8 h-8 rounded-full object-cover border mx-auto">
                                </div>
                            </td>
                            <td class="px-2 py-2 text-left align-middle">{{ $sale->kode_sales }}</td>
                            <td class="px-2 py-2 text-left align-middle">{{ $sale->nama_sales }}</td>
                            <td class="px-2 py-2 text-left align-middle">{{ $sale->agency }}</td>
                            <td class="px-2 py-2 text-center align-middle space-x-1">
                                <button type="button"
                                    class="openEditModalBtn bg-green-500 hover:bg-green-600 text-white px-2 py-1 rounded text-xs transition-colors"
                                    data-id="{{ $sale->id }}" data-gambar="{{ $sale->gambar_sales }}"
                                    data-kode="{{ $sale->kode_sales }}" data-nama="{{ $sale->nama_sales }}"
                                    data-agency="{{ $sale->agency }}">
                                    Edit
                                </button>
                                <button type="button"
                                    class="openDeleteModalBtn bg-red-500 hover:bg-red-600 text-white px-2 py-1 rounded text-xs transition-colors"
                                    data-id="{{ $sale->id }}">
                                    Hapus
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center py-3 text-gray-500">
                                Tidak ditemukan data sales.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{-- Baris per halaman + Pagination --}}
            <div class="flex flex-col sm:flex-row justify-between items-center mt-4 px-2 gap-y-2">
                {{-- Dropdown per page --}}
                <form method="GET" action="{{ route('sales.index') }}" class="flex items-center space-x-2">
                    <label for="per_page" class="text-sm text-gray-700">Baris per halaman:</label>
                    <select name="per_page" id="per_page" onchange="this.form.submit()"
                        class="border-gray-300 rounded-md text-sm py-1">
                        @foreach([5, 10, 25, 50, 100] as $limit)
                            <option value="{{ $limit }}" {{ request('per_page', 10) == $limit ? 'selected' : '' }}>
                                {{ $limit }}
                            </option>
                        @endforeach
                    </select>
                </form>

                {{-- Info + Navigasi Paginasi --}}
                <div
                    class="flex flex-col sm:flex-row sm:items-center sm:space-x-4 w-full sm:w-auto justify-between sm:justify-end">
                    <div>
                        {{ $sales->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>
        </div>

        {{-- Modal Tambah Sales --}}
        <div id="addModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50 p-4"
            style="display: none;">
            <div class="bg-white rounded-lg shadow-xl p-6 w-full max-w-md transition-all">
                <h2 class="text-xl font-bold mb-4 text-center">Tambah Sales</h2>

                <form action="{{ route('sales.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf

                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700">Gambar Sales</label>
                        <div class="flex flex-col items-center space-y-2">
                            <div class="w-16 h-16 bg-gray-200 rounded-lg flex items-center justify-center overflow-hidden">
                                <img id="preview-image" src="#" alt="Preview"
                                    class="w-full h-full object-cover hidden rounded-lg" />
                                <svg id="placeholder-icon" class="w-10 h-10 text-gray-400" fill="currentColor"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="flex items-center w-full">
                                <input type="file" id="gambar_sales" name="gambar_sales" class="hidden" accept="image/*"
                                    onchange="previewGambar(event)">
                                <label for="gambar_sales"
                                    class="cursor-pointer bg-gray-200 hover:bg-gray-300 px-3 py-1.5 rounded-l-md text-sm font-medium border border-gray-300">
                                    Pilih File
                                </label>
                                <span id="file-name"
                                    class="flex-1 px-3 py-1.5 border border-gray-300 rounded-r-md text-sm text-gray-500 bg-white truncate">
                                    Belum ada file
                                </span>
                            </div>
                            @error('gambar_sales')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Kode Sales</label>
                        <input type="text" name="kode_sales" value="{{ old('kode_sales') }}"
                            class="w-full mt-1 border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        @error('kode_sales')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nama Sales</label>
                        <input type="text" name="nama_sales" value="{{ old('nama_sales') }}"
                            class="w-full mt-1 border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        @error('nama_sales')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Agency</label>
                        <input type="text" name="agency" value="{{ old('agency') }}"
                            class="w-full mt-1 border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        @error('agency')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end space-x-2 pt-4">
                        <button type="button"
                            class="closeModalBtn px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-md text-sm font-medium transition-colors border border-gray-300">
                            Batal
                        </button>
                        <button type="submit"
                            class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md text-sm font-medium transition-colors">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>


        {{-- Modal Edit Sales --}}
        <div id="editModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50 p-4"
            style="display: none;">
            <div class="bg-white rounded-lg shadow-xl p-6 w-full max-w-md transition-all">
                <div class="flex justify-between items-center mb-4">
                    <button type="button"
                        class="closeModalBtn flex items-center text-gray-500 hover:text-gray-700 transition-colors">
                        <svg class="h-4 w-4 mr-1 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7">
                            </path>
                        </svg>
                        <span class="text-sm">Kembali</span>
                    </button>
                    <h2 class="text-xl font-bold">Edit Sales</h2>
                    <div class="w-8"></div> {{-- Placeholder untuk menjaga layout tetap simetris --}}
                </div>

                <form id="editForm" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700">Gambar Sales</label>
                        <div class="flex flex-col items-center space-y-2">
                            <div class="w-16 h-16 bg-gray-200 rounded-lg flex items-center justify-center overflow-hidden">
                                <img id="preview-edit-image" src="" class="w-full h-full object-cover hidden rounded-lg" />
                                <svg id="placeholder-edit-icon" class="w-10 h-10 text-gray-400" fill="currentColor"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="flex items-center w-full">
                                <input type="file" id="gambar_edit_sales" name="gambar_sales" class="hidden"
                                    accept="image/*" onchange="previewEditGambar(event)">
                                <label for="gambar_edit_sales"
                                    class="cursor-pointer bg-gray-200 hover:bg-gray-300 px-3 py-1.5 rounded-l-md text-sm font-medium border border-gray-300">
                                    Pilih File
                                </label>
                                <span id="file-edit-name"
                                    class="flex-1 px-3 py-1.5 border border-gray-300 rounded-r-md text-sm text-gray-500 bg-white truncate">
                                    Belum ada file
                                </span>
                            </div>
                            @error('gambar_sales')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Kode Sales</label>
                        <input type="text" name="kode_sales" id="edit-kode_sales"
                            class="w-full mt-1 border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        @error('kode_sales')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nama Sales</label>
                        <input type="text" name="nama_sales" id="edit-nama_sales"
                            class="w-full mt-1 border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        @error('nama_sales')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Agency</label>
                        <input type="text" name="agency" id="edit-agency"
                            class="w-full mt-1 border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        @error('agency')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end space-x-2 pt-4">
                        <button type="submit"
                            class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md text-sm font-medium transition-colors">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Modal Hapus --}}
    <div id="deleteModal"
        class="fixed inset-0 z-50 flex items-center justify-center min-h-screen bg-gray-500 bg-opacity-75 transition-opacity"
        style="display: none;">
        {{-- Modal dialog --}}
        <div class="bg-white rounded-lg shadow-xl max-w-sm w-full mx-4 p-6 transform transition-all">
            <div class="text-center space-y-4">
                {{-- Icon --}}
                <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-blue-100">
                    <svg class="h-8 w-8 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                            clip-rule="evenodd" />
                    </svg>
                </div>

                {{-- Teks --}}
                <h3 class="text-lg font-bold text-gray-900" id="modal-title">
                    Apakah Anda yakin ingin menghapus data ini?
                </h3>
            </div>

            {{-- Tombol Aksi --}}
            <div class="mt-6 flex justify-center space-x-4">
                <button id="closeDeleteModalBtn" type="button"
                    class="w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-200 sm:w-auto sm:text-sm">
                    Tidak
                </button>
                <form id="deleteForm" method="POST" class="inline-block">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:w-auto sm:text-sm">
                        Ya, Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- Script untuk modal dan preview gambar --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const addModal = document.getElementById('addModal');
            const openAddModalBtn = document.getElementById('openAddModalBtn');
            const closeModalBtns = document.querySelectorAll('.closeModalBtn');

            const editModal = document.getElementById('editModal');
            const openEditModalBtns = document.querySelectorAll('.openEditModalBtn');
            const editForm = document.getElementById('editForm');
            const editKodeSales = document.getElementById('edit-kode_sales');
            const editNamaSales = document.getElementById('edit-nama_sales');
            const editAgency = document.getElementById('edit-agency');
            const previewEditImage = document.getElementById('preview-edit-image');
            const placeholderEditIcon = document.getElementById('placeholder-edit-icon');
            const fileEditName = document.getElementById('file-edit-name');

            const deleteModal = document.getElementById('deleteModal');
            const openDeleteModalBtns = document.querySelectorAll('.openDeleteModalBtn');
            const closeDeleteModalBtn = document.getElementById('closeDeleteModalBtn');
            const deleteForm = document.getElementById('deleteForm');

            // Fungsi reset form tambah
            function resetAddForm() {
                const addForm = addModal.querySelector('form');
                addForm.reset();
                document.getElementById('preview-image').classList.add('hidden');
                document.getElementById('placeholder-icon').classList.remove('hidden');
                document.getElementById('file-name').textContent = 'Belum ada file';
            }

            // Logic untuk Modal Tambah
            openAddModalBtn.addEventListener('click', () => {
                resetAddForm(); // Pastikan kosong setiap dibuka
                addModal.style.display = 'flex';
            });

            // Logic untuk menutup semua modal
            closeModalBtns.forEach(btn => {
                btn.addEventListener('click', () => {
                    addModal.style.display = 'none';
                    editModal.style.display = 'none';
                    resetAddForm(); // kosongkan kalau modal tambah ditutup
                });
            });

            // Logic untuk Modal Edit
            openEditModalBtns.forEach(btn => {
                btn.addEventListener('click', () => {
                    const id = btn.getAttribute('data-id');
                    const gambar = btn.getAttribute('data-gambar');
                    const kode = btn.getAttribute('data-kode');
                    const nama = btn.getAttribute('data-nama');
                    const agency = btn.getAttribute('data-agency');

                    // Set form action URL
                    editForm.action = `{{ url('sales') }}/${id}`;

                    // Populate form fields
                    editKodeSales.value = kode;
                    editNamaSales.value = nama;
                    editAgency.value = agency;

                    // Handle image preview
                    if (gambar) {
                        previewEditImage.src = `{{ asset('storage') }}/${gambar}`;
                        previewEditImage.classList.remove('hidden');
                        placeholderEditIcon.classList.add('hidden');
                        fileEditName.textContent = gambar.split('/').pop();
                    } else {
                        previewEditImage.src = '';
                        previewEditImage.classList.add('hidden');
                        placeholderEditIcon.classList.remove('hidden');
                        fileEditName.textContent = 'Belum ada file';
                    }

                    // Show the modal
                    editModal.style.display = 'flex';
                });
            });

            // Logic untuk Modal Hapus
            openDeleteModalBtns.forEach(btn => {
                btn.addEventListener('click', () => {
                    const id = btn.getAttribute('data-id');
                    deleteForm.action = `{{ url('sales') }}/${id}`;
                    deleteModal.style.display = 'flex';
                });
            });

            closeDeleteModalBtn.addEventListener('click', () => {
                deleteModal.style.display = 'none';
            });

            // Function untuk preview gambar (tambah)
            function previewGambar(event) {
                const file = event.target.files[0];
                const preview = document.getElementById('preview-image');
                const placeholder = document.getElementById('placeholder-icon');
                const fileName = document.getElementById('file-name');

                if (file) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        preview.src = e.target.result;
                        preview.classList.remove('hidden');
                        placeholder.classList.add('hidden');
                    };
                    reader.readAsDataURL(file);
                    fileName.textContent = file.name;
                } else {
                    preview.src = '';
                    preview.classList.add('hidden');
                    placeholder.classList.remove('hidden');
                    fileName.textContent = 'Belum ada file';
                }
            }

            // Function untuk preview gambar (edit)
            function previewEditGambar(event) {
                const file = event.target.files[0];
                const preview = document.getElementById('preview-edit-image');
                const placeholder = document.getElementById('placeholder-edit-icon');
                const fileName = document.getElementById('file-edit-name');

                if (file) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        preview.src = e.target.result;
                        preview.classList.remove('hidden');
                        placeholder.classList.add('hidden');
                    };
                    reader.readAsDataURL(file);
                    fileName.textContent = file.name;
                } else {
                    preview.src = '';
                    preview.classList.add('hidden');
                    placeholder.classList.remove('hidden');
                    fileName.textContent = 'Belum ada file';
                }
            }

            window.previewGambar = previewGambar;
            window.previewEditGambar = previewEditGambar;

            // Auto open modal on validation error
            @if ($errors->any())
                const hasErrors = {!! json_encode($errors->messages()) !!};
                const oldInput = {!! json_encode(old()) !!};
                if (oldInput.hasOwnProperty('id') && oldInput.id) {
                    // Open edit modal
                    editModal.style.display = 'flex';
                    editForm.action = `{{ url('sales') }}/${oldInput.id}`;
                    editKodeSales.value = oldInput.kode_sales;
                    editNamaSales.value = oldInput.nama_sales;
                    editAgency.value = oldInput.agency;
                    // Note: Image preview for old data in edit mode is more complex and usually handled via a separate mechanism or a hidden input.
                } else {
                    // Open add modal
                    addModal.style.display = 'flex';
                }
            @endif

                                                        // Hide success alert after 3 seconds
                                                        const successAlert = document.getElementById('success-alert');
            if (successAlert) {
                setTimeout(() => {
                    successAlert.style.opacity = '0';
                    setTimeout(() => successAlert.style.display = 'none', 300);
                }, 3000);
            }
        });
    </script>

@endsection