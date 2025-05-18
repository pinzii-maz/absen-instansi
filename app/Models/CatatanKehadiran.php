<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CatatanKehadiran extends Model
{
    use HasFactory;

    protected $table = 'catatan_kehadiran';

    protected $fillable = ['users_id', 'jenis_kehadiran_id', 'tanggal','tanda_tangan','permintaan_cuti_id','keterangan'];

    public function user() {
        return $this->belongsTo(User::class, 'users_id');
    }

    public function jenisKehadiran() {
        return $this->belongsTo(JenisKehadiran::class, 'jenis_kehadiran_id');
    }

    public function permintaanCuti() {
        return $this->belongsTo(PermintaanCuti::class, 'permintaan_cuti_id');
    }
}
