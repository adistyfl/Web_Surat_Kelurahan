<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Letter extends Model
{
    use HasFactory;

    protected $fillable = [
        'nomor_surat',
        'category_id',
        'judul',
        'file_path',
        'original_filename',
        'waktu_pengarsipan'
    ];

    protected $casts = [
        'waktu_pengarsipan' => 'datetime',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function getFormattedWaktuAttribute()
    {
        return $this->waktu_pengarsipan->format('Y-m-d H:i');
    }
}