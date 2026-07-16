<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class anggotap3mModel extends Model
{
    use HasFactory;
    protected $table = 'anggotap3m_models';
    protected $fillable = ['nama', 'nim', 'prodi', 'jabatan', 'ajupengab_model_id', 'ajupenel_model_id', 'kpengab_model_id', 'kpenel_model_id'];

    public function p3m()
    {
        return $this->belongsTo(p3mModel::class, 'ajupengab_model_id');
    }
    public function ajupenel()
    {
        return $this->belongsTo(p3mModel::class, 'ajupenel_model_id');
    }
    public function kpengab()
    {
        return $this->belongsTo(p3mModel::class, 'kpengab_model_id');
    }
    public function kpeneliti()
    {
        return $this->belongsTo(p3mModel::class, 'kpenel_model_id');
    }
}
