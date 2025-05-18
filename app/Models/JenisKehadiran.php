<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisKehadiran extends Model
{
    use HasFactory;

    protected $table = 'jenis_kehadiran';

    protected $fillable = ['code', 'name', 'diperbolehkan_di_luar_jaringan'];

    public function catatanKehadiran() {
        return $this->hasMany(CatatanKehadiran::class, 'jenis_kehadiran_id');
    }
}
