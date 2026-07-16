<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class M_news extends Model
{
    use HasFactory;
    protected $fillable = ['image', 'title', 'content', 'category_id', 'date', 'user_id'];

    public function category()
    {
        return $this->belongsTo(M_categories::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
