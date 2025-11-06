<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Income extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'kategori',
        'jumlah',
        'tanggal',
        'keterangan',
    ];

    // Relasi ke user (kalau kamu punya model User)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
