<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class kum_penelitianModel extends Model
{
    use HasFactory;
    protected $table = 'kum_penelitian_models';
    protected $fillable = [
        'judul',
        'bidang',
        'ketua',
        'jeniskelamin',
        'nidn',
        'jabatan',
        'prodi',
        'telp',
        'alamat',
        'lokasi',
        'lamapenelitian',
        'biaya',
        'uppdf', // untuk file PDF
        'foto', // untuk foto
        'jeniskategori',
        'user_id',
        'tanggal_mulai',
        'tanggal_selesai', // untuk user
        'read_at',
    ];

    public function anggotap3m()
    {
        return $this->hasMany(anggotap3mModel::class, 'kpenel_model_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
