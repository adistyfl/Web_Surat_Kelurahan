@extends('layouts.app')

@section('title', 'Edit Kategori - Kelurahan Karangduren')
@section('page-title', 'Kategori Surat >> Edit')

@section('content')
    <div class="bg-white rounded-lg shadow p-6">
        <!-- Header Section -->
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800 mb-2">Kategori Surat >> Edit</h1>
            <p class="text-gray-600">
                Tambahkan atau edit data kategori. Jika sudah selesai, jangan lupa untuk mengklik tombol "Simpan"
            </p>
        </div>

        <!-- Error Messages -->
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Info kategori digunakan -->
        @if($category->letters()->count() > 0)
            <div class="bg-yellow-50 border border-yellow-200 rounded p-4 mb-6">
                <h3 class="font-medium text-yellow-800 mb-2">Perhatian:</h3>
                <p class="text-yellow-700">
                    Kategori ini sedang digunakan oleh {{ $category->letters()->count() }} surat. 
                    Perubahan nama kategori akan mempengaruhi semua surat yang menggunakan kategori ini.
                </p>
            </div>
        @endif

        <!-- Form -->
        <form method="POST" action="{{ route('categories.update', $category) }}" class="space-y-6">
            @csrf
            @method('PUT')
            
            <!-- ID (Display Only) -->
            <div class="flex items-center">
                <label for="category_id" class="w-48 text-gray-700 font-medium">ID (Auto Increment)</label>
                <input type="text" 
                       id="category_id" 
                       value="{{ $category->id }}"
                       readonly
                       class="w-20 px-3 py-2 border border-gray-300 rounded bg-gray-100 text-gray-600">
            </div>

            <!-- Nama Kategori -->
            <div class="flex items-center">
                <label for="nama_kategori" class="w-48 text-gray-700 font-medium">Nama Kategori</label>
                <input type="text" 
                       name="nama_kategori" 
                       id="nama_kategori" 
                       value="{{ old('nama_kategori', $category->nama_kategori) }}"
                       class="flex-1 max-w-md px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                       required>
            </div>

            <!-- Keterangan -->
            <div class="flex items-start">
                <label for="keterangan" class="w-48 text-gray-700 font-medium pt-2">Judul</label>
                <textarea name="keterangan" 
                          id="keterangan" 
                          rows="4"
                          placeholder="Masukkan keterangan kategori (opsional)"
                          class="flex-1 px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">{{ old('keterangan', $category->keterangan) }}</textarea>
            </div>

            <!-- Buttons -->
            <div class="flex space-x-4 pt-4">
                <a href="{{ route('categories.index') }}" 
                   class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded font-medium">
                    << Kembali
                </a>
                <button type="submit" 
                        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded font-medium">
                    Simpan
                </button>
            </div>
        </form>
    </div>
@endsection