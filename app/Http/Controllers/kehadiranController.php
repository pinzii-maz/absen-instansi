<?php

namespace App\Http\Controllers;

use App\Helpers\IpHelper;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\JaringanKantor;
use App\Models\JenisKehadiran;
use App\Helpers\KehadiranHelper;
use App\Models\CatatanKehadiran;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class kehadiranController extends Controller
{
    public function dashboard() {
        $user = Auth::user();
        $today = Carbon::now();
        $now = Carbon::now();
        $currentMonthStart = Carbon::now()->startOfMonth();
        $currentMonthEnd = Carbon::now()->endOf('month');

        $hasAttendedToday = CatatanKehadiran::where('user_id', $user->id)
            ->where(function ($query) use ($today) {
                $query->whereDate('tanggal_masuk', $today) // Untuk absen harian
                      ->orWhere(function($q) use ($today) { // Untuk izin multi-hari
                        $q->whereDate('tanggal_masuk', '<=', $today)
                            ->whereDate('tanggal_selesai_izin', '>=', $today);
                    });
            })
            ->exists();

            $hasClockedOutToday = CatatanKehadiran::where('user_id', $user->id)
            ->whereDate('tanggal_masuk', $today)
            ->whereNotNull('jam_pulang')
            ->exists();

        session(['has_attended_today' => $hasAttendedToday]);
        session(['has_clocked_out_today' => $hasClockedOutToday]);

        $totalAttendance = CatatanKehadiran::where('user_id', $user->id)
            ->whereBetween('tanggal_masuk', [$currentMonthStart, $currentMonthEnd])
            ->whereHas('jenisKehadiran', function($q) {
                $q->where('code', 'H'); // Hanya hitung yang 'Hadir (Masuk)'
            })
            ->whereNotNull('jam_pulang')
            ->count();

        $jamMasukKantor = '08:00:00';
        $totalMasukBulanIni = $totalAttendance;

        $totalTepatWaktu = CatatanKehadiran::where('user_id', $user->id)
            ->whereBetween('tanggal_masuk', [$currentMonthStart, $currentMonthEnd])
            ->whereHas('jenisKehadiran', function($q) {
                $q->where('code', 'H');
            })
            ->whereTime('jam_masuk', '<=', $jamMasukKantor)
            ->whereNotNull('jam_pulang')
            ->count();
        
        $onTimePercentage = ($totalMasukBulanIni > 0) ? round(($totalTepatWaktu / $totalMasukBulanIni) * 100) : 0;

        $jenisKehadiran = JenisKehadiran::whereIn('code', ['S', 'I', 'C', 'DL', 'TL'])->get();

        $leaveRequests = CatatanKehadiran::where('user_id', $user->id)
        ->whereHas('jenisKehadiran', function ($query) {
            
            $query->whereNotIn('code', ['H', 'P']);
        })
        ->with('jenisKehadiran') 
        ->latest() 
        ->take(5) 
        ->get();

        $pegawaiInfo = [
        ['label' => 'Nama Lengkap', 'value' => $user->name],
        ['label' => 'Email', 'value' => $user->email],
        ['label' => 'NIP', 'value' => $user->nip],
        ['label' => 'Jabatan', 'value' => ucwords(str_replace('_', ' ', $user->role))],
    ];

        return view('dashboard', compact(
        'totalAttendance', 
        'onTimePercentage', 
        'jenisKehadiran',
        'leaveRequests',
        'pegawaiInfo'
    ));
    }

    // ✅ Method absenMasuk yang hilang
    public function absenMasuk(Request $request)
    {
        try {
            $user = Auth::user();
            $clientIp = IpHelper::getClientIp($request);
            $today = Carbon::today();
            $now = Carbon::now();
            $today = $now->today();
            // Cek apakah IP client berada dalam jaringan kantor 
            $jaringanKantor = JaringanKantor::all();
            $allowedCidrs = $jaringanKantor->pluck('ip_cidr')->toArray();

            if (!IpHelper::isIpInOfficeNetwork($clientIp, $allowedCidrs)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda tidak berada dalam jaringan kantor. IP Anda: ' . $clientIp
                ], 403);
            }

            // Cek apakah user sudah absen masuk hari ini
            $existingAbsen = CatatanKehadiran::where('user_id', $user->id)
                ->whereDate('tanggal_masuk', $today)
                ->first();

            if ($existingAbsen && $existingAbsen->jam_masuk) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda sudah melakukan absen masuk hari ini'
                ], 400);
            }

            $startTime = Carbon::createFromTimeString('08:00:00');
            $lateTime = Carbon::createFromTimeString('10:00:00');

            
            $jenisKehadiranCode = '';
            if ($now->between($startTime, $lateTime)) {
                $jenisKehadiranCode = 'H'; // Hadir Tepat Waktu
            } else if ($now->isAfter($lateTime)) {
                $jenisKehadiranCode = 'T'; // Hadir Terlambat
            } else {
                return response()->json(['success' => false, 'message' => 'Waktu untuk absen masuk adalah mulai pukul 08:00.'], 400);
            }
            // --- LOGIKA ATURAN JAM SELESAI ---

            // Ambil ID jenis kehadiran berdasarkan kode
            $jenisKehadiran = JenisKehadiran::where('code', $jenisKehadiranCode)->first();
            if (!$jenisKehadiran) {
                return response()->json(['success' => false, 'message' => 'Jenis kehadiran ('.$jenisKehadiranCode.') tidak ditemukan.'], 404);
            }

            // Ambil jenis kehadiran 'Hadir'
            $jenisKehadiran = JenisKehadiran::where('code', 'H')->first();
            if (!$jenisKehadiran) {
                return response()->json([
                    'success' => false,
                    'message' => 'Jenis kehadiran tidak ditemukan'
                ], 400);
            }

            // Simpan data absen masuk
            $kehadiran = CatatanKehadiran::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'tanggal_masuk' => $today
                ],
                [
                    'jenis_kehadiran_id' => $jenisKehadiran->id,
                    'jam_masuk' => Carbon::now(),
                    'ip_address_masuk' => $clientIp,
                ]
            );

            // Update session
            session(['has_attended_today' => true]);

            return response()->json([
                'success' => true,
                'message' => 'Absen masuk berhasil dicatat',
                'data' => [
                    'jam_masuk' => $kehadiran->jam_masuk->format('H:i:s'),
                    'tanggal' => $kehadiran->tanggal_masuk->format('d-m-Y'),
                    'ip_address' => $clientIp
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Error absen masuk: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    // ✅ Method absenPulang yang hilang
    public function absenPulang(Request $request)
    {
        try {
            $user = Auth::user();
            $clientIp = IpHelper::getClientIp($request);
            $now = Carbon::now();
            $today = Carbon::today();

            // Cek apakah IP client berada dalam jaringan kantor
            $jaringanKantor = JaringanKantor::all();
            $allowedCidrs = $jaringanKantor->pluck('ip_cidr')->toArray();

            if (!IpHelper::isIpInOfficeNetwork($clientIp, $allowedCidrs)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda tidak berada dalam jaringan kantor. IP Anda: ' . $clientIp
                ], 403);
            }

            // Cek apakah user sudah absen masuk hari ini
            $kehadiran = CatatanKehadiran::where('user_id', $user->id)
                ->whereDate('tanggal_masuk', $today)
                ->first();

            if (!$kehadiran || !$kehadiran->jam_masuk) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda belum melakukan absen masuk hari ini'
                ], 400);
            }

            if ($kehadiran->jam_pulang) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda sudah melakukan absen pulang hari ini'
                ], 400);
            }

            $startClockOut = $today->copy()->setTime(16, 0, 0);
            $endClockOut = $today->copy()->setTime(16, 30, 0);   
            if (!$now->between($startClockOut, $endClockOut)) {
                return response()->json(['success' => false, 'message' => 'Waktu untuk absen pulang adalah antara pukul 16:00 hingga 16:30.'], 400);
            }

            $jenisKehadiranPulang = JenisKehadiran::where('code', 'P')->first();
            if (!$jenisKehadiranPulang) {
                return response()->json(['success' => false, 'message' => 'Jenis kehadiran Pulang (P) tidak ditemukan.'], 404);
            }

            // Update jam pulang
            $kehadiran->update([
                'jenis_kehadiran_id_pulang' => $jenisKehadiranPulang->id,
                'jam_pulang' => $now,
                'ip_address_pulang' => $clientIp
            ]);

            // Update session
            session(['has_clocked_out_today' => true]);

            return response()->json([
                'success' => true,
                'message' => 'Absen pulang berhasil dicatat',
                'data' => [
                    'jam_pulang' => $kehadiran->jam_pulang->format('H:i:s'),
                    'tanggal' => $kehadiran->tanggal_masuk->format('d-m-Y'),
                    'ip_address' => $clientIp
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Error absen pulang: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    // ✅ Method izin yang hilang
        public function izin()
        {
            dd('Method Izin Dijalankan!');
            
            $jenisKehadiran = JenisKehadiran::whereIn('code', ['S', 'I', 'C'])->get(); // Sakit, Izin, Cuti
            return view('kehadiran.izin', compact('jenisKehadiran'));
        }

        public function submitLeave(Request $request)
        {
            // dd($request->all());

            $validator = Validator::make($request->all(), [
                'jenis_izin' => 'required|string|exists:jenis_kehadiran,code', // Pastikan kode jenis izin ada di tabel
                'tanggal_mulai' => 'required|date',
                'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
                'keterangan' => 'required|string|max:1000',
                'surat' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120', // max 5MB
            ]);

            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()->first()], 422);
            }

            $user = Auth::user();
            $clientIp = $request->ip();
            $now = Carbon::now();
            
            $jenisKehadiran = JenisKehadiran::where('code', $request->input('jenis_izin'))->first();
            if (!$jenisKehadiran) { // Seharusnya sudah divalidasi oleh 'exists' rule
                return response()->json(['success' => false, 'message' => 'Jenis izin tidak valid.'], 400);
            }

            $startDate = Carbon::parse($request->input('tanggal_mulai'));
            $endDate = Carbon::parse($request->input('tanggal_selesai'));

            $overlappingRecord = CatatanKehadiran::where('user_id', $user->id)
            ->whereIn('status_izin', ['menunggu', 'disetujui'])
            ->where(function ($query) use ($startDate, $endDate) {
                $query->where(function ($q) use ($startDate, $endDate) {
                    $q->where('tanggal_masuk', '<=', $endDate)
                        ->whereRaw('COALESCE(tanggal_selesai_izin, tanggal_masuk) >= ?', [$startDate]);
                });
            })
                ->exists();

            $filePath = null;
            if ($request->hasFile('surat')) {
                $filePath = $request->file('surat')->store('public/surat_izin'); // Simpan ke storage/app/public/surat_izin
            }

            CatatanKehadiran::create([
                'user_id' => $user->id,
                'jenis_kehadiran_id' => $jenisKehadiran->id,
                'tanggal_masuk' => $startDate, // Tanggal mulai izin
                'jam_masuk' => null, // Untuk izin, jam masuk bisa null
                'ip_address_masuk' => $clientIp,
                'tanggal_selesai_izin' => $endDate,
                'keterangan_izin' => $request->input('keterangan'),
                'file_pendukung_izin' => $filePath,
            ]);
            
            // Update session jika izin mencakup hari ini
            if ($now->betweenIncluded($startDate, $endDate->endOfDay())) {
                session(['has_attended_today' => true]);
                session()->forget('has_clocked_out_today');
            }

            return response()->json(['success' => true, 'message' => 'Pengajuan izin berhasil dikirim.']);
        }

         public function cekJaringan(Request $request)
    {
        $clientIp = IpHelper::getClientIp($request);
        $officeNetworks = JaringanKantor::pluck('ip_cidr')->all();

        if (IpHelper::isIpInOfficeNetwork($clientIp, $officeNetworks)) {
            // Jika IP valid, kirim status 'allowed'
            return response()->json(['status' => 'allowed', 'ip' => $clientIp]);
        } else {
            // Jika IP tidak valid, kirim status 'denied'
            return response()->json(['status' => 'denied', 'ip' => $clientIp]);
        }
    }
    
}