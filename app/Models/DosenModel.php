<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DosenModel extends Model
{
    use HasFactory;

    // Model ini tidak dipakai secara aktif — semua data dosen diambil via User model.
    // Diproteksi dari mass assignment tidak sengaja.
    protected $guarded = ['*'];
}
