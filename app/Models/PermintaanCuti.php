<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermintaanCuti extends Model
{
    use HasFactory;

    protected $table = 'permintaan_cuti';

    protected $fillable = ['users_id','jenis_cuti_id','tanggal_dimulai','tanggal_diakhiri', 'dokumen_path', 'status'];

    public function user() {
        return $this->belongsTo(User::class, 'users_id');
    }

    public function catatanKehadiran() {
        return $this->hasMany(CatatanKehadiran::class);
    }
}
