@extends('layouts.app')

@section('title', 'About - Kelurahan Karangduren')
@section('page-title', 'About')

@section('content')
    <div class="bg-white rounded-lg shadow p-6">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-gray-800">About</h1>
        </div>

        <!-- About Content -->
        <div class="flex items-start space-x-8">
            <!-- Photo Section -->
            <div class="flex-shrink-0">
                <div class="w-32 h-32 border-2 border-gray-400 rounded bg-white flex items-center justify-center">
                    <!-- Default User Icon -->
                    <div class="w-24 h-24 bg-gray-800 rounded flex items-center justify-center">
                        <div class="text-white">
                            <!-- Head -->
                            <div class="w-8 h-8 bg-white rounded-full mx-auto mb-1"></div>
                            <!-- Body -->
                            <div class="w-12 h-8 bg-white rounded-t-full"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Info Section -->
            <div class="flex-1">
                <div class="space-y-2 text-gray-700">
                    <p><strong>Aplikasi ini dibuat oleh:</strong></p>
                    <p><strong>Nama:</strong> {{ $developer['name'] ?? 'Your Name' }}</p>
                    <p><strong>Prodi:</strong> {{ $developer['prodi'] ?? 'Your Program' }}</p>
                    <p><strong>NIM:</strong> {{ $developer['nim'] ?? 'Your NIM' }}</p>
                    <p><strong>Tanggal:</strong> {{ $developer['creation_date'] ?? date('d F Y') }}</p>
                </div>

                <!-- Additional Info -->
                <div class="mt-6 pt-4 border-t border-gray-200">
                    <h3 class="font-semibold text-gray-800 mb-2">Tentang {{ $app_info['name'] ?? 'Aplikasi' }}</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">
                        {{ $app_info['description'] ?? 'Aplikasi Arsip Surat ini dibuat khusus untuk Kelurahan Karangduren, Kecamatan Pakisaji.' }}
                    </p>
                </div>

                <!-- Features -->
                <div class="mt-4">
                    <h4 class="font-semibold text-gray-800 mb-2">Fitur Utama:</h4>
                    <ul class="text-sm text-gray-600 space-y-1">
                        @if(isset($app_info['features']))
                            @foreach($app_info['features'] as $feature)
                                <li>• {{ $feature }}</li>
                            @endforeach
                        @else
                            <li>• Upload dan arsip surat dalam format PDF</li>
                            <li>• Pencarian surat berdasarkan judul dan nomor</li>
                            <li>• Manajemen kategori surat</li>
                            <li>• Preview dan download surat</li>
                            <li>• Interface yang user-friendly</li>
                        @endif
                    </ul>
                </div>

                <!-- Technical Info -->
                <div class="mt-4">
                    <h4 class="font-semibold text-gray-800 mb-2">Teknologi:</h4>
                    <div class="flex flex-wrap gap-2">
                        @if(isset($app_info['technologies']))
                            @foreach($app_info['technologies'] as $tech)
                                <span class="px-2 py-1 bg-{{ $tech['color'] }}-100 text-{{ $tech['color'] }}-800 text-xs rounded">
                                    {{ $tech['name'] }}
                                </span>
                            @endforeach
                        @else
                            <span class="px-2 py-1 bg-red-100 text-red-800 text-xs rounded">Laravel 12</span>
                            <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded">MySQL</span>
                            <span class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded">Tailwind CSS</span>
                            <span class="px-2 py-1 bg-purple-100 text-purple-800 text-xs rounded">PHP 8.x</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Version Info -->
        <div class="mt-8 pt-4 border-t border-gray-200 text-center">
            <p class="text-sm text-gray-500">
                Version {{ $developer['version'] ?? '1.0.0' }} &copy; {{ date('Y') }} - Aplikasi Arsip Surat Kelurahan Karangduren
            </p>
        </div>
    </div>
@endsection