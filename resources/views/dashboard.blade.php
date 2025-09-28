@extends('layouts.app')

@section('title', 'Arsip Surat - Kelurahan Karangduren')
@section('page-title', 'Arsip Surat')

@section('content')
    <div class="bg-white rounded-lg shadow p-6">
        <!-- Header Section -->
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800 mb-2">Arsip Surat</h1>
            <p class="text-gray-600">
                Berikut ini adalah surat-surat yang telah terbit dan diarsipkan.<br>
                Klik "Lihat" pada kolom aksi untuk menampilkan surat.
            </p>
        </div>

        <!-- Search Section -->
        <div class="mb-6">
            <div class="flex items-center space-x-4">
                <label for="searchInput" class="text-gray-700 font-medium">Cari surat:</label>
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

        <!-- Letters Table -->
        <div class="overflow-x-auto mb-6">
            <table class="min-w-full border border-gray-300">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="border border-gray-300 px-4 py-2 text-left font-medium text-gray-700">Nomor Surat</th>
                        <th class="border border-gray-300 px-4 py-2 text-left font-medium text-gray-700">Kategori</th>
                        <th class="border border-gray-300 px-4 py-2 text-left font-medium text-gray-700">Judul</th>
                        <th class="border border-gray-300 px-4 py-2 text-left font-medium text-gray-700">Waktu Pengarsipan</th>
                        <th class="border border-gray-300 px-4 py-2 text-left font-medium text-gray-700">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($letters as $letter)
                    <tr class="hover:bg-gray-50">
                        <td class="border border-gray-300 px-4 py-2">{{ $letter->nomor_surat }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $letter->category->nama_kategori }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $letter->judul }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $letter->formatted_waktu }}</td>
                        <td class="border border-gray-300 px-4 py-2">
                            <div class="flex space-x-1">
                                <!-- Delete Button -->
                                <form method="POST" action="{{ route('letters.destroy', $letter) }}" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" 
                                            onclick="showDeleteModal(this.form)"
                                            class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm font-medium">
                                        Hapus
                                    </button>
                                </form>
                                
                                <!-- Download Button -->
                                <a href="{{ route('letters.download', $letter) }}" 
                                   class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-sm font-medium inline-block">
                                    Unduh
                                </a>
                                
                                <!-- View Button -->
                                <a href="{{ route('letters.show', $letter) }}" 
                                   class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-sm font-medium inline-block">
                                    Lihat >>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="border border-gray-300 px-4 py-8 text-center text-gray-500">
                            @if($search)
                                Tidak ada surat yang ditemukan dengan kata kunci "{{ $search }}"
                            @else
                                Belum ada surat yang diarsipkan
                            @endif
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Add Letter Button -->
        <div class="flex justify-start">
            <a href="{{ route('letters.create') }}" 
               class="bg-gray-800 hover:bg-gray-900 text-white px-6 py-3 rounded font-medium">
                Arsipkan Surat...
            </a>
        </div>
    </div>

    @if(session('success'))
    <div class="fixed top-4 right-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded shadow-lg z-50">
        <div class="flex items-center">
            <span>{{ session('success') }}</span>
            <button onclick="this.parentElement.parentElement.remove()" class="ml-4 text-green-700 hover:text-green-900">×</button>
        </div>
    </div>
    @endif
@endsection