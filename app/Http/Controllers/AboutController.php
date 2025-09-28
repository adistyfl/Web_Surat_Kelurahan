<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AboutController extends Controller
{
    public function index()
    {
        // Data developer yang bisa dikustomisasi
        $developer = [
            'name' => 'Adisty farhatul layliyah', // Ganti dengan nama Anda
            'prodi' => 'D3 Manajemen Informatika', // Ganti dengan prodi Anda
            'nim' => '2231750009', // Ganti dengan NIM Anda
            'photo' => null, // Bisa diisi path foto jika ada
            'creation_date' => '27 September 2025', // Tanggal pembuatan
            'version' => '1.0.0'
        ];

        $app_info = [
            'name' => 'Aplikasi Arsip Surat',
            'description' => 'Aplikasi ini dibuat khusus untuk Kelurahan Karangduren, Kecamatan Pakisaji. Aplikasi ini memungkinkan petugas kelurahan untuk mengarsipkan surat-surat resmi dalam format PDF, melakukan pencarian berdasarkan judul surat, dan mengelola kategori surat dengan mudah.',
            'features' => [
                'Upload dan arsip surat dalam format PDF',
                'Pencarian surat berdasarkan judul dan nomor', 
                'Manajemen kategori surat',
                'Preview dan download surat',
                'Interface yang user-friendly'
            ],
            'technologies' => [
                ['name' => 'Laravel 12', 'color' => 'red'],
                ['name' => 'MySQL', 'color' => 'blue'],
                ['name' => 'Tailwind CSS', 'color' => 'green'],
                ['name' => 'PHP 8.x', 'color' => 'purple']
            ]
        ];

        return view('about', compact('developer', 'app_info'));
    }
}