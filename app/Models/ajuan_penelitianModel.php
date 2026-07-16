<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ajuan_penelitianModel extends Model
{
    use HasFactory;
    protected $table = 'ajuan_penelitian_models';
    protected $fillable = [
        'judul',
        'bidang',
        'ketua',
        'jeniskategori',
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
        // 'foto', // untuk foto
        'user_id',
        'status',
        'tanggal_mulai',
        'tanggal_selesai', // untuk user
        'read_at',

    ];
    public function anggotap3m()
    {
        return $this->hasMany(anggotap3mModel::class, 'ajupenel_model_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
