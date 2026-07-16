<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class M_categories extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'slug'];

    public function news()
    {
        return $this->hasMany(M_news::class, 'category_id');
    }
    public function p3m()
    {
        return $this->hasMany(p3mModel::class, 'kategori_id');
    }
}
