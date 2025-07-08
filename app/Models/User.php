<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Filament\Panel;
use Filament\Models\Contracts\FilamentUser;
use Laravel\Sanctum\HasApiTokens;







class User extends Authenticatable implements FilamentUser
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'nip',
        'divisi_id',
        'role',
        'unit_kerja', 
        'password',
        'is_admin'
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
        'is_admin' => 'boolean',
    ];

    public function divisi() {
        return $this->belongsTo(Divisi::class);
    }

    public function catatanKehadiran() {
        // return $this->hasMany(CatatanKehadiran::class);
        return $this->hasMany(CatatanKehadiran::class);
    }

    public function permintaanCuti() {
        return $this->hasMany(permintaanCuti::class, 'users_id');
    }

     public function canAccessPanel(Panel $panel): bool
    {
        // Hanya izinkan jika role adalah 'admin'
         return $this->is_admin;
    }

}
