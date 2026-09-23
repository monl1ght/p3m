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
        'created_at',
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

    public function statusHistories()
    {
        return $this->hasMany(SubmissionStatusHistory::class, 'submission_id')
            ->where('submission_type', 'jurnal-upload')
            ->orderBy('decided_at', 'desc');
    }

    public function latestStatusHistory()
    {
        return $this->hasOne(SubmissionStatusHistory::class, 'submission_id')
            ->where('submission_type', 'jurnal-upload')
            ->latestOfMany('decided_at');
    }
}
