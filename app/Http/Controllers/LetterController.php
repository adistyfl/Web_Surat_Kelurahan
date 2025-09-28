<?php

namespace App\Http\Controllers;

use App\Models\Letter;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class LetterController extends Controller
{
    public function index()
    {
        return redirect()->route('dashboard');
    }

    public function create()
    {
        $categories = Category::all();
        return view('letters.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nomor_surat' => 'required|string|max:255|unique:letters,nomor_surat',
            'category_id' => 'required|exists:categories,id',
            'judul' => 'required|string|max:255',
            'file_surat' => 'required|file|mimes:pdf|max:10240', // Max 10MB
        ], [
            'nomor_surat.required' => 'Nomor surat harus diisi',
            'nomor_surat.unique' => 'Nomor surat sudah ada dalam sistem',
            'category_id.required' => 'Kategori surat harus dipilih',
            'category_id.exists' => 'Kategori yang dipilih tidak valid',
            'judul.required' => 'Judul surat harus diisi',
            'file_surat.required' => 'File surat harus diupload',
            'file_surat.mimes' => 'File harus berformat PDF',
            'file_surat.max' => 'Ukuran file maksimal 10MB',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Upload file
        $file = $request->file('file_surat');
        $originalName = $file->getClientOriginalName();
        $filename = time() . '_' . $file->getClientOriginalName();
        $filePath = $file->storeAs('letters', $filename, 'public');

        // Create letter record
        Letter::create([
            'nomor_surat' => $request->nomor_surat,
            'category_id' => $request->category_id,
            'judul' => $request->judul,
            'file_path' => $filePath,
            'original_filename' => $originalName,
            'waktu_pengarsipan' => Carbon::now(),
        ]);

        return redirect()->route('dashboard')
            ->with('success', 'Data berhasil disimpan');
    }

    public function show(Letter $letter)
    {
        return view('letters.show', compact('letter'));
    }

    public function edit(Letter $letter)
    {
        $categories = Category::all();
        return view('letters.edit', compact('letter', 'categories'));
    }

    public function update(Request $request, Letter $letter)
    {
        $validator = Validator::make($request->all(), [
            'nomor_surat' => 'required|string|max:255|unique:letters,nomor_surat,' . $letter->id,
            'category_id' => 'required|exists:categories,id',
            'judul' => 'required|string|max:255',
            'file_surat' => 'nullable|file|mimes:pdf|max:10240',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $updateData = [
            'nomor_surat' => $request->nomor_surat,
            'category_id' => $request->category_id,
            'judul' => $request->judul,
        ];

        // Handle file upload if new file provided
        if ($request->hasFile('file_surat')) {
            // Delete old file
            if (Storage::disk('public')->exists($letter->file_path)) {
                Storage::disk('public')->delete($letter->file_path);
            }

            // Upload new file
            $file = $request->file('file_surat');
            $originalName = $file->getClientOriginalName();
            $filename = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('letters', $filename, 'public');

            $updateData['file_path'] = $filePath;
            $updateData['original_filename'] = $originalName;
        }

        $letter->update($updateData);

        return redirect()->route('dashboard')
            ->with('success', 'Data berhasil diperbarui');
    }

    public function destroy(Letter $letter)
    {
        // Delete file from storage
        if (Storage::disk('public')->exists($letter->file_path)) {
            Storage::disk('public')->delete($letter->file_path);
        }

        $letter->delete();

        return redirect()->route('dashboard')
            ->with('success', 'Arsip surat berhasil dihapus');
    }

    public function download(Letter $letter)
    {
        $filePath = storage_path('app/public/' . $letter->file_path);
        
        if (!file_exists($filePath)) {
            return redirect()->back()->with('error', 'File tidak ditemukan');
        }

        return response()->download($filePath, $letter->original_filename);
    }
}