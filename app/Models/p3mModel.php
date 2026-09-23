<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class p3mModel extends Model
{
    use HasFactory;
    protected $table = 'ajupengabdian';
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
        'user_id', // untuk user
        'status',
        'tanggal_mulai',
        'tanggal_selesai',
        'read_at',
        'created_at',
    ];

    public function anggotap3m()
    {
        return $this->hasMany(anggotap3mModel::class, 'ajupengab_model_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function statusHistories()
    {
        return $this->hasMany(SubmissionStatusHistory::class, 'submission_id')
            ->where('submission_type', 'proposal-pengabdian')
            ->orderBy('decided_at', 'desc');
    }

    public function latestStatusHistory()
    {
        return $this->hasOne(SubmissionStatusHistory::class, 'submission_id')
            ->where('submission_type', 'proposal-pengabdian')
            ->latestOfMany('decided_at');
    }
}
