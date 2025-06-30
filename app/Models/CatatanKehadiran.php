<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CatatanKehadiran extends Model
{
    use HasFactory;

    protected $table = 'catatan_kehadiran';

    protected $fillable = [
        'user_id',
        'jenis_kehadiran_id',
        'tanggal_masuk',
        'jam_masuk',
        'ip_address_masuk',
        'jenis_kehadiran_id_pulang',
        'jam_pulang',
        'ip_address_pulang',
        'tanggal_selesai_izin',
        'keterangan_izin',
        'file_pendukung_izin',
        'catatan_tambahan',
        'status_izin',  
        'approved_by',
        'alasan_penolakan',
    ];

    protected $casts = [
        'tanggal_masuk' => 'date',
        'tanggal_selesai_izin' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function jenisKehadiran()
    {
        return $this->belongsTo(JenisKehadiran::class, 'jenis_kehadiran_id');
    }

    public function jenisKehadiranPulang()
    {
        return $this->belongsTo(JenisKehadiran::class, 'jenis_kehadiran_id_pulang');
    }

    public function approver() {
        return $this->belongsTo(User::class, 'approved_by');
    }
}
