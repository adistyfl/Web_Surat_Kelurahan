@extends('layouts.app')

@section('title', 'Kategori Surat - Kelurahan Karangduren')
@section('page-title', 'Kategori Surat')

@section('content')
    <div class="bg-white rounded-lg shadow p-6">
        <!-- Header Section -->
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800 mb-2">Kategori Surat</h1>
            <p class="text-gray-600">
                Berikut ini adalah kategori yang bisa digunakan untuk melabeli surat.<br>
                Klik "Tambah" pada kolom aksi untuk menambahkan kategori baru.
            </p>
        </div>

        <!-- Search Section -->
        <div class="mb-6">
            <div class="flex items-center space-x-4">
                <label for="searchInput" class="text-gray-700 font-medium">Cari kategori:</label>
                <div class="flex flex-1 max-w-md">
                    <input type="text" 
                           id="searchInput" 
                           placeholder="search" 
                           value="{{ $search }}"
                           class="flex-1 px-4 py-2 border border-gray-300 rounded-l-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                           onkeypress="if(event.key==='Enter') performSearch()">
                    <button onclick="performSearch()" 
                            class="px-4 py-2 bg-gray-200 border border-l-0 border-gray-300 rounded-r-md hover:bg-gray-300 focus:outline-none">
                        Cari!
                    </button>
                </div>
            </div>
        </div>

        <!-- Categories Table -->
        <div class="overflow-x-auto mb-6">
            <table class="min-w-full border border-gray-300">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="border border-gray-300 px-4 py-2 text-left font-medium text-gray-700">ID Kategori</th>
                        <th class="border border-gray-300 px-4 py-2 text-left font-medium text-gray-700">Nama Kategori</th>
                        <th class="border border-gray-300 px-4 py-2 text-left font-medium text-gray-700">Keterangan</th>
                        <th class="border border-gray-300 px-4 py-2 text-left font-medium text-gray-700">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $category)
                    <tr class="hover:bg-gray-50">
                        <td class="border border-gray-300 px-4 py-2">{{ $category->id }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $category->nama_kategori }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $category->keterangan ?: '-' }}</td>
                        <td class="border border-gray-300 px-4 py-2">
                            <div class="flex space-x-1">
                                <!-- Delete Button -->
                                <form method="POST" action="{{ route('categories.destroy', $category) }}" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" 
                                            onclick="showDeleteModal(this.form)"
                                            class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm font-medium"
                                            {{ $category->letters()->count() > 0 ? 'disabled title="Kategori masih digunakan oleh ' . $category->letters()->count() . ' surat"' : '' }}>
                                        Hapus
                                    </button>
                                </form>
                                
                                <!-- Edit Button -->
                                <a href="{{ route('categories.edit', $category) }}" 
                                   class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-sm font-medium inline-block">
                                    Edit
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="border border-gray-300 px-4 py-8 text-center text-gray-500">
                            @if($search)
                                Tidak ada kategori yang ditemukan dengan kata kunci "{{ $search }}"
                            @else
                                Belum ada kategori yang ditambahkan
                            @endif
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Add Category Button -->
        <div class="flex justify-start">
            <a href="{{ route('categories.create') }}" 
               class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded font-medium">
                ( + ) Tambah Kategori Baru...
            </a>
        </div>
    </div>

    <!-- Success/Error Messages -->
    @if(session('success'))
    <div class="fixed top-4 right-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded shadow-lg z-50">
        <div class="flex items-center">
            <span>{{ session('success') }}</span>
            <button onclick="this.parentElement.parentElement.remove()" class="ml-4 text-green-700 hover:text-green-900">×</button>
        </div>
    </div>
    @endif

    @if(session('error'))
    <div class="fixed top-4 right-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded shadow-lg z-50">
        <div class="flex items-center">
            <span>{{ session('error') }}</span>
            <button onclick="this.parentElement.parentElement.remove()" class="ml-4 text-red-700 hover:text-red-900">×</button>
        </div>
    </div>
    @endif

    <!-- Modal untuk konfirmasi hapus kategori -->
    <div id="deleteModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg font-bold text-gray-900 text-center">Alert</h3>
                <div class="mt-2 px-7 py-3">
                    <p class="text-sm text-gray-500 text-center">
                        Apakah Anda yakin ingin menghapus kategori ini?
                    </p>
                </div>
                <div class="flex justify-center mt-4 space-x-4">
                    <button id="cancelDelete" 
                            class="px-4 py-2 bg-gray-300 text-gray-800 text-base font-medium rounded-md shadow-sm hover:bg-gray-400">
                        Batal
                    </button>
                    <button id="confirmDelete" 
                            class="px-4 py-2 bg-red-600 text-white text-base font-medium rounded-md shadow-sm hover:bg-red-700">
                        Ya!
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    // Handle delete modal untuk kategori
    let deleteForm = null;
    
    function showDeleteModal(form) {
        deleteForm = form;
        document.getElementById('deleteModal').classList.remove('hidden');
    }
    
    document.getElementById('cancelDelete').addEventListener('click', function() {
        document.getElementById('deleteModal').classList.add('hidden');
        deleteForm = null;
    });
    
    document.getElementById('confirmDelete').addEventListener('click', function() {
        if (deleteForm) {
            deleteForm.submit();
        }
        document.getElementById('deleteModal').classList.add('hidden');
    });

    // Handle search untuk kategori
    function performSearch() {
        const searchValue = document.getElementById('searchInput').value;
        const currentUrl = new URL(window.location);
        
        if (searchValue.trim()) {
            currentUrl.searchParams.set('search', searchValue);
        } else {
            currentUrl.searchParams.delete('search');
        }
        
        window.location = currentUrl.toString();
    }
</script>
@endpush