<?php

namespace App\Http\Controllers;

use App\Models\Letter;
use App\Models\Category;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        
        $letters = Letter::with('category')
            ->when($search, function ($query, $search) {
                return $query->where('judul', 'like', "%{$search}%")
                           ->orWhere('nomor_surat', 'like', "%{$search}%");
            })
            ->orderBy('waktu_pengarsipan', 'desc')
            ->get();

        $categories = Category::all();

        return view('dashboard', compact('letters', 'categories', 'search'));
    }
}