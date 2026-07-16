<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes  that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'image',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    // public function ktp()
    // {return $this->hasOne(M_ktp::class);}

    public function news()
    {
        return $this->hasMany(M_news::class, 'user_id');
    }
    public function p3m()
    {
        return $this->hasMany(p3mModel::class);
    }
    public function kum_penelitian()
    {
        return $this->hasMany(kum_penelitianModel::class);
    }
    public function kum_pengabdian()
    {
        return $this->hasMany(kum_pengabdianModel::class);
    }
    public function ajuan_penelitian()
    {
        return $this->hasMany(ajuan_penelitianModel::class);
    }
}
