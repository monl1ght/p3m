<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HkiAnggota extends Model
{
    use HasFactory;

    protected $table = 'hki_anggotas';

    protected $fillable = [
        'hki_id',
        'nama',
        'nim_nidn',
        'peran',
        'urutan',
    ];

    /**
     * Relasi ke HKI induk.
     */
    public function hki()
    {
        return $this->belongsTo(Hki::class, 'hki_id');
    }
}
