<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DosenJurnalUpload extends Model
{
    use HasFactory;

    protected $table = 'dosen_jurnal_uploads';

    protected $fillable = [
        'user_id',
        'judul',
        'kategori',
        'file_path',
        'file_name',
        'status',
        'catatan_admin',
    ];

    protected $attributes = [
        'status' => 'diproses',
    ];

    /**
     * Relasi ke user (dosen) pemilik jurnal.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
