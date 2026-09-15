<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class M_ktp extends Model
{
    use HasFactory;

    protected $table = 'm_ktps';
    protected $guarded = ['*']; // Tidak dipakai secara aktif
}
