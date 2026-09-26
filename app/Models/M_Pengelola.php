<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class M_Pengelola extends Model
{
    use HasFactory;

    protected $fillable = [
        'image',
        'nama_pengelola',
        'jenis_identitas',
        'NIDN',
        'jabatan_pengelola',
        'email_pengelola',
    ];

    /**
     * Ensure jenis identitas defaults to NIDN if null/empty.
     */
    public function getJenisIdentitasAttribute($value)
    {
        return !empty($value) ? strtoupper($value) : 'NIDN';
    }
}
