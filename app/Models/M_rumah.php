<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class M_rumah extends Model
{
    use HasFactory;

    protected $table = 'm_rumahs';
    protected $guarded = ['*']; // Tidak dipakai secara aktif
}
