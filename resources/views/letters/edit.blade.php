@extends('layouts.app')

@section('title', 'Edit Surat - Kelurahan Karangduren')
@section('page-title', 'Arsip Surat >> Edit')

@section('content')
    <div class="bg-white rounded-lg shadow p-6">
        <!-- Header Section -->
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800 mb-2">Arsip Surat >> Edit</h1>
            <p class="text-gray-600 mb-2">
                Edit data surat yang telah diarsipkan.
            </p>
            <p class="text-gray-600">
                <strong>Catatan:</strong>
            </p>
            <ul class="list-disc list-inside text-gray-600 ml-4">
                <li>Gunakan file berformat PDF</li>
                <li>Kosongkan file jika tidak ingin mengubah file yang sudah ada</li>
            </ul>
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

        <!-- Current File Info -->
        <div class="bg-blue-50 border border-blue-200 rounded p-4 mb-6">
            <h3 class="font-medium text-blue-800 mb-2">File Saat Ini:</h3>
            <p class="text-blue-700">{{ $letter->original_filename }}</p>
        </div>

        <!-- Form -->
        <form method="POST" action="{{ route('letters.update', $letter) }}" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')
            
            <!-- Nomor Surat -->
            <div class="flex items-center">
                <label for="nomor_surat" class="w-40 text-gray-700 font-medium">Nomor Surat</label>
                <input type="text" 
                       name="nomor_surat" 
                       id="nomor_surat" 
                       value="{{ old('nomor_surat', $letter->nomor_surat) }}"
                       class="flex-1 max-w-md px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                       required>
            </div>

            <!-- Kategori -->
            <div class="flex items-center">
                <label for="category_id" class="w-40 text-gray-700 font-medium">Kategori</label>
                <select name="category_id" 
                        id="category_id"
                        class="flex-1 max-w-md px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                        required>
                    <option value="">Pilih Kategori</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" 
                                {{ old('category_id', $letter->category_id) == $category->id ? 'selected' : '' }}>
                            {{ $category->nama_kategori }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Judul -->
            <div class="flex items-start">
                <label for="judul" class="w-40 text-gray-700 font-medium pt-2">Judul</label>
                <textarea name="judul" 
                          id="judul" 
                          rows="3"
                          class="flex-1 px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                          required>{{ old('judul', $letter->judul) }}</textarea>
            </div>

            <!-- File Surat -->
            <div class="flex items-center">
                <label for="file_surat" class="w-40 text-gray-700 font-medium">File Surat (PDF)</label>
                <div class="flex items-center space-x-4">
                    <input type="file" 
                           name="file_surat" 
                           id="file_surat"
                           accept=".pdf"
                           class="hidden">
                    <input type="text" 
                           id="file_display" 
                           readonly 
                           placeholder="Pilih file PDF baru (opsional)..."
                           class="flex-1 max-w-md px-3 py-2 border border-gray-300 rounded bg-gray-50">
                    <button type="button" 
                            onclick="document.getElementById('file_surat').click()"
                            class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded font-medium">
                        Browse File...
                    </button>
                </div>
            </div>

            <!-- Buttons -->
            <div class="flex space-x-4 pt-4">
                <a href="{{ route('letters.show', $letter) }}" 
                   class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded font-medium">
                    << Kembali
                </a>
                <button type="submit" 
                        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded font-medium">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>

    <script>
        document.getElementById('file_surat').addEventListener('change', function() {
            const fileInput = this;
            const fileDisplay = document.getElementById('file_display');
            
            if (fileInput.files.length > 0) {
                fileDisplay.value = fileInput.files[0].name;
            } else {
                fileDisplay.value = '';
            }
        });
    </script>
@endsection