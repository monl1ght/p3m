<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class M_tentang extends Model
{
    use HasFactory;
    protected $table = 'm_tentangs';
    protected $fillable = ['visi', 'misi', 'ourbout'];
}
