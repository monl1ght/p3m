<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hki extends Model
{
    use HasFactory;

    protected $table = 'hkis';

    protected $fillable = [
        'user_id',
        'judul',
        'tanggal',
        'jenis_hki',
        'nomor_pencatatan',
        'file_path',
        'file_name',
        'status',
        'catatan_admin',
        'read_at',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'read_at' => 'datetime',
    ];

    protected $attributes = [
        'status' => 'diproses',
    ];

    /**
     * Relasi ke user (dosen) pemilik HKI.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relasi ke anggota/pencipta HKI.
     */
    public function anggotas()
    {
        return $this->hasMany(HkiAnggota::class, 'hki_id')->orderBy('urutan', 'asc');
    }
}
