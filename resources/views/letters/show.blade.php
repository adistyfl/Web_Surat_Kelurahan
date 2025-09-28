@extends('layouts.app')

@section('title', 'Lihat Surat - Kelurahan Karangduren')
@section('page-title', 'Arsip Surat >> Lihat')

@section('content')
    <div class="bg-white rounded-lg shadow p-6">
        <!-- Header Section -->
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800 mb-4">Arsip Surat >> Lihat</h1>
            
            <!-- Letter Details -->
            <div class="space-y-2 text-gray-700">
                <div><strong>Nomor:</strong> {{ $letter->nomor_surat }}</div>
                <div><strong>Kategori:</strong> {{ $letter->category->nama_kategori }}</div>
                <div><strong>Judul:</strong> {{ $letter->judul }}</div>
                <div><strong>Waktu Unggah:</strong> {{ $letter->formatted_waktu }}</div>
            </div>
        </div>

        <!-- PDF Preview -->
        <div class="mb-6">
            <div class="border border-gray-300 rounded">
                <iframe src="{{ Storage::url($letter->file_path) }}" 
                        width="100%" 
                        height="600"
                        class="rounded">
                    <p class="text-center text-gray-500 py-8">
                        Browser Anda tidak mendukung preview PDF. 
                        <a href="{{ route('letters.download', $letter) }}" 
                           class="text-blue-600 hover:text-blue-800 underline">
                            Klik di sini untuk mengunduh file
                        </a>
                    </p>
                </iframe>
            </div>
        </div>

        <!-- Buttons -->
        <div class="flex space-x-4">
            <a href="{{ route('dashboard') }}" 
               class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded font-medium">
                << Kembali
            </a>
            
            <a href="{{ route('letters.download', $letter) }}" 
               class="bg-yellow-500 hover:bg-yellow-600 text-white px-6 py-2 rounded font-medium">
                Unduh
            </a>
            
            <a href="{{ route('letters.edit', $letter) }}" 
               class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded font-medium">
                Edit/Ganti File
            </a>
        </div>
    </div>

    @if(session('error'))
    <div class="fixed top-4 right-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded shadow-lg z-50">
        <div class="flex items-center">
            <span>{{ session('error') }}</span>
            <button onclick="this.parentElement.parentElement.remove()" class="ml-4 text-red-700 hover:text-red-900">×</button>
        </div>
    </div>
    @endif
@endsection